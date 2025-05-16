<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            ['title' => 'Bronze Package', 'type' => 'bronze' , 'price' => 1100, 'client_number' => 2],
            ['title' => 'Silver Package', 'type' => 'silver', 'price' => 1600, 'client_number' => 3],
            ['title' => 'Gold Package', 'type' => 'gold', 'price' => 2100, 'client_number' => 4],
        ];

        foreach ($packages as $package) {
            Package::create([
                'title' => $package['title'],
                'price' => $package['price'],
                'number_of_client' => $package['client_number'],
                'thumbnail' => 'default/'.$package['title'].'.png',
                'type' => $package['type'],
                'val_type' => 'EX VAT',
            ]);
        }
    }
}
