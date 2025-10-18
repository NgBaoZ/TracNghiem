<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // Chỉ định rõ tên bảng trong database của bạn là 'questions'
    protected $table = 'questions';

    // Không cần cột created_at và updated_at
    public $timestamps = false;
}