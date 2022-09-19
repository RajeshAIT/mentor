<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UpdateMediatypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mediatypes')->where('name', 'Document')->update(['name' => 'Audio']);
    }
}
