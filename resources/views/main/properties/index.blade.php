@section('title', __('main.property.properties'))
@section('description', 'search')
@section('image', metaImage('meta-home.webp'))
@section('image-type', 'webp')
@extends('main.layouts.master')
@section('body-class', 'bg-gray-100')
{{-- <x-css :links="[['from' => 'plugins', 'link' => 'owl-carousel/owl.carousel.min.css']]" /> --}}
@section('content')


    <div class="search-page container-fluid px-3">
        <div class="row">



            <!-- Sidebar Filters -->
            <aside class="col-xl-2 col-lg-6 col-md-3 search-filters d-none d-md-block" id="filtersSidebar">

                <x-property-filters :data="['filters' => $filters]" :propertyTypes="$propertyTypes" :filterRanges="$filterRanges" :sections="$sections"
                    :showSearchButton="false" />

                <div class="filter-actions mb-4">
                    <a href="{{ route('main.properties.index') }}" class="btn btn-soft-main btn-block">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>

                        {{ __('main.filters.clear_all') }}
                    </a>
                </div>

            </aside>


            <!-- Results -->
            <main class="col-xl-10 col-lg-6 col-md-9 search-results">


                <!-- Overlay filters for mobile -->
                <div class="filters-overlay" id="filtersOverlay">
                    <div class="filters-overlay-content">
                        <div class="filters-overlay-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">{{ __('main.filters.filters') }}</h5>
                            <button type="button" class="btn btn-link text-dark" id="closeFiltersBtn"
                                style="font-size: 2rem; line-height: 1;">&times;</button>
                        </div>

                        <x-property-filters :data="['filters' => $filters]" :propertyTypes="$propertyTypes" :filterRanges="$filterRanges" :sections="$sections"
                            :showSearchButton="true" />

                    </div>
                </div>


                <!-- Top bar -->
                <div class="results-header d-flex justify-content-between align-items-center mb-2">
                    <h4 class="m-0 text-black">
                        {{ __('main.filters.properties_found_label') }}
                        <span id="resultsCount">{{ $properties->total() }}</span>
                    </h4>
                    {{-- <h4 class="m-0 text-black">Properties <span class=" font-15 text-secondary">( Found 32 )</span></h4> --}}

                    <div class="actions d-flex flex-wrap">

                        {{-- Mobile filters toggle --}}
                        <button class="d-inline-flex d-md-none" id="openFiltersBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-filter-spark">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M15 12.5v-.5l4.414 -4.414a2 2 0 0 0 .586 -1.414v-2.172h-16v2.227c0 .497 .185 .977 .52 1.345l4.48 4.928v8.5l2 -.667" />
                                <path
                                    d="M18.5 22a4.75 4.75 0 0 1 3.5 -3.5a4.75 4.75 0 0 1 -3.5 -3.5a4.75 4.75 0 0 1 -3.5 3.5a4.75 4.75 0 0 1 3.5 3.5" />
                            </svg>
                        </button>

                        <div class="sort-box">
                            <div class="btn-group">

                                <button class="dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-sort">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 9l4 -4l4 4m-4 -4v14" />
                                        <path d="M21 15l-4 4l-4 -4m4 4v-14" />
                                    </svg>
                                    <!-- Current -->
                                    <span class="current-options">{{ __('main.filters.sort') }}</span>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="#" data-sort="latest">
                                        {{ __('main.filters.newest') }}
                                    </a>

                                    <a class="dropdown-item" href="#" data-sort="price-low">
                                        {{ __('main.filters.price_low_to_high') }}
                                    </a>

                                    <a class="dropdown-item" href="#" data-sort="price-high">
                                        {{ __('main.filters.price_high_to_low') }}
                                    </a>
                                </div>


                            </div>
                        </div>

                    </div>

                </div>


                <!-- Properties Grid -->
                <div class="row md-gap" id="properties-list"
                    data-filter-url="{{ route('main.properties.filters.properties') }}">

                    @include('main.properties.partials.property-grid', [
                        'properties' => $properties,
                    ])<!-- data -->

                </div><!-- end row data properties-->


                <div class="row md-gap mb-5" id="properties-pagination">
                    <div class="col-12">
                        @include('main.properties.partials.property-pagination', [
                            'properties' => $properties,
                        ])
                    </div>
                </div><!-- pagination -->

            </main>

        </div>
    </div>

@endsection
<x-js :links="[
    // ['from' => 'plugins', 'link' => 'owl-carousel/owl.carousel.min.js'],
    ['from' => 'pages', 'link' => 'main/properties.js'],
]" />
