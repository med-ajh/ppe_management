<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValueStream extends Model
{
    protected $fillable = [
        'name',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
