<?php

namespace App\Http\Livewire\User;

use App\Models\Quiz;
use Livewire\Component;

class ManageQuiz extends Component
{
    public $quiz;

    public $text = '';
    public $timeLimit = 15;
    public $options = [];
    public $correctOptionIndex = 0;

    // Acts as constructor, to bind Quiz model
    public function mount($quiz)
    {
        $this->quiz = Quiz::whereId($quiz)
            ->with(['sessions.players', 'questions']) // Must bind components that need to be accessed
            ->firstOrFail();

        $this->resetQuestion();
    }

    public function resetQuestion()
    {
        $this->text = '';
        $this->timeLimit = 15;
        $this->options = [ '', '' ];
        $this->correctOptionIndex = 0;
    }

    public function keys($index)
    {
        return ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'][$index];
    }

    // Function called to render layout
    public function render()
    {
        return view('livewire.user.manage-quiz');
    }

    public function addOption()
    {
        if (count($this->options) < 6) {
            array_push($this->options, '');
        }            
    }

    public function removeOption($index = null)
    {
        if (count($this->options) < 2) {
            return;
        }

        if ($index === null) {
            $index = count($this->options) - 1;
        }

        array_splice($this->options, $index, 1);

        if ($index === (int) $this->correctOptionIndex && $index >= count($this->options)) {
            $this->correctOptionIndex = count($this->options) - 1;
        }
    }

    public function create()
    {
        $this->validate([
            'text' => ['required', 'string', 'min:4', 'max:190'],
            'timeLimit' => ['required', 'numeric', 'min:7'],
            'options' => ['required', 'array', 'min:2', 'max:6'],
            'options.*' => ['required', 'string', 'min:2', 'max:50'],
            'correctOptionIndex' => ['required', 'numeric', 'gte:0', 'lt:'.count($this->options)],
        ]);

        $question = $this->quiz->questions()->create([
            'text' => $this->text,
            'time_limit' => $this->timeLimit,
            'options' => $this->makeKeyedOptions($this->options),
            'correct_key' => $this->keys($this->correctOptionIndex)
        ]);
        
        $this->quiz->questions->push($question);

        $this->resetQuestion();

        $this->emit('closeModal');
    }

    public function makeKeyedOptions($options)
    {
        $keys = array_map(function ($index) {
            return $this->keys($index);
        }, range(0, count($options) - 1));

        return array_combine($keys, $options);
    }
}
