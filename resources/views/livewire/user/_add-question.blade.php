
    <div class="add-question">
        <h4 class="text-2xl text-left font-bold mb-4 text-white">Add Question</h4>
        <form wire:submit.prevent="create">
            <div class="mb-2">
                <h2 for="text" class="w-full text-xs uppercase text-left font-bold tracking-wide mb-1 text-white">Text</label>
                <textarea id="text" wire:model="text" class="w-full px-3 py-2 border rounded bg-black text-white" rows="2"></textarea>
                @error('text')
                    <p class="text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <h2 for="time_limit" class="w-full text-xs uppercase text-left font-bold tracking-wide mb-1 text-white">Time Limit (s)</label>
                <input id="time_limit" type="number" wire:model="timeLimit" class="w-full px-3 py-2 border rounded bg-black border-white">
                @error('timeLimit')
                <p class="text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-baseline mt-3 mb-1 leading-none">
                <h2 class="mr-4 text-xs uppercase font-bold tracking-wide text-white">Options</label>
                <button wire:click="removeOption" type="button"
                    class="px-2 border text-white bg:black rounded">-</button>
                <button wire:click="addOption" type="button"
                    class="ml-2 px-2 border text-white bg:black rounded">+</button>
            </div>
            <div>
                @foreach($options as $index => $option)
                    <div class="flex items-center mb-2" wire:key="{{$index}}-$option">
                        <p class="mr-2 font-bold">{{ $this->keys($index) }}) </p>
                        <input type="text" wire:model="options.{{ $index }}"
                            class="w-full px-3 py-2 border rounded bg-black text-white flex-1 mr-2"
                            placeholder="Option ({{ $this->keys($index) }})">
                        @error('options')
                            <p class="mb-1 text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- <button id="delete-question" type="button"
                            class="leading-none font-bold p-2 rounded text-red-600 hover:bg-white hover:text-black"
                            wire:click="removeOption({{ $index }})">&cross;</button> -->
                    </div>
                @endforeach
            </div>
            <div class="mb-2">
                <h2 for="correct_key" class="w-full text-xs uppercase text-left font-bold tracking-wide mb-1 text-white">
                    Correct Answer
                </h2>
                <select class="w-full px-3 py-2 border rounded bg-black"
                    wire:model="correctOptionIndex"
                    @change="@this.set('correctOptionIndex', $event.target.value)">
                    @foreach($options as $index => $option)
                    <option value="{{$loop->index}}"
                        wire:key="{{$loop->index -1}}-option"
                        {{ $loop->index === (int) $correctOptionIndex ? 'selected' : '' }}
                        >
                        {{ $this->keys($loop->index) }}) {{ $option }}
                    </option>
                    @endforeach
                </select>
            </div>
            @error('correctOptionIndex')
                <p class="text-red-600 mt-2">{{ $message }}</p>
            @enderror
            <div class="text-left" wire:key="submit-button">
                <button class="ml-2 px-2 py-1 text-sm rounded bg-blue-600 hover:bg-blue-500 text-white font-bold">Create</button>
            </div>
        </form>
    </div>
