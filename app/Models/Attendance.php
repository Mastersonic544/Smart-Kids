<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a daily attendance record for a child.
 */
class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'date',
        'statut',
        'motif',
    ];
}
