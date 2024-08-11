<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name', 'cost_center', 'value_stream_id',
    ];

    public function valueStream()
    {
        return $this->belongsTo(ValueStream::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
