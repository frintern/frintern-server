<?php

use Illuminate\Database\Seeder;

class CareerPathQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('career_path_questions')->insert([
            ['text' => 'What did you study in school?'],
            ['text' => 'If you had to pick, which ones would you pick?'],
            ['text' => 'Which of the following do you enjoy doing the most?'],
            ['text' => 'Which describes you the most?'],
            ['text' => 'When given a task, which of the following do you do first?'],
            ['text' => 'If you were to be part of a team working on something, which role would you prefer?'],
            ['text' => 'Which of the following do you have experience in?'],
        ]);
    }
}
