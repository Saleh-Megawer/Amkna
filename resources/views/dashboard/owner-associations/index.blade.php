@extends('dashboard.layouts.master')
@section('title', $linksMap['index']['title'])
<x-dashboard.css :links="[
    [
        'link' => 'owner-associations/index.css',
    ],
]" />
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['index']['title'],
        ],
    ]" :buttons="[
        [
            'name' => '<i class=\'fa fa-plus\'></i>  إنشاء ملف',
            'class' => 'btn-main',
            'options' => [
                'data-toggle' => 'modal',
                'data-target' => '#model-add-owner-association',
            ],
        ],
    ]" /><!-- links bar -->

    <main id="page-owner-associations">
        @if (count($associations))
            <div class="row">
                @foreach ($associations as $association)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('owner-associations.show', $association->uuid) }}" class="association-card-link">
                            <div class="association-card">

                                <!-- Header -->
                                <div class="association-card-header">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h5 class="association-card-title">
                                            {{ $association->name }}
                                        </h5>
                                        <span class="association-card-badge">
                                            {{ $association->units()->count() }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="association-card-body">
                                    <div class="association-card-info">
                                        <svg class="association-card-icon" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="14" width="7" height="7"></rect>
                                            <rect x="3" y="14" width="7" height="7"></rect>
                                        </svg>
                                        <span>{{ $association->units()->count() }} وحدة</span>
                                    </div>

                                    <div class="association-card-info">
                                        <svg class="association-card-icon" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span>
                                            @if ($association->manager)
                                                {{ $association->manager->name }}
                                            @else
                                                <em class="text-muted">لم يتم تعيين أي مسؤول</em>
                                            @endif
                                        </span>
                                    </div>


                                    <div class="association-card-info">
                                        <svg class="association-card-icon" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                            </path>
                                        </svg>

                                        @if ($association->manager)
                                            <span
                                                class="text-ltr">{{ $association->manager->country_code . $association->manager->phone }}</span>
                                        @else
                                            <em class="text-muted">لا يوجد</em>
                                        @endif

                                    </div>

                                </div>

                                <!-- Footer -->
                                <div class="association-card-footer">
                                    <small class="text-muted">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        {{ $association->created_at->diffForHumans() }}
                                    </small>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            @if ($associations->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $associations->links() }}
                </div>
            @endif
        @else
            <div class="box text-center font-18 py-5">
                لا يوجد {{ $linksMap['index']['title'] }} حتى الان
            </div>
        @endif
    </main>



@endsection
<x-dashboard.js :links="[
    [
        'link' => 'owner-associations/index.js',
    ],
]" />
