<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class City extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    public $timestamps = false;

    protected $searchable = [
        'columns' => [
            'cities.name' => 10,
        ],
    ];



    public function status()
    {
        return $this->status ? 'Active' : 'InActive';
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

}
