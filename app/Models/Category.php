<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'discriminator',
        'state',
    ];

    public function scopeFiltersToIndex($query, $filters)
    {
        $query->where('category.name', 'like', '%' . $filters . '%');
    }
}
