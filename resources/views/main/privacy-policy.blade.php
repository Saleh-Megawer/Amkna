@section('title', __('main.privacy.meta_title'))
@section('description', __('main.privacy.meta_desc'))
@section('head')
    <link rel="stylesheet" href="{{ asset('css/privacy-policy.css') }}">
@endsection

@extends('main.layouts.master')
@section('body-class', 'privacy-body')
@section('content')

    <main class="privacy-page" role="main" aria-labelledby="privacy-title">

        <!-- Hero Section -->
        <header class="privacy-hero">
            <div class="container py-0 py-sm-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 ">
                        <h1 id="privacy-title" class=" text-black font-weight-bold mb-2">
                            {{ __('main.privacy.title') }}
                        </h1>
                        <p class="text-dark ">
                            <small>{{ __('main.privacy.last_updated') }}:
                                {{ $updatedDate ?? now()->format('d M, Y') }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Section -->
        <section class="py-5 bg-gray-200">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <!-- Introduction -->
                        <div class="card border-0 shadow-sm pt-4 px-4 pb-1 editor">
                            @if ($row->desc)
                                {!! $row->desc !!}
                            @else
                                <div class="text-center py-5">Not Data</div>
                            @endif
                        </div>



                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection
