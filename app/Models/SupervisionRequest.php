<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class SupervisionRequest extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'student_id',
        'lecturer_id',
        'project_title',
        'status',
        'request_message',
        'request_date',
    ];

    public function toSearchable(){
        return[
            'project_title' => $this->project_title,
            'status'=> $this->status,
            'request_message' => $this->request_message,
            'request_date' => $this->request_date,
        ];
    }

    public function searchableAs()
    {
        return 'request_index';
    }

    public function student()
    {
    return $this->belongsTo('App\Models\StudentProfile', 'student_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo('App\Models\SupervisorProfile', 'lecturer_id', 'id');
    }
}
