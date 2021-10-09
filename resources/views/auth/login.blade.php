@extends('layouts.frontend_app')

@section('title', 'Login')

@section('content')

<div class="container">
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">Login</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="row">
            <div class="col-lg-6 offset-3">
                <h1 class="h2 text-uppercase mb-4">Login</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-small text=uppercase" for="email">{{ __('Email Address') }}</label>
                                <input id="email" type="text" class="form-control form-control-user" @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}"placeholder="Enter Email Address..." required autocomplete="email" autofocus  aria-describedby="emailHelp">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-small text=uppercase" for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6 form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        <div class="col-6 offset-3">
                            <div class="form-group">
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
        </div>
    </section>
</div>


@endsection
