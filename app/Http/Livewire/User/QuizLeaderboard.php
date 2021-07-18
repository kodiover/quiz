<?php

namespace App\Http\Livewire\User;

use App\Quiz;
use App\QuizPlayer;
use App\PlayerSession;
use Livewire\Component;

class QuizLeaderboard extends Component
{
    protected $sessionId;
    protected $session;

    public function render()
    {
        return view('livewire.admin.quiz-leaderboard', [
            'players' => QuizPlayer::whereQuizSessionId($this->sessionId)
                ->orderBy('score', 'desc')
                ->limit(7)
                ->get()
        ]);
    }

    public function end()
    {
       QuizSession::where('id', PlayerSession::id())->delete();
       return redirect(route('user.home'));

    }

    public function mount($quizSession)
    {
        $this->sessionId = $quizSession;

    }
}
