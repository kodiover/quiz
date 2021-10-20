<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizPlayer extends Model
{
    // Defined variable to allow for 'nickname' to be overriden
    protected $fillable = ['nickname'];

    // Function links QuizPlayer with QuestionResponse model
    public function responses()
    {
        return $this->hasMany(QuestionResponse::class, 'player_id');
    }
    
    // Function that defines a child for the QuizSession class
    public function session()
    {
        return $this->belongsTo(QuizSession::class, 'quiz_session_id');
    }

    public function respond($question, $key)
    {
        if (
            ! $question->is($this->session->currentQuestion())
            || $this->session->hasTimedOut()
        ) {
            return false;
        }

        return $this->responses()->firstOrCreate(
            ['question_id' => $question->id],
            ['response' => $key]
        );
    }
}
