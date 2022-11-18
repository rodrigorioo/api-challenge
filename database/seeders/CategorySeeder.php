<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    protected Generator $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct() {
        $this->faker = $this->withFaker();
    }

    protected function withFaker() {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        for($i = 0; $i < 500; $i++) {

            $fatherCategoryId = null;

            // To know if the category was a father or go to the first or second level
            $random = rand(1, 3);

            switch($random) {

                case 2:

                    $categories = Category::whereDoesntHave('father')
                        ->get();

                    if($categories->count() > 0) {
                        $fatherCategoryId = $categories->random()->id;
                    }

                    break;

                case 3:

                    $categories = Category::whereHas('father')
                        ->whereDoesntHave('childrens')
                        ->get();

                    if($categories->count() > 0) {
                        $fatherCategoryId = $categories->random()->id;
                    }

                    break;

                default:
                    $fatherCategory = null;
                    break;
            }

            $categorias = Category::factory()->create([
                'name' => 'Categoría '.$i,
                'father_id' => $fatherCategoryId,
            ]);

        }
    }
}
