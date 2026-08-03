@extends('dashboard.layouts.blank')
@section('title', 'إعادة كلمة السر')
@section('content')
    <section class="vh-100" style="background-color: #f5f5f5;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 col-md-9">
                    <div class="box p-4 p-md-5 text-right">

                        <div class="text-center mb-4">
                            <img width="180px" src="{{ website_logo() }}" alt="">
                        </div>

                        <h4 class="text-center mb-4">تعيين كلمة مرور جديدة</h4>

                        {{-- عرض الأخطاء --}}
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger text-center">
                                    {{ $error }}</div>
                            @endforeach
                        @endif

                        {{-- رسالة نجاح --}}
                        @if (session('status'))
                            <div class="alert alert-success text-center">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group mb-3">
                                <input type="email" name="email" class="form-control text-right"
                                    placeholder="البريد الإلكتروني" value="{{ $email ?? old('email') }}" required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" name="password" class="form-control text-right"
                                    placeholder="كلمة السر الجديدة" required>
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" name="password_confirmation" class="form-control text-right"
                                    placeholder="تأكيد كلمة السر" required>
                            </div>

                            <button type="submit" class="btn btn-main btn-block">تحديث كلمة السر</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
