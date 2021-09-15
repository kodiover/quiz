<div class="h-screen flex flex-col justify-center items-center index-page">
    <img class="image" src="{{ asset('images/index-page.jpeg') }}">
    @if($enteredSession)
        <?php
            echo '<style type="text/css">
                #nav-bar {
                    display: none;
                }
                </style>';
        ?>
        <div class="max-w-lg mx-auto container flex items-center justify-center">
            <h3 wire:transition.fade class="text-2xl text-white font-bold py-4 mb-6 text-center relative text-top text-title">
                {{ $enteredSession->quiz->title }}
            </h3>
            <h2 class="text-4xl font-bold text-center text-white py-2">Enter Nickname</h2>
            <form wire.transition.fade wire:submit.prevent="ready" class="text-center form-center">
                <div class="text-xl text-white container2">
                    <x-jet-input id="pin" class="box-mod"
                            type="tel"
                            placeholder="Nickname"
                            autocomplete="off"
                            autofocus
                            wire:model.defer="nickname"/>
                    <div class="text-xl mt-4">
                    <x-jet-button type="submit" class="btn-submit">
                        Ready
                    </x-jet-button>
                </div>
            </form>
        </div>
        @error('nickname')
            <p class="px-4 mt-1 text-sm inherit error bottom-25">{{ $message }}</p>
        @enderror
    @else
        <div class="max-w-lg mx-auto container ">
            <h2 for="pin" class="text-4xl font-bold text-center text-white py-2 mb-5">Enter Quiz Pin</h2>
            <form wire:transition.fade wire:submit.prevent="enter" wire:key="enter-quiz"  class="text-center form-center mb-15">
                <div class="text-xl text-black container2">
                    <x-jet-input id="pin" class="box-mod"
                            type="tel"
                            placeholder="Game PIN"
                            autocomplete="off"
                            autofocus
                            wire:model.defer="pin"/>
                </div>
                <div class="text-xl mt-4">
                    <x-jet-button type="submit" class="btn-submit mb-15">
                        Enter Quiz
                    </x-jet-button>
                </div>
            </form>
            @error('pin')
                <p class="px-4 mt-1 text-sm text-4xl inherit error font-bold bottom-25">{{ $message }}</p>
            @enderror
        </div>
    @endif
</div>
