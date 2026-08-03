@php
    $exportSvg =
        '<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-table-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 21h-7.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" /><path d="M3 10h18" /><path d="M10 3v18" /><path d="M19 16v6" /><path d="M22 19l-3 3l-3 -3" /></svg></span>';
@endphp
@extends('dashboard.layouts.master')
@section('title', $linksMap['index']['title'])
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['index']['title'],
        ],
    ]" :buttons="[
        [
            'name' => $exportSvg . ' تصدير البيانات',
            'class' => 'btn-light bg-white',
            'can' => 'clients_export_data',
            'options' => [
                'id' => 'exportExcel',
            ],
        ],
        [
            'name' => '<i class=\'fa fa-plus\'></i> إضافة عميل',
            'class' => 'btn-main',
            'can' => 'clients_create',
            'options' => [
                'data-toggle' => 'modal',
                'data-target' => '#model-add-client',
            ],
        ],
    ]" /><!-- links bar -->



    <section class="mb-5">

        {{-- Search Form --}}
        @can('clients_allow_search')
            <div class="box mb-3">
                <form method="GET" action="{{ route('crm.clients.index') }}" autocomplete="off">
                    <div class="form-row mt-1">

                        <div class="col-lg-10 col-xl-11">
                            <div class="form-row">

                                <div class="col-xl-3 col-sm-6 col-6">
                                    <x-form-group class="mb-3 mb-lg-0" :properties="[
                                        'input' => [
                                            'name' => 'search',
                                            'type' => 'text',
                                            'value' => request('search'),
                                            'options' => [
                                                'class' => 'input-multi-search ltr text-right',
                                                'placeholder' => 'بالاسم أو رقم الجوال...',
                                            ],
                                        ],
                                        'label' => [
                                            'text' => 'البحث عن عميل',
                                        ],
                                    ]" />
                                </div>{{-- name or phone --}}

                                <div class="col-xl-3 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">حالة الحساب</label>
                                        <select name="has-account" class="form-control choices" data-search="false">
                                            <option value="">الكل</option>
                                            <option value="1" {{ request('has-account') == '1' ? 'selected' : '' }}>عنده
                                                حساب
                                            </option>
                                            <option value="0" {{ request('has-account') == '0' ? 'selected' : '' }}>ما عنده
                                                حساب
                                            </option>
                                        </select>
                                    </div>
                                </div> {{-- حالة الحساب --}}

                                <div class="col-xl-3 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">المكلف</label>
                                        <select name="assigned-to" class="form-control choices">
                                            <option value="">الكل</option>
                                            @foreach ($admins as $admin)
                                                <option value="{{ $admin->id }}"
                                                    {{ request('assigned-to') == $admin->id ? 'selected' : '' }}>
                                                    {{ $admin->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>{{-- المكلف --}}

                                <div class="col-xl-3 col-sm-6 col-6">
                                    <div class="form-group mb-3 mb-lg-0">
                                        <label class="form-label">الترتيب</label>
                                        <select name="sort-order" class="form-control choices" data-search="false">
                                            <option value="desc"
                                                {{ request('sort-order', 'desc') == 'desc' ? 'selected' : '' }}>
                                                الأحدث أولاً</option>
                                            <option value="asc" {{ request('sort-order') == 'asc' ? 'selected' : '' }}>الأقدم
                                                أولاً
                                            </option>
                                        </select>
                                    </div>
                                </div>{{-- الترتيب --}}

                            </div>
                        </div>

                        <div class="col-lg-2 col-xl-1 d-flex">
                            <button type="submit" class="btn btn-second btn-block align-self-lg-stretch align-self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                                <span class="d-inline-block d-lg-none">بحث</span>
                            </button>
                        </div>

                    </div>
                </form>
                @if (request()->hasAny(['search', 'has-account', 'assigned-to']) || request('sort-order') == 'asc')
                    <div class="mt-3">
                        <a href="{{ route('crm.clients.index') }}" class="btn btn-sm btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                            مسح جميع الفلاتر
                        </a>
                    </div>
                @endif
            </div><!-- end for search -->
        @endcan

        <div class="text-muted mb-3">
            إجمالي <strong class="text-dark">{{ $stats['total'] }}</strong>
            <span class="mx-1">|</span>
            المفعّلين <strong class="text-success">{{ $stats['active'] }}</strong>
            <span class="mx-1">|</span>
            المحظورين <strong class="text-danger">{{ $stats['blocked'] }}</strong>
        </div>

        <div class="box table-responsive">
            <table class="table table-modern text-center table-modern-xs table-inverse">
                <thead class="thead-inverse">
                    <tr>
                        @canany(['clients_delete', 'clients_ban_account', 'clients_edit', 'clients_view_details'])
                            <th class="noExl text-center">الإجراءات</th>
                        @endcanany

                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>رقم الجوال</th>
                        <th>البريد الإلكتروني</th>
                        <th class="noExl">حالة الحساب</th>
                        {{-- <th class="noExl">المكلف</th> --}}
                        <th class="noExl">آخر ظهور</th>
                        <th class="noExl">مصدر العميل</th>
                        <th class="noExl">اضيف بواسطة</th>
                        <th>تاريخ التسجيل</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $row)
                        <tr data-id="{{ $row->uuid }}" class="parents">

                            @canany(['clients_delete', 'clients_ban_account', 'clients_edit', 'clients_view_details'])
                                <td class="noExl text-center">

                                    @can('clients_edit')
                                        <a href="{{ route('crm.clients.edit', $row->uuid) }}" class="btn btn-xs btn-second"
                                            title="تعديل">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39" />
                                            </svg>
                                        </a>
                                    @endcan

                                    @canany(['clients_delete', 'clients_ban_account', 'clients_view_details'])
                                        <div style="width: 70px" class="dropdown d-inline-block dropdown-basic ">

                                            <button class="btn btn-sm btn-secondary btn-block dropdown-toggle" type="button"
                                                id="dropdownStatusClient" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                المزيد
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownStatusClient">

                                                @can('clients_view_details')
                                                    <a class="dropdown-item" href="{{ route('crm.clients.show', $row) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path
                                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                        </svg>
                                                        عرض التفاصيل
                                                    </a><!-- end show details -->
                                                @endcan

                                                @can('clients_ban_account')
                                                    <form class="form-status d-inline-block dropdown-item form-status ajax-post"
                                                        action="{{ route('crm.clients.change-status') }}" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="id" value="{{ $row->uuid }}">

                                                        @include(
                                                            'dashboard.crm.clients.partials.status-button',
                                                            [
                                                                'client' => $row,
                                                            ]
                                                        )
                                                    </form>
                                                @endcan

                                                @can('clients_delete')
                                                    <form class="dropdown-item ajax-delete"
                                                        action="{{ route('crm.clients.destroy', $row) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button style="color: #ff0000" type="submit"
                                                            data-delete="هل انت متأكد من حذف : {{ $row->name }}"
                                                            class="p-0 font-16 bg-transparent">
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
                                                            حذف
                                                        </button>
                                                    </form><!-- end delete client -->
                                                @endcan

                                            </div><!-- end menu -->

                                        </div>
                                    @endcanany

                                </td>
                            @endcanany

                            <td>{{ $row->id }}</td>
                            <td>{{ $row->name }}</td>

                            <td class="ltr">
                                @if ($row->phone)
                                    <a href="https://wa.me/{{ ltrim($row->country_code, '+') }}{{ $row->phone }}"
                                        target="_blank">
                                        {{ $row->country_code != null ? '(' . $row->country_code . ') ' : '' }}{{ $row->phone }}
                                    </a>
                                @else
                                    <small class="text-muted">لا يوجد جوال</small>
                                @endif
                            </td>

                            <td class="ltr">
                                <!-- ✅ لو عايز اللينك يفتح Email -->
                                @if ($row->email)
                                    {{ $row->email }}
                                @else
                                    <small class="text-muted">لا يوجد بريد</small>
                                @endif
                            </td>

                            <td class="noExl">
                                @if ($row->hasAccount())
                                    @if ($row->isEmailVerified())
                                        <span class="badge badge-soft-success badge-md">✓ موثق</span>
                                        <span class="d-none">موثق</span>
                                    @else
                                        <span class="badge badge-soft-danger badge-md">غير موثق</span>
                                        <span class="d-none">غير موثق</span>
                                    @endif
                                @else
                                    <span class="badge badge-soft-secondary badge-md">لا يوجد حساب</span>
                                    <span class="d-none">لا يوجد حساب</span>
                                @endif
                            </td>
                            <!----------------------------------------------------->

                            {{-- <td>
                                <select class="form-control form-control-sm choices-assign"
                                    data-action="{{ route('crm.clients.assign', $row->uuid) }}"
                                    data-client-id="{{ $row->id }}">


                                    @if ($row->assignedAdmin)
                                        <!-- ✅ لو فيه مكلف، حطه selected -->
                                        <option value="{{ $row->assignedAdmin->id }}" selected>
                                            {{ $row->assignedAdmin->full_name }}
                                        </option>
                                    @else
                                        <!-- ✅ لو مفيش مكلف -->
                                        <option value="">تكليف موظف...</option>
                                    @endif

                                    @foreach ($admins as $admin)
                                        <!-- ✅ استثني المكلف الحالي من الـ loop -->
                                        @if (!$row->assignedAdmin || $row->assignedAdmin->id != $admin->id)
                                            <option value="{{ $admin->id }}">{{ $admin->full_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td> --}}




                            <!----------------------------------------------------->

                            <td class="noExl ltr">
                                @if ($row->last_seen)
                                    {{ $row->last_seen->diffForHumans() }}
                                @else
                                    <span class="text-muted">لا يوجد</span>
                                @endif
                            </td>


                            <td class="ltr">{{ $row->source != null ? $row->source->name : '-' }}</td>
                            <td>{{ $row->creator?->full_name ?? '-' }}</td>
                            <td class="ltr">{{ $row->created_at->format('Y-m-d • H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center pt-4 text-muted">
                                @if (request('search'))
                                    لا توجد نتائج للبحث "{{ request('search') }}"
                                    <a href="{{ route('crm.clients.index') }}" class="text-danger">
                                        مسح جميع الفلاتر
                                    </a>
                                @else
                                    لا توجد بيانات بعد
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <x-paginate :data="$clients" />

    </section>

    <!-- Modal -->
    <div class="modal fade" id="model-add-client" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <form class="form" action="{{ route('crm.clients.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M16 19h6" />
                                <path d="M19 16v6" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                            </svg>
                            إضافة عميل
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- modal-header -->

                    <div class="modal-body">


                        <x-form-group :properties="[
                            'input' => [
                                'name' => 'name',
                                'type' => 'text',
                                'options' => ['required', 'placeholder' => 'اسم العميل'],
                            ],
                            'label' => [
                                'text' => 'اسم العميل',
                                'options' => [
                                    'class' => 'required',
                                ],
                            ],
                        ]" /><!-- name -->


                        <x-dashboard.input-phone />


                    </div><!-- end modal-body -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">رجوع</button>
                        <button type="submit" class="btn btn-main">إضافة عميل</button>
                    </div><!-- end modal-footer -->

                </form><!-- end form -->
            </div><!-- end modal-content -->
        </div>
    </div>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-table2excel@1.1.1/dist/jquery.table2excel.min.js"></script>
    <script>
        $(document).ready(function() {

            // =====================================
            // Export table data to Excel
            // =====================================
            $('#exportExcel').on('click', function() {
                $('.table').table2excel({
                    name: 'Clients Data',
                    exclude: '.noExl',
                    filename: 'clients_' + Date.now() + '.xls',
                    preserveColors: false
                });
            });


            // $("#exportExcel").click(function() {
            //     $(".table").table2excel({
            //         name: "Clients Data",
            //         exclude: ".noExl",
            //         filename: "clients_" + new Date().getTime() + ".xls",
            //         preserveColors: false
            //     });
            // });

            // document.addEventListener('DOMContentLoaded', function() {
            //     document.querySelectorAll('.choices-assign').forEach(select => {
            //         const choice = new Choices(select, {
            //             searchEnabled: true,
            //             searchPlaceholderValue: 'ابحث...',
            //             noResultsText: 'لا توجد نتائج',
            //             itemSelectText: '',
            //         });

            //         // ✅ ضيف class بعد الإنشاء
            //         select.closest('.choices').classList.add('choices-assign');
            //     });
            // });

            // function submitAssign(selectElement, adminId) {
            //     if (adminId) {
            //         const url = selectElement.dataset.action;

            //         $.ajax({
            //             url: url,
            //             method: 'POST',
            //             data: {
            //                 assigned_to: adminId
            //             },
            //             success: function(response) {
            //                 iziToast.success({
            //                     message: response.message || 'تم تكليف الموظف بنجاح'
            //                 });
            //             },
            //             error: function(xhr) {
            //                 iziToast.error({
            //                     message: xhr.responseJSON?.message || 'حدث خطأ أثناء التكليف'
            //                 });
            //                 selectElement.value = '';
            //             }
            //         });
            //     }
            // }


        });
    </script>


@endsection
