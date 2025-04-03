<?php

// LabKey.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabKey extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'lab_keys';

    // The primary key for the model
    protected $primaryKey = 'key_id';

    // If your table doesn't have 'timestamps' columns, set this to false.
    public $timestamps = true;

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'key_id',
        'laboratory',
        'status',
    ];
}

