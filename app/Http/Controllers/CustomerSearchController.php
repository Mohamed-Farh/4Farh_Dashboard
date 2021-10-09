<?php

namespace App\Http\Controllers;

use App\City;
use App\State;
use App\User;
use Illuminate\Http\Request;

class CustomerSearchController extends Controller
{
    public function index()
    {
        $customers = User::whereHas('roles', function($query){
            $query->where('name', 'customer');
        })
        ->when(\request()->input('query') != '', function ($query){
            $query->search(\request()->input('query'));
        })
        ->get(['id', 'first_name', 'last_name', 'email'])->toArray();

        return response()->json($customers);
    }



    public function get_state_customerSearch(Request $request)
    {
        $states = State::whereCountryId($request->country_id)->whereStatus(true)->get(['id', 'name'])->toArray();

        return response()->json($states);
    }


    public function get_city_customerSearch(Request $request)
    {
        $cities = City::whereStateId($request->state_id)->whereStatus(true)->get(['id', 'name'])->toArray();

        return response()->json($cities);
    }
}
