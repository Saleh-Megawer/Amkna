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
                        {{ __('client.deals.description') }}
                    </p>

                    @if ($deals->isEmpty())
                        <p class="text-muted">
                            {{ __('client.deals.empty_title') }}
                        </p>
                    @else
                        <div class="row md-gap">
                            @foreach ($deals as $deal)
                                <div class="col-md-6 mb-3">
                                    <div class="box h-100">

                                        <h6 class="mb-2 d-flex justify-content-between">
                                            {{ __('deal.title') }} #{{ $deal->id }}

                                            <small class="text-muted icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                    <path d="M12 12l3 2" />
                                                    <path d="M12 7v5" />
                                                </svg>
                                                {{ $deal->created_at->diffForHumans() }}
                                            </small>
                                        </h6>

                                        @if ($deal->is_win)
                                            <span class="badge badge-success py-2 mb-2 d-block">
                                                {{ __('deal.is_win') }}
                                            </span>
                                        @elseif($deal->is_lost)
                                            <span class="badge badge-danger py-2 mb-2 d-block">
                                                {{ __('deal.is_lost') }}
                                            </span>
                                        @else
                                            <span class="badge badge-info py-2 mb-2 d-block">
                                                {{ __('deal.in_progress') }}
                                            </span>
                                        @endif


                                        <p class="mb-0">
                                            <strong>{{ __('deal.purpose_label') }} : </strong>
                                            {{ $deal->purpose == 'buy' ? 'شراء' : 'تأجير' }} -
                                            {{ $deal->propertyType?->name }}
                                        </p>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif


                </x-client-content>{{-- End Client Col Content --}}
            </div>
        </div>
    </section>



@endsection
@section('js')

@endsection
