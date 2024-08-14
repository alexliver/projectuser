<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department',
        'start_date',
        'end_date',
        'status',
    ];

    public static $statuses = [
        'in_progress' => 'In Progress',
        'finished' => 'Finished',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
