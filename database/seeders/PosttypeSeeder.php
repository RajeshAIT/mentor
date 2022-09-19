<?php

namespace Database\Seeders;

use App\Models\Posttype;
use Illuminate\Database\Seeder;

class PosttypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Posttype::create([
            'type' => "Post"]);
        Posttype::create([
          'type' => "Job"]);
    }
}
