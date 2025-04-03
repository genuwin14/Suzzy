<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $timestamps = true;

    protected $fillable = [
        'fname',
        'lname',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
