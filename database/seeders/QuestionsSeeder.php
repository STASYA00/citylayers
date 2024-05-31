<?php

namespace Database\Seeders;

use App\Models\Question;

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
        $questions = [
            ['category' => 'Beauty', 'question' => 'How would you rate the beauty of this space?'],
            ['category' => 'Beauty', 'question' => 'Which features of beauty are you rating?'],
            ['category' => 'Sound', 'question' => 'What do you think of the sounds around you?'],
            ['category' => 'Sound', 'question' => 'Which sounds are you rating?'],
            ['category' => 'Movement', 'question' => 'How would you rate the movement around this place?'],
            ['category' => 'Movement', 'question' => 'Which aspects of movement are you rating?'],
            ['category' => 'Protection', 'question' => 'How would you rate the protection in this place?'],
            ['category' => 'Protection', 'question' => 'Which types of protection are you rating?'],
            ['category' => 'Climate comfort', 'question' => 'How comfortable do you find the climate here?'],
            ['category' => 'Climate comfort', 'question' => 'Which types of climate (protection) are you rating?'],
            ['category' => 'Activities', 'question' => 'How enjoyable are the available activities in this area?'],
            ['category' => 'Activities', 'question' => 'Which activities are you rating?'],

        ];

        foreach ($questions as $qData) {
            Question::create($qData);
        }
    }
}
