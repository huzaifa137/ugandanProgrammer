<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assignment_id',
        'submitted_text',
        'submitted_file',
        'submitted_at',
        'grade',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
