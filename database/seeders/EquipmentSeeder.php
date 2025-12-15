<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipment = [
            [
                'name' => 'Mikroskop Digital',
                'code' => 'LAB-001',
                'description' => 'Mikroskop digital dengan pembesaran hingga 1000x, dilengkapi kamera untuk dokumentasi',
                'quantity' => 5,
                'availability_status' => 'tersedia'
            ],
            [
                'name' => 'Spektrofotometer UV-Vis',
                'code' => 'LAB-002',
                'description' => 'Alat untuk mengukur absorbansi cahaya pada rentang UV dan visible',
                'quantity' => 3,
                'availability_status' => 'tersedia'
            ],
            [
                'name' => 'pH Meter Digital',
                'code' => 'LAB-003',
                'description' => 'pH meter digital dengan akurasi tinggi untuk pengukuran pH larutan',
                'quantity' => 10,
                'availability_status' => 'tersedia'
            ],
            [
                'name' => 'Centrifuge',
                'code' => 'LAB-004',
                'description' => 'Centrifuge dengan kecepatan maksimal 5000 rpm untuk pemisahan sampel',
                'quantity' => 4,
                'availability_status' => 'tersedia'
            ],
            [
                'name' => 'Hotplate Stirrer',
                'code' => 'LAB-005',
                'description' => 'Hotplate dengan magnetic stirrer untuk pemanasan dan pengadukan larutan',
                'quantity' => 8,
                'availability_status' => 'tersedia'
            ],
            [
                'name' => 'Pipet Mikro 10-100 µL',
                'code' => 'LAB-006',
                'description' => 'Pipet mikro adjustable volume 10-100 mikroliter',
                'quantity' => 15,
                'availability_status' => 'tersedia'
            ],
            [
                'name' => 'Neraca Analitik',
                'code' => 'LAB-007',
                'description' => 'Neraca analitik dengan ketelitian 0.0001 gram',
                'quantity' => 6,
                'availability_status' => 'tersedia'
            ],
            [
                'name' => 'Inkubator',
                'code' => 'LAB-008',
                'description' => 'Inkubator dengan kontrol suhu 20-60°C untuk kultur mikroorganisme',
                'quantity' => 2,
                'availability_status' => 'tersedia'
            ],
            [
                'name' => 'Autoclave',
                'code' => 'LAB-009',
                'description' => 'Autoclave untuk sterilisasi alat dan media dengan suhu 121°C',
                'quantity' => 2,
                'availability_status' => 'tersedia'
            ],
            [
                'name' => 'Vortex Mixer',
                'code' => 'LAB-010',
                'description' => 'Vortex mixer untuk mencampur larutan dengan cepat',
                'quantity' => 12,
                'availability_status' => 'tersedia'
            ]
        ];

        foreach ($equipment as $item) {
            \App\Models\Equipment::create($item);
        }
    }
}
