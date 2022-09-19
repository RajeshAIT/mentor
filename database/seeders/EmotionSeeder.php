<?php

namespace Database\Seeders;

use App\Models\Emotion;
use Illuminate\Database\Seeder;

class EmotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['emotion' => 'excited'],
            ['emotion' => 'happy'],
            ['emotion' => 'alert'],
            ['emotion' => 'nervous'],
            ['emotion' => 'curious']

        ];
        Emotion::insert($data);
    }
}
