<?php

namespace Database\Seeders;

use App\Models\Category;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Beauty', 'description' => 'Reflects harmony of the environment.', 'color' => 'C4B5F0'],
            ['name' => 'Sound', 'description' => 'Refers to the noise emitted from various sources in an urban environment.', 'color' => 'B1CDEF'],
            ['name' => 'Movement', 'description' => 'Flow of vehicles and people within the city.', 'color' => '5DB3B5'],
            ['name' => 'Protection', 'description' => 'All about keeping our cities safe and sound, from guarding against crime to shielding us from environmental challenges.', 'color' => '3ACE8E'],
            ['name' => 'Climate comfort', 'description' => 'Balancing the heat, the breeze, and the shade to keep us comfortable outdoors.', 'color' => 'A1F7B9'],
            ['name' => 'Activities', 'description' => 'Actions and behaviors associated with cities or densely populated areas.', 'color' => 'FFE7A4'],
        ];

        foreach ($categories as $catData) {
            Category::create($catData);
        }
    }
}
