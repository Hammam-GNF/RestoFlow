<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = [
            ['name' => 'Nasi Goreng', 'price' => 25000, 'category' => 'Makanan'],
            ['name' => 'Mie Goreng', 'price' => 22000, 'category' => 'Makanan'],
            ['name' => 'Ayam Bakar', 'price' => 35000, 'category' => 'Makanan'],
            ['name' => 'Es Teh', 'price' => 8000, 'category' => 'Minuman'],
            ['name' => 'Es Jeruk', 'price' => 10000, 'category' => 'Minuman'],
            ['name' => 'Kopi Hitam', 'price' => 12000, 'category' => 'Minuman'],
        ];

        foreach ($foods as $food) {
            Food::create([
                ...$food,
                'is_available' => true,
            ]);
        }
    }
}
