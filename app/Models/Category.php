<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
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
            'categories.name' => 10,
        ],
    ];



    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->hasOne(Product::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function appearedChildren()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('status', true);
    }

    public static function tree( $level = 1 )
    {
        return static::with(implode('.', array_fill(0, $level, 'children')))
            ->whereNull('parent_id')
            ->whereStatus(true)
            ->orderBy('id', 'asc')
            ->get();
    }

}
