<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Truncate tables
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        // Seeders
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

    }
}
