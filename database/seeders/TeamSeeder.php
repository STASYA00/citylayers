<?php

namespace Database\Seeders;

use App\Models\TeamMember;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = [
            ['name' => 'Lovro Koncar-Gamulin', 'role' => 'research lead', 
            'link' => 'https://at.linkedin.com/in/lovro-koncar-gamulin-a46b37266'],
            ['name' => 'Peter Mörtenböck', 'role' => 'project director of “platFORMed city” (base project of “City Layers: Citizen Mapping as a Practice of City-Making”)', 
            'link' => 'https://www.gold.ac.uk/visual-cultures/p-mortenbock/'],
            ['name' => 'Angelos Chronis', 'role' => 'technical implementation lead', 
            'link' => 'https://iaac.net/dt-team/angelos-chronis/'],
            ['name' => 'Androniki Pappa', 'role' => 'researcher', 
            'link' => 'https://iaac.net/dt-team/androniki-pappa/6'],
            ['name' => 'Stasja Fedorova', 'role' => 'technical implementation', 
            'link' => 'https://www.linkedin.com/in/stasja-fedorova/'],
            ['name' => 'Aurel Richard', 'role' => 'UI / UX', 
            'link' => 'https://iaac.net/dt-team/aurel-richard/'],
            ['name' => 'Carmen Lael Hines', 'role' => 'researcher and outreach expert', 
            'link' => 'https://at.linkedin.com/in/carmen-lael-hines-4b84139b'],
            ['name' => 'Bilal Alame', 'role' => 'researcher and outreach expert', 
            'link' => 'https://archive-2020.biennial.ge/artist/bilal-alame/100'],
            ['name' => 'Eveline Wandl-Vogt', 'role' => 'researcher', 
            'link' => 'https://www.linkedin.com/in/evelinewandlvogt/'],

        ];

        foreach ($team as $qData) {
            TeamMember::create($qData);
        }
    }
}
