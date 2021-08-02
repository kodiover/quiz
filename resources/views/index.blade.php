<x-guest-layout>
    <x-jet-authentication-card>
        
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
            
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <div class="h-screen flex flex-col justify-center items-center form-center">
            @if($enteredSession)
            <h3 wire:transition.fade class="text-2xl font-bold py-4 mb-6 text-center">
                {{ $enteredSession->quiz->title }}
            </h3>   
            @endif
            <div class="max-w-lg mx-auto container">
                @if(! $enteredSession )
                <h2 class="text-4xl font-bold text-center text-white py-2">Enter Quiz Pin</h2>

                <form wire:transition.fade wire:key="enter-quiz" class="form-center">
                    <!-- @csrf -->
                    <div class="text-xl text-black">
                        <input class="block w-full text-center border-gray-300 focus:border-blue-300 focus:ring                  focus:ring-blue-300 focus-ring-opacity-1 rounded-md shadow-sm"
                                type="tel"
                                placeholder="Game PIN"                            
                                autocomplete="off"
                                autofocus
                                wire:model="pin">   
                        <!-- <x-jet-label for="pin" /> -->
                        <!-- <input class="block mt-1 w-full text-center" type="tel" wire:model="pin" placeholder="Game PIN"  autofocus value="{{old('pin')}}"/> -->

                    </div>
                
                    <div class="text-xl mt-4 mb-4">
                        <button type="submit" wire:click="enter" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition btn-submit">
                            Enter Quiz
                        </button>
                    </div>
                    @error('pin')
                        <p class="px-4 mt-1 text-sm error">{{ $message }}</p>
                    @enderror
                </form>
                @else
                <div class="max-w-lg mx-auto container">
                    <h2 class="mb-6 text-4xl font-bold text-center text-black py-2">Enter Nickname</h2>
                    <form method="POST" wire:submit.prevent="ready" class="text-center form-center">
                        <div class="text-xl text-black container2">
                            <!-- <input type="text"
                                class="w-full px-4 py-2 textbox tracking-widest rounded shadow-md box-mod"
                                placeholder="Nickname"
                                required autocomplete="off"
                                wire:model="nickname">                                                    -->
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