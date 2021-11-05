<?php

namespace App\Http\Livewire\User;

use App\Models\QuizPlayer;
use Livewire\Component;

class QuizLeaderboard extends Component
{
    protected $sessionId;

    public function render()
    {
        return view('livewire.user.quiz-leaderboard', [
            'players' => QuizPlayer::whereQuizSessionId($this->sessionId)
                ->orderBy('score', 'desc')
                ->limit(7)
                ->get()
        ]);
    }

    public function end()
    {
        return redirect(route('home'));
    }

    public function mount($quizSession)
    {
        $this->sessionId = $quizSession;
    }
}
