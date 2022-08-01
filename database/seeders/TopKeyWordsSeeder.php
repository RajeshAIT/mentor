<?php

namespace Database\Seeders;

use App\Models\TopKeywords;
use Illuminate\Database\Seeder;

class TopKeyWordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data =[
        ['keywords' => 'product'],
        ['keywords' => 'surgeon'],
        ['keywords' => 'inspired'],
        ['keywords' => 'people'],
        ['keywords' => 'happy'],
        ['keywords' => 'nurse'],
        ['keywords' => 'curious']
       ];
       TopKeyWords::insert($data);
    }
}
