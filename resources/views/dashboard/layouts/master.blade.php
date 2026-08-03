<!DOCTYPE html>
<html lang="ar">

<head>
    <title>@yield('title') - لوحة التحكم</title>

    <script>
        window.Dropzone = {
            autoDiscover: false
        };
    </script>

    @include('dashboard.layouts.meta.meta')
    @include('dashboard.layouts.styles.styles')

</head>

<body>



    <!-- Start Get Styles -->
    @include('dashboard.layouts.menus.aside')
    @include('dashboard.layouts.menus.navbar')
    <!-- End Get Styles -->

    @stack('after-navbar')


    <div class="container-fluid">


        <!-- Start Page Result Box Components -->
        @include('dashboard.layouts.components.results')
        <!-- End Page Result Box Components -->



        <!-- Start Contact Yield In Container -->
        @yield('content')
        <!-- End Contact Yield In Container -->


    </div><!-- End Container -->




    <!-- Start Body Contact Yield In Container -->
    @yield('body')
    <!-- End Body Contact Yield In Container -->




    <!-- Modal Add New Property -->
    <div class="modal fade" id="model-add-property" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form class="form" action="{{ route('properties.store') }}" method="post">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 12h3v4h-3z" />
                                <path
                                    d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" />
                                <path
                                    d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                <path d="M14 16h2" />
                                <path d="M14 12h4" />
                            </svg>
                            إضافة وحدة عقارية
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- modal-header -->

                    <div class="modal-body">


                        <div class="form-row">

                            @foreach (languages() as $key => $val)
                                <div class="col-6">
                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => $key . '[title]',
                                            'type' => 'text',
                                            'options' => ['required'],
                                        ],
                                        'label' => [
                                            'text' => 'عنوان الوحدة ( ' . $val['name'] . ' )',
                                            'options' => [
                                                'class' => 'required',
                                            ],
                                        ],
                                    ]" />
                                </div>
                            @endforeach

                            <div class="col-12">
                                <x-form-group :properties="[
                                    'select' => [
                                        'name' => 'property_type_id',
                                        'list' => getPropertyTypes(),
                                        'options' => [
                                            'placeholder' => 'اختر نوع من القائمة',
                                            'class' => 'choices',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'النوع العقاري',
                                        'options' => [
                                            'class' => 'required',
                                        ],
                                    ],
                                ]" /><!-- property_type_id -->
                            </div><!-- property_type_id -->

                        </div>

                        <x-dashboard.purpose-options :only="['rent', 'sale']" selected="sale" />


                    </div><!-- end modal-body -->

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">إضافة الوحدة</button>
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">رجوع</button>
                    </div><!-- end modal-footer -->

                </form><!-- end form -->
            </div><!-- end modal-content -->
        </div>
    </div>


    <!-- Modal Add Owner Association -->
    <div class="modal fade" id="model-add-owner-association" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <form class="form" action="{{ route('owner-associations.store') }}" method="post" autocomplete="off">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px">
                                <path
                                    d="M240-320q-33 0-56.5-23.5T160-400q0-33 23.5-56.5T240-480q33 0 56.5 23.5T320-400q0 33-23.5 56.5T240-320Zm480 0q-33 0-56.5-23.5T640-400q0-33 23.5-56.5T720-480q33 0 56.5 23.5T800-400q0 33-23.5 56.5T720-320Zm-240-40q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM284-120q7-35 25-63.5t44-50.5q26-22 58.5-34t68.5-12q36 0 68.5 12t58.5 34q26 22 44 50.5t25 63.5H284Zm-153 0q-21 0-36-14t-15-32q0-39 47.5-76.5T237-280q17 0 33 3t31 9q-30 29-50 66.5T224-120h-93Zm605 0q-7-44-27-81.5T659-268q15-6 30.5-9t32.5-3q62 0 110 37.5t48 76.5q0 19-15 32.5T828-120h-92ZM64-512q-10-14-8-30t16-26l359-275q22-17 49-17t49 17l111 85v-22q0-25 17.5-42.5T700-840q25 0 42.5 17.5T760-780v114l128 98q13 10 15.5 26t-7.5 30q-10 14-26 16t-30-8L480-779 120-504q-14 10-30 8t-26-16Z" />
                            </svg>
                            إنشاء ملف اتحاد ملاك
                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- modal-header -->

                    <div class="modal-body">

                        <div class="form-row">

                            {{-- Association Name --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'name',
                                        'type' => 'text',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => 'اسم ملف اتحاد الملاك',
                                        'options' => ['class' => 'required'],
                                    ],
                                ]" />
                            </div>

                            {{-- Manager Client --}}
                            <div class="col-12 ">
                                <x-dashboard.input-client-search :required="false" label='المسؤول عن الاتحاد'
                                    name="manager_client_id" />
                            </div>

                            {{-- Notes --}}
                            <div class="col-12">
                                <x-form-group :properties="[
                                    'textarea' => [
                                        'name' => 'notes',
                                        'options' => ['rows' => 3],
                                    ],
                                    'label' => [
                                        'text' => 'ملاحظات',
                                    ],
                                ]" />
                            </div>

                        </div><!-- form-row -->

                    </div><!-- modal-body -->

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">
                            إنشاء الملف
                        </button>
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">
                            رجوع
                        </button>
                    </div><!-- modal-footer -->

                </form>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade " id="model-add-deal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <form class="form" action="{{ route('crm.deals.store') }}" method="post" autocomplete="off">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M7.263 3.26A2.25 2.25 0 0 1 9.5 1.25h5a2.25 2.25 0 0 1 2.237 2.01c.764.016 1.423.055 1.987.159c.758.14 1.403.404 1.928.93c.602.601.86 1.36.982 2.26c.116.866.116 1.969.116 3.336v6.11c0 1.367 0 2.47-.116 3.337c-.122.9-.38 1.658-.982 2.26s-1.36.86-2.26.982c-.867.116-1.97.116-3.337.116h-6.11c-1.367 0-2.47 0-3.337-.116c-.9-.122-1.658-.38-2.26-.982s-.86-1.36-.981-2.26c-.117-.867-.117-1.97-.117-3.337v-6.11c0-1.367 0-2.47.117-3.337c.12-.9.38-1.658.981-2.26c.525-.525 1.17-.79 1.928-.929c.564-.104 1.224-.143 1.987-.159m1.487.741V4.5c0 .414.336.75.75.75h5a.75.75 0 0 0 .75-.75v-1a.75.75 0 0 0-.75-.75h-5a.75.75 0 0 0-.75.75zm7.985.76A2.25 2.25 0 0 1 14.5 6.75h-5a2.25 2.25 0 0 1-2.235-1.99c-.718.016-1.272.052-1.718.134c-.566.104-.895.272-1.138.515c-.277.277-.457.665-.556 1.4c-.101.754-.103 1.756-.103 3.191v6c0 1.435.002 2.436.103 3.192c.099.734.28 1.122.556 1.399c.277.277.665.457 1.4.556c.754.101 1.756.103 3.191.103h6c1.435 0 2.436-.002 3.192-.103c.734-.099 1.122-.28 1.399-.556c.277-.277.457-.665.556-1.4c.101-.755.103-1.756.103-3.191v-6c0-1.435-.002-2.437-.103-3.192c-.099-.734-.28-1.122-.556-1.399c-.244-.243-.572-.41-1.138-.515c-.446-.082-1-.118-1.718-.133M6.25 14.5a.75.75 0 0 1 .75-.75h8a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m0 3.5a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75"
                                    clip-rule="evenodd" />
                            </svg>
                            معلومات الصفقة
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- modal-header -->

                    <div class="modal-body">

                        {{-- <div class="client-search-box">
                            <x-form-group :properties="[
                                'input' => [
                                    'name' => 'q_name_or_phone',
                                    'type' => 'text',
                                    'options' => [
                                        'class' => 'client-search-input',
                                        'required',
                                        'placeholder' => 'ابحث بواسطة ( الاسم او رقم الجوال )',
                                    ],
                                ],
                                'label' => [
                                    'text' => 'العميل',
                                    'options' => [
                                        'class' => 'required',
                                    ],
                                ],
                            ]" /><!-- name_or_phone -->
                            <div class="client-results"></div>
                        </div> --}}

                        {{-- <input type="hidden" id="hidden-client-id-input" name="client_id" value=""> --}}


                        <x-dashboard.input-client-search :required="true" label='ابحث بواسطة ( الاسم او رقم الجوال )'
                            name="client_id" />


                        <div class="purpose-wrapper mb-3">

                            <label class="label required">الرغبة</label>
                            <div class="purpose-options">

                                <label for="purpose-rent" class="label-content btn-label-purpose is-active-purpose">
                                    <input type="radio" name="purpose" id="purpose-rent" value="rent"
                                        checked="checked">

                                    <span class="purpose-option-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                            <path
                                                d="M475-160q4 0 8-2t6-4l328-328q12-12 17.5-27t5.5-30q0-16-5.5-30.5T817-607L647-777q-11-12-25.5-17.5T591-800q-15 0-30 5.5T534-777l-11 11 74 75q15 14 22 32t7 38q0 42-28.5 70.5T527-522q-20 0-38.5-7T456-550l-75-74-175 175q-3 3-4.5 6.5T200-435q0 8 6 14.5t14 6.5q4 0 8-2t6-4l136-136 56 56-135 136q-3 3-4.5 6.5T285-350q0 8 6 14t14 6q4 0 8-2t6-4l136-135 56 56-135 136q-3 2-4.5 6t-1.5 8q0 8 6 14t14 6q4 0 7.5-1.5t6.5-4.5l136-135 56 56-136 136q-3 3-4.5 6.5T454-180q0 8 6.5 14t14.5 6Zm-1 80q-37 0-65.5-24.5T375-166q-34-5-57-28t-28-57q-34-5-56.5-28.5T206-336q-38-5-62-33t-24-66q0-20 7.5-38.5T149-506l232-231 131 131q2 3 6 4.5t8 1.5q9 0 15-5.5t6-14.5q0-4-1.5-8t-4.5-6L398-777q-11-12-25.5-17.5T342-800q-15 0-30 5.5T285-777L144-635q-9 9-15 21t-8 24q-2 12 0 24.5t8 23.5l-58 58q-17-23-25-50.5T40-590q2-28 14-54.5T87-692l141-141q24-23 53.5-35t60.5-12q31 0 60.5 12t52.5 35l11 11 11-11q24-23 53.5-35t60.5-12q31 0 60.5 12t52.5 35l169 169q23 23 35 53t12 61q0 31-12 60.5T873-437L545-110q-14 14-32.5 22T474-80Zm-99-560Z" />
                                        </svg>
                                    </span><!-- purpose-option-icon -->

                                    <span class="purpose-option-name">تأجير</span>
                                </label>

                                <label for="purpose-buy" class="label-content btn-label-purpose">
                                    <input type="radio" name="purpose" id="purpose-buy" value="buy">

                                    <span class="purpose-option-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                                            <path
                                                d="m558-144 238-74q-5-9-14.5-15.5T760-240H558q-27 0-43-2t-33-8l-57-19q-16-5-23-20t-2-31q5-16 19.5-23.5T450-346l42 14q17 5 38.5 8t58.5 4h11q0-11-6.5-21T578-354l-234-86h-64v220l278 76Zm-21 78-257-72q-8 26-31.5 42T200-80h-80q-33 0-56.5-23.5T40-160v-280q0-33 23.5-56.5T120-520h224q7 0 14 1.5t13 3.5l235 87q33 12 53.5 42t20.5 66h80q50 0 85 33t35 87q0 22-11.5 34.5T833-145L583-67q-11 4-23 4t-23-3Zm-417-94h80v-280h-80v280Zm440-722q12 0 23.5 3.5T606-867l200 143q16 11 25 28t9 37v219q0 17-11.5 28.5T800-400q-17 0-28.5-11.5T760-440v-220L560-800 360-660v20q0 17-11.5 28.5T320-600q-17 0-28.5-11.5T280-640v-19q0-20 9-37t25-28l200-143q11-8 22.5-11.5T560-882Zm0 102Zm-40 140q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6Zm80 0q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6Zm-80 80q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6Zm80 0q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6Z" />
                                        </svg>
                                    </span><!-- purpose-option-icon -->

                                    <span class="purpose-option-name">شراء</span>

                                </label>

                            </div>
                        </div><!-- purpose-wrapper -->

                        <x-form-group :properties="[
                            'select' => [
                                'name' => 'property_type_id',
                                'list' => getPropertyTypes(),
                                'options' => [
                                    'placeholder' => 'اختر نوع من القائمة',
                                    'class' => 'choices',
                                ],
                            ],
                            'label' => [
                                'text' => 'النوع العقاري',
                                'options' => [
                                    'class' => 'required',
                                ],
                            ],
                        ]" /><!-- property_type_id -->

                    </div><!-- end modal-body -->

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">اضافة الصفقة</button>
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">رجوع</button>
                    </div><!-- end modal-footer -->

                </form><!-- end form -->
            </div><!-- end modal-content -->
        </div>
    </div>



    <!-- Start Get Scripts -->
    @include('dashboard.layouts.scripts.scripts')
    <!-- End Get Scripts -->


</body>

</html>
