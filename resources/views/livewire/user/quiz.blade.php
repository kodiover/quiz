<div class="flex flex-col bg-lightseagreen text-white justify-center items-center min-h-screen">
    <div class="max-w-md mx-auto text-center p-4">
        <h2 class="text-xl font-bold">Game Pin</h2>
        <p class="text-5xl font-bold">{{ $session->pin }}</p>
    </div>
    <div class="flex-1">
        <div class="flex flex-wrap gap-6">
            @foreach ($session->players as $player)
                <div class="bg-blue-600 rounded py-2 px-4 text-xl font-bold italic">{{ $player->nickname }}</div>
            @endforeach
        </div>
    </div>
    <p class="py-6 mb-5">Waiting for players...</p>
    <div class="my-6 text-center">
        <button wire:click="start"
            class="px-4 py-2 font-bold bg-blue-700 hover:bg-blue-600 text-black rounded text-xl">
            Ready!
        </button>
    </div>
</div>