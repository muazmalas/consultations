<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

	protected $table = 'appointments';

    protected $fillable = [
        'user_id',
        'expert_id',
        'consultation_id',
        'from_time',
        'to_time',
        'status'
    ];

    // Get Users
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function expert()
    {
        return $this->belongsTo('App\Models\User', 'expert_id', 'id');
    }

    public function consultation()
    {
        return $this->belongsTo('App\Models\Consultation', 'consultation_id', 'id');
    }

}
