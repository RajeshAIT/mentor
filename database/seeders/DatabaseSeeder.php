<?php

namespace Database\Seeders;

use App\Models\Posttype;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(MediaSeeder::class);
        $this->call(Posttype::class);
       // \App\Models\Company::factory(5)->create();

    }
}