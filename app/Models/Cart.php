<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Example function to move to the next approval step
    public function advanceApproval()
    {
        $statuses = [
            'pending', 'step_1', 'step_2', 'step_3', 'step_4', 'step_5', 'step_6', 'approved'
        ];

        $currentStatusIndex = array_search($this->status, $statuses);
        if ($currentStatusIndex < count($statuses) - 1) {
            $this->status = $statuses[$currentStatusIndex + 1];
            $this->save();
        }
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}
