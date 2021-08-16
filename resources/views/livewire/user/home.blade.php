<div class="max-w-screen-md mx-auto flex flex-col min-h-screen leading-none bg-gray-300"
    x-data="{ creating: false }"
    x-init="window.livewire.on('creatingStatus', status => creating = status)">

    <h2 class="text-center font-bold text-white mt-6 mb-8 text-title">Quizzes</h2>
    @if (!$quizzes)
        <p class="text-white text-center">No quizzes created.</p>
    @else
        @foreach($quizzes as $quiz)
            <div class="w-full bg-black text-white py-3 px-6 rounded border border-gray-300 relative mb-4">
                <h3 class="text-lg font-bold hover:underline pr-12">
                    <a href="{{ route('user.manage-quiz', $quiz->id) }}">{{ $quiz->title }}</a>

                </h3>
                <p class="mt-2">
                    @if(!$quiz->freshSession)

                        <x-jet-button wire:click="startSession({{ $quiz->id }})"
                            class="ml-2 px-2 py-1 text-sm rounded font-bold">
                            Start
                        </x-jet-button>
                    
                    @else

                        <x-jet-button wire:click="resumeSession({{ $quiz->freshSession->id }})"
                            class="ml-2 px-2 py-1 text-sm rounded font-bold">
                            Resume
                        </x-jet-button>

                        <x-jet-button wire:click="abandonAndStartNewSession({{ $quiz->id }}, {{ $quiz->freshSession->id }})"
                            class="ml-2 px-2 py-1 text-sm rounded font-bold">
                            Abandon and Start New
                        </x-jet-button>
                        
                        <x-jet-button wire:click="discardSession({{ $quiz->freshSession->id }})"
                            class="ml-2 px-2 py-1 text-sm rounded font-bold">
                            Discard Session
                        </x-jet-button>

                    
                    @endif

                    <x-jet-button wire:click="deleteQuiz({{ $quiz->id }})"
                        class="ml-2 px-2 py-1 text-sm rounded font-bold">
                        Delete
                    </x-jet-button>
                </p>
            </div>
        @endforeach
    @endif
    <div class="inherit text-right">
        <x-jet-button class="px-4 py-2 border-gray-300" @click="creating = true">
            <svg class="h-6" viewBox="0 0 20 20" stroke-width="2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <line x1="2" y1="10" x2="18" y2="10"></line>
                <line x1="10" y1="2" x2="10" y2="18"></line>
            </svg>
        </x-jet-button>
    </div>

    <div wire:key="create-quiz-modal"
        x-show.fade="creating"
        @keydown.window.escape="creating = false"
        class="fixed z-50 inset-0 flex items-center justify-center p-4"
        style="background-color: rgba(0, 0, 0, 0.5);">        

        <div @click.away="creating = false"
            class="max-w-full bg-black text-gray-900 p-6 rounded shadow">
            <h4 class="text-white text-center">Create Quiz</h4>
            <form wire:submit.prevent="createQuiz"  class="text-center form-center">
                <!-- @csrf -->
                <div class="text-xl text-black container2">
                    <x-jet-input id="title" class="box-mod"
                            type="text"
                            placeholder="Title"                            
                            autocomplete="off"
                            autofocus
                            wire:model="quizTitle"/>
                </div>
            
                <div class="text-xl mt-4 mb-4">
                    <x-jet-button type="submit" class="btn-submit mb-15">
                    Create
                    </x-jet-button>
                </div>
            </form>
        </div>
        @error('quizTitle')
            <p class="px-4 mt-1 text-sm inherit error">
                {{ $message }} 
            </p>
        @enderror
    </div>   
</div>
