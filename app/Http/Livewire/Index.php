<?php

namespace App\Http\Livewire;

use App\Events\PlayerJoined;
use App\Models\PlayerSession;
use App\Models\QuizSession;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Index extends Component
{
    public $pin = '';
    public $nickname = '';
    public $enteredSession = null;

    // public function rules()
    // {
    //     return [
    //         'pin' => 'required|min:6|exists:quiz_sessions,pin',
    //         'nickname' => ['required|max:100|', Rule::unique('quiz_players', 'nickname')
    //                     ->where('quiz_session_id', $this->enteredSession->id)],
    //     ];
    // }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'pin' => 'min:6',
            'nickname' => 'max:100',
        ]);
    }

    public function render()
    {
        return view('index');
    }

    public function enter()
    {
        // Checks is pin is valid and generates error message
        // $this->validate([
        //     'pin' => ['required', 'numeric', 'digits:6', 'exists:quiz_sessions,pin']
        // ]);

        // $validateData = $this->validate([
        //     'pin' => ['required', 'numeric', 'digits:6', 'exists:quiz_sessions,pin']
        // ]);
        // QuizSession::create($validateData);
        // dd($validateData);

        $validatedData = Validator::make(
            ['pin' => $this->pin],
            ['pin' => 'required|numeric','digits:6','exists:quiz_sessions,pin'],
            ['required' => 'The :attribute field is required'],
        )->validate();
        
        $this->enteredSession = QuizSession::with('quiz')->where('pin', $this->pin)->first();
        PlayerSession::id($this->enteredSession->id);
        }

    public function ready()
    {
        $this->validate([
            'nickname' => [
                'required', 'string', 'max:100',
                Rule::unique('quiz_players', 'nickname')
                    ->where('quiz_session_id', $this->enteredSession->id)
            ]
        ]);

        $this->validate();

        $player = $this->enteredSession->joinAs($this->nickname);

        event(new PlayerJoined($player, $this->enteredSession));

        return redirect()->route('quiz.enter', $this->enteredSession);
    }

    public function mount()
    {
        if (PlayerSession::id()) {
            $this->enteredSession = QuizSession::with('quiz')
                ->where('id', PlayerSession::id())
                ->first();
        }

        if ($this->enteredSession && $nickname = PlayerSession::nickname()) {
            $this->nickname = $nickname;
            $this->enteredSession->joinAs($nickname);

            return redirect()->route('quiz.enter', $this->enteredSession);
        }
    }
}
