<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'items';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'size',
        'status',
        'description',
        'image',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
