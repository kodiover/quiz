<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\Quiz;
use Livewire\Component;
use App\Models\QuizSession;
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

        $this->quizzes->put($quiz->id, $quiz);

        $this->quizTitle = '';

        $this->emit('creatingStatus', false);
    }

    public function deleteQuiz($quizId)
    {
        // foreach ($this->quizzes as $object){

        //     $quizzes[] = (array) $object;

        //     $key = array_search($quiz, $quizzes);
        //     unset($this->quizzes[$key]);

        //     $this->quizzes = array_values(array($this->quizzes));
        // }

        unset($this->quizzes[$quizId-1]);
        Quiz::where('id', $quizId)->delete();
        return redirect(route('home'));
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
    }
}
