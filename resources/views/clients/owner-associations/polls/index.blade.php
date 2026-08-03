@extends('main.layouts.master')
@section('title', $pageTitle)
@section('content')

    <main id="page-owner-associations-polls-index">
        <div class="container mb-5">
            <div class="row">

                <div class="col-12">
                    <h1 class="page-title">{{ $pageTitle }}</h1>
                </div><!-- page title -->

                @include('clients.includes.aside')

                <x-client-content>



                    <x-client-breadcrumb :items="[['title' => __('client.profile.title'), 'url' => clientUrl()], ['title' => $pageTitle]]" />


                    <p class="font-14 text-center mb-4 alert alert-info">
                        {{ $pageTitle }} : {{ __('client.polls.subtitle') }}
                    </p>


                    @forelse($polls as $poll)
                        <div class="box mb-4">
                            <div class="poll-item">

                                <span class="ms -2 status-badges pb-2 pb-sm-0">
                                    @if ($poll->has_voted)
                                        <span class="badge bg-success text-white font-weight-500 p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            {{ __('client.polls.voted') }}
                                        </span>
                                    @else
                                        @if ($poll->is_active)
                                            <span class="badge bg-warning text-dark font-weight-500 p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10">
                                                    </circle>
                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                </svg>
                                                {{ __('client.polls.unvoted') }}
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-secondary text-white font-weight-500 p-2">{{ __('client.polls.closed') }}</span>
                                        @endif
                                    @endif
                                </span><!-- status -->

                                <div class="row align-items-center">

                                    <div class="col-lg-9 col-md-8">
                                        <div class="d-flex align-items-start">

                                            <div class="flex-shrink-0 me-3">
                                                <div class="rounded d-flex align-items-center justify-content-center text-accent"
                                                    style="width: 50px; height: 50px; background: var(--accent-soft);">
                                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 256 256">
                                                        <rect width="256" height="256" fill="none" />
                                                        <path
                                                            d="M160,80V200.67a8,8,0,0,0,3.56,6.65l11,7.33a8,8,0,0,0,12.2-4.72L200,160"
                                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="20" />
                                                        <path
                                                            d="M40,200a8,8,0,0,0,13.15,6.12C105.55,162.16,160,160,160,160h40a40,40,0,0,0,0-80H160S105.55,77.84,53.15,33.89A8,8,0,0,0,40,40Z"
                                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="20" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="flex-grow-1">

                                                <h5
                                                    class="mb-2 font-weight-600 font-18 d-flex align-items-center flex-wrap">
                                                    {{ $poll->title }}

                                                </h5><!-- title -->

                                                <p class="text-muted mb-2 font-14">{{ Str::limit($poll->description, 100) }}
                                                </p>

                                                <div class="d-flex align-items-center gap-3 flex-wrap">

                                                    <span class="badge bg-light text-dark d-flex align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                            <path d="M12 9h.01" />
                                                            <path d="M11 12h1v4h1" />
                                                        </svg>
                                                        <span class="ms-1">{{ $poll->ownerAssociation->name }}</span>
                                                    </span>

                                                    <span class="mx-1"></span>

                                                    <span class="text-muted small  d-flex align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                            <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                            <path
                                                                d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                                        </svg>
                                                        {{ $poll->votes_count }} {{ __('client.polls.votes') }}
                                                    </span>

                                                    <span class="mx-1">-</span>
                                                    <span class="text-muted small ">
                                                        {{ $poll->created_at->diffForHumans() }}
                                                    </span>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-4 text-lg-end mt-3 mt-lg-0">


                                        <a href="{{ route('main.clients.owner-association.polls.show', $poll->uuid) }}"
                                            class="btn p-0 py-2 font-14 btn-second btn-block">
                                            {{ $poll->has_voted ? __('client.polls.view_details') : __('client.polls.vote_now') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="box">
                            <div class="text-center py-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-muted mb-3">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                                <p class="text-muted mb-0">{{ __('client.polls.no_polls') }}</p>
                            </div>
                        </div>
                    @endforelse


                    {{-- Pagination --}}
                    {{-- @if ($polls->hasPages())
                        <div class="mt-4">
                            {{ $polls->links() }}
                        </div>
                    @endif --}}

                </x-client-content>{{-- End Client Col Content --}}

            </div>
        </div>
    </main>


@endsection
