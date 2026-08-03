@extends('main.layouts.master')
@section('title', $pageTitle)
@section('content')


    <section id="customers">
        <div class="container mb-5">
            <div class="row">

                <div class="col-12">
                    <h1 class="page-title">{{ $pageTitle }}</h1>
                </div><!-- page title -->

                @include('clients.includes.aside')

                <x-client-content>

                    @php
                        $client = client();
                        $profileIncomplete =
                            !$client->national_id || !$client->birth_date || !$client->national_address;
                    @endphp

                    @if ($profileIncomplete)
                        <div class="alert alert-warning d-flex align-items-center justify-content-between" role="alert">
                            <div>
                                {{ __('client.dashboard.profile_incomplete_alert') }}
                            </div>

                            <a href="{{ route('main.clients.profile.index') }}" class="btn btn-sm btn-warning ml-3">
                                {{ __('client.dashboard.complete_profile') }}
                            </a>
                        </div>
                    @endif

                    @if (session('success-send-email') || session('verified_successfully'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('success-send-email') ?? session('verified_successfully') }}
                        </div>
                    @else
                        @if (client() && client()->has_account && client()->hasEmail() && !client()->isEmailVerified())
                            <div class="alert alert-warning mb-4 d-flex justify-content-between align-items-center">
                                {{ __('client.email.not_verified') }}
                                <div class="">
                                    <form method="POST" action="{{ route('main.clients.email.verify.send') }}"
                                        class="d-inline"
                                        onsubmit="this.querySelector('button').disabled=true;this.querySelector('button').innerText='{{ __('client.email.sending') }}';">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm ml-2">
                                            {{ __('client.email.verify_now') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif


                    <div class="row">

                        {{-- إجمالي الوحدات --}}
                        <div class="col-xl-3 col-md-6 mb-3 mb-lg-4">
                            <div class="box">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px; background: var(--accent-soft);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="mb-1">{{ number_format($stats['total_units']) }}</h3>
                                        <p class="text-muted text-nowrap mb-0 small">
                                            {{ __('client.dashboard.total_units') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- الطلبات النشطة --}}
                        <div class="col-xl-3 col-md-6 mb-3 mb-lg-4">
                            <div class="box">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px; background: rgba(25, 135, 84, 0.1);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="#198754" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="mb-1">{{ number_format($stats['active_requests']) }}</h3>
                                        <p class="text-muted text-nowrap mb-0 small">
                                            {{ __('client.dashboard.active_requests') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- الطلبات المعلقة --}}
                        <div class="col-xl-3 col-md-6 mb-3 mb-lg-4">
                            <div class="box">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px; background: rgba(255, 193, 7, 0.1);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="#ffc107" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="mb-1">{{ number_format($stats['pending_requests']) }}</h3>
                                        <p class="text-muted text-nowrap mb-0 small">
                                            {{ __('client.dashboard.pending_requests') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- إجمالي الطلبات --}}
                        <div class="col-xl-3 col-md-6 mb-3 mb-lg-4">
                            <div class="box">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px; background: rgba(13, 110, 253, 0.1);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="#0d6efd" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13">
                                                </line>
                                                <line x1="16" y1="17" x2="8" y2="17">
                                                </line>
                                                <polyline points="10 9 9 9 8 9"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="mb-1">{{ number_format($stats['total_requests']) }}</h3>
                                        <p class="text-muted text-nowrap mb-0 small">
                                            {{ __('client.dashboard.total_requests') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- row -->


                    <div class="row mb-3 mb-lg-4">
                        <div class="col-12">
                            <div class="box p-0">

                                <div class="px-4 pt-4 pb-2 d-flex align-items-center justify-content-between mb-3">
                                    <h5 class="mb-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        </svg>
                                        {{ __('client.dashboard.my_associations') }}
                                    </h5>
                                    <a href="{{ route('main.clients.owner-associations.index') }}"
                                        class="text-decoration-none">
                                        {{ __('client.dashboard.view_all') }}
                                    </a>
                                </div>

                                @forelse($ownerAssociations as $association)
                                    <a href="{{ route('main.clients.owner-associations.show', $association->uuid) }}"
                                        class="text-decoration-none fw-medium d-block">
                                        <div class="px-4 pt-3 pb-3 d-flex py-3 border-top">

                                            <div class="flex-shrink-0 me-3">
                                                <div class="rounded d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px; background: var(--accent-soft);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="var(--accent)"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <rect x="3" y="3" width="7" height="7"></rect>
                                                        <rect x="14" y="3" width="7" height="7"></rect>
                                                        <rect x="14" y="14" width="7" height="7"></rect>
                                                        <rect x="3" y="14" width="7" height="7"></rect>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="flex-grow-1">

                                                <span>{{ $association->name }}</span>

                                                <div class="small text-muted mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                    </svg>
                                                    {{ $association->units_count }} {{ __('client.dashboard.units') }}
                                                </div>

                                            </div>

                                            {{-- <div class="flex-shrink-0 d-none d-sm-block">
                                            <a href="{{ route('main.clients.owner-associations.show', $association->uuid) }}"
                                                class="btn btn-sm btn-outline-main">
                                                {{ __('client.dashboard.view_details') }}
                                            </a>
                                            </div> --}}
                                        </div>
                                    </a>

                                @empty
                                    <div class=" text-center">

                                        <img src="{{ asset('assets/images/default/empty.png') }}" alt="Empty"
                                            width="180">
                                        <p class="text-muted pt-0 pb-4 mb-0">
                                            {{ __('client.dashboard.no_associations') }}
                                        </p>

                                    </div>
                                @endforelse

                            </div>
                        </div>
                    </div>


                    <div class="row ">

                        {{-- آخر الطلبات --}}
                        <div class="col-lg-6 mb-3 mb-lg-4">
                            <div class="box p-0">

                                <div class="px-4 pt-4 pb-2 d-flex align-items-center justify-content-between mb-3">
                                    <h5 class="mb-0 font-18">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                        </svg>
                                        {{ __('client.dashboard.latest_requests') }}
                                    </h5>
                                    <a href="{{ route('main.clients.owner-associations.requests.index') }}"
                                        class="text-decoration-none">
                                        {{ __('client.dashboard.view_all') }}
                                    </a>
                                </div>

                                @forelse($latestRequests as $request)
                                    <div class="px-4 pt-3 pb-3 d-flex align-items-center border-top">
                                        <div class="flex-grow-1">
                                            <a href="{{ route('main.clients.owner-associations.requests.show', $request->uuid) }}"
                                                class="text-decoration-none text-dark fw-medium">
                                                {{ $request->title }}
                                            </a>
                                            <div class="small text-muted">
                                                {{ $request->ownerAssociation->name }} - {{ $request->unit->unit_number }}
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <span class="badge font-weight-400 {{ $request->status->color() }}">
                                                {{ $request->status->label() }}
                                            </span>
                                            <div class="small text-muted mt-1">
                                                {{ $request->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class=" text-center">
                                        <img src="{{ asset('assets/images/default/empty.png') }}" alt="Empty"
                                            width="180">
                                        <p class="text-muted pt-0 pb-4 mb-0">
                                            {{ __('client.dashboard.no_requests') }}
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- آخر تحديثات من الإدارة --}}
                        <div class="col-lg-6 mb-3 mb-lg-4">
                            <div class="box p-0">
                                <div class="px-4 pt-4 pb-2  d-flex align-items-center justify-content-between mb-3">
                                    <h5 class="mb-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                        {{ __('client.dashboard.admin_updates') }}
                                    </h5>
                                </div>

                                @forelse($latestAdminReplies as $reply)
                                    <div class="px-4 pt-3 pb-3 d-flex align-items-start py-2 border-top">
                                        <div class="flex-shrink-0 me-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 35px; height: 35px; background: var(--accent-soft);">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="var(--accent)"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium">{{ $reply->replier->full_name }}</div>
                                            <a href="{{ route('main.clients.owner-associations.requests.show', $reply->request->uuid) }}"
                                                class="text-decoration-none small text-muted">
                                                {{ $reply->request->title }}
                                            </a>
                                            <p class="mb-1 small mt-1">{{ Str::limit($reply->message, 60) }}</p>
                                            <span
                                                class="small text-muted">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class=" text-center">
                                        <img src="{{ asset('assets/images/default/empty.png') }}" alt="Empty"
                                            width="180">
                                        <p class="text-muted pt-0 pb-4 mb-0">
                                            {{ __('client.dashboard.no_admin_updates') }}
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div><!-- end row -->

                </x-client-content>{{-- End Client Col Content --}}

            </div>
        </div>
    </section>



@endsection
