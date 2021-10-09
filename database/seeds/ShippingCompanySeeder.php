<?php

use App\Country;
use App\Models\ShippingCompany;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShippingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('shipping_companies')->truncate();
        DB::table('shipping_company_country')->truncate();
        Schema::enableForeignKeyConstraints();

        $Company1 = ShippingCompany::create([
            'name'          => '4FARH Company',
            'code'          => '4FARH',
            'description'   => '4FARH Company',
            'fast'          => true,
            'cost'          => '10 - 100',
            'status'        => true,
        ]);
        $Company1->countries()->attach([65]);

        $Company2 = ShippingCompany::create([
            'name'          => 'NEW Company',
            'code'          => 'NEW',
            'description'   => 'NEW Company',
            'fast'          => true,
            'cost'          => '5 - 80',
            'status'        => true,
        ]);
        $Company2->countries()->attach([65]);




        $countriesIds = Country::where('id', '!=', '65')->pluck('id')->toArray();

        $Company3 = ShippingCompany::create([
            'name'          => 'SHOP Company',
            'code'          => 'SHOP',
            'description'   => 'SHOP Company Outside',
            'fast'          => false,
            'cost'          => '5 - 80',
            'status'        => true,
        ]);
        $Company3->countries()->attach($countriesIds);

        $Company4 = ShippingCompany::create([
            'name'          => 'Travel Company',
            'code'          => 'Travel',
            'description'   => 'Travel Company Outside',
            'fast'          => true,
            'cost'          => '5 - 80',
            'status'        => true,
        ]);
        $Company4->countries()->attach($countriesIds);
    }
}
