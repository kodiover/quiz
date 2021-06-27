<!-- @push('child-scripts')
<script src="{{ URL::asset('js/btnbounce.js') }}" type="text/javascript"></script>
@endpush() -->
<div class="h-screen flex flex-col justify-center items-center">
    @if($enteredSession)
    <h3 wire:transition.fade class="text-2xl font-bold py-4 mb-6 text-center">
        {{ $enteredSession->quiz->title }}
    </h3>
    @endif
    <main class="container">
        @if(! $enteredSession)
        <canvas id="lamp-anim" class="lamp" width="1500px" height="700px"></canvas>
        <div class="container2">
        <h2 class="mb-6 text-4xl textbox font-bold text-center py-2">Enter Quiz Pin</h2>

            <form wire:transition.fade wire:key="enter-quiz" wire:submit.prevent="enter" class="text-center form-center">
                <!-- <div class="mx-auto text-xl text-black mb-6"> -->
                    <input type="tel"
                        class="w-full px-4 py-2 textbox bg-gray-200 hover:bg-white focus:bg-white tracking-widest rounded shadow-md box-mod"
                        style="width: 7em;"
                        autofocus
                        wire:model="pin" placeholder="Game PIN">
                    <button type="submit" class="a" id="button">
                    Enter Quiz
                    </button>
                    {{-- @error('pin')
                        <p class="font-bold px-4 mt-2 textbox text-center text-sm text-red-700">{{ $message }}</p>
                    @enderror --}}
            </form>
		</div>
    </main>
        @else
        <h2 class="mb-6 text-4xl font-bold text-center py-2">Enter Nickname</h2>
        <form wire:transition.fade wire:key="ready-for-quiz" wire:submit.prevent="ready" class="text-center form-center">
            <div class="mx-auto text-xl text-black mb-6">
                <input type="text"
                    class="w-full px-4 py-2 bg-gray-200 hover:bg-white focus:bg-white tracking-widest rounded shadow-md"
                    autofocus
                    wire:model="nickname">
                {{-- @error('nickname')
                <p class="font-bold px-4 mt-2 text-sm text-red-700">{{ $message }}</p>
                @enderror --}}
            </div>
            <div class="mx-auto text-xl mb-6">
                <button id="button" type="submit"
                    class="px-4 py-2 text-white bg-purple-700 hover:bg-purple-600 font-bold rounded shadow-lg a">
                    Ready!
                </button>
            </div>
        </form>
        <!-- @error('nickname')
        <p class="px-4 mt-1 text-sm text-red-700">{{ $message }}</p>
        @enderror -->
        @endif
</div>
