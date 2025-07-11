<?php

namespace Database\Seeders;

use App\Models\Audition;
use App\Models\AuditionSlot;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuditionSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startTime = Carbon::createFromTime(9, 0, 0, );
        $endTime = Carbon::createFromTime(16, 0, 0, );

        $audition = Audition::query()->create([
            'name' => 'Talent on Stage',
            'date' => Carbon::createFromDate('2025', '7', '26'),
            'start' => $startTime,
        ]);

        while ($startTime < $endTime) {
            AuditionSlot::query()->create([
                'audition_id' => $audition->id,
                'time' => $startTime->format('H:i'),
                'max_participants' => 4
            ]);

            $startTime->addMinutes(40);
        }
    }
}
