<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section; // Make sure to import your Section model

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            ['name' => 'R1'],
            ['name' => 'R2'],
            ['name' => 'R3'],
            ['name' => 'R4'],
            ['name' => 'R5'],
            ['name' => 'R6'],
        ];

        foreach ($sections as $sectionData) {
            Section::create($sectionData);
        }
    }
}
