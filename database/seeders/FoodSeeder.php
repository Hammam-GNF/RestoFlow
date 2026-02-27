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
            ['name' => 'Spring Rolls', 'price' => 18000, 'category' => 'Appetizers'],
            ['name' => 'Garlic Bread', 'price' => 15000, 'category' => 'Appetizers'],
            ['name' => 'Chicken Wings', 'price' => 22000, 'category' => 'Appetizers'],

            ['name' => 'Grilled Chicken', 'price' => 45000, 'category' => 'Main Course'],
            ['name' => 'Beef Steak', 'price' => 75000, 'category' => 'Main Course'],
            ['name' => 'Spaghetti Bolognese', 'price' => 42000, 'category' => 'Main Course'],

            ['name' => 'Caesar Salad', 'price' => 30000, 'category' => 'Salads'],
            ['name' => 'Greek Salad', 'price' => 28000, 'category' => 'Salads'],

            ['name' => 'Chocolate Lava Cake', 'price' => 25000, 'category' => 'Desserts'],
            ['name' => 'Ice Cream Sundae', 'price' => 20000, 'category' => 'Desserts'],

            ['name' => 'Mineral Water', 'price' => 8000, 'category' => 'Beverages'],
            ['name' => 'Iced Tea', 'price' => 12000, 'category' => 'Beverages'],
            ['name' => 'Cappuccino', 'price' => 25000, 'category' => 'Beverages'],
        ];

        foreach ($foods as $food) {
            Food::create([
                ...$food,
                'is_available' => true,
            ]);
        }
    }
}
