<div x-data="{ duration: {{ $duration ?? '' }}, nextQuestion: {{ $duration ?? '' }}  }" x-init="() => {
            nextQuestion = new Number(duration);
            var start = new Date();
            var reload = false;
            var timer = setInterval(() => {
                nextQuestion = duration - Math.floor((new Date() - start) / 1000);

                if(nextQuestion == 0) {     
                    clearInterval(timer);
                    reload = true;
                    $dispatch('refresh');    
                }
                if(reload){
                    window.location.reload();
                }

            }, 100/3)
        }" @refresh="{{ $refresh ?? 'console.log(\'refresh!\')' }}">
    {{ $slot }}
</div>
