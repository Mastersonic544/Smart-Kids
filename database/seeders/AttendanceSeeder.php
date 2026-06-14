<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Child;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

/**
 * Seeder for daily attendance records.
 */
class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $children = Child::all();
        $startDate = Carbon::now()->subMonths(3)->startOfMonth();
        $endDate = Carbon::now();

        $period = CarbonPeriod::create($startDate, '1 day', $endDate);

        foreach ($period as $date) {
            // Skip weekends
            if ($date->isWeekend()) {
                continue;
            }

            foreach ($children as $child) {
                // Determine status randomly with weights
                $chance = rand(1, 100);
                if ($chance <= 85) {
                    $statut = 'present';
                    $motif = null;
                } elseif ($chance <= 95) {
                    $statut = 'absent';
                    $motif = 'Maladie'.(rand(0, 1) ? ' (Grippe)' : '');
                } else {
                    $statut = 'en_retard';
                    $motif = 'Transport'.(rand(0, 1) ? ' (Embouteillage)' : '');
                }

                Attendance::create([
                    'child_id' => $child->id,
                    'date' => $date->format('Y-m-d'),
                    'statut' => $statut,
                    'motif' => $motif,
                ]);
            }
        }
    }
}
