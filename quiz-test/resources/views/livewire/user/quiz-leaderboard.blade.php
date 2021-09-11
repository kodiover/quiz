<div class="w-h-max mx-auto flex flex-col items-center bg-blue-900">
    <h2 class="text-5xl font-bold italic text-white mt-6 mb-8">Leaderboard</h2>

    <div class="flex-1 h-full max-w-screen-md-2 w-full px-5">
        @foreach($players as $index => $player)
        <div class="w-full flex items-center text-2xl font-bold text-white py-2 px-4 rounded-lg {{ $index == 0 ? 'bg-blue-700' : 'bg-blue-600' }} mb-2">
            <div class="w-20 pl-6 pr-6 text-right">{{ $index + 1 }}</div>
            <div class="px-4 flex-1 truncate">{{ $player->nickname }}</div>
            <div class="w-32 pl-4 pr-6 text-right">{{ $player->score }}</div>
        </div>
        @endforeach
    </div>
    <div class="mb-25">
        <x-jet-button wire:click="end" class="bg-blue-700 hover:bg-blue-700 active:bg-blue-700 text-white text-2xl font-bold px-4 py-2 rounded">Home</x-jet-button>
    </div>
</div>
