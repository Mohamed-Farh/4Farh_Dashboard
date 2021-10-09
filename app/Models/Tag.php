<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tag extends Model
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
            'tags.name' => 10,
        ],
    ];

    public function products(): morphToMany
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
