@extends('dashboard.layouts.master')
@section('title', 'إضافة عقد إيجار جديد')
@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/rental/rental.css') }}">
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'عقود الإيجار',
            'link' => route('rental.contracts.index'),
        ],
        [
            'name' => 'إضافة عقد جديد',
        ],
    ]" /><!-- links bar -->

    <main class="mb-5">
        <form class="form" action="{{ route('rental.contracts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row ">

                <div class="col-lg-8">

                    {{-- معلومات العقد الأساسية --}}
                    <div class="form-box">

                        <h5 class="mb-4 font-weight-600">معلومات العقد</h5>

                        <div class="form-row">

                            <div class="col-md-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'start_date',
                                        'type' => 'date',
                                    ],
                                    'label' => [
                                        'text' => 'تاريخ البداية',
                                    ],
                                ]" />
                            </div><!-- start_date -->

                            <div class="col-md-6">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'end_date',
                                        'type' => 'date',
                                    ],
                                    'label' => [
                                        'text' => 'تاريخ النهاية',
                                    ],
                                ]" />
                            </div><!-- end_date -->

                        </div><!-- row -->
                    </div><!-- معلومات العقد -->

                    {{-- معلومات العقار --}}
                    <div class="form-box">

                        <h5 class="mb-4 font-weight-600">معلومات العقار</h5>

                        <div class="form-row">

                            <div class="col-12">
                                <div class="input-normal-style d-flex mb-3">
                                    <label class="d-flex align-items-center px-0">
                                        <input type="radio" name="property_source" value="internal" checked
                                            class="ml-2">
                                        <span>عقار من النظام</span>
                                    </label>
                                    <label class="d-flex align-items-center mr-3">
                                        <input type="radio" name="property_source" value="external" class="ml-2">
                                        <span>عقار خارجي</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Internal Property --}}
                            <div class="col-12 property-internal">

                                <div class="form-group">
                                    <label>العقار</label>
                                    <input type="text" id="property-search" class="form-control"
                                        placeholder="ابحث برقم العقار أو العنوان..." autocomplete="off">

                                    <input type="hidden" name="property_id" id="property-id">

                                    {{-- Selected Property Display --}}
                                    <div id="selected-property" class="mt-2">
                                        <div class="alert alert-info d-flex justify-content-between align-items-center">
                                            <span id="selected-property-text"></span>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="clearPropertySelection()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Search Results Dropdown --}}
                                    <div id="property-results" class="list-group mt-1"></div>
                                </div>

                            </div><!-- property_id -->

                            {{-- External Property --}}
                            <div class="col-12 property-external" style="display:none">
                                <div class="form-row">

                                    <div class="col-md-6">
                                        <x-form-group :properties="[
                                            'select' => [
                                                'name' => 'city_id',
                                                'list' => getCities(),
                                                'options' => [
                                                    'placeholder' => 'حدد مدينة',
                                                    'class' => 'choices',
                                                    'data-url-get-neighborhoods' => route('neighborhoods.byCity'),
                                                ],
                                            ],
                                            'label' => [
                                                'text' => 'المدينة',
                                            ],
                                        ]" />
                                    </div>

                                    <div class="col-md-6">
                                        <x-form-group :properties="[
                                            'select' => [
                                                'name' => 'neighborhood_id',
                                                'options' => [
                                                    'class' => 'choices',
                                                ],
                                            ],
                                            'label' => [
                                                'text' => 'المنطقة',
                                            ],
                                        ]" />
                                    </div>

                                    <div class="col-md-6">
                                        <x-form-group :properties="[
                                            'select' => [
                                                'name' => 'property_type_id',
                                                'list' => getPropertyTypes(),
                                            ],
                                            'label' => ['text' => 'نوع العقار'],
                                        ]" />
                                    </div>

                                    <div class="col-md-6">
                                        <x-form-group :properties="[
                                            'input' => ['name' => 'address'],
                                            'label' => ['text' => 'العنوان'],
                                        ]" />
                                    </div>

                                    <div class="col-md-3">
                                        <x-form-group :properties="[
                                            'input' => ['name' => 'area', 'type' => 'number'],
                                            'label' => ['text' => 'المساحة'],
                                        ]" />
                                    </div>

                                    <div class="col-md-3">
                                        <x-form-group :properties="[
                                            'input' => ['name' => 'bedrooms', 'type' => 'number'],
                                            'label' => ['text' => 'عدد الغرف'],
                                        ]" />
                                    </div>

                                    <div class="col-md-3">
                                        <x-form-group :properties="[
                                            'input' => ['name' => 'bathrooms', 'type' => 'number'],
                                            'label' => ['text' => 'عدد الحمامات'],
                                        ]" />
                                    </div>

                                    <div class="col-md-3">
                                        <x-form-group :properties="[
                                            'input' => [
                                                'name' => 'floor',
                                                'options' => [
                                                    'class' => 'text-left ltr',
                                                ],
                                            ],
                                            'label' => ['text' => 'الدور'],
                                        ]" />
                                    </div>

                                    <div class="col-12">
                                        <x-form-group :properties="[
                                            'textarea' => ['name' => 'description'],
                                            'label' => ['text' => 'وصف العقار'],
                                        ]" />
                                    </div>

                                </div>
                            </div>



                            <div class="col-12">
                                <x-form-group :properties="[
                                    'input' => [
                                        'type' => 'text',
                                        'name' => 'deed_number',
                                        'options' => [
                                            'maxlength' => 100,
                                            'placeholder' => 'أدخل رقم صك الملكية',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'رقم الصك',
                                    ],
                                ]" />
                            </div>


                        </div><!-- row -->
                    </div><!-- معلومات العقار -->

                    {{-- معلومات الأطراف --}}
                    <div class="form-box">

                        <div class=" d-flex justify-content-between align-items-start">

                            <h5 class="mb-4 font-weight-600">معلومات الأطراف</h5>

                            <a class="btn btn-sm btn-success tip"
                                title="إذا لم يكن العميل موجودًا في النظام، قم بإضافته ثم اربطه من الحقول بالأسفل."
                                href="{{ route('crm.clients.create') }}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                عميل جديد
                            </a>

                        </div>


                        <div class="form-row">

                            <div class="col-md-6">
                                <x-dashboard.input-client-search :required="true" label='المالك (ابحث بالاسم أو الجوال)'
                                    name="owner_client_id" />
                            </div><!-- owner_client_id -->

                            <div class="col-md-6">
                                <x-dashboard.input-client-search :required="true" label='المستأجر (ابحث بالاسم أو الجوال)'
                                    name="tenant_client_id" />
                            </div><!-- tenant_client_id -->

                        </div><!-- row -->
                    </div><!-- معلومات الأطراف -->

                    {{-- المعلومات المالية --}}
                    <div class="form-box">

                        <h5 class="mb-4 font-weight-600">المعلومات المالية</h5>

                        <div class="form-row">

                            <div class="col-md-6">
                                <x-dashboard.input-price :options="[
                                    'name' => 'total_rent_amount',
                                    'label_text' => 'إجمالي الإيجار',
                                ]" />
                            </div><!-- total_rent_amount -->

                            <div class="col-md-6">
                                <x-form-group :properties="[
                                    'select' => [
                                        'name' => 'payment_frequency',
                                        'list' => $paymentFrequencyOptions,
                                        'options' => [
                                            'placeholder' => '',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'دورية الدفع',
                                    ],
                                ]" />
                            </div><!-- payment_frequency -->

                            <div class="col-md-4">
                                <x-dashboard.input-price :options="[
                                    'name' => 'expected_payment_amount',
                                    'label_text' => 'قيمة الدفعة الواحدة',
                                ]" />
                            </div><!-- expected_payment_amount -->

                            <div class="col-md-4">
                                <x-dashboard.input-price :options="[
                                    'name' => 'deposit_amount',
                                    'label_text' => 'مبلغ التأمين',
                                ]" />
                            </div><!-- deposit_amount -->

                            <div class="col-md-4">
                                <x-dashboard.input-price :options="[
                                    'name' => 'commission_amount',
                                    'label_text' => 'مبلغ العمولة',
                                ]" />
                            </div><!-- commission_amount -->

                        </div><!-- row -->
                    </div><!-- المعلومات المالية -->

                </div><!-- col-lg-8 -->

                <div class="col-lg-4">

                    {{-- الملاحظات --}}
                    <div class="box">

                        <div class="mb-4">
                            <h5 class="mb-1 font-weight-600">الملاحظات</h5>
                            <small class="text-muted font-14">ملاحظات داخلية عن العقد</small>
                        </div>

                        <x-form-group class="mb-2" :properties="[
                            'textarea' => [
                                'name' => 'notes',
                                'options' => ['rows' => 5],
                            ],
                        ]" />

                    </div><!-- box -->

                </div><!-- col-lg-4 -->

            </div><!-- row -->

            <button class="btn btn-main px-5" type="submit">حفظ العقد</button>

        </form>
    </main>
@endsection
@section('js')
    <script>
        $(function() {

            /* ====================================
               Property Search with AJAX
            ==================================== */

            let searchTimeout;

            $('#property-search').on('input', function() {

                const query = $(this).val().trim();
                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    $('#property-results').hide();
                    return;
                }

                searchTimeout = setTimeout(() => {
                    $.get("{{ route('rental.contracts.search-properties') }}", {
                            q: query
                        })
                        .done(function(data) {
                            displayResults(data);
                        });
                }, 500);
            });

            function displayResults(properties) {

                const results = $('#property-results');
                results.empty();

                if (!properties.length) {
                    results.html('<div class="list-group-item text-muted">لا توجد نتائج</div>').show();
                    return;
                }

                $.each(properties, function(_, property) {

                    const item = $('<a>', {
                        href: '#',
                        class: 'list-group-item list-group-item-action',
                        text: property.text,
                        click: function(e) {
                            e.preventDefault();
                            selectProperty(property);
                        }
                    });

                    results.append(item);
                });

                results.show();
            }

            function selectProperty(property) {

                $('#property-id').val(property.id);
                $('#selected-property-text').text(property.text);
                $('#selected-property').show();

                $('#property-search').val('');
                $('#property-results').hide();
            }

            window.clearPropertySelection = function() {
                $('#property-id').val('');
                $('#selected-property').hide();
            };

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#property-search, #property-results').length) {
                    $('#property-results').hide();
                }
            });

            /* ====================================
               Toggle property source
            ==================================== */

            $('input[name="property_source"]').on('change', function() {

                if ($(this).val() === 'internal') {
                    $('.property-internal').show();
                    $('.property-external').hide();
                } else {
                    $('.property-internal').hide();
                    $('.property-external').show();
                }
            });


        });
    </script>
@endsection
