<?php

namespace App\Http\Livewire\User;

use App\Quiz;
use App\QuizSession;
use Livewire\Component;

class Home extends Component
{
    public $quizzes = [];
    public $sessions = [];
    public $quizTitle = '';
    public $creating, $isFresh = false;

    public function render()
    {
        return view('livewire.user.home');
    }

    public function createQuiz()
    {
        $this->validate([
            'quizTitle' => 'required|string|min:5|max:190'
        ]);

        $quiz = Quiz::create(['title' => $this->quizTitle]);

        $this->quizTitle = '';

        $this->quizzes->put($quiz->id, $quiz);

        $this->emit('creatingStatus', false);
    }

    public function deleteQuiz($quizId)
    {
        // Quiz::where('id', $quizId)->delete();

        $this->quizzes->get($quizId, optional())->delete();

        $this->quizzes->forget($quizId);
    }

    public function startSession($quizId)
    {
        $quiz = $this->quizzes[$quizId];

        if (isset($this->quizzes)){
            foreach ($this->quizzes as $key => $value){
                $quiz = $this->quizzes[$key];
            }
        }

        $session = $quiz->startSession(rand(pow(10, 5), pow(10, 6) - 1));

        $this->sessions->put($session->id, $session);

        $this->checkState($quizId);

        return redirect()->route('user.quiz.start', $session);
    }

    public function checkState($quizId)
    {
        $session = QuizSession::where('quiz_id', $quizId)->get()->first();
        dd($session);
        if ($session->isFresh()){
            $this->isFresh = true;
        }
    }

    public function abandonAndStartNewSession($quizId)
    {
        $session = QuizSession::where('quiz_id', $quizId)->latest('id');

        $this->sessions->get($session->id, optional())->delete();

        $this->sessions->forget($session->id);

        $quiz = $this->quizzes[$quizId];

        $session = $quiz->startSession(rand(pow(10, 5), pow(10, 6) - 1));

        $this->sessions->put($session->id, $session);

        return redirect()->route('user.quiz.start', $session);
    }

    public function discardSession($quizId)
    {
        QuizSession::where('quiz_id', $quizId)->latest('id')->delete();
        
        return redirect()->route('home');
    }

    public function mount()
    {
        $this->quizzes = Quiz::get()->keyBy('id');

        $this->sessions = QuizSession::latest('id')->get()->keyBy('id');

        // dd($this->sessions);
    }
}   