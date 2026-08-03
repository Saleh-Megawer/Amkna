@extends('dashboard.layouts.blank')
@section('title', 'نسيت كلمة السر')
@section('content')
    <section class="vh-100" style="background-color: #f5f5f5;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 col-md-9">
                    <div class="box p-4 p-md-5 text-right">

                        <div class="text-center mb-4">
                            <img width="180px" src="{{ website_logo() }}" alt="">
                        </div>

                        <h4 class="text-center mb-4">إعادة تعيين كلمة المرور</h4>

                        @if (session('status'))
                            <div class="alert alert-success text-center" role="alert">
                                <strong>{{ session('status') }}</strong>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger text-center" role="alert">
                                <strong>{{ $errors->first() }}</strong>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <input type="email" name="email" placeholder="البريد الإلكتروني"
                                    class="form-control text-right" required autofocus>
                            </div>

                            <div class="pt-1">
                                <button style="border-radius: 5px !important;" class="btn btn-main btn-block"
                                    type="submit">إرسال رابط إعادة التعيين</button>
                            </div>
                        </form>

                        <a href="{{ route('login') }}" class="text-decoration-underline mt-4 text-secondary d-inline-block">
                            رجوع إلى تسجيل الدخول
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
