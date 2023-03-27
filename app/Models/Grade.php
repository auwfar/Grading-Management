<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_name',
        'quiz_score',
        'task_score',
        'presence_score',
        'practice_score',
        'exam_score'
    ];
}
