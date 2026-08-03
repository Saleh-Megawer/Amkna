@extends('main.layouts.master')
@section('title', __('client.reset_password.title'))
@section('body-class', 'bg-gray-200')
@section('content')



    <div style="height: 100vh" class="container">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6 col-lg-5 my-4 my-md-0">
                <div class="box p-4 p-sm-5 reset-password-container">



                    {{-- Logo --}}
                    <div class="text-center mb-4">
                        <a href="{{ clientUrl() }}">
                            <img src="{{ website_logo() }}" alt="{{ config('app.name') }}" class="mb-3"
                                style="max-height: 75px;">
                        </a>
                    </div>



                    {{-- Header --}}
                    <h2 style="font-size: clamp(1.375rem, 1.1989rem + 0.5634vw, 1.875rem);"
                        class="text-black text-center mb-2">{{ __('client.reset_password.title') }}</h2>
                    </p>



                    {{-- Success Message --}}
                    @if (session('status'))
                        <div class="alert alert-success fade show" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-rosette-discount-check">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7c.412 .41 .97 .64 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1c0 .58 .23 1.138 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                            {{ session('status') }}
                        </div>
                    @endif


                    {{-- Form --}}
                    <form method="POST" action="{{ route('main.clients.password.update') }}">
                        @csrf


                        <input type="hidden" name="token" value="{{ $token }}">


                        <div class="form-group">
                            <label for="email">{{ __('client.reset_password.email_label') }}</label>
                            <input style="direction: ltr" id="email" type="email" name="email"
                                value="{{ $email ?? old('email') }}" required
                                class="form-control text-left @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="password">{{ __('client.reset_password.password_label') }}</label>
                            <input style="direction: ltr" id="password" autofocus type="password" name="password" required
                                class="form-control text-left @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label
                                for="password_confirmation">{{ __('client.reset_password.password_confirmation_label') }}</label>
                            <input style="direction: ltr" id="password_confirmation" type="password"
                                name="password_confirmation" required class="form-control text-left">
                        </div>


                        <button type="submit" class="btn btn-main btn-block mb-3">
                            {{ __('client.reset_password.submit_button') }}
                        </button>



                        {{-- Links --}}
                        <div class="text-center d-flex align-items-center">

                            <a href="{{ appUrl('login') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>
                                {{ __('client.forget_password.back_to_login') }}
                            </a>

                            <span class="mx-2 text-muted">|</span>

                            <a href="{{ appUrl('') }}" class="text-decoration-none">
                                <i class="fas fa-home me-1"></i>
                                {{ __('client.forget_password.home') }}
                            </a>

                            <span class="mx-2 text-muted">|</span>


                            <a class=" d-inline-flex align-items-center" href="{{ urlSwitchLang() }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-world">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                    <path d="M3.6 9h16.8" />
                                    <path d="M3.6 15h16.8" />
                                    <path d="M11.5 3a17 17 0 0 0 0 18" />
                                    <path d="M12.5 3a17 17 0 0 1 0 18" />
                                </svg>

                                <span class="nav-label">
                                    @if (lang() == 'ar')
                                        الإنجليزية
                                    @else
                                        Arabic
                                    @endif
                                </span>
                            </a>

                        </div><!-- end flex -->
                        
                    </form>


                </div><!-- box -->
            </div>
        </div>
    </div>



@endsection
