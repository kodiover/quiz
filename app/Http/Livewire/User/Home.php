<?php

namespace App\Http\Livewire\User;

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

    // Defined function to create a Quiz model
    public function createQuiz()
    {
        $this->validate([
            'quizTitle' => ['required', 'string', 'min:5', 'max:190']
        ]);

        $user_id = Auth::user()->id;

        $quiz = Quiz::create(['title' => $this->quizTitle, 'user_id' => $user_id]);

        $this->quizTitle = '';

        $this->quizzes->put($quiz->id, $quiz);

        $this->emit('creatingStatus', false);
    }

    // Function to remove a quiz
    public function deleteQuiz($quizId, $index)
    {
        unset($this->quizzes[$index]);
        
        Quiz::where('id', $quizId)->delete();
    }

    // Function to start a quiz session 
    public function startSession($quizId)
    {   
        $quiz = Quiz::where('id', $quizId)->first();

        $session = $quiz->startSession(rand(pow(10, 5), pow(10, 6) - 1));

        return redirect(route('user.quiz.start', $session));
    }

    // Function to abandon and redirect to a new session 
    public function abandonAndStartNewSession($quizId, $sessionId)
    {
        QuizSession::where('id', $sessionId)->where('quiz_id', $quizId)->delete();

        $quiz = $this->quizzes[$quizId];

        $session = $quiz->startSession(rand(pow(10, 5), pow(10, 6) - 1));

        return redirect(route('user.quiz.start', $session));
    }

    // Function to discard the session
    public function discardSession($sessionId)
    {
        QuizSession::where('id', $sessionId)->delete();

        return redirect(route('home'));
    }

    // Function to resume the session
    public function resumeSession($sessionId)
    {
        return redirect(route('user.quiz.start', $sessionId));
    }

    // Function defines what the quiz array stores
    public function mount()
    {
        $user_id = Auth::user()->id;

        $this->quizzes = Quiz::withFreshSession()->where('user_id', $user_id)->get()->keyBy('id');
    }
}
