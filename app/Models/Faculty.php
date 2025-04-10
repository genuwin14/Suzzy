<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculty';
    protected $primaryKey = 'faculty_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'faculty_id',
        'rfid_uid',
        'pin_code',
        'fname',
        'mname',
        'lname',
        'suffix',
        'role_type',  // 🆕 Added field
        'admin_id',
        'status',
    ];    

    public function logs()
    {
        return $this->hasMany(Logs::class, 'faculty_id', 'faculty_id');
    }
}
