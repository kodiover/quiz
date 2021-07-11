<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quiz extends Model
{
    // Defined variable to allow for 'title' to be overriden
    protected $fillable = ['title'];

    public function startSession($pin)
    {
        return $this->sessions()->create(['pin' => $pin]);
    }

    // Function links QuizSession with Quiz model
    public function sessions()
    {
        return $this->hasMany(QuizSession::class, 'quiz_id');
    }

    // Defines function to start a fresh session by adding a 'fresh_quiz_session_id' key
    public function freshSession()
    {
        return $this->belongsTo(QuizSession::class, 'fresh_quiz_session_id');
    }

    // SQL statement to define the scope of fresh session
    public function scopeWithFreshSession($query)
    {
        return $query->addSelect([     
            'fresh_quiz_session_id' => QuizSession::select('id')  // 'key' is in QuizSession('id') where column 'quiz_id'
                ->whereColumn('quiz_id', 'id')->fresh()->limit(1) //  links to 'id'
        ])->with('freshSession');
    }

    // Functions links Question with Quiz model
    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }
}
