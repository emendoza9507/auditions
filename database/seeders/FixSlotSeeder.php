<?php

namespace Database\Seeders;

use App\Models\Audition;
use App\Models\AuditionSlot;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startTime = Carbon::createFromTime(13, 30, 0, );
        $endTime = Carbon::createFromTime(17, 30, 0, );

        $audition = Audition::query()->find(1);

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
