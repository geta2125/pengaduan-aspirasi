<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'username',
        'nama',
        'password',
        'role',
        'foto'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // app/Models/User.php
    public function warga()
    {
        return $this->hasOne(Warga::class, 'user_id', 'id');
    }

}
