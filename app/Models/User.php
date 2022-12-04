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
        'name',
        'email',
        'password',
        'role_id',
        'address',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Get User Role
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    // Get User consultations
    public function consultations()
    {
        return $this->belongsToMany('App\Models\Consultation', 'user_consultations');
    }

    // Get User appointments
    public function userAppointments()
    {
        return $this->hasMany('App\Models\Appointment', 'user_id', 'id');
    }

    // Get Expert appointments
    public function expertAppointments()
    {
        return $this->hasMany('App\Models\Appointment', 'expert_id', 'id');
    }

}
