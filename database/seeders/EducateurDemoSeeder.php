<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Child;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class EducateurDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Find the educateur user
        $user = User::where('email', 'educateur@smartkids.tn')->first();
        
        if (!$user) {
            $this->command->error('User educateur@smartkids.tn not found');
            return;
        }

        // Create or get teacher profile
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            $teacher = Teacher::create([
                'user_id' => $user->id,
                'nom' => 'Benali',
                'prenom' => 'Amira',
                'email' => $user->email,
                'telephone' => '+216 98 765 432'
            ]);
            $this->command->info('✓ Teacher profile created for educateur@smartkids.tn');
        } else {
            $this->command->info('✓ Teacher profile already exists');
        }

        // Assign to Moyenne class
        $classroom = Classroom::where('niveau', 'moyenne_section')->first();
        if ($classroom) {
            $classroom->educator_id = $teacher->id;
            $classroom->save();
            $this->command->info('✓ Assigned educator to Moyenne Section class (ID: ' . $classroom->id . ')');
        } else {
            $this->command->error('Moyenne Section classroom not found');
            return;
        }

        // Get children in this class
        $children = Child::where('classroom_id', $classroom->id)->take(8)->get();
        $this->command->info('✓ Found ' . $children->count() . ' children in Moyenne class');

        // Create an activity
        $activity = Activity::create([
            'educator_id' => $teacher->id,
            'name' => 'Atelier Peinture',
            'description' => 'Activité créative de peinture pour développer la motricité fine',
            'scheduled_date' => now()->addDays(3)->format('Y-m-d'),
            'scheduled_time' => '10:00:00'
        ]);
        $this->command->info('✓ Created activity: Atelier Peinture');

        // Enroll 5 children in the activity
        foreach ($children->take(5) as $child) {
            DB::table('activity_child')->insert([
                'activity_id' => $activity->id,
                'child_id' => $child->id,
                'attended' => false
            ]);
        }
        $this->command->info('✓ Enrolled 5 children in the activity');

        $this->command->info('');
        $this->command->info('Demo data setup complete for educateur@smartkids.tn');
    }
}
