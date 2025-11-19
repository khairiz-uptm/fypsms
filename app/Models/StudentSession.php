<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class StudentSession extends Model
{
    use Searchable;

    public function toSearchable(){
        return[
            'session_name' => $this->session_name,
        ];
    }

    public function searchableAs()
    {
        return 'session_index';
    }
}
