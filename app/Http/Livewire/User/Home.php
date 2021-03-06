<?php

namespace App\Http\Livewire\User;

use App\Models\PlayerSession;
use App\Models\Quiz;
use App\Models\QuizSession;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public $quizzes = [];
    public $quizTitle = '';
    public $creating = false;

    public function render()
    {
        return view('livewire.user.home');
    }


    public function createQuiz()
    {
        $this->validate([
            'quizTitle' => ['required', 'string', 'min:5', 'max:190']
        ]);

        $user_id = Auth::user()->id;

        $quiz = Quiz::create(['title' => $this->quizTitle,'user_id' => $user_id]);

        $this->quizTitle = '';

        $this->quizzes->put($quiz->id, $quiz);

        $this->emit('creatingStatus', false);
    }

    public function deleteQuiz($quizId, $index)
    {
        unset($this->quizzes[$index]);
        
        Quiz::where('id', $quizId)->delete();

        QuizSession::where('quiz_id', $quizId)->delete();
    }

    public function startSession($quizId)
    {   
        if (isset($this->quizzes)){
            foreach ($this->quizzes as $key => $value){
                $quiz = $this->quizzes[$key];
            }
        }

        $quiz = Quiz::where('id', $quizId)->first();

        $session = $quiz->startSession(rand(pow(10, 5), pow(10, 6) - 1));

        return redirect(route('user.quiz.start', $session));
    }

    public function abandonAndStartNewSession($quizId, $sessionId)
    {
        QuizSession::where('id', $sessionId)->where('quiz_id', $quizId)->delete();

        $quiz = $this->quizzes[$quizId];

        $session = $quiz->startSession(rand(pow(10, 5), pow(10, 6) - 1));

        return redirect(route('user.quiz.start', $session));
    }


    public function discardSession($sessionId)
    {
        QuizSession::where('id', $sessionId)->delete();

        return redirect(route('home'));
    }

    public function resumeSession($sessionId)
    {
        return redirect(route('user.quiz.start', $sessionId));
    }

    public function mount()
    {
        $user_id = Auth::user()->id;

        $this->quizzes = Quiz::withFreshSession()->where('user_id',$user_id)->get()->keyBy('id');

        if (! isset($this->quizzes)){
            PlayerSession::clear();
        }
    }
}
