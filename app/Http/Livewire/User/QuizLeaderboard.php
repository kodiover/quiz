<?php

namespace App\Http\Livewire\User;

use App\Models\QuizSession;
use App\Models\QuizPlayer;
use Livewire\Component;

class QuizLeaderboard extends Component
{
    protected $session;
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
        $this->session->endSession();
        return redirect(route('home'));
    }

    public function mount($quizSession)
    {
        $this->sessionId = $quizSession;

        $this->session = QuizSession::where('id', $quizSession);
    }
}
