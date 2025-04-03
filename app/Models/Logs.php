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
        'faculty_id',
        'key_id',
        'details',
        'date_time_borrowed',
        'date_time_returned',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'faculty_id');
    }

    public function labKey()
    {
        return $this->belongsTo(LabKey::class, 'key_id', 'key_id');
    }
}
