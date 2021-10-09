@extends('layouts.frontend_app')

@section('title', 'Register')

@section('content')

    <div class="container">
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                    <div class="col-lg-6">
                        <h1 class="h2 text-uppercase mb-0">Verify Your Email Address</h1>
                    </div>
                    <div class="col-lg-6 text-lg-right">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="row">
                <div class="col-lg-6 offset-md-3">
                    <h3 class="h5 text-uppercase mb-4">Verify Your Email Address</h3>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
