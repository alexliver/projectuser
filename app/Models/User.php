<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'date_of_birth', 
        'gender', 
        'email', 
        'password',
    ];

    public static $genders = [
        'male' => 'Male',
        'female' => 'Female',
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}

