<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{

	protected $table = 'consultations';

    protected $fillable = [
        'consultation_type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Get Users
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_consultations');
    }

    // Get Appointments
    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment', 'id', 'consultation_id');
    }

}
