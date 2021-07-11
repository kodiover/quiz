<div class="max-w-screen-md px-4 mx-auto relative x9oAws">
    <h2 class="text-3xl text-center text-black font-bold italic">{{ $quiz->title }}</h2>
    <p class="flex items-center text-black justify-center font-bold mb-8">
        <span class="flex-1 text-right">{{ $quiz->questions->count() }} Questions</span> <!-- Counts the no. of Qs via ->count() -->
        <span class="mx-4">|</span>
        <span class="flex-1">{{ $quiz->questions->sum('time_limit') }} seconds</span>
    </p>

    {{-- Old Sessions --}}
    <details>
        <summary class="cursor-pointer font-bold italic px-2 py-1 bg-red-600 rounded">
            <div class="inline-flex items-center">
                Stale Sessions
                <span class="ml-4 text-xs bg-black rounded-full border-white p-1 leading-none">{{ $quiz->sessions->count() }}</span>
            </div>
        </summary>
        <div class="ml-2 border-l pl-4 pt-4">
            @foreach ($quiz->sessions->filter->isStale() as $session)
                <div class="mb-4 bg-black rounded p-3 text-white">
                    <p>
                        <strong>{{ $session->players->where('score', $session->players->max('score'))->first()->nickname }}</strong>
                        won
                        {{ $session->ended_at->diffForHumans() }}
                    </p>
                </div>
            @endforeach
        </div>
    </details>

    {{-- Questions --}}
    <details class="mt-1">
        <summary class="cursor-pointer font-bold italic px-2 py-1 bg-black rounded">
            <div class="inline-flex items-center">
                Questions
                <span class="ml-4 text-xs bg-red-600 border-white rounded-full p-1 leading-none">{{ $quiz->questions->count() }}</span>
            </div>
        </summary>
        <div class="ml-2 border-l pl-4 pt-4">
            @foreach ($quiz->questions as $index => $question)
            <div class="mb-4 bg-black rounded p-3 text-gray-900" x-data="{showAnswer: false}">
                <p class="mb-3 text-white float-left">
                    <strong class="float-left mr-2">{{ $index + 1 }}.</strong>
                    {!! $question->text !!}
                </p>
                <p class="mb-4 text-white text-right font-bold italic">
                    Time Limit: {{ $question->time_limit }}s
                </p>
                <div class="flex flex-wrap -m-1">
                    @foreach ($question->options as $key => $option)
                        <div class="w-1/2 p-1">
                            <div class="bg-gray-200 rounded border px-3 py-1">
                                <strong class="float-left mr-2">{{$key}})</strong>
                                {{ $option }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex mt-2 items-baseline">
                    <button class="bg-blue-700 text-black hover:bg-blue-600 font-bold text-sm px-2 py-1 rounded"
                        @click="showAnswer = !showAnswer"
                        x-text="showAnswer ? 'Hide Answer' : 'Show Answer'"></button>
                    <template x-if.fade="showAnswer">
                        <p class="ml-4 mt-2 italic text-white text-left">
                            <strong class="mr-2">{{ $question->correct_key }})</strong>
                            {{ $question->options[$question->correct_key] }}
                        </p>
                    </template>
                </div>
            </div>
            @endforeach
        </div>
    </details>

    {{-- Add New Question Button --}}
    <div class="bottom-0 ml-12 mt-12 z-10 text-right"
        x-data="{ creating: false }"
        x-init="window.livewire.on('closeModal', () => creating = false)">
            <button class="fas fa-plus fa-3x text-black hover:text-blue-700" @click="creating = true">
            </button>
        {{-- Add New Question Modal --}}
        <div wire:ignore.self
            x-show.fade="creating"
            @keydown.window.escape="creating = false"
            class="fixed z-50 inset-0 flex items-center justify-center p-8"
            style="background-color: rgba(0, 0, 0, 0.5)">
            <div @click.away="creating = false"
                class="max-w-screen-md max-h-full overflow-y-auto w-full bg-black text-white p-6 rounded shadow">
                @include('livewire.admin._add-question', ['quiz' => $quiz])
            </div>
        </div>
    </div>
</div>
