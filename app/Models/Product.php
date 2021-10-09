<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
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
            'products.name' => 10,
        ],
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags(): MorphToMany
    {
        return $this->MorphToMany(Tag::class, 'taggable');
    }

    //علشان يجيب اول صوره تحمل الاسم يتاع البودكت
    public function firstMedia(): MorphOne
    {
        return $this->MorphOne(Media::class, 'mediable')->orderBy('file_sort', 'asc');
    }


    public function media(): MorphMany
    {
        return $this->MorphMany(Media::class, 'mediable');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

}
