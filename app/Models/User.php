<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'lastname', 'te', 'email', 'password', 'role', 'department_id', 'cost_center_id', 'manager_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function employees()
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    // Relationship: An employee belongs to a manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }



    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }


}
