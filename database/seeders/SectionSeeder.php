<?php

namespace Database\Seeders;

use App\Models\Team;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = [
            

        ];

        foreach ($sections as $s) {
            Section::create($s);
        }
    }
}
