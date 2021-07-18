<section>
  <div>
    <div class="card-header">{{ __('Login') }}</div>
    <form wire:submit.prevent="submit" class="form">
      @csrf
      <input type="text" placeholder="Username" wire:model="name">
      @error('email') 
        <span class="text-danger error">{{ $message }}</span>
      @enderror
      <input type="password" placeholder="Password" wire:model="password">
      @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
      <button type="submit" id="login-button">Login</button>
      <div class="form-group row">
        <div class="col-md-6 offset-md-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" wire:model.lazy="remember"
                id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
          </div>
        </div>
      </div>
          @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
          @endif
        </form>
    </div>
    
    <ul class="bg-bubbles">
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul>
  </div>
</section>