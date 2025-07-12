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
        $startTime = Carbon::createFromTime(13, 30, 0, );
        $endTime = Carbon::createFromTime(17, 30, 0, );

        $audition = Audition::query()->create([
            'name' => 'Talent on Stage',
            'date' => Carbon::createFromDate('2025', '7', '26'),
            'start' => $startTime,
        ]);

        $audition->contents()->createMany([
            [
                'title' => 'Propose of the Audition',
                'slug' => 'propose-the-audition',
                'content' => "
                    <section class=\"objective\">
                        <h2>Purposes of the Audition</h2>
                        <p>
                            It's an ambitious but achievable goal to establish the Jazz Hamilton Youth Community Symphony (JHYCS) and culminate in an October concert. Here's a plan outlining the key steps:
                            Jazz Hamilton Youth Community Symphony (JHYCS) - Ages 10-17.
                            <br/>
                            To be a premier youth orchestral program that nurtures future musicians, enriches the community through music, and provides a platform for artistic expression.
                        </p>
                    </section>
                ",
                'order' => 1
            ],
            [
                'title' => 'Requirements',
                'slug' => 'requirements',
                'content' => "
                    <section class=\"info\">
                        <h2>Requirements</h2>
                        <p>Participants must wear appropriate and respectful attire. Behavior must reflect that of a library—quiet, respectful, and free from loud noises.</p>
                        <p>Each participant will have five minutes to perform. After the audition, candidates will be contacted at the end of the day—or when deemed appropriate—to inform them whether they’ve been selected.</p>
                        <b>Who can audition for the Jazz Hamilton Youth Community Symphony (JHYCS) ?</b>
                        <p>We're  looking for  enthusiastic and talented young musicians and singers aged 10 to 17</p>
                    </section>
                ",
                'order' => 2
            ],
            [
                'title' => 'What to perform',
                'slug' => 'what-to-perform',
                'content' => "
                <section class=\"repertoire\">
                    <h2>What to perform</h2>
                    <p>Participants should be prepared to perform the following repertoire according to their instrument family:</p>

                    <div  style=\"text-align:center; height: 300px;overflow:hidden;background-position: center; background-image: url('https://plus.unsplash.com/premium_photo-1683219368443-cb52cb4bf023?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')\">

                    </div>

                    <h3>Strings</h3>
                    <ul>
                        <li>Beethoven – Symphony No. 5 (First Movement)</li>
                        <li>Bernstein – West Side Story (Selections)</li>
                    </ul>

                    <h3>Woodwinds</h3>
                    <ul>
                        <li>Gershwin – Rhapsody in Blue</li>
                        <li>Ellington – Take the \"A\" Train</li>
                    </ul>

                    <h3>Brass</h3>
                    <ul>
                        <li>Hamilton – Jazz Concerto for Youth</li>
                    </ul>

                    <h3>Percussion</h3>
                    <ul>
                        <li>Hamilton – Jazz Concerto for Youth</li>
                    </ul>

                    <h3>Singers</h3>
                    <ul>
                        <li>Beethoven – Symphony No. 5 (First Movement)</li>
                        <li>Bernstein – West Side Story (Selections)</li>
                    </ul>
                </section>
                ",
                'order' => 3
            ]
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
