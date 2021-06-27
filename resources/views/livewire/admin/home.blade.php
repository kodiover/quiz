<div class="max-w-screen-md mx-auto flex flex-col min-h-screen leading-none"
    x-data="{ creating: false }"
    x-init="window.livewire.on('creatingStatus', status => creating = status)">
    
    <div class="fixed z-30 bottom-0 right-0 mb-12 mr-12">
            <button class="fas fa-plus" @click="creating = true">
            </button>
        
    </div>
    <h2 class="text-center text-4xl font-bold italic mt-6 mb-8">Quizzes</h2>
    @forelse($quizzes as $quiz)
        <div class="w-full bg-black text-black-900 py-3 px-6 rounded border shadow relative mb-4">
            <h3 class="text-lg font-bold pr-12">
                <a href="{{ route('admin.quizzes.manage', $quiz) }}">{{ $quiz->title }}</a>
            </h3>
            <p class="mt-2">
                @if(!$quiz->freshSession)
                    <button wire:click="startSession({{ $quiz->id }})"
                        class="">
                        Start
                    </button>
                   
                @else
                    <a href="{{ route('admin.quiz.start', $quiz->freshSession) }}"
                        class="ml-2 px-2 py-1 text-sm rounded bg-orange-500 hover:bg-orange-700 text-black font-bold">
                        Resume
                    </a>
                    <button wire:click="abandonAndStartNewSession({{ $quiz->id }}, {{ $quiz->freshSession->id }})"
                        class="ml-2 px-2 py-1 text-sm rounded bg-orange-500 hover:bg-orange-700 text-black font-bold">
                        Abandon and Start New
                    </button>
                    
                    <button wire:click="discardSession({{ $quiz->freshSession->id }})"
                        class="ml-2 px-2 py-1 text-sm rounded bg-orange-500 hover:bg-orange-700 text-black font-bold">
                        Discard Session
                    </button>
                    
                @endif
                <button wire:click="deleteQuiz({{$quiz->id}})"
                    class="ml-2 px-2 py-1 text-sm rounded bg-orange-500 hover:bg-orange-700 text-black font-bold">
                    Delete
                </button>
            </p>
        </div>
    @empty
        <p>No quizzes created.</p>
    @endforelse
    <div wire:key="create-quiz-modal"
        x-show.fade="creating"
        @keydown.window.escape="creating = false"
        class="fixed z-50 inset-0 flex items-center justify-center p-4">
        <div @click.away="creating = false" class="max-w-full bg-white text-gray-900 p-6 rounded shadow">
            <h4 class="admin-text">Create Quiz</h4>
            <form wire:submit.prevent="createQuiz">
                <div class="mb-2 bg-black">
                    <label for="title" class="w-full text-xs uppercase font-bold tracking-wide mb-1">Title</label>
                    <input id="title" wire:model="quizTitle" class="w-full px-3 py-2 border rounded bg-white" autocomplete="off"/>
                    @error('quizTitle')
                        <p class="admin-text">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button class="admin-text">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
