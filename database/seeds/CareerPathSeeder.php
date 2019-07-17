<?php

use Illuminate\Database\Seeder;

class CareerPathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('career_paths')->insert([
            [
                'name' => 'Web Interface and Experience (UI/UX) Designer',
                'career_path_category_id' => 1,
                'description' => 'A UI/UX designer designs the visual images and representations of what people see and experience on the web/internet.'
            ],
            [
                'name' => 'Front End Developer',
                'career_path_category_id' => 2,
                'description' => 'A front end developer builds what people see and experience on the web/internet.'
            ],
            [
                'name' => 'Back End Developer',
                'career_path_category_id' => 2,
                'description' => 'A back end developer builds the behind-the-scenes parts of what people see and experience on the web.'
            ],
            [
                'name' => 'Digital Marketer',
                'career_path_category_id' => 2,
                'description' => 'A digital marketer creates product awareness and brings in customers and users across all digital mediums.'
            ],
            [
                'name' => 'Project Manager',
                'career_path_category_id' => 3,
                'description' => 'A project manager plans, manages and executes projects.'
            ],
            [
                'name' => 'Community Manager',
                'career_path_category_id' => 3,
                'description' => 'A community manager builds, organizes, and manages groups of users while building advocacy for a company brand or cause, both online and offline.'
            ],
            [
                'name' => 'Business Developer',
                'career_path_category_id' => 3,
                'description' => 'A business developer designs and creates the business processes that help the business grow and scale.'
            ]
        ]);
    }
}
