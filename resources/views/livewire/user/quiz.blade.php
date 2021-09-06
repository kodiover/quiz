<div class="flex flex-col bg-black text-white justify-center items-center min-h-screen">
    <div class="max-w-md mx-auto text-center p-4">
        <h2 class="text-xl font-bold">Game Pin</h2>
        <p class="text-5xl font-bold">{{ $session->pin }}</p>
    </div>
    <div wire:poll.keep-alive class="flex-1 text-center">
        <div class="flex flex-wrap gap-6">
            @foreach ($session->players as $player)
                <div class="bg-blue-400 rounded py-2 px-4 text-xl font-bold italic">{{ $player->nickname }}</div>
            @endforeach
        </div>
    </div>
    <div class="my-6 text-center">
        <x-jet-button wire:click="start"
            class="px-4 py-2 font-bold text-white border-gray-300 rounded text-xl">
            Ready!
        </x-jet-button>
    </div>
    <p class="py-6 mb-5">Waiting for players...</p>
</div>
