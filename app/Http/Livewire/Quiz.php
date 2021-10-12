<?php

namespace App\Http\Livewire;

use App\Models\PlayerSession;
use App\Models\QuizSession;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Quiz extends Component
{
    use AuthorizesRequests;

    public $session;

    public function getListeners()
    {
        return [
            "echo:Quiz.{$this->session['id']},QuizSessionStarted" => 'redirectToPlay'
        ];
    }

    public function render()
    {
        return view('livewire.quiz');
    }

    public function redirectToPlay()
    {
        $this->redirect(route('quiz.play', $this->session));
    }

    public function mount(QuizSession $quizSession)
    {
        $this->authorize('view', $quizSession);

        $this->session = $quizSession->load(['quiz']);

        if ($this->session->start_quiz) {
            $this->startQuiz = 1;
        } else {
            $this->startQuiz = 50;
        }

        if ($this->session->isActive()){
            $this->redirect(route('quiz.play', $this->session));
        }
    }
}
