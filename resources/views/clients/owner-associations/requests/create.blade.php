@extends('main.layouts.master')
@section('title', __('client.owner_associations.new_request'))

@section('content')
    <main id="page-owner-associations-create-request">
        <div class="container mb-5">
            <div class="row">

                <div class="col-12">
                    <h1 class="page-title">{{ __('client.owner_associations.new_request') }}</h1>
                </div>

                @include('clients.includes.aside')


                <x-client-content>

                    <x-client-breadcrumb :items="[
                        ['title' => __('client.profile.title'), 'url' => clientUrl()],
                        [
                            'title' => __('client.owner_associations.title'),
                            'url' => route('main.clients.owner-associations.index'),
                        ],
                        ['title' => __('client.owner_associations.new_request')],
                    ]" /> <!-- end breadcrumb -->

                    <div class="box px-0">

                        <h5 class="mb-4 font-weight-500 text-dark px-4 fs-clamp-16-20">{{ $ownerAssociation->name }}</h5>

                        <hr>
                        <div class="px-4 pt-2">
                            <form class="form"
                                action="{{ route('main.clients.owner-associations.requests.store', $ownerAssociation->uuid) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row">

                                    <div class="col-md-4">
                                        <x-form-group :properties="[
                                            'select' => [
                                                'name' => 'type',
                                                'list' => $types,
                                                'options' => ['required', 'class' => ''],
                                            ],
                                            'label' => [
                                                'text' => __('client.owner_associations.field_type'),
                                                'options' => [
                                                    'class' => 'required',
                                                ],
                                            ],
                                        ]" /> <!-- type  -->
                                    </div>

                                    <div class="col-md-4">
                                        <x-form-group :properties="[
                                            'select' => [
                                                'name' => 'unit_id',
                                                'list' => $clientUnits,
                                                'text' => 'unit_number',
                                                'options' => [
                                                    'required',
                                                    'class' => '',
                                                    'placeholder' => __(
                                                        'client.owner_associations.field_unit_placeholder',
                                                    ),
                                                ],
                                            ],
                                            'label' => [
                                                'text' => __('client.owner_associations.field_unit'),
                                                'options' => [
                                                    'class' => 'required',
                                                ],
                                            ],
                                        ]" /> <!-- unit_id -->
                                    </div>

                                    <div class="col-md-4">
                                        <x-form-group :properties="[
                                            'select' => [
                                                'name' => 'priority',
                                                'list' => $priorities,
                                                'options' => [],
                                            ],
                                            'label' => [
                                                'text' => __('client.owner_associations.field_priority'),
                                            ],
                                        ]" /> <!-- Priority (optional) -->
                                    </div>

                                </div><!-- end row -->


                                <x-form-group :properties="[
                                    'input' => [
                                        'name' => 'title',
                                        'type' => 'text',
                                        'options' => ['required'],
                                    ],
                                    'label' => [
                                        'text' => __('client.owner_associations.field_title'),
                                        'options' => [
                                            'class' => 'required',
                                        ],
                                    ],
                                ]" /> <!-- Title -->


                                <x-form-group :properties="[
                                    'textarea' => [
                                        'name' => 'description',
                                        'type' => 'text',
                                        'options' => ['required', 'rows' => '4', 'placeholder' => ''],
                                    ],
                                    'label' => [
                                        'text' => __('client.owner_associations.field_description'),
                                    ],
                                ]" /> <!-- Description -->


                                <x-form-group class="mb-0 attachments-form-group" :properties="[
                                    'input' => [
                                        'name' => 'attachments[]',
                                        'type' => 'file',
                                        'options' => [
                                            'multiple',
                                            'accept' => 'image/jpeg,image/png,image/webp,.pdf,.doc,.docx',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => __('client.owner_associations.field_attachments'),
                                        'options' => [],
                                    ],
                                ]" />
                                <!-- Attachments (optional -->
                                <small class=" text-muted">jpg, jpeg, png, pdf, doc, docx</small>


                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('main.clients.owner-associations.index', $ownerAssociation->uuid) }}"
                                        class="btn btn-soft-main">
                                        {{ __('client.owner_associations.cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-second px-4">
                                        {{ __('client.owner_associations.submit_request') }}
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>

                </x-client-content>


            </div>
        </div>
    </main>
@endsection
@section('js')
    <script>
        $(function() {

            // اللغة الحالية من لارافيل
            let currentLang = "{{ app()->getLocale() }}";

            let helpText = {
                ar: " قم برفع صورة من الفاتورة أو ملف PDF",
                en: " Please upload invoice image or PDF file"
            };

            function toggleAttachmentRequired() {

                let isSubscription = $('#type').val() === 'subscription_payment';

                let $group = $('.attachments-form-group');
                let $input = $group.find('input[type="file"]');
                let $label = $group.find('label');

                // احذف أي إضافات قديمة
                $label.find('.required-star, .extra-text').remove();

                if (isSubscription) {
                    $input.prop('required', true);
                    $label.append('<span class="text-muted extra-text">' + helpText[currentLang] + '</span>');
                    $label.append('<b class="text-danger font-weight-bold required-star"> *</b>');
                } else {
                    $input.prop('required', false);
                }
            }

            $('#type').on('change', toggleAttachmentRequired);

            toggleAttachmentRequired();
        });

        $(function() {

            function handlePriority() {

                let isSubscription = $('#type').val() === 'subscription_payment';
                let $priority = $('#priority');

                if (isSubscription) {
                    $priority.val('normal'); // اختار عادي
                    $priority.prop('disabled', true); // اقفل الحقل
                } else {
                    $priority.prop('disabled', false); // افتحه تاني
                }
            }

            $('#type').on('change', handlePriority);

            handlePriority(); // تشغيل أول ما الصفحة تفتح
        });
    </script>
@endsection
