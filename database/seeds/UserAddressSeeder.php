<?php

use App\City;
use App\Country;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        DB::table('customer_addresses');
        Schema::enableForeignKeyConstraints();

        $faker = Factory::create();

        $farh  = User::whereUsername('Mohamed Farh')->first();
        $eg    = Country::with('states')->whereId(65)->first();
        $state = $eg->states->random()->id;
        $city  = City::whereStateId($state)->inRandomOrder()->first()->id;

        $farh->addresses()->create([
            'default_address'=> true,
            'address_title'  => 'Home',
            'first_name'     => 'Mohamed',
            'last_name'      => 'Farh',
            'email'          => $faker->email,
            'mobile'         => $faker->phoneNumber,
            'address'        => $faker->address,
            'address2'       => $faker->secondaryAddress,
            'country_id'     => $eg->id,
            'state_id'       => $state,
            'city_id'        => $city,
            'zip_code'       => $faker->randomNumber(5),
            'po_box'         => $faker->randomNumber(4),
        ]);

        $farh->addresses()->create([
            'default_address'=> false,
            'address_title'  => 'Work',
            'first_name'     => 'Mohamed',
            'last_name'      => 'Farh',
            'email'          => $faker->email,
            'mobile'         => $faker->phoneNumber,
            'address'        => $faker->address,
            'address2'       => $faker->secondaryAddress,
            'country_id'     => $eg->id,
            'state_id'       => $state,
            'city_id'        => $city,
            'zip_code'       => $faker->randomNumber(5),
            'po_box'         => $faker->randomNumber(4),
        ]);


        User::where('id', '>', '4')->each(function ($user) use ($faker, $eg, $state, $city){
            $user->addresses()->create([
                'default_address'=> false,
                'address_title'  => $faker->word,
                'first_name'     => $faker->firstName,
                'last_name'      => $faker->lastName,
                'email'          => $faker->email,
                'mobile'         => $faker->phoneNumber,
                'address'        => $faker->address,
                'address2'       => $faker->secondaryAddress,
                'country_id'     => $eg->id,
                'state_id'       => $state,
                'city_id'        => $city,
                'zip_code'       => $faker->randomNumber(5),
                'po_box'         => $faker->randomNumber(4),
            ]);
        });

    }
}
