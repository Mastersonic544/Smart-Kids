<?php

namespace Database\Seeders;

use App\Enums\ActivityStatus;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Child;
use App\Models\Classroom;
use App\Models\Message;
use App\Models\Payment;
use App\Models\SaasPayment;
use App\Models\Teacher;
use App\Models\User;
use App\Support\PasscodeGenerator;
use App\Support\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Idempotent seeder for the FULL SmartKids vision dataset:
 *
 *   - 1 superadmin (kept from RoleSeeder)
 *   - 2 admin tenants ("La Petite Étoile" current, "Soleil d'Hammamet" due in 6d)
 *   - per tenant: 3 educators, 6 parents (with 1-2 kids each), 3 classrooms
 *   - 2 weeks of attendance, payments mix (paid + overdue), 8 activities
 *     (pending / approved / completed), meals already in MealSeeder
 *   - messages in all four channels: System DM, parent<->admin, parent<->educator
 *   - SmartKids Pro SaaS payment receipts
 *
 * Re-runnable: matches by email and updates instead of duplicating.
 */
class VisionSeeder extends Seeder
{
    public function run(): void
    {
        $system = User::where('is_system', true)->first();

        $tenants = [
            [
                'name' => 'La Petite Étoile',
                'email' => 'etoile@smartkids.tn',
                'phone' => '71200300',
                'tuition' => 380,
                'subscription_due_at' => now()->addMonths(2),
            ],
            [
                'name' => 'Soleil d\'Hammamet',
                'email' => 'soleil@smartkids.tn',
                'phone' => '72444555',
                'tuition' => 420,
                // Due in 6 days — within the 7-day notification window
                'subscription_due_at' => now()->addDays(6),
            ],
        ];

        foreach ($tenants as $config) {
            $admin = $this->makeAdmin($config);
            $teachers = $this->makeEducators($admin);
            $classrooms = $this->makeClassrooms($admin, $teachers);
            $parents = $this->makeParents($admin);
            $this->makeChildren($admin, $parents, $classrooms);
            $this->makeAttendance($classrooms);
            $this->makePayments($parents);
            $this->makeActivities($admin, $teachers, $classrooms);
            $this->makeMessages($admin, $teachers, $parents, $system);
            $this->makeSaasPayment($admin);
        }
    }

    private function makeAdmin(array $config): User
    {
        $admin = User::updateOrCreate(
            ['email' => $config['email']],
            [
                'name' => $config['name'],
                'phone' => $config['phone'],
                'password' => Hash::make('password'),
                'monthly_tuition_tnd' => $config['tuition'],
                'subscription_status' => 'active',
                'billing_period' => 'monthly',
                'subscription_started_at' => now()->subMonth(),
                'subscription_due_at' => $config['subscription_due_at'],
            ]
        );
        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        return $admin;
    }

    private function makeEducators(User $admin): array
    {
        $rosters = [
            'etoile@smartkids.tn' => [
                ['Anissa', 'Belhadj'],
                ['Mehdi', 'Trabelsi'],
                ['Salma', 'Khelifi'],
            ],
            'soleil@smartkids.tn' => [
                ['Wassim', 'Mansour'],
                ['Lina', 'Bouzid'],
                ['Karim', 'Saadi'],
            ],
        ];

        $created = [];
        foreach ($rosters[$admin->email] as [$prenom, $nom]) {
            $email = strtolower("$prenom.$nom@".explode('@', $admin->email)[1]);
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => "$prenom $nom",
                    'password' => Hash::make(Str::random(40)),
                    'passcode' => User::where('email', $email)->value('passcode') ?? PasscodeGenerator::generate(),
                    'tenant_admin_id' => $admin->id,
                ]
            );
            if (! $user->hasRole('educateur')) {
                $user->assignRole('educateur');
            }

            $teacher = Teacher::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'telephone' => '2'.fake()->randomNumber(7, true),
                ]
            );

            $created[] = $teacher;
        }

        return $created;
    }

    private function makeClassrooms(User $admin, array $teachers): array
    {
        $sets = [
            'etoile@smartkids.tn' => [
                ['nom' => 'Petite Section', 'niveau' => 'PS', 'capacite' => 15],
                ['nom' => 'Moyenne Section', 'niveau' => 'MS', 'capacite' => 18],
                ['nom' => 'Grande Section', 'niveau' => 'GS', 'capacite' => 20],
            ],
            'soleil@smartkids.tn' => [
                ['nom' => 'Étoiles', 'niveau' => 'PS', 'capacite' => 12],
                ['nom' => 'Soleils', 'niveau' => 'MS', 'capacite' => 16],
                ['nom' => 'Lunes', 'niveau' => 'GS', 'capacite' => 18],
            ],
        ];

        $created = [];
        foreach ($sets[$admin->email] as $i => $row) {
            $classroom = Classroom::updateOrCreate(
                ['nom' => $row['nom'].' — '.$admin->name],
                [
                    'niveau' => $row['niveau'],
                    'capacite' => $row['capacite'],
                    'educator_id' => $teachers[$i]->id,
                ]
            );
            $created[] = $classroom;
        }

        return $created;
    }

    private function makeParents(User $admin): array
    {
        $faker = \Faker\Factory::create('fr_FR');
        $created = [];
        for ($i = 1; $i <= 6; $i++) {
            $emailSlug = strtolower(explode('@', $admin->email)[0]);
            $email = "parent{$i}.{$emailSlug}@example.com";
            $parent = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $faker->firstName.' '.$faker->lastName,
                    'phone' => '2'.$faker->randomNumber(7, true),
                    'password' => Hash::make(Str::random(40)),
                    'passcode' => User::where('email', $email)->value('passcode') ?? PasscodeGenerator::generate(),
                    'tenant_admin_id' => $admin->id,
                ]
            );
            if (! $parent->hasRole('parent')) {
                $parent->assignRole('parent');
            }
            $created[] = $parent;
        }

        return $created;
    }

    private function makeChildren(User $admin, array $parents, array $classrooms): void
    {
        $existing = Child::whereIn('parent_id', collect($parents)->pluck('id'))->count();
        if ($existing > 0) {
            return; // Idempotency: keep already-seeded children
        }

        foreach ($parents as $i => $parent) {
            $kids = 1 + ($i % 2); // 1 or 2 kids
            for ($k = 0; $k < $kids; $k++) {
                Child::factory()->create([
                    'parent_id' => $parent->id,
                    'classroom_id' => $classrooms[$k % count($classrooms)]->id,
                ]);
            }
        }
    }

    private function makeAttendance(array $classrooms): void
    {
        $start = Carbon::now()->subDays(14)->startOfDay();
        foreach ($classrooms as $classroom) {
            $children = $classroom->children;
            for ($d = 0; $d < 14; $d++) {
                $date = (clone $start)->addDays($d);
                if ($date->isWeekend()) {
                    continue;
                }
                foreach ($children as $child) {
                    $statut = fake()->randomElement(['present', 'present', 'present', 'absent', 'en_retard']);
                    Attendance::updateOrCreate(
                        ['child_id' => $child->id, 'date' => $date->toDateString()],
                        ['statut' => $statut]
                    );
                }
            }
        }
    }

    private function makePayments(array $parents): void
    {
        foreach ($parents as $parent) {
            foreach ($parent->children as $child) {
                // 2 paid months + 1 overdue
                Payment::updateOrCreate(
                    ['child_id' => $child->id, 'mois' => Carbon::now()->subMonths(2)->format('Y-m')],
                    ['montant' => 400, 'statut' => 'payé', 'date_echeance' => Carbon::now()->subMonths(2)->endOfMonth(), 'paye_le' => Carbon::now()->subMonths(2)->day(20)]
                );
                Payment::updateOrCreate(
                    ['child_id' => $child->id, 'mois' => Carbon::now()->subMonth()->format('Y-m')],
                    ['montant' => 400, 'statut' => 'payé', 'date_echeance' => Carbon::now()->subMonth()->endOfMonth(), 'paye_le' => Carbon::now()->subMonth()->day(18)]
                );
                Payment::updateOrCreate(
                    ['child_id' => $child->id, 'mois' => Carbon::now()->format('Y-m')],
                    ['montant' => 400, 'statut' => 'en attente', 'date_echeance' => Carbon::now()->endOfMonth()]
                );
            }
        }
    }

    private function makeActivities(User $admin, array $teachers, array $classrooms): void
    {
        $existing = Activity::whereHas('educator', fn ($q) => $q->whereIn('id', collect($teachers)->pluck('id')))->count();
        if ($existing > 0) {
            return;
        }

        $blueprints = [
            ['name' => 'Sortie au parc', 'status' => ActivityStatus::Approved, 'days' => 5],
            ['name' => 'Atelier peinture', 'status' => ActivityStatus::Completed, 'days' => -3],
            ['name' => 'Yoga des petits', 'status' => ActivityStatus::PendingApproval, 'days' => 10],
            ['name' => 'Spectacle de fin d\'année', 'status' => ActivityStatus::PendingApproval, 'days' => 30],
            ['name' => 'Initiation à la musique', 'status' => ActivityStatus::Approved, 'days' => 7],
            ['name' => 'Journée pyjama', 'status' => ActivityStatus::Completed, 'days' => -10],
            ['name' => 'Sortie ferme pédagogique', 'status' => ActivityStatus::Rejected, 'days' => 14],
            ['name' => 'Atelier cuisine', 'status' => ActivityStatus::Approved, 'days' => 3],
        ];

        foreach ($blueprints as $i => $b) {
            $teacher = $teachers[$i % count($teachers)];
            Activity::create([
                'name' => $b['name'].' ('.$admin->name.')',
                'description' => fake()->sentence(12),
                'scheduled_date' => Carbon::now()->addDays($b['days']),
                'scheduled_time' => '10:00',
                'educator_id' => $teacher->id,
                'max_participants' => 25,
                'status' => $b['status']->value,
                'requested_by' => $teacher->user_id,
                'approved_by' => in_array($b['status'], [ActivityStatus::Approved, ActivityStatus::Completed, ActivityStatus::Rejected]) ? $admin->id : null,
                'approved_at' => in_array($b['status'], [ActivityStatus::Approved, ActivityStatus::Completed, ActivityStatus::Rejected]) ? Carbon::now()->subDays(2) : null,
                'rejection_reason' => $b['status'] === ActivityStatus::Rejected ? 'Date conflictuelle avec un autre événement.' : null,
            ]);
        }
    }

    private function makeMessages(User $admin, array $teachers, array $parents, ?User $system): void
    {
        $existing = Message::whereIn('sender_id', collect($parents)->pluck('id'))->count();
        if ($existing > 0) {
            return;
        }

        // Parent <-> Admin
        Message::create(['sender_id' => $parents[0]->id, 'receiver_id' => $admin->id, 'body' => 'Bonjour, mon enfant sera absent demain.']);
        Message::create(['sender_id' => $admin->id, 'receiver_id' => $parents[0]->id, 'body' => 'Merci pour l\'information, bonne journée.']);

        // Parent <-> Educator (parent[1] <-> teacher[0]'s user)
        $eduUser = User::find($teachers[0]->user_id);
        Message::create(['sender_id' => $parents[1]->id, 'receiver_id' => $eduUser->id, 'body' => 'Bonjour, comment ma fille a-t-elle évolué cette semaine ?']);
        Message::create(['sender_id' => $eduUser->id, 'receiver_id' => $parents[1]->id, 'body' => 'Très bien, elle progresse en lecture !']);

        // System DM to a parent (already mirrored by other flows, but seed one for inbox demo)
        if ($system) {
            Message::create([
                'sender_id' => $system->id,
                'receiver_id' => $parents[2]->id,
                'body' => 'Bienvenue sur SmartKids ! Vous recevrez ici les notifications importantes de votre établissement.',
            ]);
        }
    }

    private function makeSaasPayment(User $admin): void
    {
        SaasPayment::updateOrCreate(
            ['admin_id' => $admin->id, 'period_start' => now()->subMonth()->toDateString()],
            [
                'amount_tnd' => SubscriptionPlan::MONTHLY_PRICE_TND,
                'period' => 'monthly',
                'period_end' => $admin->subscription_due_at ?? now()->addMonth(),
                'status' => 'paid',
                'paid_at' => now()->subMonth()->day(2),
            ]
        );
    }
}
