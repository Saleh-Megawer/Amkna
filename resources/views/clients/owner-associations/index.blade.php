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

                    <x-client-breadcrumb :items="[['title' => __('client.profile.my'), 'url' => clientUrl()], ['title' => $pageTitle]]" />

                    <p class="font-14 text-center mb-4 alert alert-info">
                        {{ __('client.owner_associations.intro') }}
                    </p>

                    @forelse($ownerAssociations as $association)
                        <div class="box mb-4">
                            <div class="row">

                                <div class="col-md-8 col-sm-12">

                                    <div class="">
                                        <a href="{{ route('main.clients.owner-associations.show', $association->uuid) }}"
                                            class="">
                                            <h5 class="mb-2 text-black fs-clamp-16-22 font-weight-600">
                                                {{ $association->name }}</h5>
                                        </a>
                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            <span class="badge bg-soft-main text-main px-3 py-2">
                                                <i class="fas fa-user me-1"></i>
                                                {{ __('client.owner_associations.manager') }}:
                                                @if ($association->manager)
                                                    {{ $association->manager->name }}
                                                @else
                                                    {{ __('client.owner_associations.not_assigned') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div><!-- head info -->

                                    <div class="form-row">

                                        <div class="col-6 mb-3 mb-md-0">
                                            <div class="d-flex align-items-center bg-light py-3 px-2 px-sm-3 rounded">
                                                <i class="fas fa-building text-primary me-2 fs-5"></i>
                                                <div>
                                                    <small
                                                        class="text-muted d-block">{{ __('client.owner_associations.my_units') }}</small>
                                                    <strong>{{ $association->my_units_count }}</strong>
                                                    <small class="text-muted"> /
                                                        {{ $association->total_units_count }}</small>
                                                </div>
                                            </div>
                                        </div>{{-- total_units_count --}}

                                        <div class="col-6">
                                            <div class="d-flex align-items-center bg-light py-3 px-2 px-sm-3 rounded">
                                                <i class="fas fa-tasks text-warning me-2 fs-5"></i>
                                                <div>
                                                    <small
                                                        class="text-muted d-block">{{ __('client.owner_associations.open_requests') }}</small>
                                                    <strong
                                                        class="text-warning">{{ $association->open_requests_count }}</strong>
                                                    <small class="text-muted"> /
                                                        {{ $association->total_requests_count }}</small>
                                                </div>
                                            </div>
                                        </div>{{-- open_requests_count --}}

                                    </div>

                                </div>

                                <div class="col-md-4 col-sm-12 text-sm-end mt-0 mt-md-3">
                                    <div class="d-flex flex-column">

                                        <a href="{{ route('main.clients.owner-associations.requests.create', $association->uuid) }}"
                                            class="btn btn-second py-2 w-100 w-md-auto">
                                            <i class="fas fa-plus me-1"></i>
                                            {{ __('client.owner_associations.new_request') }}
                                        </a>

                                        <a href="{{ route('main.clients.owner-associations.show', $association->uuid) }}"
                                            class="btn btn-outline-main py-2 w-100 w-md-auto my-2">
                                            <i class="fas fa-eye me-1"></i>
                                            {{ __('client.owner_associations.view_association') }}
                                        </a>

                                        <a href="{{ route('main.clients.owner-associations.show.requests', $association->uuid) }}"
                                            class="btn btn-outline-main py-2 w-100 w-md-auto ">
                                            <i class="fas fa-list me-1"></i>
                                            {{ __('client.owner_associations.my_requests') }}
                                        </a>



                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="box">
                            <div class="text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" height="52px" viewBox="0 -960 960 960"
                                    width="52px" fill="#6c757d">
                                    <path
                                        d="M240-320q-33 0-56.5-23.5T160-400q0-33 23.5-56.5T240-480q33 0 56.5 23.5T320-400q0 33-23.5 56.5T240-320Zm480 0q-33 0-56.5-23.5T640-400q0-33 23.5-56.5T720-480q33 0 56.5 23.5T800-400q0 33-23.5 56.5T720-320Zm-240-40q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM284-120q14-69 68.5-114.5T480-280q73 0 127.5 45.5T676-120H284Zm-204 0q0-66 47-113t113-47q17 0 32 3t29 9q-30 29-50 66.5T224-120H80Zm656 0q-7-44-27-81.5T659-268q14-6 29-9t32-3q66 0 113 47t47 113H736ZM88-480l-48-64 440-336 160 122v-82h120v174l160 122-48 64-392-299L88-480Z">
                                    </path>
                                </svg>
                                <h5 class="text-muted mb-3 mt-2">{{ __('client.owner_associations.no_associations') }}</h5>
                                <p class="text-muted mb-0">{{ __('client.owner_associations.no_associations_desc') }}</p>
                            </div>
                        </div>
                    @endforelse

                </x-client-content>{{-- End Client Col Content --}}


            </div>
        </div>
    </section>

@endsection

@section('js')
@endsection
