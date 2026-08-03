@extends('dashboard.layouts.blank')
@section('title', 'تسجيل الدخول')
@section('content')
    <section class="vh-100" style="background-color: #f5f5f5;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 col-md-9">

                    <div class="box p-4 p-md-5 text-right">

                        <div class="text-center mb-4">
                            <img width="120px" src="{{ website_logo() }}" alt="">
                        </div>

                        @if (session()->has('error_login'))
                            <div class="alert alert-danger text-center" role="alert">
                                <strong>{{ session()->get('error_login') }}</strong>
                            </div>
                        @endif


                        <form action="{{ route('admin.login') }}" method="POST">

                            @csrf

                            <x-form-group :properties="[
                                'input' => [
                                    'type' => 'email',
                                    'name' => 'email',
                                    'options' => ['required'],
                                ],
                                'label' => [
                                    'text' => 'البريد الإلكتروني',
                                ],
                            ]" /><!-- email -->



                            <x-form-group :properties="[
                                'input' => [
                                    'type' => 'password',
                                    'name' => 'password',
                                    'options' => ['required'],
                                ],
                                'label' => [
                                    'text' => 'كلمة السر',
                                ],
                            ]" /><!-- password -->


                            <div class="pt-1">
                                <button style="border-radius: 5px !important;" class="btn btn-main btn-block"
                                    type="submit">تسجيل الدخول</button>
                            </div>

                        </form>

                        <a href="{{ route('password.request') }}"
                            class=" text-decoration-underline mt-4 text-secondary d-inline-block">استعادة كلمة
                            السر ؟</a>

                        {{-- <div class="py-3">
                            <hr>
                        </div>

                        <a href="" class="btn btn-light btn-block">تسجيل حساب مسوق</a> --}}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
