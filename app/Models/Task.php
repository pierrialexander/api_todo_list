<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Category;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'user_id',
        'category_id'
    ];

    // DEFINE O RELACIONAMENTO COM USER A NÍVEL DE MODEL
    public function user() {
        return $this->belongsTo(User::class);
    }

    // DEFINE O RELACIOMANTO COM CATEGORY A NÍVEL DE MODEL
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
