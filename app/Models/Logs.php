<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'faculty_id_borrowed',
        'faculty_id_returned',
        'key_id',
        'details',
        'date_time_borrowed',
        'date_time_returned',
    ];

    // New relations
    public function borrowedBy()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id_borrowed', 'faculty_id');
    }

    public function returnedBy()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id_returned', 'faculty_id');
    }

    public function labKey()
    {
        return $this->belongsTo(LabKey::class, 'key_id', 'key_id');
    }
}
