<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\NextQuestion;
use App\Events\QuizSessionEnded;

class QuizSession extends Model
{
    // Defined variable to allow keys to be mass assignable
    protected $fillable = ['pin', 'started_at', 'ended_at', 'next_question_at', 'current_question_index'];

    // Defined variable to allow the conversion of timestamps to datetime
    protected $casts = [
        'next_question_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    // Defined functions to allow for a filter for quiz sessions
    public function scopeActive($query)
    {
        return $query->where('started_at', '<=', now())
            ->whereNull('ended_at');
    }
    public function scopeFresh($query)
    {
        return $query->whereNull('started_at')
            ->whereNull('ended_at');
    }
    // public function scopeStale($query)
    // {
    //     return $query->whereNotNull('started_at')
    //         ->where('ended_at', '<', now());
    // }

    // Defined function to create a player session for each player
    public function joinAs($nickname)
    {
        return tap($this->players()->firstOrCreate(['nickname' => $nickname]), function($player) {
            PlayerSession::nickname($player->nickname);
        });
    }

    // Function links QuizPlayer to QuizSession model
    public function players()
    {
        return $this->hasMany(QuizPlayer::class);
    }

    // Function that defines a child for the Quiz Class
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Defined function to set neccessary attributes to start the session
    public function start($delayInSeconds = 0)
    {
        return $this->update([
            'started_at' => now(),
            'next_question_at' => now()->addSeconds($this->quiz->questions->first()->time_limit + $delayInSeconds),
            'pin' => null,
            'current_question_index' => 0,
        ]);
    }

    // Defined function that increments to the next question
    public function nextQuestion($delayInSeconds = 0)
    {
        $this->current_question_index++;

        $question = $this->quiz->questions->get($this->current_question_index, null);

        if (! $question) {
            return $this->update(['current_question_index' => null]);
        }

        $this->next_question_at = now()->addSeconds($question->time_limit + $delayInSeconds);

        $this->save();

        event(new NextQuestion($this, $question));

        return $question;
    }

    // Defined function to end the current quiz session
    public function endSession()
    {
        $this->update([
            'ended_at' => now(),
            'next_question_at' => null
        ]);
        event(new QuizSessionEnded($this));
    }

    // Defined functions that return a specific value
    public function isActive()
    {
        return $this->started_at && ! $this->ended_at;
    }

    public function isFresh()
    {
        return ! $this->started_at && ! $this->ended_at;
    }

    public function isStale()
    {
        return $this->started_at && $this->ended_at;
    }

    // Defined function to link QuizPlayer's QuestionResponse
    public function responses()
    {
        return $this->hasManyThrough(QuestionResponse::class, QuizPlayer::class, 'quiz_session_id', 'player_id');
    }

    // Defined function to return the current question
    public function currentQuestion()
    {
        $index = $this->current_question_index;

        return $this->quiz->questions->get($index, null);
    }

    // Defined function returns boolean depending on the attributes
    public function hasTimedOut()
    {
        return $this->ended_at
            || ! $this->next_question_at
            || $this->next_question_at < now();
    }
}

