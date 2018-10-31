<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
        	'quiz_id' => str_random(1),
        	'question_text' => str_random(10)
        ]);
    }
}
