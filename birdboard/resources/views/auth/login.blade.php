@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <h2 class="text-lg text-grey font-normal mb-3">{{ __('Login') }}</h2>
        </div>
    </header>
    <main>
        <div class="card">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <div class="flex items-center">
                        <label class="w-1/6 flex-none text-right" for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email"
                               class="form-input {{ $errors->has('email') ? ' is-invalid' : '' }}"
                               name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div>
                        @if ($errors->has('email'))
                            <span role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <div class="flex items-center">
                        <label class="flex-none w-1/6 text-right" for="password">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="form-input {{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password" value="{{ old('password') }}" required autofocus>
                    </div>
                    <div>
                        @if ($errors->has('password'))
                            <span role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="mb-3 w-full">
                    <div class="flex justify-center items-center">
                        <div class="mx-4">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <div class="mx-4">
                            <button class="button" type="submit">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
