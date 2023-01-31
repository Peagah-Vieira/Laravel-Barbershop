<?php

namespace App\Models;

use Buildix\Timex\Models\Category as BaseCategory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseCategory
{
    use HasUuids, HasFactory;
    
    protected $guarded = [];

    protected $fillable = [
        'value',
        'icon',
        'color',
    ];

    public $timestamps = false;

    public function getTable()
    {
        return config('timex.tables.category.name', "timex_categories");
    }
}
