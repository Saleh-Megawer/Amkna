@extends('main.layouts.master')
@section('title', __('client.owner_associations.my_requests_title'))

@section('content')
    <section id="">
        <div class="container mb-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">{{ __('client.owner_associations.my_requests_title') }}</h1>
                </div>

                @include('clients.includes.aside')

                <x-client-content> 

                    <x-client-breadcrumb :items="[
                        ['title' => __('client.profile.title'), 'url' => clientUrl()],
                        [
                            'title' => __('client.owner_associations.title'),
                            'url' => route('main.clients.owner-associations.index'),
                        ],
                        [
                            'title' => Str::limit($ownerAssociation->name, 25),
                            'url' => route('main.clients.owner-associations.show', $ownerAssociation->uuid),
                        ],
                        [
                            'title' => __('client.owner_associations.my_requests_title'),
                        ],
                    ]" /> <!-- end breadcrumb -->

                    <!-- Association Info Header -->
                    <div class="box mb-4">
                        <div class="d-block d-md-flex justify-content-between align-items-start flex-wrap">

                            <div>
                                <h5 class="mb-1 font-18 font-weight-600">{{ $ownerAssociation->name }}</h5>
                                <small class="text-muted">{{ __('client.owner_associations.viewing_requests_for') }}</small>
                            </div>


                            <div  class="mt-3 mt-md-0">


                                <a href="{{ route('main.clients.owner-associations.requests.create', $ownerAssociation->uuid) }}"
                                    class="btn btn-second btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="18" height="18"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M12 5v14" />
                                        <path d="M5 12h14" />
                                    </svg>
                                    {{ __('client.owner_associations.new_request') }}
                                </a>

                                <a href="{{ route('main.clients.owner-associations.show', $ownerAssociation->uuid) }}"
                                    class="btn btn-soft-main btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="18" height="18"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M9 11l-4 4l4 4" />
                                        <path d="M5 15h11a4 4 0 0 0 0 -8h-1" />
                                    </svg>
                                    {{ __('client.owner_associations.back') }}
                                </a>

                            </div>

                        </div>
                    </div>

                    <!-- Requests List -->
                    <div class="box p-0">

                        <h5 class="mb-0 px-4 pt-4 font-18 font-weight-600 d-flex align-items-center pb-4">
                            {{ __('client.owner_associations.all_requests') }}
                            <span class="badge bg-primary text-white ms-2">{{ $requests->total() }}</span>
                        </h5>


                        @forelse($requests as $request)
                            <div class="px-4 py-2 border-top">
                                <div class="form-row align-items-center">

                                    <div class="col-md-1">
                                        <span class="badge bg-light text-dark fs-6">#{{ $request->id }}</span>
                                    </div>

                                    <div class="col-md-4">
                                        <a class="hover-box" title="{{ __('client.owner_associations.view') }}"
                                            href="{{ route('main.clients.owner-associations.requests.show', $request->uuid) }}">


                                            <h6 class="mb-1 font-16">
                                                {{ $request->title }}
                                            </h6>

                                            <small class="text-muted d-flex align-items-center">
                                                {{ __('client.owner_associations.unit') }}:
                                                {{ $request->unit->unit_number ?? '-' }}
                                            </small>

                                        </a>
                                    </div>

                                    <div class="col-md-2">
                                        <span class="badge {{ $request->status->color() }} px-3 py-2">
                                            {{ $request->status->label() }}
                                        </span>
                                    </div>


                                    <div class="col-md-3">
                                        @if ($request->assignedAdmin)
                                            <small class="text-muted d-flex align-items-center mb-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" />
                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                </svg>
                                                {{ $request->assignedAdmin->full_name }}
                                            </small>
                                        @endif
                                        <small class="text-muted d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16"
                                                height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <path d="M12 7v5l3 3" />
                                                <path d="M4 12a8 8 0 1 0 16 0a8 8 0 0 0 -16 0" />
                                            </svg>
                                            {{ $request->updated_at->diffForHumans() }}
                                        </small>
                                    </div>

                                    <div class="col-md-2 text-end">

                                        <!-- Start Cancel Action -->
                                        @if ($request->status->value === 'pending')
                                            <form
                                                action="{{ route('main.clients.owner-associations.requests.cancel', $request->uuid) }}"
                                                method="POST" class="d-inline ajax-form">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-soft-danger w-100 btn-sm"
                                                    onclick="return confirm('هل أنت متأكد من إلغاء هذا الطلب؟')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="15" y1="9" x2="9" y2="15">
                                                        </line>
                                                        <line x1="9" y1="9" x2="15"
                                                            y2="15"></line>
                                                    </svg>
                                                    {{ __('client.owner_associations.cancel_request') }}
                                                </button>
                                            </form>
                                        @endif
                                        <!-- End Cancel Action -->

                                    </div>


                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mb-3 text-muted" width="40"
                                    height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <path d="M4 7h16" />
                                    <path d="M10 11h6" />
                                    <path d="M10 15h3" />
                                    <path
                                        d="M5 19h14a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-9l-2 -2h-3a1 1 0 0 0 -1 1v14a1 1 0 0 0 1 1z" />
                                </svg>
                                <h5 class="text-muted mb-3">{{ __('client.owner_associations.no_requests') }}</h5>
                                <p class="text-muted mb-4">{{ __('client.owner_associations.no_requests_desc') }}</p>
                                <a href="{{ route('main.clients.owner-associations.requests.create', $ownerAssociation->uuid) }}"
                                    class="btn btn-primary d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="18" height="18"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M12 5v14" />
                                        <path d="M5 12h14" />
                                    </svg>
                                    {{ __('client.owner_associations.create_first_request') }}
                                </a>
                            </div>
                        @endforelse


                        @if ($requests->hasPages())
                            <div class="card-footer bg-white border-0">
                                {{ $requests->links() }}
                            </div>
                        @endif
                    </div>

                </x-client-content>{{-- End Client Col Content --}}

            </div>
        </div>
    </section>
@endsection
