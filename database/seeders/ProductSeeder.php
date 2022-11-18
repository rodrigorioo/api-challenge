<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoriesWithoutChildren = $categories = Category::whereDoesntHave('childrens')
            ->get()
            ->pluck('id');

        for($i = 0; $i < 500; $i++) {

            $data = [];

            for($j = 0; $j < 1000; $j++) {
                $categoryId = $categoriesWithoutChildren->random();

                $productData = Product::factory()->make([
                    'name' => "Producto ".$i + $j,
                    'category_id' => $categoryId,
                ]);

                $data[] = $productData->toArray();
            }

            Product::insert($data);
        }
    }
}
