<?php

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Product::all()->each(function ($product) use ($faker){
            for ($i =1; $i < rand(1, 3); $i++){
                $product->reviews()->create([
                    'user_id'   => rand(4, 16),
                    'name'      => $faker->username,
                    'email'     => $faker->safeEmail,
                    'title'     => $faker->sentence,
                    'message'   => $faker->paragraph,
                    'status'    => rand(0, 1),
                    'rating'    => rand(1, 5),
                ]);
            }
        });
    }
}
