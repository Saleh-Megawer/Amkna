@extends('dashboard.layouts.blank')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">

                <div class="box mb-2 mt-5 py-4">
                    <h4 class="text-center mb-4">{{ dbTrans('admin.Reset account password') }}</h4>
                    <form class="ajax-post" action="{{ route('reset-admin-password') }}" method="POST">

                        <x-form-group :properties="[
                            'input' => [
                                'name' => 'password',
                                'options' => [
                                    'placeholder' => dbTrans('admin.Password'),
                                    'required',
                                ],
                            ],
                        ]" />

                        @csrf
                        @method('PATCH')
                        
                        <input type="hidden" name="token" value="{{ $token }}">
                        <x-form-group :properties="[
                            'input' => [
                                'name' => 'password_confirmation',
                                'options' => [
                                    'placeholder' => dbTrans('admin.Confirm Password'),
                                ],
                            ],
                        ]" />

                        <button type="submit" class="btn btn-main btn-block">{{ dbTrans('admin.Reset Password') }}</button>
                    </form>
                </div>
                <a href="{{ adminUrl('') }}" class=" text-secondary">{{ dbTrans('admin.Back to dashboard') }}</a>
            </div>
        </div>
    </div>
@endsection
