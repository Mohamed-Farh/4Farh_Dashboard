@extends('layouts.frontend_app')

@section('title', 'Register')

@section('content')

    <div class="container">
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                    <div class="col-lg-6">
                        <h1 class="h2 text-uppercase mb-0">Register</h1>
                    </div>
                    <div class="col-lg-6 text-lg-right">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="row">
                <div class="col-lg-6 offset-md-3">
                    <h3 class="h5 text-uppercase mb-4">Register</h3>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="first_name" class="text-small text=uppercase">{{ __('First Name') }}</label>
                                    <input id="first_name" type="text" class="form-control form-control-lg @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus  placeholder="Enter Your First Name">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="last_name" class="text-small text=uppercase">{{ __('Last Name') }}</label>
                                    <input id="last_name" type="text" class="form-control form-control-lg @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus  placeholder="Enter Your Last Name">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="username" class="text-small text=uppercase">{{ __('User Name') }}</label>
                                    <input id="username" type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" name="username"  required  placeholder="Enter Your User Name">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="mobile" class="text-small text=uppercase">{{ __('Mobil Number') }}</label>
                                    <input id="mobile" type="text" class="form-control form-control-lg @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus  placeholder="Enter Your Mobile Number">
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email" class="text-small text=uppercase">{{ __('EMail Address') }}</label>
                                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Your Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password" class="text-small text=uppercase">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter Your Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password-confirm" class="text-small text=uppercase">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password" placeholder="Enter Your Password Again">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="user_image" class="text-small text=uppercase">{{ __('User Image') }}</label>
                                    <input id="user_image" type="file" class="form-control form-control-lg @error('user_image') is-invalid @enderror" name="user_image" required>
                                    @error('user_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

@endsection
