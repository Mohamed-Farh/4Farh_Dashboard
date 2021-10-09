<?php

namespace App\Models;

use App\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class ShippingCompany extends Model
{

    use SearchableTrait;

    protected $guarded = [];


    protected $searchable = [
        'columns' => [
            'shipping_companies.name'        => 10,
            'shipping_companies.code'        => 10,
            'shipping_companies.description' => 10,

        ],
    ];


    public function status()
    {
        return $this->status ? 'Active' : 'InActive';
    }

    public function fast()
    {
        return $this->fast ? 'Fast Delivery' : 'Normal Delivery';
    }

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'shipping_company_country');
    }


}

