@extends('main.layouts.master')
@section('title', $pageTitle)

@section('content')
    <section id="page-show-owner-associations-requests">
        <div class="container mb-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">{{ $pageTitle }}</h1>
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
                            'title' => __('client.owner_associations.request') . ' #' . $request->id,
                        ],
                    ]" /> <!-- end breadcrumb -->

                    <!-- Request Header -->
                    <div class="box mb-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-light text-dark me-2">#{{ $request->id }}</span>
                                {{ $request->title }}
                            </div>

                            <a href="{{ route('main.clients.owner-associations.show', $ownerAssociation->uuid) }}"
                                class="btn btn-sm btn-outline-secondary">
                                {{ __('client.owner_associations.back') }}
                            </a>

                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <small
                                    class="text-muted d-block mb-1">{{ __('client.owner_associations.request_type') }}</small>
                                <span class="badge {{ $request->type->color() }} px-3 py-2">
                                    <span>{!! $request->type->icon() !!}</span>
                                    {{ $request->type->label() }}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <small
                                    class="text-muted d-block mb-1">{{ __('client.owner_associations.request_priority') }}</small>
                                <span class="badge {{ $request->priority->color() }} px-3 py-2">
                                    {{ $request->priority->label() }}
                                </span>
                            </div>

                            <div class="col-md-3">
                                <small
                                    class="text-muted d-block mb-1">{{ __('client.owner_associations.request_status') }}</small>
                                <span class="badge {{ $request->status->color() }} px-3 py-2">
                                    {{ $request->status->label() }}
                                </span>
                            </div>

                            <div class="col-md-3">
                                <small class="text-muted d-block mb-1">{{ __('client.owner_associations.unit') }}</small>
                                <strong>{{ $request->unit->unit_number ?? '-' }}</strong>
                                <small class="text-muted d-block">{{ $request->unit->propertyType->name ?? '' }}</small>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 font-14">
                                <small
                                    class="text-muted d-block mb-1">{{ __('client.owner_associations.created_at') }}</small>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1 text-muted" width="17"
                                        height="17" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M12 7v5l3 3" />
                                        <path d="M4 12a8 8 0 1 0 16 0a8 8 0 0 0 -16 0" />
                                    </svg>
                                    <span>{{ $request->created_at->format('Y-m-d H:i') }}</span>
                                    <small class="text-muted ms-2"> ( {{ $request->created_at->diffForHumans() }} )
                                    </small>
                                </div>
                            </div>
                            @if ($request->assignedAdmin)
                                <div class="col-md-6 font-14">
                                    <small
                                        class="text-muted d-block mb-1">{{ __('client.owner_associations.assigned_to') }}</small>
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" />
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        </svg>
                                        <span>{{ $request->assignedAdmin->full_name }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- Request Description -->
                    <div class="box mb-4">

                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2 text-primary" width="20" height="20"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <path d="M9 9h1" />
                                <path d="M9 13h6" />
                                <path d="M9 17h6" />
                            </svg>
                            {{ __('client.owner_associations.request_description') }}
                        </div>

                        <p class="mb-0">{{ $request->description ?? __('client.owner_associations.no_description') }}</p>

                    </div>

                    <!-- Replies Timeline -->
                    <div class="box mb-4">

                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2 text-primary" width="20" height="20"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                                <path d="M12 12v.01" />
                                <path d="M8 12v.01" />
                                <path d="M16 12v.01" />
                            </svg>
                            {{ __('client.owner_associations.replies') }}
                            <span class="badge bg-primary text-white mx-1">{{ $request->replies->count() }}</span>
                        </div>

                        <div class="mt-3">
                            @forelse($request->replies as $reply)
                                <div class="reply-timeline">
                                    <div class="reply-item {{ $reply->isFromAdmin() ? 'admin-reply' : '' }}">
                                        <div class="reply-content">
                                            <div class="reply-meta">
                                                <strong>
                                                    @if ($reply->isFromAdmin())
                                                        {{ $reply->replier->full_name }}
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success ms-1">{{ __('client.owner_associations.admin') }}</span>
                                                    @else
                                                        {{ $reply->replier->name ?? __('client.owner_associations.you') }}
                                                    @endif
                                                </strong>
                                                <span class="ms-2">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="reply-text">
                                                {{ $reply->message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-2" width="32" height="32"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                                    </svg>
                                    <p class="mb-0">{{ __('client.owner_associations.no_replies_yet') }}</p>
                                </div>
                            @endforelse
                        </div>

                    </div>

                    <!-- Add Reply Form -->
                    <div class="box">

                        <div class="">
                            {{ __('client.owner_associations.add_reply') }}
                        </div>

                        <div class="mt-3">
                            <form action="{{ route('main.clients.owner-associations.requests.reply', $request->uuid) }}"
                                method="POST">
                                @csrf
                                <div class="mb-3">


                                    <x-form-group :properties="[
                                        'textarea' => [
                                            'name' => 'message',
                                            'type' => 'text',
                                            'options' => [
                                                'required',
                                                'rows' => '4',
                                                'placeholder' => __('client.owner_associations.reply_placeholder'),
                                            ],
                                        ],
                                    ]" /> <!-- message -->

                                    {{-- 
                                    <textarea name="message" rows="4" class="form-control @error('message') is-invalid @enderror"
                                        placeholder="{{ __('client.owner_associations.reply_placeholder') }}">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror --}}


                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-second px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="18"
                                            height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" />
                                            <path d="M10 14l11 -11" />
                                            <path
                                                d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                        </svg>
                                        {{ __('client.owner_associations.send_reply') }}
                                    </button>
                                </div>
                            </form>

                        </div>

                    </div>

                </x-client-content>{{-- End Client Col Content --}}

            </div>
        </div>
    </section>
@endsection
