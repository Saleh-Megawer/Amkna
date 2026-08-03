@extends('main.layouts.master')
@section('title', __('client.owner_associations.new_request'))

@section('content')
    <main id="page-owner-associations-create-request">
        <div class="container mb-5">
            <div class="row">

                <div class="col-12">
                    <h1 class="page-title">{{ __('client.owner_associations.new_request') }}</h1>
                </div>

                @include('clients.includes.aside')


                <x-client-content>

                    <x-client-breadcrumb :items="[
                        ['title' => __('client.profile.title'), 'url' => clientUrl()],
                        [
                            'title' => __('client.owner_associations.title'),
                            'url' => route('main.clients.owner-associations.index'),
                        ],
                        ['title' => __('client.owner_associations.new_request')],
                    ]" /> <!-- end breadcrumb -->

                    <div class="alert alert-info" role="alert">
                        <strong>{{ __('client.owner_associations.create_request_title') }}</strong><br>
                        {{ __('client.owner_associations.create_request_info') }}
                    </div>


                    @foreach ($all_owner_association as $association)
                        <div class="box mb-4">
                            <div class="row align-items-center">

                                <div class="col-md-8 col-sm-12">
                                    <div class="">
                                        <a href="{{ route('main.clients.owner-associations.show', $association->uuid) }}"
                                            class="">
                                            <h5 class="fs-clamp-16-20 mb-0 font-weight-600">
                                                {{ $association->name }}</h5>
                                        </a>
                                    </div><!-- head info -->
                                </div>

                                <div class="col-md-4 col-sm-12 text-sm-end mt-3 mt-md-0">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('main.clients.owner-associations.requests.create', $association->uuid) }}"
                                            class="btn btn-second py-2 w-100 w-md-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                            {{ __('client.owner_associations.new_request') }}
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach


                </x-client-content>


            </div>
        </div>
    </main>
@endsection
@section('js')

@endsection
