<?php

namespace App\Models;

use Carbon\Carbon;
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
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function isActive($date=null) 
    {
        if (!$date)
            $date = Carbon::now(); 
        if ($this->status == 'finished')
            return false;
        $endDate = Carbon::parse($this->end_date)->addDay();
        if ($date < $this->start_date || $date >= $endDate)
            return false;
        return true;
    }
}
