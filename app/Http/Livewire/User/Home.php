<?php

namespace App\Http\Livewire\User;

use App\Models\Quiz;
use App\Models\QuizSession;
use Livewire\Component;

class Home extends Component
{
    public $quizzes = [];
    public $creating = false;
    public $quizTitle = '';

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
        Quiz::where('id', $quizId)->delete();
        // $this->quizzes->get($quizId, optional())->delete();
        // $this->quizzes->forget($quizId);
    }

    public function startSession($quizId)
    {

        // dd($this->quizzes->get($quizId));
	    if(isset($this->quizzes)){
            foreach ($this->quizzes as $key => $value) {
                $quiz = $this->quizzes[$key];
            }
        }

        $quiz = $this->quizzes[$quizId];

        $session = $quiz->startSession(rand(pow(10, 5), pow(10, 6) - 1));

        // return redirect()->route('quiz.start', $session);
    }

    public function abandonAndStartNewSession($quizId, $sessionId)
    {
        QuizSession::where('id', $sessionId)->where('quiz_id', $quizId)->delete();

        $quiz = $this->quizzes[$quizId];

        $session = $quiz->startSession(rand(pow(10, 5), pow(10, 6) - 1));

        return redirect()->route('user.quiz.start', $session);
    }

    public function discardSession($sessionId)
    {
        QuizSession::where('id', $sessionId)->delete();

        return redirect()->route('home');
    }

    public function mount()
    {
        $this->quizzes = Quiz::withFreshSession()->get()->keyBy('id');
    }
}
