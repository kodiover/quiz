<?php

namespace App\Http\Livewire\User;

use App\Models\QuizSession;
use App\Models\QuizPlayer;
use App\Models\PlayerSession;
use Livewire\Component;

class QuizLeaderboard extends Component
{
    protected $sessionId;
    protected $session;

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
       QuizSession::where('id', PlayerSession::id())->delete();
       return redirect(route('home'));

    }

    public function mount($quizSession)
    {
        $this->sessionId = $quizSession;

    }
}
