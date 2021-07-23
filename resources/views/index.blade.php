<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>
            <div class="h-screen flex flex-col justify-center items-center home-page">
            @if($enteredSession ?? '' )
            <h3 wire:transition.fade class="text-2xl font-bold py-4 mb-6 text-center">
                {{ $enteredSession ?? ''->quiz->title }}
            </h3>   
            @endif
            <div class="max-w-lg mx-auto container">
                @if(! $enteredSession ?? '' )
                <h2 class="mb-6 text-4xl font-bold text-center text-black py-2">Enter Quiz Pin</h2>

                <form wire:transition.fade wire:key="enter-quiz" wire:submit.prevent="enter" class="text-center form-center">
                    <div class="text-xl text-black container2">
                        <input type="tel"
                                class="w-full px-4 py-2 textbox tracking-widest rounded shadow-md box-mod"
                                placeholder="Game PIN"                            
                                autocomplete="off"
                                wire:model="pin">   
                    </div>
                
                    <div class="text-xl mb-4">
                            <button type="submit" class="btn-submit">
                                Enter Quiz
                            </button>
                    </div>
                    @error('pin')
                    <p class="font-bold px-4 mt-2 textbox text-sm error">{{ $message }}</p>
                    @enderror
                </form>
                @else
                <div class="max-w-lg mx-auto container">
                    <h2 class="mb-6 text-4xl font-bold text-center text-black py-2">Enter Nickname</h2>
                    <form wire:transition.fade wire:key="ready-for-quiz" wire:submit.prevent="ready" class="text-center form-center">
                        <div class="text-xl text-black container2">
                            <input type="text"
                                class="w-full px-4 py-2 textbox tracking-widest rounded shadow-md box-mod"
                                placeholder="Nickname"
                                required autocomplete="off"
                                wire:model="nickname">                                                   
                        </div>
                        <div class="text-xl mb-4">
                            <button type="submit"
                                class="px-4 py-2 text-white bg-blue-700 hover:bg-blue-600 font-bold rounded shadow-lg button">
                                Ready!
                            </button>
                        </div>
                        @error('nickname')
                        <p class="px-4 mt-1 text-sm error">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
                @error('nickname')
                <p class="px-4 mt-1 text-sm error">{{ $message }}</p>
                @enderror
                @endif
            </div>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>