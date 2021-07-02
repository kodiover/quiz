<!-- @extends('layouts.master') -->
<div class="h-screen flex flex-col justify-center items-center">
    @if($enteredSession)
    <h3 wire:transition.fade class="text-2xl font-bold py-4 mb-6 text-center">
        {{ $enteredSession->quiz->title }}
    </h3>   
    @endif
    <!-- <canvas id="lamp-anim" class="lamp" style="position: absolute; left: 0; right: 0; width: 80%; height:80%;z-index:-9999999"></canvas> -->
    <div class="max-w-lg mx-auto container">
        @if(! $enteredSession)
        <h2 class="mb-6 text-4xl font-bold text-center py-2">Enter Quiz Pin</h2>
        <form wire:transition.fade wire:key="enter-quiz" wire:submit.prevent="enter" class="text-center form-center">
            <div class="text-xl text-black container2">
                <input type="tel"
                        class="w-full px-4 py-2 textbox bg-gray-200 hover:bg-white focus:bg-white tracking-widest rounded shadow-md box-mod"
                        autofocus
                        wire:model="pin" placeholder="Game PIN">
                <div class="mx-auto text-xl mb-6">
                <!-- <input type="tel" autofocus wire:model="pin" placeholder="Game PIN" class="text-center form-center" id="cb1" />
                <label for="cb1">Enter Quiz</label> -->
                </div>
            </div>
        
        <div class="mx-auto text-xl mb-6">
                <button type="submit" class="px-4 py-2 text-white bg-purple-700 hover:bg-purple-600 font-bold rounded shadow-lg">
                    Enter Quiz
                </button>
                @error('pin')
                        <p class="font-bold px-4 mt-2 textbox text-sm error">{{ $message }}</p>
                @enderror
            </div>
        </form>
        @else
        <h2 class="mb-6 text-4xl font-bold text-center py-2">Enter Nickname</h2>
        <form wire:transition.fade wire:key="ready-for-quiz" wire:submit.prevent="ready" class="text-center">
            <div class="mx-auto text-xl text-black mb-6">
                <input type="text"
                    class="w-full px-4 py-2 bg-gray-200 hover:bg-white focus:bg-white tracking-widest rounded shadow-md"
                    autofocus
                    wire:model="nickname">
                @error('nickname')
                <p class="font-bold px-4 mt-2 text-sm error">{{ $message }}</p>
                @enderror
            </div>
            <div class="mx-auto text-xl mb-6">
                <button type="submit"
                    class="px-4 py-2 text-white bg-purple-700 hover:bg-purple-600 font-bold rounded shadow-lg">
                    Ready!
                </button>
            </div>
        </form>
        @error('nickname')
        <p class="px-4 mt-1 text-sm error">{{ $message }}</p>
        @enderror
        @endif
    </div>
</div>
