<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plate extends Model
{
    protected $table = 'plate';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'state',
        'avatar',
        'idCategory',
    ];

    public function scopeFiltersToIndex($query, $filters)
    {
        $query->where('plate.name', 'like', '%' . $filters . '%');
    }
}
