<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	protected $table = 'roles';

    protected $fillable = [
        'role_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Get Role Users
    public function users()
    {
        return $this->hasMany('App\Models\User', 'role_id', 'id');
    }


}
