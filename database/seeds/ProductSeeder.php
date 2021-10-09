<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

use Faker\Factory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $categories = Category::whereNotNull('parent_id')->pluck('id');

        for ($i = 1; $i <1000; $i++) {
            $products[] =[
                'name'              => $faker->sentence(2, true),
                'slug'              => $faker->unique()->slug(2, true),
                'description'        => $faker->paragraph(),
                'price'             => $faker->numberBetween(5, 1000),
                'quantity'          => $faker->numberBetween(5, 10000),
                'category_id'       => $categories->random(),
                'featured'          => rand(0, 1),
                'status'            => true,
                'created_at'        => now(),
                'updated_at'        => now(),

            ];
        }

        $chunks = array_chunk($products, 100);  //حتي لا يحصل تحميل علي الداتا بيز بقوله دخل كل مية مع بعض دفعه واحدة
        foreach ($chunks as $chunk){
            Product::insert($chunk);
        }
    }
}
