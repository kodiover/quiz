@php($bgColors = ['bg-blue-400 text-white', 'bg-red-500 text-white', 'bg-green-400 text-white', 'bg-yellow-400 text-white'])
@php($shapes = ['triangle', 'hexagon', 'circle', 'star'])
<div class="container-w mx-auto flex flex-col min-h-screen relative bg-blue-900">
    <h2 class="text-2xl font-bold text-center text-white my-8">{{ $session->quiz->title }}</h2>
    @if (! $showAnswers)
        <div class="absolute top-0 right-0 text-white mt-4">
            @component('components.countdown', [
                'duration' => $timeLeft,
                'timeup' => 'timeUp()'
            ])
            <div class="absolute top-0 right-0 mt-6 mr-6">
                <p class="text-3xl font-bold italic" x-text="timeLeft"></p>
            </div>
            @endcomponent
        </div>
        <div class="px-4">
            <p class="p-6 rounded bg-blue-600 text-white text-2xl font-mono font-bold tracking-wide mb-8 p-4">{{ $question->text }}</p>
        </div>
        <div class="w-full flex-1 grid grid-cols-2 gap-8 content-start px-4">
            @foreach($question->options as $option)
            <div
                class="{{ $bgColors[$loop->index] }} text-2xl font-mono font-bold tracking-wide px-8 py-6 flex items-center rounded">
                @include('svg.shapes.' . $shapes[$loop->index], ['classes' => 'h-12 mr-6'])
                {{ $option }}
        </div>
            @endforeach
        </div>
    @else
        <div class="w-full md:w-screen-md md:self-center flex-1 flex items-end justify-center h-full mb-12 border-b">
            @foreach($optionPolls as $key => $count)
            @php($percent = $count/$session->players->count() * 100)
            <div class="px-4 flex flex-col items-center justify-between {{ $bgColors[$loop->index] }} rounded-t p-2 mx-1 font-bold text-2xl"
                {{ $percent > 0 ? "style=height:{$percent}%" : ''}}>
                @if ($question->correct_key == $key)
                    <span class="mb-4">&check;</span>
                @endif
                <div>{{ $count }}</div>
            </div>
            @endforeach
        </div>
        <form class="py-12 center-items" action="{{ route('user.quiz.next', $session) }}" method="POST">
            @csrf
            <x-jet-button class="px-4 py-2 font-bold bg-blue-800 text-white rounded text-xl">Next &NestedGreaterGreater;</x-jet-button>
        </div>
    @endif
</div>
<script>    
    function timeUp() {
        $this.call('showAnswersIfRequired');
    }
</script>
