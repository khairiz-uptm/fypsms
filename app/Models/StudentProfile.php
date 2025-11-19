<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class StudentProfile extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'student_name',
        'student_course',
        'student_phone',
        'student_profile_picture'
    ];

    public function toSearchable(){
        return[
            'student_name' => $this->student_name,
            'student_course'=> $this->student_course,
            'student_phone' => $this->student_phone,
            'user_id' => $this->user_id,
        ];
    }

    public function student_profile()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function student_requests()
    {
        return $this->hasMany('App\Models\SupervisionRequest', 'student_id', 'id');
    }
}
