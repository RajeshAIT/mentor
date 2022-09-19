<?php

namespace Database\Seeders;

use App\Models\QuestionAssociation;
use Illuminate\Database\Seeder;

class QuestionAssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ['question_association' => 'product'],
            ['question_association' => 'people'],
            ['question_association' => 'operations']
        ];
        QuestionAssociation::insert($data);
    }
}
