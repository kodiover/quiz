<?php

namespace App\Http\Livewire;

use App\Events\AnswerReceived;
use App\Models\PlayerSession;
use App\Models\QuizSession;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class PlayQuiz extends Component
{
    use AuthorizesRequests;

    public $count;
    public $session;
    public $question;
    public $response;
    public $player;
    public $showAnswer = false;
    public $ended = false;

    public function getListeners()
    {
        // We're using public channel for broadcasting to players,
        // because we don't want them to have to login to play.
        return [
            "echo:Quiz.{$this->session['id']},QuestionCompleted" => 'showAnswer',
            "echo:Quiz.{$this->session['id']},NextQuestion" => 'reload',
            "echo:Quiz.{$this->session['id']},QuizSessionEnded" => 'endQuiz',
        ];
    }

    public function render()
    {
        return view('livewire.play-quiz');
    }

    public function reload($data)
    {
        $this->redirect(route('quiz.play', $this->session));
    }


    public function storeAnswer($answerKey)
    {
        $this->response = $this->player->respond($this->question, $answerKey);

        event(new AnswerReceived($this->session, $this->response));
    }

    public function showAnswer()
    {
        $this->response = optional($this->response)->fresh();
        $this->showAnswer = true;
    }

    public function endQuiz()
    {
        PlayerSession::clear();
    }

    public function mount(QuizSession $quizSession)
    {
        $this->authorize('play', $quizSession);

        $this->session = $quizSession->load(['quiz']);

        $this->player = $quizSession->players()->whereNickname(
            PlayerSession::nickname()
        )->firstOrFail();

        $this->question = $this->session->quiz->questions
            ->get($this->session->current_question_index, null);

        if ( !$this->session->currentQuestion()){
            $this->ended = true;
        }

        $this->response = $this->player->responses()
            ->where('question_id', $this->question->id)
            ->first();

        if ($this->response && $this->response->score !== null) {
            $this->showAnswer();
        }
    }
}
