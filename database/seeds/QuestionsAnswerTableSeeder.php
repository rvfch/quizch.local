<?php

use Illuminate\Database\Seeder;

class QuestionsAnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\QuestionAnswer::class, 4)->create();
    }
}
