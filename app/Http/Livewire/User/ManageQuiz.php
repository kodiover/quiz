<?php

namespace App\Http\Livewire\User;

use App\Models\Quiz;
use Livewire\Component;

class ManageQuiz extends Component
{
    public $quiz;
    public $text = '';
    public $timeLimit = 15;
    public $options = [ '', '' ];
    public $correctOptionIndex = 0;

    // Custom validation message
    public $messages = [
        'options.*.required' => 'This cannot be cannot be empty.',
        'options.*.min' => 'This must be at least 2 characters.',
        'options.*.max' => 'This must not be greater than 50 characters.'
    ];

    // Acts as constructor, to bind Quiz model
    public function mount($quiz)
    {
        $this->quiz = Quiz::whereId($quiz)
            ->with(['sessions.players', 'questions']) // Must bind components that need to be accessed
            ->firstOrFail();
    }

    // Function to reset input question has been submitted 
    public function resetQuestion()
    {
        $this->text = '';
        $this->timeLimit = 15;
        $this->options = [ '', '' ];
        $this->correctOptionIndex = 0;
    }

    // Function to return a char based on specified index
    public function keys($index)
    {
        return ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'][$index];
    }

    // Function called to render layout
    public function render()
    {
        return view('livewire.user.manage-quiz');
    }

    // Function to add an item to the options array
    public function addOption()
    {
        if (count($this->options) < 6) {
            array_push($this->options, '');
        }            
    }

    // Function to remove an item from the options array
    public function removeOption()
    {
        if (count($this->options) < 3) { // Must be greater than 2
            return;
        }
            
        $index = count($this->options) - 1; // Must remove from the last item

        array_splice($this->options, $index, 1); // Remove 1 item
    }

    // Function to create a question
    public function create()
    {
        $this->validate([
            'text' => ['required', 'string', 'min:4', 'max:190'],
            'timeLimit' => ['required', 'numeric', 'min:7'],
            'options.*' => ['min:2', 'max:50'],
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

    // Function used to convert the index of an array to a key a, b, c etc.
    public function makeKeyedOptions($options)
    {
        $keys = array_map(function ($index) {
            return $this->keys($index);
        }, range(0, count($options) - 1));

        return array_combine($keys, $options);
    }
}
