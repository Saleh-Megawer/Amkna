@extends('dashboard.layouts.master')
@section('title', 'انشاء مشرف جديد')

@section('content')


    <x-dashboard.links-bar :links="[
        [
            'name' => 'المشرفين',
            'link' => adminUrl('admins'),
        ],
        [
            'name' => 'انشاء مشرف جديد',
        ],
    ]" />

    <section>

        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="box">
                    <h5 class=" fs-clamp-20-22 font-weight-600 mb-4 pb-2">إضافة مشرف جديد</h5>
                    @include('dashboard.admin.partials.form-create-admin')
                </div>
            </div>
        </div>

    </section>


@endsection

<x-dashboard.js :links="[
    [
        'link' => 'admin/admins.js',
        'from' => 'pages',
        'type' => 'module',
    ],
    [
        'link' => 'generate-random-characters.js',
        'from' => 'components',
    ],
]" />
