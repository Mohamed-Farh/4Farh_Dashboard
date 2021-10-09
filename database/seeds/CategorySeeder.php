<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clothes = Category::create(['name' => 'Clothes', 'cover' => 'clothes.png', 'status' => true, 'visible' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women T-shirt', 'cover' => 'womenclothes.png', 'status' => true, 'visible' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 T-shirt', 'cover' => 'womenclothes2.png', 'status' => true, 'visible' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man T-shirt', 'cover' => 'manclothes.png', 'status' =>true, 'visible' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man2 T-shirt', 'cover' => 'manclothes2.png', 'status' => true, 'visible' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);


        $shoses = Category::create(['name' => 'Shoses', 'cover' => 'shoses.png', 'status' => true, 'visible' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women Shoses', 'cover' => 'womenshoses.png', 'status' => true, 'visible' => true, 'parent_id' => $shoses->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 Shoses', 'cover' => 'womenshoses2.png', 'status' => true, 'visible' => true, 'parent_id' => $shoses->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Man Shoses', 'cover' => 'manshoses.png', 'status' => true, 'visible' => true, 'parent_id' => $shoses->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Man2 Shoses', 'cover' => 'manshoses2.png', 'status' => true, 'visible' => true, 'parent_id' => $shoses->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);


        $watches = Category::create(['name' => 'Watches', 'cover' => 'watches.png', 'status' => true, 'visible' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women Watch', 'cover' => 'womenwatches.png', 'status' => true, 'visible' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 Watch', 'cover' => 'womenwatches2.png', 'status' => true, 'visible' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man Watch', 'cover' => 'manwatches.png', 'status' => true, 'visible' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man2 Watch', 'cover' => 'manwatches2.png', 'status' => true, 'visible' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);

    }
}
