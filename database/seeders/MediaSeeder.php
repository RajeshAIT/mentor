<?php

namespace Database\Seeders;

use App\Models\Mediatype;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mediatype::create([
                'name' => "Image"]);
        Mediatype::create([
                'name' => "Video"]);
        Mediatype::create([
                'name' => "Document"]);
    }
}
