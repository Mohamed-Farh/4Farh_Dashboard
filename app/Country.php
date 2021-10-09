<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Country extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    public $timestamps = false;

    protected $searchable = [
        'columns' => [
            'countries.name' => 10,
        ],
    ];


    public function status()
    {
        return $this->status ? 'Active' : 'InActive';
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }
}
