<?php

namespace App\Http\Livewire\Admin;

use App\QuizPlayer;
use App\Quiz;
use Livewire\Component;

class QuizLeaderboard extends Component
{
    protected $sessionId;

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
        $session = Quiz::where('id', $this->sessionId);
        $session->sessions->endSession;
        return redirect()->route('admin.home');
            

    }

    public function mount($quizSession)
    {
        $this->sessionId = $quizSession;

    }
}
