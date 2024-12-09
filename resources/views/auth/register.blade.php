@extends('layouts.guest')

@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-md-6 col-lg-6 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="{{asset('admin/images/logo.svg')}}">
                                <!-- <h2 class="text-primary"></h2> -->
                            </div>
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3" method="POST" action="{{ route('register') }}">
                            @csrf

                                <input type="hidden" name="role" value="customer">

                                <!-- First Name -->
                                <div class="row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                    <div class="form-group col-md-8">
                                        <input id="name" type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>
                                    <div class="form-group col-md-8">
                                        <input id="first_name" type="text" class="form-control rounded-3 @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> -->

                                <!-- Last Name -->
                                <!-- <div class="row">
                                    <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>
                                    <div class="form-group col-md-8">
                                        <input id="last_name" type="text" class="form-control rounded-3 @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> -->

                                <!-- Email -->
                                <div class="row">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail') }}</label>
                                    <div class="form-group col-md-8">
                                        <input id="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Mobile No -->
                                <!-- <div class="row">
                                    <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Mobile No') }}</label>
                                    <div class="form-group col-md-8">
                                        <input id="phone" type="tel" class="form-control rounded-3 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> -->

                                <!-- NID -->
                                <!-- <div class="row">
                                    <label for="nid" class="col-md-4 col-form-label text-md-end">{{ __('NID') }}</label>
                                    <div class="form-group col-md-8">
                                        <input id="nid" type="number" class="form-control rounded-3 @error('nid') is-invalid @enderror" name="nid" value="{{ old('nid') }}">
                                        @error('nid')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> -->

                                <!-- Password -->
                                <div class="row">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                    <div class="form-group col-md-8">
                                        <input id="password" type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                                    <div class="form-group col-md-8">
                                        <input id="password-confirm" type="password" class="form-control rounded-3" name="password_confirmation" required>
                                    </div>
                                </div>

                                <!-- <div class="form-check">
                                    <label class="form-check-label text-muted">
                                    <input type="checkbox" class="form-check-input"> I agree to all Terms & Conditions </label>
                                </div> -->

                                <!-- Submit Button -->
                                <div class="mt-2 d-grid gap-2">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                        {{ __('SIGN UP') }}
                                    </button>
                                </div>

                                <!-- Already Registered -->
                                <div class="text-center mt-4 font-weight-light">
                                    Already have an account?
                                    <a href="{{route('login')}}" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
