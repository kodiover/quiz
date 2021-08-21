<div class="h-screen relative text-white flex flex-col items-center justify-center p-4
{{ ! $showAnswer ? 'bg-blue-400' : ($response && $question->isCorrect($response->response) ? 'bg-green-500' : 'bg-red-500') }}">
    @if($ended)
        <div class="absolute top-0 right-0 mt-6 mr-6">
            <p class="font-bold text-3xl italic">{{ $player->score }}</p>
        </div>
        <h2 class="text-5xl font-bold italic">The End!</h2>
        <x-jet-button 
            wire:click="end" 
            class="absolute bottom-0 text-white text-2xl font-bold px-4 py-2 mb-15 
            rounded">Home</x-jet-button>            
    @elseif(! $response && $noResponse)
        <p class="text-xl font-bold">Time's Up!</p>
    @elseif($showAnswer)
        <div class="absolute top-0 right-0 mt-6 mr-6">
            <p class="font-bold text-3xl italic">{{ $player->score }}</p>
        </div>
        <div class="text-5xl font-bold mb-4 p-4">
            @if($response->response === $question->correct_key) &check; @else &times; @endif
        </div>
        <div class="text-xl font-bold">
            
            @if($question->isCorrect($response->response))
                <p class="text-xl font-bold">Woah! Correct Answer</p>
                <p class="text-2xl font-bold">You scored {{ $response->score }}</p>
            @else
                <p class="text-xl font-bold">Oops! Wrong Answer</p>
            @endif
        </div>
    @elseif(! $response)

        <div class="none">
            @component('components.countdown', [
                'duration' => $timeLeft,
                'timeup' => 'timeUp()'
            ])
            @endcomponent
        </div>

        <div class="w-full flex-1 grid grid-cols-2 bg-black gap-6 md:gap-8 h-full">
            @php($bgColors = ['bg-blue-400 text-white', 'bg-red-500 text-white', 'bg-green-400 text-white', 'bg-yellow-400 text-white'])

            @if($count !== 0)
                    @php($percent = $count/$session->players->count() * 100)
                @else
                    @php($percent = $session->players->count() * 100)
                @endif

            @php($shapes = ['triangle', 'hexagon', 'circle', 'star'])
            @foreach($question->options as $key => $option)
                <button class="{{ $bgColors[$loop->index] }} p-6 flex items-center justify-center rounded"
                    wire:click.prevent="storeAnswer('{{$key}}')">
                    @include('svg.shapes.' . $shapes[$loop->index], ['classes' => 'w-48'])
                </button>
            @endforeach
        </div>
    @else
        @include('partials.spinner', ['classes' => 'w-16 h-16'])
        <p class="text-center text-lg font-bold bg-lightseagreen">
            Waiting for answer...
        </p>
    @endif   
</div>

<script>
    function timeUp(){
        $this.call('checkForAnswers');
    }
</script>
