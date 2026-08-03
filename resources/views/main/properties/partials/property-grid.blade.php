@forelse ($properties as $property)
    <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-4">
        <x-property-card :property="$property" />
    </div>
@empty
    <div class="col-12">
        <div class="box text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-info-square-rounded">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 9h.01" />
                <path d="M11 12h1v4h1" />
                <path d="M12 3c7.2 0 9 1.8 9 9c0 7.2 -1.8 9 -9 9c-7.2 0 -9 -1.8 -9 -9c0 -7.2 1.8 -9 9 -9" />
            </svg>
            {{ __('main.property.no_results_found') }}
        </div>
    </div>
@endforelse
