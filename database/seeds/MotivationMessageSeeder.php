<?php

use Illuminate\Database\Seeder;

class MotivationMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motivation_messages')->insert([
            [
                'title' => 'You are your own biggest project',
                'body' => 'There is only one corner of the universe you can be certain of improving, and that´s your own self.'
            ],
            [
                'title' => 'Start somewhere',
                'body' => 'Don´t judge each day by the harvest you reap but by the seeds that you plant.'
            ],
            [
                'title' => 'Get over the mental block',
                'body' => 'Do not give up, the beginning is always the hardest.'
            ],
            [
                'title' => 'Take it day by day',
                'body' => 'Smile and let everyone know that today, you´re a lot stronger then you were yesterday.'
            ],
            [
                'title' => 'Embrace challenges with poise',
                'body' => 'When life puts you in tough situations, don´t say "why me" just say "try me".'
            ]
        ]);
    }
}
