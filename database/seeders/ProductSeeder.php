<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['product_name' => 'Chevrolet', 'merk' => 'Lumina', 'type' => '2002', 'police_number' => 'KNADM4A38E6053617', 'price' => '10000', 'created_at' => now()],
            ['product_name' => 'Honda', 'merk' => 'Ridgeline', 'type' => 'Riviera', 'police_number' => 'WBA3B3C59FJ861743', 'price' => '13000', 'created_at' => now()],
            ['product_name' => 'Ford', 'merk' => 'Expedition EL', 'type' => '1979', 'police_number' => '3D73M4CL9BG877895', 'price' => '16000', 'created_at' => now()],
            ['product_name' => 'Mazda', 'merk' => 'B-Series', 'type' => 'Intrepid', 'police_number' => 'WAUJT68E25A006363', 'price' => '15000', 'created_at' => now()],
            ['product_name' => 'Mitsubishi', 'merk' => 'Raider', 'type' => '2000', 'police_number' => '5FRYD4H48EB512313', 'price' => '20000', 'created_at' => now()],
            ['product_name' => 'Audi', 'merk' => 'TT', 'type' => 'Galant', 'police_number' => '5N1AA0ND6EN602419', 'price' => '6000', 'created_at' => now()]
        ];

        Product::insert($data); // Eloquent approach
    }
}
