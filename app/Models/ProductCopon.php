<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

use Cviebrock\EloquentSluggable\Sluggable;

class ProductCopon extends Model
{

    use Sluggable, SearchableTrait;

    protected $guarded = [];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $searchable = [
        'columns' => [
            'product_copons.code' => 10,
            'product_copons.description' => 10,
        ],
    ];

    protected $dates = [ 'start_date', 'expire_date'];




}

