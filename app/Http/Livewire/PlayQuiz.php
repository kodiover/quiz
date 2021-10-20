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
    public $timeLeft = 0;
    public $nextQuestion = 30;
    public $showAnswer = false;
    public $noResponse = false;
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

    public function end()
    {
        PlayerSession::clear();
        $this->redirect(route('index'));
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

    public function checkForAnswers()
    {
        if ($this->timeLimitElapsed()) {
            return true;
        }
        return;
    }

    public function timeLimitElapsed()
    {
        $this->calculateTimeLeft();

        return $this->timeLeft <= 0;
    }

    public function calculateTimeLeft()
    {
        $this->timeLeft = now()->diffInSeconds($this->session->next_question_at, false);

        if ($this->timeLeft <= 0) {

            $this->timeLeft = 0;
        }
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

        if (isset($this->question)) {
            $this->response = $this->player->responses()
                ->where('question_id', $this->question->id)
                ->first();
        } else {
            $this->ended = true;
        }

        if ($this->timeLimitElapsed() && $this->response === null) {
            $this->noResponse = true;
        }

        $this->checkForAnswers();

        if ($this->response && $this->response->score !== null) {
            $this->showAnswer();
        }
    }
}
