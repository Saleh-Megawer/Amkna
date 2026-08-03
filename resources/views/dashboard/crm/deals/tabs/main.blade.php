<div class="row justify-content-center">
    <div class="col-xl-11 col-lg-12">

        {{-- <div class="d-flex align-items-center">

            <h4 class="my-3 font-20 font-weight-600">
                <a href="{{ route('crm.clients.index') }}">{{ $linksMap->index->page_title }}</a>
            </h4>

            <span class="mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l14 0" />
                    <path d="M5 12l6 6" />
                    <path d="M5 12l6 -6" />
                </svg>
            </span>

            <h4 class="my-3 font-20 font-weight-600">{{ $tabName }}</h4>

        </div><!-- links bar --> --}}

        <div class="d-flex flex-wrap">

            <div class="border bg-white radius font-13 px-2 text-black ml-1">

                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-hash">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 9l14 0" />
                    <path d="M5 15l14 0" />
                    <path d="M11 4l-4 16" />
                    <path d="M17 4l-4 16" />
                </svg>

                <span>رقم الصفقة : {{ $row->id }}</span>
            </div><!-- id -->

            <div class="border bg-white radius font-13 px-2 text-black">

                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                    <path d="M16 3v4" />
                    <path d="M8 3v4" />
                    <path d="M4 11h16" />
                    <path d="M7 14h.013" />
                    <path d="M10.01 14h.005" />
                    <path d="M13.01 14h.005" />
                    <path d="M16.015 14h.005" />
                    <path d="M13.015 17h.005" />
                    <path d="M7.01 17h.005" />
                    <path d="M10.01 17h.005" />
                </svg>

                <span>تاريخ الإنشاء
                    {{ \Carbon\Carbon::parse($row->created_at)->locale('ar')->translatedFormat('d F Y - h:i A') }}
                </span>
            </div><!-- created_at -->

        </div><!-- id + created_at -->


        <!-- end status buttons -->
        @if (isSalesAdmin())
            @if ($row->assigned_to === adminId())
                <div class="row no-gutters mt-3">
                    @foreach ($deal_statuses as $actionStatus)
                        @php
                            $isActive = match (true) {
                                $row->is_won == 1 && $actionStatus['id'] === 'is_win' => true,
                                $row->is_lost == 1 && $actionStatus['id'] === 'is_lost' => true,
                                $row->is_won == 0 && $row->is_lost == 0 && $actionStatus['id'] === 'is_pending' => true,
                                default => false,
                            };
                        @endphp
                        <div class="col-4">
                            <button type="button"
                                class="{{ $isActive ? 'btn-' . $actionStatus['button_class'] : 'btn-outline-' . $actionStatus['button_class'] }} btn-change-deal-status btn btn-block text-center px-0 py-3 radius-0 font-weight-600"
                                data-status="{{ $actionStatus['id'] }}" data-deal="{{ $row->uuid }}">
                                {{ $actionStatus['name'] }}
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            @can('deals_change_status')
                <div class="row no-gutters mt-3">
                    @foreach ($deal_statuses as $actionStatus)
                        @php
                            $isActive = match (true) {
                                $row->is_won == 1 && $actionStatus['id'] === 'is_win' => true,
                                $row->is_lost == 1 && $actionStatus['id'] === 'is_lost' => true,
                                $row->is_won == 0 && $row->is_lost == 0 && $actionStatus['id'] === 'is_pending' => true,
                                default => false,
                            };
                        @endphp
                        <div class="col-4">
                            <button type="button"
                                class="{{ $isActive ? 'btn-' . $actionStatus['button_class'] : 'btn-outline-' . $actionStatus['button_class'] }} btn-change-deal-status btn btn-block text-center px-0 py-3 radius-0 font-weight-600"
                                data-status="{{ $actionStatus['id'] }}" data-deal="{{ $row->uuid }}">
                                {{ $actionStatus['name'] }}
                            </button>
                        </div>
                    @endforeach
                </div><!-- end status buttons -->
            @endcan
        @endif

        <form class="form" action="{{ route('crm.deals.update', $row) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="uuid" value="{{ $row->uuid }}">
            @method('PATCH')

            <div class="row mt-3">

                <div class="col-lg-8">

                    <div class="form-box">

                        <h5 class="mb-4 font-weight-600">معلومات الصفقة</h5><!-- box-title -->

                        <div class="form-row">

                            <div class="col-md-4">
                                <x-dashboard.input-price :options="[
                                    'name' => 'amount',
                                    'value' => $row->amount,
                                    'label_text' => 'تكلفة الصفقة',
                                ]" />
                            </div><!-- amount -->

                            <div class="col-md-4">
                                <x-dashboard.input-price :options="[
                                    'name' => 'commission',
                                    'value' => $row->commission,
                                    'label_text' => 'عمولة الشركة',
                                ]" />
                            </div><!-- commission -->


                            <div class="col-md-4">
                                <x-dashboard.input-price :options="[
                                    'name' => 'marketer_commission',
                                    'value' => $row->marketer_commission,
                                    'label_text' => 'عمولة المسوق',
                                ]" />
                            </div><!-- marketer_commission -->


                        </div><!--  -->
                    </div><!-- معلومات الصفقة -->

                    <div class="form-box">

                        <h5 class="mb-4 font-weight-600">معلومات العميل</h5><!-- box-title -->

                        <div class="form-row">

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'name',
                                        'value' => $row->client->name,
                                        'type' => 'text',
                                        'options' => ['readonly'],
                                    ],
                                    'label' => [
                                        'text' => 'اسم العميل',
                                    ],
                                ]" />
                            </div><!-- name -->

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'phone',
                                        'value' => $row->client->country_code . $row->client->phone,
                                        'type' => 'text',
                                        'options' => ['readonly', 'class' => 'ltr text-right'],
                                    ],
                                    'label' => [
                                        'text' => 'رقم الجوال',
                                    ],
                                ]" />
                            </div><!-- phone -->

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'email',
                                        'value' => $row->client->email,
                                        'type' => 'email',
                                        'options' => ['readonly'],
                                    ],
                                    'label' => [
                                        'text' => 'رقم الجوال',
                                    ],
                                ]" />
                            </div><!-- email -->

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'purpose_display_text',
                                        'type' => 'text',
                                        'value' => $row->purpose == 'buy' ? 'شراء' : 'تأجير',
                                        'options' => ['readonly'],
                                    ],
                                    'label' => [
                                        'text' => 'الرغبة',
                                    ],
                                ]" />
                                <input type="hidden" id="purpose" value="purpose" value="{{ $row->purpose }}">
                            </div><!-- purpose -->

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'property_type_id',
                                        'type' => 'text',
                                        'value' => $row->propertyType?->name,
                                        'options' => ['readonly'],
                                    ],
                                    'label' => [
                                        'text' => 'النوع العقاري',
                                    ],
                                ]" />
                            </div><!-- property_type_id -->

                        </div><!-- row -->
                    </div><!-- معلومات العميل -->

                    <div class="form-box">

                        <h5 class="mb-4 font-weight-600">الخصائص المطلوبة</h5><!-- box-title -->

                        <div class="form-row align-items-center">

                            <div class="col-md-4">
                                <x-dashboard.input-price :options="[
                                    'name' => 'budget_min',
                                    'value' => $row->budget_min,
                                    'label_text' => 'الحد الأدنى للميزانية',
                                ]" />
                            </div><!-- budget_min -->

                            <div class="col-md-4">
                                <x-dashboard.input-price :options="[
                                    'name' => 'budget_max',
                                    'value' => $row->budget_max,
                                    'label_text' => 'الحد الأقصى للميزانية',
                                ]" />
                            </div><!-- budget_min -->

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'select' => [
                                        'name' => 'facade_id',
                                        'list' => getPropertyFacade(),
                                        'selected' => $row->facade_id,
                                        'options' => [
                                            'class' => 'choices',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'الواجهة',
                                    ],
                                ]" />
                            </div><!-- facade_id -->

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'area_min',
                                        'value' => $row->area_min,
                                        'type' => 'number',
                                        'options' => ['pattern' => '[0-9]*\.?[0-9]*'],
                                    ],
                                    'label' => [
                                        'text' => 'اصغر مساحة م²',
                                    ],
                                ]" />
                            </div><!-- area_min -->

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'area_max',
                                        'value' => $row->area_max,
                                        'type' => 'number',
                                        'options' => ['pattern' => '[0-9]*\.?[0-9]*'],
                                    ],
                                    'label' => [
                                        'text' => 'اكبر مساحة م²',
                                    ],
                                ]" />
                            </div><!-- area_max -->

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'bedrooms',
                                        'value' => $row->bedrooms,
                                        'type' => 'number',
                                        'options' => ['pattern' => '[0-9]*\.?[0-9]*'],
                                    ],
                                    'label' => [
                                        'text' => 'عدد الغرف',
                                    ],
                                ]" />
                            </div><!-- bedrooms -->

                            <div class="col-md-4">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'bathrooms',
                                        'value' => $row->bathrooms,
                                        'type' => 'number',
                                        'options' => ['pattern' => '[0-9]*\.?[0-9]*'],
                                    ],
                                    'label' => [
                                        'text' => 'عدد دورات المياة',
                                    ],
                                ]" />
                            </div><!-- bathrooms -->

                            <div class="col-md-8">
                                <x-form-group :properties="[
                                    'select' => [
                                        'name' => 'city_id',
                                        'list' => getCities(),
                                        'selected' => $row->city_id,
                                        'options' => [
                                            'placeholder' => 'حدد مدينة',
                                            'class' => 'choices',
                                            'data-url-get-neighborhoods' => route('neighborhoods.byCity'),
                                            'data-target' => 'choices-neighborhoods',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'المدينة',
                                    ],
                                ]" />
                            </div><!-- city_id -->

                            <div class="col-md-4"></div>

                            <div class="col-md-8">
                                <x-form-group :properties="[
                                    'select' => [
                                        'name' => 'neighborhoods[]',
                                        'list' => $cityNeighborhoods,
                                        'selected' => $selectedNeighborhoods,
                                        'options' => [
                                            'class' => 'choices-multiple choices-neighborhoods',
                                            'multiple',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'المناطق',
                                    ],
                                ]" />
                            </div><!-- neighborhoods -->








                            {{-- <div class="col-md-4"></div> --}}

                            {{-- <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="tags">الأحياء</label>
                                            <select class="choices-multiple" iname="" multiple>
                                                @foreach (getTags(['type' => 'client']) as $tag)
                                                    <option value="{{ $tag->id }}" data-color="{{ $tag->color }}">
                                                        {{ $tag->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div><!-- الأحياء --> --}}

                        </div><!-- end row -->
                    </div><!-- end box | personal data -->

                    <div class="form-box px-0">

                        <h5
                            class="mb-2 px-4 font-weight-600 d-flex justify-content-between align-items-center flex-wrap">

                            <div class=" fs-clamp-16-22">
                                الوحدات المناسبة
                                <a tabindex="0" class="text-black" role="button" data-toggle="popover"
                                    data-trigger="focus" data-placement="top"
                                    data-content="يقوم النظام بترشيح الوحدات المناسبة بناءً على البيانات المطلوبة اعلاه في معلومات الصفقة ( شراء او إيجار ) ونوع المنتج العقاري والمساحة والحي المرغوب.">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                        <path d="M12 8v4" />
                                        <path d="M12 16h.01" />
                                    </svg>
                                </a><!-- help -->
                            </div><!-- title + help -->

                            <div class="">

                                <button id="btn-match-properties"
                                    data-url="{{ route('crm.deals.match-properties') }}" type="button"
                                    class="btn btn-soft-main btn-sm">
                                    <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none" />
                                        <line x1="80" y1="112" x2="144" y2="112"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16" />
                                        <circle cx="112" cy="112" r="80" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="16" />
                                        <line x1="168.57" y1="168.57" x2="224" y2="224"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16" />
                                        <line x1="112" y1="80" x2="112" y2="144"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16" />
                                    </svg>
                                    <span class=" d-none d-sm-inline-block">
                                        بحث عن وحدات مطابقة
                                    </span>
                                    {{--  عرض المطابقات  --}}
                                </button>


                                <button id="btn-show-matched-properties-only"
                                    data-url="{{ route('crm.deals.match-properties') }}" type="button"
                                    class="btn btn-soft-main btn-sm tip" title="إظهار الوحدات المضافة للصفقة فقط">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye-check">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M11.102 17.957c-3.204 -.307 -5.904 -2.294 -8.102 -5.957c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6a19.5 19.5 0 0 1 -.663 1.032" />
                                        <path d="M15 19l2 2l4 -4" />
                                    </svg>
                                </button>

                            </div>

                        </h5><!-- box-title + help + button -->



                        <div style="min-height: 200px" id="matched-properties-container" class="row">
                            {!! $dealPropertiesHtml ?? '' !!}
                        </div>


                    </div><!-- end box | personal data -->

                </div><!-- grid 1 -->

                <div class="col-lg-4">
                    <div class="box">

                        <div class="mb-4">
                            <h5 class="mb-1 font-weight-600">الملاحظات</h5>
                            <small class=" text-muted font-14">تتم مشاركة الملاحظات داخليًّا فقط بين
                                الفريق.</small>
                        </div>
                        <!--  -->

                        <x-form-group class="mb-2" :properties="[
                            'textarea' => [
                                'name' => 'notes',
                                'value' => $row->notes,
                                'options' => ['rows' => 5],
                            ],
                        ]" /><!-- notes -->

                    </div>
                </div><!-- fast notes -->

            </div><!-- end row -->


            @if (isSalesAdmin())

                @if ($row->assigned_to === adminId())
                    <div id="publish-buttons-bar">
                        <button class="btn btn-main px-5" type="submit">حفظ</button>
                    </div>
                @endif
            @else
                @if (canPermission('deals_edit'))
                    <div id="publish-buttons-bar">
                        <button class="btn btn-main px-5" type="submit">حفظ</button>
                    </div>
                @endif

            @endif



        </form><!-- end form -->

    </div><!-- end col-lg-10 -->
</div><!-- end row -->
