<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relationships
    public function managers()
    {
        return $this->hasMany(User::class, 'cost_center_id');
    }
}
