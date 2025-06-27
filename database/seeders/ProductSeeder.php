<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'image' => 'test',
            'name' => 'test name',
            'size' => 'M',
            'description' => 'test blah blah',
            'price' => 89700.90,
            'stock' => 78
        ]);
    }
}
