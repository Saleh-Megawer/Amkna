@extends('dashboard.layouts.master')
@section('title', 'مركز الإشعارات | عملائي | ' . $row->name)
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'مركز الإشعارات',
            'link' => route('notifications.interests'),
        ],
        [
            'name' => 'عملائي',
            'link' => route('notifications.interests'),
        ],
        [
            'name' => $row->name,
        ],
    ]" /><!-- links bar -->

    <section id="">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <x-panel-with-heading body="px-0" title="ملف العميل">

                    <div class="px-3">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>اسم العميل</td>
                                    <td>: {{ $row->name }}</td>
                                </tr>
                                <tr>
                                    <td>رقم الهاتف</td>
                                    <td>: {{ $row->phone }}</td>
                                </tr>
                                <tr>
                                    <td>البريد الإلكتروني</td>
                                    <td>: {{ $row->email ?? 'لا يوجد' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <form class="form" action="{{ route('notifications.interests.update') }}" method="post"
                        enctype="multipart/form-data">
                        <div class="px-4">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id" value="{{ $row->id }}">

                            <x-form-group class="mb-1" :properties="[
                                'select' => [
                                    'name' => 'interest_type',
                                    'list' => $interestTypes,
                                    'selected' => $row->interest_type,
                                    'options' => ['required', 'placeholder' => 'اختر'],
                                ],
                                'label' => [
                                    'text' => 'حدد نوع الإهتمام',
                                    'options' => ['class' => 'required'],
                                ],
                            ]" /><!-- interest_type -->
                            <small>قم بتغير الحالة بعد التواصل مع العميل ومعرفة نوع اهتمامه</small>

                            <x-form-group class="mt-3" :properties="[
                                'textarea' => [
                                    'name' => 'notes',
                                    'type' => 'text',
                                    'value' => $row->notes,
                                    'options' => [
                                        'rows' => 10,
                                        'placeholder' => 'يمكنك كتابة تفاصيل وملاحظات حول العميل',
                                    ],
                                ],
                                'label' => [
                                    'text' => 'ملاحظاتك عن العميل',
                                ],
                            ]" /><!-- notes -->


                            <button type="submit" class="btn btn-main px-5">حفظ</button>
                        </div>
                    </form>
                </x-panel-with-heading>
            </div>
        </div>
    </section><!-- section -->

@endsection
@section('js')
@endsection
