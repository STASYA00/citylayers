<?php

namespace Database\Seeders;

use App\Models\Subcategory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [
            ['name' => 'Buildings', 'subcategory' => 'Architecture & sights', 'category' => 'Beauty'],
            ['name' => 'Landmarks', 'subcategory' => 'Architecture & sights','category' => 'Beauty'],
            ['name' => 'Colours', 'subcategory' => 'Architecture & sights','category' => 'Beauty'],
            ['name' => 'Street Art', 'subcategory' => 'Architecture & sights','category' => 'Beauty'],
            ['name' => 'Trees', 'subcategory' => 'Nature','category' => 'Beauty'],
            ['name' => 'Plants', 'subcategory' => 'Nature','category' => 'Beauty'],
            ['name' => 'Gardens', 'subcategory' => 'Nature','category' => 'Beauty'],
            ['name' => 'Water', 'subcategory' => 'Nature','category' => 'Beauty'],
            ['name' => 'Cleanliness', 'subcategory' => 'Care','category' => 'Beauty'],
            ['name' => 'Smell', 'subcategory' => 'Care','category' => 'Beauty'],

            ['name' => 'Water', 'subcategory' => 'Nature','category' => 'Sound'],
            ['name' => 'Wind', 'subcategory' => 'Nature','category' => 'Sound'],
            ['name' => 'Animals', 'subcategory' => 'Nature','category' => 'Sound'],
            ['name' => 'Voices', 'subcategory' => 'Human sounds','category' => 'Sound'],
            ['name' => 'Crowds', 'subcategory' => 'Human sounds','category' => 'Sound'],
            ['name' => 'Children', 'subcategory' => 'Human sounds','category' => 'Sound'],
            ['name' => 'Music', 'subcategory' => 'City noises','category' => 'Sound'],
            ['name' => 'Traffic', 'subcategory' => 'City noises','category' => 'Sound'],
            ['name' => 'Construction', 'subcategory' => 'City noises','category' => 'Sound'],

            ['name' => 'Walking','subcategory' => 'Accessibility', 'category' => 'Movement'],
            ['name' => 'Cycling', 'subcategory' => 'Accessibility','category' => 'Movement'],
            ['name' => 'Wheelchair access', 'subcategory' => 'Accessibility','category' => 'Movement'],
            ['name' => 'Benches', 'subcategory' => 'Comfort','category' => 'Movement'],
            ['name' => 'Stairs', 'subcategory' => 'Comfort','category' => 'Movement'],
            ['name' => 'Sidewalks', 'subcategory' => 'Comfort','category' => 'Movement'],
            ['name' => 'Crosswalks', 'subcategory' => 'Connectivity','category' => 'Movement'],
            ['name' => 'Public transport', 'subcategory' => 'Connectivity','category' => 'Movement'],
            ['name' => 'Wayfinding', 'subcategory' => 'Connectivity','category' => 'Movement'],

            ['name' => 'Cars', 'subcategory' => 'Protection from traffic', 'category' => 'Protection'],
            ['name' => 'Visibility', 'subcategory' => 'Protection from traffic','category' => 'Protection'],
            ['name' => 'Traffic signs', 'subcategory' => 'Protection from traffic','category' => 'Protection'],
            ['name' => 'Children safety','subcategory' => 'People safety', 'category' => 'Protection'],
            ['name' => 'Animal safety', 'subcategory' => 'People safety','category' => 'Protection'],
            ['name' => 'Lighting', 'subcategory' => 'People safety','category' => 'Protection'],
            ['name' => 'Pavement quality', 'subcategory' => 'Quality of roads & buildings','category' => 'Protection'],
            ['name' => 'Road condition', 'subcategory' => 'Quality of roads & buildings','category' => 'Protection'],
            ['name' => 'Building condition', 'subcategory' => 'Quality of roads & buildings','category' => 'Protection'],

            ['name' => 'Heat', 'subcategory' => 'Weather','category' => 'Climate Comfort'],
            ['name' => 'Humidity', 'subcategory' => 'Weather','category' => 'Climate Comfort'],
            ['name' => 'Airflow', 'subcategory' => 'Weather','category' => 'Climate Comfort'],
            ['name' => 'Shade', 'subcategory' => 'Climate protection','category' => 'Climate Comfort'],
            ['name' => 'Rain cover', 'subcategory' => 'Climate protection','category' => 'Climate Comfort'],
            ['name' => 'Wind shelter', 'subcategory' => 'Climate protection','category' => 'Climate Comfort'],

            ['name' => 'Sports', 'subcategory' => 'Everyday activities','category' => 'Activities'],
            ['name' => 'Shopping', 'subcategory' => 'Everyday activities','category' => 'Activities'],
            ['name' => 'Food', 'subcategory' => 'Everyday activities','category' => 'Activities'],
            ['name' => 'Dog parks','subcategory' => 'Social activities', 'category' => 'Activities'],
            ['name' => 'Playground', 'subcategory' => 'Social activities','category' => 'Activities'],
            ['name' => 'Relaxation', 'subcategory' => 'Social activities','category' => 'Activities'],
            ['name' => 'Friends meetup','subcategory' => 'Social activities', 'category' => 'Activities'],
            ['name' => 'Coffee', 'subcategory' => 'Social activities','category' => 'Activities'],
            ['name' => 'Toilet','subcategory' => 'Essential needs', 'category' => 'Activities'],
            ['name' => 'Drinking water','subcategory' => 'Essential needs', 'category' => 'Activities'],
        ];

        foreach ($subcategories as $subcatData) {
            Subcategory::create($subcatData);
        }
    }
}
