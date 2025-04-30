<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
        'description',
        'language',
        'difficulty',
        'tags',
        'thumbnail',
        'category_id',
        'is_published',
    ];

    // If using JSON for tags, ensure it's casted properly
    protected $casts = [
        'tags' => 'array',
    ];
}
