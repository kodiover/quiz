<div class="flex flex-col text-white justify-center items-center min-h-screen">
    <div class="max-w-md mx-auto text-center p-4">
        <h2 class="text-xl font-bold">{{ $session->quiz->title}}</h2>
    </div>
    <div class="flex-1 flex flex-col justify-center items-center">
        <h3 class="text-3xl font-bold mb-4">You're in...</h3>
        <p class="text-xl">See your name on the screen?</p>
    </div>
    <p class="py-6">Waiting for players...</p>
</div>

<div class="none">
    @component('components.refresh', [
        'duration', $startQuiz,
        'refresh', 'refresh()'
    ])
    @endcomponent
</div>