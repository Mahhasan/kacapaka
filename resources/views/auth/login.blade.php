@extends('layouts.guest')

@section('content')
    <!-- Session Status -->
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="{{asset('admin/images/logo.svg')}}">
                                <!-- <h2 class="text-primary"></h2> -->
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <!-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> -->
                                    <input id="exampleInputEmail1" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Username" autofocus required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> -->
                                    <input id="exampleInputPassword1" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted" for="remember">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            {{ __('Keep me signed in') }}
                                        </label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                        {{ __('SIGN IN') }}
                                    </button>
                                </div>

                                <div class="text-center mt-4 font-weight-light">
                                {{ __('Dont have an account? ') }}
                                    <a href="{{ route('register') }}" class="text-primary">Create</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
