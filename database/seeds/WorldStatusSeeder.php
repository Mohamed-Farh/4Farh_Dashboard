<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\State;
use App\City;

class WorldStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countriesArray = ['Algeria', 'Bahrain', 'Comoros', 'Djibouti', 'Egypt', 'Iraq', 'Jordan', 'Kuwait', 'Lebanon', 'Libya', 'Mauritania', 'Morocco', 'Oman', 'Qatar', 'Saudi Arabia', 'Somalia', 'Sudan', 'Syria', 'Tunisia', 'United Arab Emirates', 'Yemen'];

        Country::wherehas('states')
                ->whereIn('name', $countriesArray)
                ->update(['status' => true]);

        State::select('states.*')
                ->wherehas('cities')
                ->join('countries', 'states.country_id', '=', 'countries.id')
                ->where('countries.status', 1)
                ->update(['states.status' => true]);

        City::select('cities.*')
                ->join('states', 'cities.state_id', '=', 'states.id')
                ->where('states.status', 1)
                ->update(['cities.status' => true]);
    }
}
