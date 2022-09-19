<?php

namespace Database\Seeders;

use App\Models\Reaction;
use Illuminate\Database\Seeder;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data =[
        ['reactions' => 'like'],
        ['reactions' => 'heart'],
        ['reactions' => 'smiley'],
        ['reactions' => 'clap'],
        ['reactions' => 'brilliant']
       ];
       Reaction::insert($data);
    }
}
