@php
    $limitTitle = Str::limit($property->title, 60);
@endphp
<div class="property-card-basic h-100">

    <a href="{{ propertyUrl($property) }}">


        <div class="image-wrapper">
            <img src="{{ propertyImage($property->main_image, 'medium') }}" class="lozad img-fluid"
                alt="{{ $limitTitle }}">


            <div class="property-badges">
                <span class="badge {{ $property->purpose_color }} status-badge">
                    {{ __('main.property.' . $property->purpose) }}
                </span>
                
                <small class="badge archived-badge">{{ $property->availability_status->mainCardlabel() }}</small>
            </div>
        </div>

        {{-- <div class="image-wrapper">
                        <img data-src="{{ propertyImage($property->main_image, 'medium') }}"
                            class="lozad img-fluid" alt="{{ $limitTitle }}">
                        <span
                            class="badge {{ $property->purpose_color }} status-badge">{{ __('main.property.' . $property->purpose) }}</span>
                    </div> --}}

    </a><!-- link -->

    {{-- <div class="property-badges">
                    <small class="badge">Available</small>
                    @if ($i % 2)
                        <small class="badge badge-sale">Sale</small>
                    @else
                        <small class="badge badge-rent">Rent</small>
                    @endif
                </div><!-- badges --> --}}


    <div class="property-body p-3">

        <a href="{{ propertyUrl($property) }}">
            <div class="property-info">

                @if ($property->getPrice())
                    <p class="property-price mb-2 font-weight-600 text-black">

                        {{-- EN (LTR): show currency icon BEFORE the number --}}
                        @if (lang() == 'en')
                            {!! currency_icon() !!}
                        @endif

                        @if ($property->purpose == 'sale')
                            {{-- SALE price --}}
                            {{ number_format($property->sale_price) }}

                            {{-- AR (RTL): show currency icon AFTER the number --}}
                            @if (lang() == 'ar')
                                {!! currency_icon() !!}
                            @endif
                        @else
                            {{-- RENT price (monthly) --}}
                            {{ number_format($property->rent_price_monthly) }}

                            {{-- AR (RTL): show currency icon AFTER the number --}}
                            @if (lang() == 'ar')
                                {!! currency_icon() !!}
                            @endif

                            {{-- "/ per month" label (kept as-is) --}}
                            <span class="font-13 text-muted">/
                                {{ __('main.property.per_month') }}</span>
                        @endif
                    </p><!-- price -->
                @endif


                <h2 class="property-title mb-3">{{ $limitTitle }}</h2>

                @if (!empty($property->city) || empty($property->neighborhood))
                    <h3 class="property-location">

                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                viewBox="0 0 256 256">
                                <path
                                    d="M200,224H150.54A266.56,266.56,0,0,0,174,200.25c27.45-31.57,42-64.85,42-96.25a88,88,0,0,0-176,0c0,31.4,14.51,64.68,42,96.25A266.56,266.56,0,0,0,105.46,224H56a8,8,0,0,0,0,16H200a8,8,0,0,0,0-16ZM56,104a72,72,0,0,1,144,0c0,57.23-55.47,105-72,118C111.47,209,56,161.23,56,104Zm112,0a40,40,0,1,0-40,40A40,40,0,0,0,168,104Zm-64,0a24,24,0,1,1,24,24A24,24,0,0,1,104,104Z">
                                </path>
                            </svg>
                        </span><!-- icon -->

                        <span>
                            @if (!empty($property->city))
                                {{ $property->city->name }}
                            @endif
                            @if (!empty($property->neighborhood))
                                — {{ $property->neighborhood->name }}
                            @endif
                        </span>

                    </h3><!-- location -->
                @endif

                <h4 class="property-details">

                    @if ($property->bedrooms)
                        <div class="d-inline-block">
                            <span class="icon icon-area">
                                <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960"
                                    width="14px" fill="#e3e3e3">
                                    <path
                                        d="M200-120q-33 0-56.5-23.5T120-200v-120q0-17 11.5-28.5T160-360q17 0 28.5 11.5T200-320v120h120q17 0 28.5 11.5T360-160q0 17-11.5 28.5T320-120H200Zm560 0H640q-17 0-28.5-11.5T600-160q0-17 11.5-28.5T640-200h120v-120q0-17 11.5-28.5T800-360q17 0 28.5 11.5T840-320v120q0 33-23.5 56.5T760-120ZM120-640v-120q0-33 23.5-56.5T200-840h120q17 0 28.5 11.5T360-800q0 17-11.5 28.5T320-760H200v120q0 17-11.5 28.5T160-600q-17 0-28.5-11.5T120-640Zm640 0v-120H640q-17 0-28.5-11.5T600-800q0-17 11.5-28.5T640-840h120q33 0 56.5 23.5T840-760v120q0 17-11.5 28.5T800-600q-17 0-28.5-11.5T760-640Z" />
                                </svg>
                            </span><!-- icon -->
                            <span>
                                {{ $property->area }} {{ __('main.property.square_meter') }}
                            </span>
                        </div><!-- area -->
                    @endif

                    @if ($property->bedrooms)
                        <span style="margin: 0px 2px;color:#aaaaaa7d;">|</span>
                        <div class="d-inline-block">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#e3e3e3">
                                    <path
                                        d="M176-200h-30.3L126-280H80v-214q0-25.9 17-43.95Q114-556 140-556h26v-144q0-24.75 17.63-42.38Q201.25-760 226-760h507q24.75 0 42.38 17.62Q793-724.75 793-700v144h27q24.75 0 42.38 17.62Q880-520.75 880-496v216h-46l-19.78 80h-30.44L764-280H197l-21 80Zm334-356h223v-144H510v144Zm-284 0h224v-144H226v144Zm-86 216h680v-156H140v156Zm680 0H140h680Z" />
                                </svg>
                            </span><!-- icon -->
                            <span>{{ $property->bedrooms }}
                                {{ __('main.property.bedroom') }}</span>
                        </div><!-- Bedroom -->
                    @endif

                    @if ($property->bathrooms)
                        <span style="margin: 0px 2px;color:#aaaaaa7d;">|</span>
                        <div class="d-inline-block">
                            <span class="icon icon-bedroom">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M240,96H208a8,8,0,0,0-8-8H136a8,8,0,0,0-8,8H64V52A12,12,0,0,1,76,40a12.44,12.44,0,0,1,12.16,9.59,8,8,0,0,0,15.68-3.18A28.32,28.32,0,0,0,76,24,28,28,0,0,0,48,52V96H16a8,8,0,0,0-8,8v40a56.06,56.06,0,0,0,56,56v16a8,8,0,0,0,16,0V200h96v16a8,8,0,0,0,16,0V200a56.06,56.06,0,0,0,56-56V104A8,8,0,0,0,240,96Zm-48,8v32H144V104Zm40,40a40,40,0,0,1-40,40H64a40,40,0,0,1-40-40V112H128v32a8,8,0,0,0,8,8h64a8,8,0,0,0,8-8V112h24Z">
                                    </path>
                                </svg>
                            </span><!-- icon -->
                            <span>{{ $property->bathrooms }}
                                {{ __('main.property.bathroom') }}</span>
                        </div><!-- Bathroom -->
                    @endif

                </h4><!-- details -->

            </div><!-- info -->
        </a><!-- link -->

        <div class="property-contacts">
            <div class="form-row">

                <div class="col-6 property-contact property-contact-whatsapp">
                    <a href="" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                            <path
                                d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                        </svg>
                    </a><!--  -->
                </div><!-- whatsapp -->

                <div class="col-6 property-contact property-contact-call">
                    <a href="" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-phone">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                        </svg>
                        <span>{{ __('main.property.call') }}</span>
                    </a><!--  -->
                </div><!-- call -->

            </div><!-- row -->
        </div><!-- property-contacts -->

    </div><!-- property-body  -->

</div><!-- property-card-basic -->
