@extends('main.layouts.master')
@section('title', $pageTitle)

@section('content')
    <section id="customers">
        <div class="container mb-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">{{ $pageTitle }}</h1>
                </div>

                @include('clients.includes.aside')

                <x-client-content>


                    <x-client-breadcrumb :items="[
                        ['title' => __('client.profile.my'), 'url' => clientUrl()],
                        [
                            'title' => __('client.owner_associations.title'),
                            'url' => route('main.clients.owner-associations.index'),
                        ],
                        ['title' => Str::limit($ownerAssociation->name, 20)],
                    ]" /> <!-- end breadcrumb -->



                    <p class="font-14 text-center mb-3 alert alert-info">
                        {{ __('client.owner_associations.show_intro') }}
                    </p>

                    <!-- Association Header -->
                    <div class="box mb-4">

                        <h5 class="mb-2 text-black fs-clamp-16-22 font-weight-600">{{ $ownerAssociation->name }}</h5>
                        <p class="text-muted mb-2">
                            {{ $ownerAssociation->address ?? __('client.owner_associations.no_address') }}
                        </p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-soft-main text-main px-3 py-2 icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                </svg>
                                {{ __('client.owner_associations.manager') }}:
                                @if ($ownerAssociation->manager)
                                    {{ $ownerAssociation->manager->name }}
                                @else
                                    {{ __('client.owner_associations.not_assigned') }}
                                @endif
                            </span>
                        </div><!-- manager -->

                        <div class="form-row">

                            <div class="col-md-3 col-6 mb-2 mb-md-0">
                                <div class="bg-light p-3 rounded text-center">

                                    <span class="text-primary  mb-2 d-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-building">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 21l18 0" />
                                            <path d="M9 8l1 0" />
                                            <path d="M9 12l1 0" />
                                            <path d="M9 16l1 0" />
                                            <path d="M14 8l1 0" />
                                            <path d="M14 12l1 0" />
                                            <path d="M14 16l1 0" />
                                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" />
                                        </svg>
                                    </span>
                                    <strong>{{ $myUnits->count() }}</strong>
                                    <small class="text-muted d-block">{{ __('client.owner_associations.my_units') }}</small>
                                </div>
                            </div>

                            <div class="col-md-3 col-6 mb-2 mb-md-0">
                                <div class="bg-light p-3 rounded text-center">

                                    <span class="text-warning  mb-2 d-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-list-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3.5 5.5l1.5 1.5l2.5 -2.5" />
                                            <path d="M3.5 11.5l1.5 1.5l2.5 -2.5" />
                                            <path d="M3.5 17.5l1.5 1.5l2.5 -2.5" />
                                            <path d="M11 6l9 0" />
                                            <path d="M11 12l9 0" />
                                            <path d="M11 18l9 0" />
                                        </svg>
                                    </span>

                                    <strong
                                        class="text-warning">{{ $requestsStats['pending'] + $requestsStats['in_progress'] }}</strong>
                                    <small
                                        class="text-muted d-block">{{ __('client.owner_associations.open_requests') }}</small>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="bg-light p-3 rounded text-center">

                                    <span class="text-info  mb-2 d-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-message-question">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M8 9h8" />
                                            <path d="M8 13h6" />
                                            <path
                                                d="M14 18h-1l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
                                            <path d="M19 22v.01" />
                                            <path d="M19 19a2.003 2.003 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                                        </svg>
                                    </span>

                                    <strong>{{ $requestsStats['total'] }}</strong>
                                    <small
                                        class="text-muted d-block">{{ __('client.owner_associations.total_requests') }}</small>
                                </div>
                            </div>

                            <div class="col-md-3 col-6 ">
                                <div class="bg-light p-3 rounded text-center">
                                    <span class="text-success  mb-2 d-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-square-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 12l2 2l4 -4" />
                                        </svg>
                                    </span>
                                    <strong class="text-success">{{ $requestsStats['completed'] }}</strong>
                                    <small
                                        class="text-muted d-block">{{ __('client.owner_associations.completed') }}</small>
                                </div>
                            </div>

                        </div><!-- row -->

                    </div><!-- box -->

                    <!-- My Units -->
                    <div class="box px-0 mb-4">

                        <h5 class=" font-weight-600 px-4 pb-3">
                            {{ __('client.owner_associations.my_units_list') }}
                            <span class="badge bg-primary text-white ms-2">{{ $myUnits->count() }}</span>
                        </h5><!-- units title -->

                        @forelse($myUnits as $unit)
                            <div
                                class="px-4 {{ $loop->last ? 'pt-3 pb-0' : ($loop->first ? 'py-3' : 'pt-3 pb-3') }} border-top">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <h6 class="mb-1">{{ $unit->unit_number ?? $unit->name }}</h6>
                                        <small class="text-muted">{{ $unit->propertyType->name ?? '-' }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <svg class="fa-2x text-muted mb-3"
                                    style="width: 2em; height: 2em; display: block; margin: 0 auto;"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor">
                                    <path
                                        d="M336 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zM144 480H48c-8.8 0-16-7.2-16-16s7.2-16 16-16h96v32zm0-64H48v-80h96v80zm0-128H48v-80h96v80zm0-128H48V80h96v80zm144 320h-96v-32h96c8.8 0 16 7.2 16 16s-7.2 16-16 16zm0-64h-96v-80h96v80zm0-128h-96v-80h96v80zm0-128h-96V80h96v80z" />
                                </svg>
                                <p class="text-muted">{{ __('client.owner_associations.no_units') }}</p>
                            </div>
                        @endforelse

                    </div>

                    <!-- Recent Requests -->
                    @if ($recentRequests->count())


                        <div class="box px-0 mb-4">

                            <h5 class=" font-weight-600 px-4 pb-3">
                                <svg class="text-info me-2" style="width: 1em; height: 1em; vertical-align: -0.125em;"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                                    <path
                                        d="M504 255.531c.253 136.64-111.18 248.372-247.82 248.468-59.015.042-113.223-20.53-155.822-54.911-11.077-8.94-11.905-25.541-1.839-35.607l11.267-11.267c8.609-8.609 22.353-9.551 31.891-1.984C173.062 425.135 212.781 440 256 440c101.705 0 184-82.311 184-184 0-101.705-82.311-184-184-184-48.814 0-93.149 18.969-126.068 49.932l50.754 50.754c10.08 10.08 2.941 27.314-11.313 27.314H24c-8.837 0-16-7.163-16-16V38.627c0-14.254 17.234-21.393 27.314-11.314l49.372 49.372C129.209 34.136 189.552 8 256 8c136.81 0 247.747 110.78 248 247.531zm-180.912 78.784l9.823-12.63c8.138-10.463 6.253-25.542-4.21-33.679L288 256.349V152c0-13.255-10.745-24-24-24h-16c-13.255 0-24 10.745-24 24v135.651l65.409 50.874c10.463 8.137 25.541 6.253 33.679-4.21z" />
                                </svg>
                                {{ __('client.owner_associations.recent_requests') }}
                            </h5>

                            @foreach ($recentRequests as $request)
                                <a title="{{ __('client.owner_associations.view') }}"
                                    href="{{ route('main.clients.owner-associations.requests.show', $request->uuid) }}">
                                    <div
                                        class="px-4 {{ $loop->first ? 'py-3' : 'pt-3' }} {{ $loop->last ? 'pb-0' : 'pb-3' }} border-top">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h6 class="mb-1">#{{ $request->id }} -
                                                    {{ $request->title ?? $request->subject }}</h6>
                                                <small class="text-muted">{{ $request->unit->unit_number ?? '-' }}</small>
                                            </div>

                                            <div class="col-md-4 text-md-end">

                                                <span class="badge {{ $request->status->color() }} px-3 py-2">
                                                    {{ $request->status->label() }}
                                                </span>

                                                @if ($request->assignedAdmin)
                                                    <small class="text-muted d-block mb-1">
                                                        {{ __('client.owner_associations.assigned_to') }}:
                                                        {{ $request->assignedAdmin->full_name }}
                                                    </small>
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                        </div>

                    @endif

                    <!-- Quick Actions -->
                    <div class="row">

                        <div class="col-md-6 mb-4">
                            <a href="{{ route('main.clients.owner-associations.show.requests', $ownerAssociation->uuid) }}"
                                class="box d-block text-secondary h-100 text-center p-4 ">

                                <svg class="fa-3x  mb-3" style="width: 3em; height: 3em; display: block; margin: 0 auto;"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M13 5h8" />
                                    <path d="M13 9h5" />
                                    <path d="M13 15h8" />
                                    <path d="M13 19h5" />
                                    <path
                                        d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    <path
                                        d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                </svg>

                                <h6>{{ __('client.owner_associations.all_requests') }}</h6>

                                <small class="text-muted">
                                    {{ $requestsStats['total'] }}
                                    {{ __('client.owner_associations.total') }}
                                </small>

                            </a>
                        </div>

                        <div class="col-md-6 mb-4">
                            <a href="{{ route('main.clients.owner-associations.requests.create', $ownerAssociation->uuid) }}"
                                class="card h-100 shadow-sm border-0 text-center p-4 bg-main text-white bg-primary-hover">

                                <svg class="fa-3x mb-3" style="width: 3em; height: 3em; display: block; margin: 0 auto;"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-square-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 12h6" />
                                    <path d="M12 9v6" />
                                    <path
                                        d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" />
                                </svg>

                                <h6>{{ __('client.owner_associations.new_request') }}</h6>
                                <small>{{ __('client.owner_associations.submit_new') }}</small>
                            </a>
                        </div>

                    </div>

                </x-client-content>{{-- End Client Col Content --}}

            </div>
        </div>
    </section>
@endsection
