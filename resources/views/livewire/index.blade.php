<x-slot name="logo">
    <x-jet-authentication-card-logo />
</x-slot>

<div class="h-screen flex flex-col justify-center items-center index-page">
    @if($enteredSession)
    <h3 wire:transition.fade class="text-2xl text-white font-bold py-4 mb-6 text-center text-title">
        {{ $enteredSession->quiz->title }}
    </h3>   
    @endif
    <div class="max-w-lg mx-auto container ">
        @if(! $enteredSession )
        <h2 for="pin" class="text-4xl font-bold text-center text-white py-2">Enter Quiz Pin</label>

        <form wire:transition.fade wire:submit.prevent="enter" wire:key="enter-quiz"  class="text-center form-center">
            <!-- @csrf -->
            <div class="text-xl text-black container2">
                <x-jet-input id="pin" class="box-mod"
                        type="tel"
                        placeholder="Game PIN"                            
                        autocomplete="off"
                        autofocus
                        wire:model="pin"/>
            </div>
        
            <div class="text-xl mt-4 mb-4">
                <x-jet-button type="submit" class="btn-submit mb-15">
                    Enter Quiz
                </x-jet-button>
            </div>
        </form>
        @error('pin')
            <p class="px-4 mt-1 text-sm error">{{ $message }}</p>
        @enderror
        @else
        <div class="max-w-lg mx-auto container flex items-center justify-center">
            <h2 class="text-4xl font-bold text-center text-white py-2">Enter Nickname</h2>
            <form wire.transition.fade wire:submit.prevent="ready" class="text-center form-center border border-gray-300">
                <div class="text-xl text-black container2">
                    <x-jet-input id="pin" class="box-mod"
                            type="tel"
                            placeholder="Nickname"                            
                            autocomplete="off"
                            autofocus
                            wire:model="nickname"/> 
                    <div class="text-xl mt-4">
                    <x-jet-button type="submit" class="btn-submit">
                        Ready
                    </x-jet-button>
                </div>
            </form>
        </div>
        @error('nickname')
        <p class="px-4 mt-6 text-sm error">{{ $message }}</p>
        @enderror
        @endif
    </div>
</div>