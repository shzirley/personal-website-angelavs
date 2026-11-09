<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'AI / HEALTH-TECH',
        'PRODUCT / UI & UX',
        'ANDROID / SUSTAINABILITY',
        'WEB DEVELOPMENT',
    ];

    protected $fillable = [
        'title', 'slug', 'category', 'role', 'year', 'summary',
        'description', 'responsibilities', 'highlight', 'image', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'responsibilities' => 'array'];
    }
}
