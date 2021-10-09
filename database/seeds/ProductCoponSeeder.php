<?php

use App\Models\ProductCopon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProductCoponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCopon::create([
            'code'          =>'FARH_200',
            'type'          =>'fixed',
            'value'         =>200,
            'description'   =>'Discount $200 On Your Sales From Website',
            'use_times'     =>20,
            'start_date'    =>Carbon::now(),
            'expire_date'   =>Carbon::now()->addMonth(),
            'greater_than'  =>600,
        ]);


        ProductCopon::create([
            'code'          =>'FARH_50H',
            'type'          =>'percentage',
            'value'         =>50,
            'description'   =>'Discount 50% On Your Sales From Website',
            'use_times'     =>10,
            'start_date'    =>Carbon::now(),
            'expire_date'   =>Carbon::now()->addWeek(),
            'greater_than'  =>null,
        ]);
    }
}
