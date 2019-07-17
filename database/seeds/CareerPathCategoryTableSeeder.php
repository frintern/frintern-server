<?php

use Illuminate\Database\Seeder;

class CareerPathCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('career_path_categories')->insert([
            ['name' => 'Design'],
            ['name' => 'Analyse'],
            ['name' => 'Manage']
        ]);
    }
}
