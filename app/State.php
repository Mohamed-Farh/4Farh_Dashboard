<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class State extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    public $timestamps = false;

    protected $searchable = [
        'columns' => [
            'states.name' => 10,
        ],
    ];



    public function status()
    {
        return $this->status ? 'Active' : 'InActive';
    }



    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }



}
