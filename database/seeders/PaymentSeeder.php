<?php

namespace Database\Seeders;

use App\Models\Child;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder for monthly payments.
 */
class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $children = Child::all();
        $months = [
            Carbon::now()->subMonth()->format('F Y'),
            Carbon::now()->format('F Y'),
        ];

        foreach ($children as $child) {
            foreach ($months as $month) {
                Payment::create([
                    'child_id' => $child->id,
                    'montant' => rand(250, 450),
                    'statut' => rand(1, 100) > 20 ? 'payé' : 'en attente',
                    'created_at' => Carbon::now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }
}
