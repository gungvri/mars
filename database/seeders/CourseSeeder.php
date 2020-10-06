<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Course;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::factory()->count(90)->create()->each(function ($course) {
            $faker = \Faker\Factory::create();
            $time = $faker->dateTimeBetween('-1 week', '+ 1 week');
            $dt = Carbon::instance($time);
            $midDay = Carbon::instance($dt)->midDay();
            if ($dt < $midDay) {
                // The use case is that we have lessons mostly in the evening, so pushing
                // the hours to the second half of the day. This way the UI will better reflect
                // what we will see in prod.
                $dt = $dt->addHours(12);
            }
            $course->classrooms()->attach(
                Classroom::all()->random(),
                ['time' => $dt]
            );
        });
    }
}