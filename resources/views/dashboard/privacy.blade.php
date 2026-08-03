@extends('dashboard.layouts.master')
@section('title', 'الخدمات')
@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/summernote/summernote-bs4.min.css') }}" />
    <style>
        .note-editable,
        .editor {
            min-height: 400px !important;
        }
    </style>
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'سياسة الخصوصية',
        ],
    ]" />

    <section class="mb-5">

        <form class="form validate" action="{{ route('privacy-store-update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="box">

                <x-dashboard.lang-tabs /> <!-- Languages Tabs -->

                <x-dashboard.lang-tabs-parnet-content>

                    @foreach (languages() as $key => $val)
                        <x-dashboard.lang-tabs-content active="{{ $loop->index == 0 ? true : false }}"
                            key="{{ $key }}">

                            <x-form-group class="mb-1 mt-3 ltr" :properties="[
                                'textarea' => [
                                    'name' => $key . '[desc]',
                                    'value' => $row != null ? $row->translate($key)?->desc : '',
                                    'options' => [
                                        'rows' => '3',
                                        'required',
                                        'placeholder' => 'وصف عن البرنامج باللغة ' . $val['name'],
                                        'class' => 'editor ltr',
                                    ],
                                ],
                                'label' => [
                                    'text' => 'سياسة الخصوصية ( ' . $val['name'] . ' )',
                                    'options' => [
                                        'class' => 'required',
                                    ],
                                ],
                            ]" /><!-- desc -->

                        </x-dashboard.lang-tabs-content> <!-- End Of Lang Key -->
                    @endforeach

                </x-dashboard.lang-tabs-parnet-content> <!-- End Of Parnet Div Content Header -->

            </div><!-- Articles Content -->

            <button type="submit" class="btn btn-main px-4">حفظ البيانات</button>

        </form><!-- End Form -->

    </section><!-- Section -->

@endsection
@section('js')
    <script src="{{ asset('dashboard/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection
