<?php

namespace App\Http\Livewire\User;

use App\Events\QuizSessionStarted;
use Illuminate\Support\Facades\DB;
use App\Models\QuizSession;
use Livewire\Component;

class Quiz extends Component
{
    public $session;

    protected function getListeners() {
        return [
            "echo:private-User.Quiz.{$this->session['id']},PlayerJoined" => 'loadPlayers'
        ];
    }

    public function render()
    {
        return view('livewire.user.quiz');
    }

    public function loadPlayers()
    {
        $this->session->load('players');
    }

    public function start()
    {
        $this->session->start();

        event(new QuizSessionStarted($this->session));
        
        // DB::table('quiz_sessions')->where('id', $this->session->id)->update(['start_quiz' => true]);

        return redirect()->route('user.quiz.play', $this->session);
        
    }

    public function mount(QuizSession $quizSession)
    {
        $this->session = $quizSession;

        if ($this->session->isActive()) {
            $this->redirect(route('user.quiz.play', $this->session));
        }
    }
}
