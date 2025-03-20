<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculty';
    protected $primaryKey = 'faculty_id';
    public $incrementing = false; // Since faculty_id is a string
    protected $keyType = 'string';

    protected $fillable = [
        'faculty_id',
        'rfid_uid',
        'fname',
        'mname',
        'lname',
        'suffix',
    ];

    public function logs()
    {
        return $this->hasMany(Logs::class, 'faculty_id', 'faculty_id');
    }
}
