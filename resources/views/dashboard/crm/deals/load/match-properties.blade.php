{{-- <div class="px-3">
    <div id="search-properties-result" class="display-none">
        <div class="px-4 fs-clamp-16-20">
            تم العثور على <span class="result-count font-weight-700">...</span> وحدة ذات صلة
            باهتمام العميل
        </div>
    </div>

    <div id="deal-properties-result" class="{{ count($properties) == 0 ? 'display-none' : '' }}">
        <div class="px-4 fs-clamp-16-20">
            يوجد <span class="deal-count font-weight-700">{{ $totalCount }}</span>
            وحدة مرتبطة بالصفقة
        </div>
    </div>
</div> --}}


<div class="px-4 fs-clamp-16-20">
    <div class="px-3">{{ $result_message ?? '' }}</div>
</div>


@forelse ($properties as $property)
    @php
        $isAdded = in_array($property->id, $addedPropertyIds ?? []);
    @endphp

    <div class="parents col-12 ">
        <div class="card box mb-0 p-0 ">
            <hr>
            <div class="row no-gutters px-3 px-sm-4">
                <!-- الصورة -->
                <div class="col-md-4">
                    <a href="{{ slugUrl('property', $property->title ?? 'p', $property->id, true) }}" target="_blank">
                        <div class="propertie-image">
                            <img class=" img-fluid" class="radius-br radius-tr object-cover"
                                src="{{ propertyImage($property->main_image) }}">

                            @if ($property->units_count > 0)
                                <div class="units-count-badge btn btn-main radius btn-sm">
                                    <span class="font-weight-500">
                                        ({{ $property->units_count }})
                                        عدد النماذج
                                    </span>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>

                <!-- المحتوى -->
                <div class="col-md-8">
                    <div class="card-body pb-0">
                        <!-- العنوان -->
                        <h5 class="card-title">
                            <a href="{{ slugUrl('property', $property->title ?? 'p', $property->id, true) }}"
                                class="font-weight-500" target="_blank">
                                {{ $property->title }}
                            </a>
                        </h5>

                        <!-- السعر -->
                        <h6 class="font-20 font-weight-500 icon mb-3">
                            <span class="d-inline-block">
                                @if ($property->purpose == 'sale')
                                    {{ number_format($property->sale_price) }}
                                    {!! currency_icon('sm') !!}
                                @else
                                    {{ number_format($property->rent_price_monthly) }}
                                    {!! currency_icon('sm') !!}
                                    <span class="font-15">/ للشهر</span>
                                @endif
                            </span>
                        </h6>

                        <!-- المواصفات -->
                        <div class="prop d-flex flex-wrap mt-2">
                            @if ($property->area)
                                <div class="mb-2 ml-3">
                                    <img width="16px" height="16px"
                                        src="{{ asset('dashboard/images/icons/mtr.svg') }}">
                                    <span class="font-weight-500">{{ $property->area }} <small>م</small></span>
                                </div>
                            @endif

                            @if ($property->bedrooms)
                                <div class="mb-2 ml-3">
                                    <img width="16px" height="16px"
                                        src="{{ asset('dashboard/images/icons/room.svg') }}">
                                    <span class="font-weight-500">{{ $property->bedrooms }}</span>
                                </div>
                            @endif

                            @if ($property->bathrooms)
                                <div class="mb-2 ml-3">
                                    <img width="16px" height="16px"
                                        src="{{ asset('dashboard/images/icons/bathroom.svg') }}">
                                    <span class="font-weight-500">{{ $property->bathrooms }}</span>
                                </div>
                            @endif

                            @if ($property?->neighborhood?->name)
                                <div class="mb-2">
                                    <img width="16px" height="16px"
                                        src="{{ asset('dashboard/images/icons/map-pin-simple-area.svg') }}">
                                    <span class="font-weight-500">
                                        {{ $property->city?->name . ' — ' . $property->neighborhood?->name }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- الوصف -->
                        <p class="card-text text-secondary mb-2">
                            <span class="show-full-text cursor-pointer" data-text="{{ $property->description }}">
                                {!! Str::limit($property->description, 70, ' <span class="text-primary">المزيد...</span>') !!}
                            </span>
                        </p>


                        <!-- زر الإضافة/الإلغاء للصفقة -->
                        <div class="mt-3 d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-sm add-property-to-deal"
                                style="display: {{ $isAdded ? 'none' : 'inline-block' }};"
                                data-property-id="{{ $property->id }}" data-property-title="{{ $property->title }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                إضافة للصفقة
                            </button>

                            <button type="button" class="btn btn-soft-danger btn-sm remove-property-from-deal"
                                style="display: {{ $isAdded ? 'inline-block' : 'none' }};"
                                data-property-id="{{ $property->id }}" data-property-title="{{ $property->title }}">
                                إلغاء الربط
                            </button>

                            <small style="font-style: italic; display: {{ $isAdded ? 'inline-block' : 'none' }};"
                                class="assign-badge-status text-success mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M9 12l2 2l4 -4" />
                                </svg>
                                <span class="mr-1">مرتبط بالصفقة</span>
                            </small>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>

@empty
    <div style="min-height:200px" class="col-12 h-100 d-flex align-items-center justify-content-center">
        <div class="text-center">
            <p class="mb-0">لا توجد عقارات مطابقة للمعايير المحددة</p>
        </div>
    </div>
@endforelse

<!-- Pagination -->


@if (method_exists($properties, 'links'))
    @if (count($properties) > 0)
        <div class="col-12 mt-3">
            <div class="px-4 ajax-pagination">
                <x-paginate :data="$properties" />
            </div>
        </div>
    @endif
@endif
