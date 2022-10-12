<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'color',
        'user_id'
    ];

    /**
     * Define o relacionamento com o model User
     * @return array
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Define o relacionamento com o model Task
     * @return array
     */
    public function tasks() {
        return $this->hasMany(Task::class);
    }

}
