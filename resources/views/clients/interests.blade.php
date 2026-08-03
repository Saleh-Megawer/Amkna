@extends('main.layouts.master')
@section('title', $pageTitle)
@section('css')
@endsection
@section('content')


    <section id="customers">
        <div class="container mb-5">
            <div class="row">

                <div class="col-12">
                    <h1 class="page-title">{{ $pageTitle }}</h1>
                </div><!-- page title -->

                @include('clients.includes.aside')
                <x-client-content>


                    <p class="font-14 text-center mb-3 alert alert-info">
                        {{ __('client.interest.description') }}
                    </p>

                    @if ($interests->isEmpty())
                        <div class="box text-center py-4">
                            <img src="{{ asset('assets/images/default/empty.png') }}" alt="Empty" width="180">

                            <h5 class="mt-3">
                                {{ __('client.interest.no_interests_title') }} !
                            </h5>

                            <a href="{{ route('main.properties.index') }}" class="text-muted mb-2 btn btn-main mt-2">
                                {{ __('client.interest.start_browsing') }}
                            </a>
                        </div>
                    @else
                        <div class="row md-gap">
                            @foreach ($interests as $interest)
                                <div class="col-xl-4 col-sm-6 mb-4">
                                    <div class="box p-0 mb-0 h-100 position-relative">

                                        {{-- Image --}}
                                        <img data-src="{{ propertyImage($interest->property->main_image, 'medium') }}"
                                            class="card-img-top lazy" alt="{{ $interest->property->title }}">

                                        <div class="card-body">

                                            {{-- Status --}}
                                            <span class="badge {{ $interest->status_class }}">
                                                {{ $interest->status_text }}
                                            </span>


                                            {{-- Interest Label --}}
                                            <small class="text-primary font-weight-500 d-block mb-0 mt-1">
                                                {{ __('client.interest.interest_submitted') }}
                                            </small>

                                            {{-- Property Title --}}
                                            <h6 style="line-height: 1.6" class="card-title my-2">
                                                {{ $interest->property?->title }}
                                            </h6>


                                            {{-- Date --}}
                                            <p class="text-muted small mb-0 icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                    <path d="M12 12l3 2" />
                                                    <path d="M12 7v5" />
                                                </svg>
                                                {{ $interest->created_at->diffForHumans() }}
                                            </p>

                                            {{-- Visit Property --}}
                                            <a href="{{ propertyUrl($interest->property) }}" class="stretched-link "></a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </x-client-content>
            </div>
        </div>
    </section>



@endsection
@section('js')

@endsection
