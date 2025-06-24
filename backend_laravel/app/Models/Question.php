<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'type',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    public function answers()  {
        return $this->hasMany(Answer::class);
    }

}
