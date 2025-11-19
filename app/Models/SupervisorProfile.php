<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\SupervisionRequest;

class SupervisorProfile extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'supervisor_name',
        'supervisor_email',
        'supervisor_phone',
        'supervisor_expertise',
        'supervisor_profile_picture'
    ];

    public function toSearchableArray()
    {
        return [
            'supervisor_name' => $this->supervisor_name,
            'supervisor_email' => $this->supervisor_email,
            'supervisor_phone' => $this->supervisor_phone,
            'supervisor_expertise' => $this->supervisor_expertise,
        ];
    }

    public function searchableAs()
    {
        return 'supervisor_index';
    }

    public function profile()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function supervisees()
    {
        return $this->hasMany(SupervisionRequest::class, 'lecturer_id', 'id')
            ->where('status', 'approved');
    }

    public function supervisee_requests()
    {
        return $this->hasMany(SupervisionRequest::class, 'lecturer_id', 'id')
            ->where('status', 'pending');
    }

    public function supervisee_request()
    {
        return $this->hasOne(SupervisionRequest::class, 'lecturer_id', 'id');
    }
}
