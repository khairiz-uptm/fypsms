<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;

class Expertise extends Model
{
    use Searchable;

    public function toSearchable(){
        return[
            'expertise_tag' => $this->expertise_tag,
        ];
    }

    public function searchableAs()
    {
        return 'expertise_index';
    }

    protected $fillable = [
        'expertise_tag',
    ];

    public static function getAllExpertiseTags()
    {
        // Return an array of unique, trimmed expertise tags.
        // Cached for one hour to avoid repeated DB queries.
        return Cache::remember('expertise_tags', 3600, function (): array {
            return self::orderBy('expertise_tag')
                ->pluck('expertise_tag')
                ->filter() // remove null/empty
                ->map(fn($s) => trim($s))
                ->unique()
                ->values()
                ->all();
        });
    }

}
