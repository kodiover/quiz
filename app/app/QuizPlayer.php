<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizPlayer extends Model
{
    protected $fillable = ['nickname'];

    public function responses()
    {
        return $this->hasMany(QuestionResponse::class, 'player_id');
    }

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
