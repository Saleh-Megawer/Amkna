@extends('dashboard.layouts.master')
@section('title', 'تعديل سؤال')
@section('css')
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/summernote/summernote-bs4.min.css') }}" />
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'الأسئلة الشائعة',
            'link' => adminUrl('faqs'),
        ],
        [
            'name' => 'تعديل سؤال',
        ],
    ]" />

    <section class="mb-5">



        <form class="form validate" action="{{ route('faqs-update') }}" method="POST" enctype="multipart/form-data"
            autocomplete="on">
            <div class="row justify-content-center">

                @csrf
                @method('PATCH')
                <input type="hidden" value="{{ $row->id }}" name="id">


                <div class="col-md-9">
                    <div class="box">

                        <x-dashboard.lang-tabs /> <!-- Languages Tabs -->

                        <x-dashboard.lang-tabs-parnet-content>

                            @foreach (languages() as $key => $val)
                                <x-dashboard.lang-tabs-content active="{{ $loop->index == 0 ? true : false }}"
                                    key="{{ $key }}">

                                    <x-form-group :properties="[
                                        'input' => [
                                            'name' => $key . '[title]',
                                            'type' => 'text',
                                            'value' => $row->translate($key)->title,
                                            'placeholder' => 'العنوان باللغة ' . $val['name'],
                                        ],
                                        'label' => [
                                            'text' => 'عنوان السؤال',
                                            'options' => [
                                                'class' => 'required',
                                            ],
                                        ],
                                    ]" /><!-- title -->

                                    <x-form-group class="mb-1" :properties="[
                                        'textarea' => [
                                            'name' => $key . '[desc]',
                                            'value' => $row->translate($key)->desc,

                                            'options' => [
                                                'rows' => '10',
                                                'required',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'اجابة السؤال ( ' . $val['name'] . ' )',
                                            'options' => [
                                                'class' => 'required',
                                            ],
                                        ],
                                    ]" /><!-- desc -->

                                </x-dashboard.lang-tabs-content> <!-- End Of Lang Key -->
                            @endforeach

                        </x-dashboard.lang-tabs-parnet-content> <!-- End Of Parnet Div Content Header -->

                    </div><!-- end box -->

                    <button type="submit" class="btn btn-main px-4">تحديث البيانات</button>
                </div><!-- Articles Content -->



            </div><!-- Row -->


        </form><!-- End Form -->

        <div class="trans">
            <div id="There-are-no-subcategories" class="d-none">
                {{ dbTrans('articles.There are no subcategories for your choice') }}</div>
        </div><!-- trans -->



    </section><!-- Section -->

@endsection
@section('js')
    <script src="{{ asset('dashboard/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection
