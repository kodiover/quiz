    <x-slot name="header">
        <h2 class="font-semibold text-xl header-color leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>     
    
    <x-jet-validation-errors class="mb-4" />

    @php
        $this->checkUser();
    @endphp

    <div class="max-w-screen-md mx-auto flex flex-col min-h-screen leading-none bg-gray-300"
        x-data="{ creating: false }"
        x-init="window.livewire.on('creatingStatus', status => creating = status)">

        <h2 class="text-center text-white italic mt-6 mb-8 text-title">Quizzes</h2>
        @forelse($quizzes as $quiz)
            <div class="w-full bg-black text-white py-3 px-6 rounded border border-gray-300 shadow relative mb-4">
                <h3 class="text-lg font-bold pr-12">
                    <a href="{{ url('/manage/quizzes', $quiz) }}">{{ $quiz->title }}</a>
                </h3>
                <p class="mt-2">
                    @if(!$quiz->freshSession)

                        <button wire:click="startSession({{ $quiz->id }})"
                            class="ml-2 px-2 py-1 text-sm rounded font-bold">
                            Start
                        </button>
                    
                    @else
                        <a href="{{ route('/quiz/', $quiz->freshSession) }}"
                            class="ml-2 px-2 py-1 text-sm rounded font-bold">
                            Resume
                        </a>
                        <button wire:click="abandonAndStartNewSession({{ $quiz->id }}, {{ $quiz->freshSession->id }})"
                            class="ml-2 px-2 py-1 text-sm rounded font-bold">
                            Abandon and Start New
                        </button>
                        
                        <button wire:click="discardSession({{ $quiz->freshSession->id }})"
                            class="ml-2 px-2 py-1 text-sm rounded font-bold">
                            Discard Session
                        </button>
                        
                    @endif
                    <button wire:click="deleteQuiz({{$quiz->id}})"
                        class="ml-2 px-2 py-1 text-sm rounded font-bold">
                        Delete
                    </button>
                </p>
            </div>

            @empty
            <p class="text-white text-center">No quizzes created.</p>
            
            @endforelse
        <div class="bottom-0 ml-12 mt-12 z-10 text-right plus">
            <button class="bg-black hover:bg-blue-700 text-white rounded-full shadow p-3" @click="creating = true">
                <svg class="h-6" viewBox="0 0 20 20" stroke-width="2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="2" y1="10" x2="18" y2="10"></line>
                    <line x1="10" y1="2" x2="10" y2="18"></line>
                </svg>
            </button>
        </div>
        <div wire:key="create-quiz-modal"
        x-show.fade="creating"
        @keydown.window.escape="creating = false"
        class="fixed z-50 inset-0 flex items-center justify-center p-4">
            <div @click.away="creating = false" class="max-w-full bg-black text-gray-900 p-6 rounded shadow">
                <h4 class="text-white">Create Quiz</h4>
                <form wire:submit="createQuiz">
                    <div class="mb-2 bg-gray-700 rounded ">
                        <input id="title" type="text" wire:model="quizTitle" class="" placeholder="Title"  autocomplete="off"/>
                        @error('quizTitle')
                        <p class="px-4 mt-1 text-sm error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <!-- <button class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white hover:text-black font-bold rounded">Create</button> -->
                        <button type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
