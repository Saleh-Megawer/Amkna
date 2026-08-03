@php
    $exportSvg =
        '<span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-table-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 21h-7.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" /><path d="M3 10h18" /><path d="M10 3v18" /><path d="M19 16v6" /><path d="M22 19l-3 3l-3 -3" /></svg></span>';
@endphp
@extends('dashboard.layouts.master')
@section('title', $pageTitle)
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => $pageTitle,
        ],
    ]" :buttons="[
        [
            'name' => $exportSvg . ' تصدير البيانات',
            'class' => 'btn-light bg-white',
            'can' => 'interests_export_data',
            'options' => [
                'id' => 'exportExcel',
            ],
        ],
    ]" /><!-- links bar -->

    <style>
        .interest-tr .btn-sm {
            padding-top: 6px;
            padding-bottom: 6px;
        }

        .select2-container {
            max-width: 100% !important;
        }
    </style>


    @can('interests_advanced_search')

        <div class="box mb-3">
            <form method="GET" action="{{ route('crm.interests.index') }}" autocomplete="off">
                <div class="form-row mt-1">

                    <div class="col-lg-10 col-xl-11">
                        <div class="form-row">

                            <div class="col-xl-3 col-sm-6 col-6">
                                <x-form-group class="" :properties="[
                                    'input' => [
                                        'name' => 'search',
                                        'type' => 'text',
                                        'value' => request('search'),
                                        'options' => [
                                            'class' => 'input-multi-search ltr text-right',
                                            'placeholder' => 'بالاسم أو رقم الهاتف أو #رقم الاهتمام',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'البحث',
                                    ],
                                ]" />
                            </div>{{-- Search --}}

                            <div class="col-xl-3 col-sm-6 col-6">
                                <div class="form-group ">
                                    <label class="form-label">حسب الإجراء</label>
                                    <select name="status" class="form-control choices">
                                        <option value="">الكل</option>
                                        <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>بدون
                                            إجراء</option>
                                        <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>تم
                                            التواصل</option>
                                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>
                                            قيد المتابعة</option>
                                        <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>
                                            تم التحويل لصفقة
                                        </option>
                                        <option value="not_interested"
                                            {{ request('status') == 'not_interested' ? 'selected' : '' }}>غير مهتم</option>
                                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلق
                                        </option>
                                    </select>
                                </div>
                            </div>{{-- Status --}}

                            @if (adminAuth('type') !== 'sales')
                                <div class="col-xl-3 col-sm-6 col-6">
                                    <div class="form-group ">
                                        <label class="form-label">المكلف</label>
                                        <select name="assigned-to" class="form-control choices">
                                            <option value="">الكل</option>
                                            <option value="unassigned"
                                                {{ request('assigned-to') == 'unassigned' ? 'selected' : '' }}>غير مكلف</option>
                                            @foreach ($admins as $admin)
                                                <option value="{{ $admin->id }}"
                                                    {{ request('assigned-to') == $admin->id ? 'selected' : '' }}>
                                                    {{ $admin->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>{{-- Assigned To --}}
                            @endif

                            <div class="col-xl-3 col-sm-6 col-6">
                                <div class="form-group ">
                                    <label class="form-label">حالة الصفقة</label>
                                    <select name="has-deal" class="form-control choices" data-search="false">
                                        <option value="">الكل</option>
                                        <option value="1" {{ request('has-deal') == '1' ? 'selected' : '' }}>لديه صفقة
                                        </option>
                                        <option value="0" {{ request('has-deal') == '0' ? 'selected' : '' }}>بدون صفقة
                                        </option>
                                    </select>
                                </div>
                            </div>{{-- Deal Status --}}
                            {{-- 
                        <div class="col-xl-3 col-sm-6 col-6">
                            <div class="form-group mb-3 mb-xl-0">
                                <label class="form-label">حالة القراءة</label>
                                <select name="is-read" class="form-control choices" data-search="false">
                                    <option value="">الكل</option>
                                    <option value="1" {{ request('is-read') == '1' ? 'selected' : '' }}>مقروء</option>
                                    <option value="0" {{ request('is-read') == '0' ? 'selected' : '' }}>غير مقروء
                                    </option>
                                </select>
                            </div>
                        </div> --}}
                            {{-- Read Status --}}

                            <div class="col-xl-3 col-sm-6 col-6">
                                <x-form-group class="mb-3 mb-xl-0" :properties="[
                                    'input' => [
                                        'name' => 'date-from',
                                        'type' => 'date',
                                        'value' => request('date-from'),
                                        'options' => [
                                            'class' => 'ltr text-right',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'من تاريخ',
                                    ],
                                ]" />
                            </div>{{-- Date From --}}

                            <div class="col-xl-3 col-sm-6 col-6">
                                <x-form-group class="mb-0" :properties="[
                                    'input' => [
                                        'name' => 'date-to',
                                        'type' => 'date',
                                        'value' => request('date-to'),
                                        'options' => [
                                            'class' => 'ltr text-right',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'إلى تاريخ',
                                    ],
                                ]" />
                            </div>{{-- Date To --}}

                            <div class="col-xl-3 col-sm-6 col-6">
                                <div class="form-group mb-0">
                                    <label class="form-label">الترتيب</label>
                                    <select name="sort-order" class="form-control choices" data-search="false">
                                        <option value="desc" {{ request('sort-order', 'desc') == 'desc' ? 'selected' : '' }}>
                                            الأحدث أولاً</option>
                                        <option value="asc" {{ request('sort-order') == 'asc' ? 'selected' : '' }}>الأقدم
                                            أولاً</option>
                                    </select>
                                </div>
                            </div>{{-- Sort Order --}}

                        </div>
                    </div>

                    <div class="col-lg-2 col-xl-1 mt-3 mt-lg-1 d-flex">
                        <button type="submit" class="btn btn-second btn-block align-self-stretch">
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
            @if (request()->hasAny(['search', 'status', 'assigned-to', 'source', 'has-deal', 'is-read', 'date-from', 'date-to']) ||
                    request('sort-order') == 'asc')
                <div class="mt-3">
                    <a href="{{ route('crm.interests.index') }}" class="btn btn-sm btn-outline-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                        مسح جميع الفلاتر
                    </a>
                </div>
            @endif
        </div><!-- end box search -->

    @endcan

    <div class="text-muted mb-3 font-14">
        <a href="{{ route('crm.interests.index') }}" class="stat-link">
            <strong class="text-dark">{{ $stats['total'] }}</strong> إجمالي
        </a>

        @if (adminAuth('type') !== 'sales')
            <span class="mx-1">|</span>
            <a href="{{ route('crm.interests.index', ['status' => 'new']) }}" class="stat-link">
                <strong class="text-dark">{{ $stats['new'] ?? 0 }}</strong> جديد
            </a>
            <span class="mx-1">|</span>
            <a href="{{ route('crm.interests.index', ['status' => 'assigned']) }}" class="stat-link">
                <strong class="text-dark">{{ $stats['assigned'] }}</strong> مكلف
            </a>
        @else
            <span class="mx-1">|</span>
            <a href="{{ route('crm.interests.index', ['status' => 'assigned']) }}" class="stat-link">
                <strong class="text-dark">{{ $stats['assigned'] ?? 0 }}</strong> بدون إجراء
            </a>
        @endif

        <span class="mx-1">|</span>
        <a href="{{ route('crm.interests.index', ['status' => 'contacted']) }}" class="stat-link">
            <strong class="text-dark">{{ $stats['contacted'] ?? 0 }}</strong> تم التواصل
        </a>

        <span class="mx-1">|</span>
        <a href="{{ route('crm.interests.index', ['status' => 'in_progress']) }}" class="stat-link">
            <strong class="text-dark">{{ $stats['in_progress'] ?? 0 }}</strong> قيد المتابعة
        </a>

        <span class="mx-1">|</span>
        <a href="{{ route('crm.interests.index', ['status' => 'converted']) }}" class="stat-link">
            <strong class="text-dark">{{ $stats['converted'] ?? 0 }}</strong> تحويل لصفقة
        </a>

        <span class="mx-1">|</span>
        <a href="{{ route('crm.interests.index', ['status' => 'closed']) }}" class="stat-link">
            <strong class="text-dark">{{ $stats['closed'] ?? 0 }}</strong> مغلق
        </a>
    </div>

    <div class="form-box table-responsive">
        <table class="table table-modern text-center table-modern-xs table-inverse">
            <thead class="thead-inverse">
                <tr>
                    @if (isSalesAdmin() ||
                            admin()?->canAny(['interests_view_details', 'interests_add_deal', 'interests_update_deal_status']))
                        <th class="noExl">الإجراءات</th>
                    @endif
                    <th title="الرقم المرجعي / التعريفي" class="tip">رقم</th>
                    <th>العميل</th>
                    <th>الهاتف</th>
                    <th>الإجراء الحالي</th>
                    @if (adminAuth('type') === 'admin')
                        <th class="noExl">المكلّف</th>
                    @endif
                    <th>المصدر</th>
                    <th>العقار</th>
                    <th>الرسالة</th>
                    <th>تاريخ الإنشاء</th>
                    @if (adminAuth('type') === 'admin')
                        <th class="noExl">تاريخ التكليف</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $row)
                    @php
                        $client = $row->client;
                        $property = $row->property;
                    @endphp
                    <tr data-interest-uuid="{{ $row->uuid }}" class="parents interest-tr">

                        @if (isSalesAdmin() ||
                                admin()?->canAny(['interests_view_details', 'interests_add_deal', 'interests_update_deal_status']))
                            <td class="noExl" style="width: 250px;">
                                @include('dashboard.interest.partials._status-button', [
                                    'interest' => $row,
                                ])
                            </td><!-- Actions -->
                        @endif


                        <!-- Interest id -->
                        <td>
                            #{{ $row->id }}
                        </td>

                        <!-- Client Name with Links -->
                        <td class="">
                            @if ($row->client)
                                <a target="__blank" href="{{ route('crm.clients.show', $row->client->uuid) }}"
                                    class="text-primary tip" title="عرض الملف">
                                    {{ $row->client->name }}
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <!-- phone -->
                        <td class="ltr text-left">
                            @if ($client)
                                @if ($client->phone)
                                    <a href="https://wa.me/{{ ltrim($client->country_code, '+') }}{{ $client->phone }}"
                                        target="_blank" class="text-dark">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" color="#10882c" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                            <path
                                                d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                                        </svg>
                                        {{ $client->country_code != null ? '(' . $client->country_code . ') ' : '' }}{{ $client->phone }}
                                    </a>
                                @else
                                    <small class=" text-center d-block text-muted">لا يوجد جوال</small>
                                @endif
                            @else
                                <small class=" text-center d-block text-muted">لا يوجد جوال</small>
                            @endif
                        </td>

                        <!-- Status -->
                        <td id="status-{{ $row->id }}">
                            @include('dashboard.interest.partials._status-badge', ['interest' => $row])
                        </td>

                        <!-- Assigned Admin (Admin only) -->
                        @can('interests_change_assigned_user')
                            @if (adminAuth('type') === 'admin')
                                <td class="noExl" style="max-width: 250px;">
                                    <select class="form-control form-control-sm select2"
                                        data-action="{{ route('crm.interests.assign', $row->uuid) }}"
                                        data-client-id="{{ $row->id }}">
                                        @if ($row->assignedAdmin)
                                            <!-- ✅ لو ف   يه مكلف، حطه selected -->
                                            <option title="{{ $row->assignedAdmin->full_name }}"
                                                value="{{ $row->assignedAdmin->id }}" selected>
                                                {{ Str::limit($row->assignedAdmin->full_name, 20, '..') }}
                                            </option>
                                        @else
                                            <!-- ✅ لو مفيش مكلف -->
                                            <option value="">تكليف موظف...</option>
                                        @endif

                                        @foreach ($admins as $admin)
                                            <!-- ✅ استثني المكلف الحالي من الـ loop -->
                                            @if (!$row->assignedAdmin || $row->assignedAdmin->id != $admin->id)
                                                <option title="{{ $admin->full_name }}" value="{{ $admin->id }}">
                                                    {{ Str::limit($admin->full_name, 20, '..') }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                            @endif
                        @endcan

                        <!-- Interest Type using Enum -->
                        <td>
                            {{ $row->type?->label() }}
                        </td>

                        <!-- Property -->
                        <td>
                            @if ($property)
                                <a href="{{ propertyUrl($property) }}" target="__blank">
                                    #{{ $property->id }}
                                    –
                                    {{ Str::limit($property->title, 15) }}
                                </a>
                            @else
                                -
                            @endif
                        </td>


                        <!-- Message -->
                        <td>
                            <x-dashboard.text-preview :text="$row->message" />
                        </td>

                        <!-- Created At -->
                        <td class="ltr">
                            {{ $row->created_at->format('Y-m-d • h:i a') }}
                        </td>

                        <!-- Assigned At (Admin only) -->
                        @if (adminAuth('type') === 'admin')
                            <td class="ltr noExl">
                                {{ $row->assigned_at ? \Carbon\Carbon::parse($row->assigned_at)->format('Y-m-d • h:i a') : '-' }}
                            </td>
                        @endif

                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center pt-4 text-muted">لا توجد بيانات بعد</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}


    <div class="mb-5">
        {{-- Pagination --}}
        <x-paginate :data="$rows" />
    </div>


    {{-- Modal for Creating Deal - Outside the loop --}}
    <div class="modal fade" id="modal-create-deal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <form class="form" action="{{ route('crm.interests.store-deal') }}" method="post"
                    autocomplete="off">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M7.263 3.26A2.25 2.25 0 0 1 9.5 1.25h5a2.25 2.25 0 0 1 2.237 2.01c.764.016 1.423.055 1.987.159c.758.14 1.403.404 1.928.93c.602.601.86 1.36.982 2.26c.116.866.116 1.969.116 3.336v6.11c0 1.367 0 2.47-.116 3.337c-.122.9-.38 1.658-.982 2.26s-1.36.86-2.26.982c-.867.116-1.97.116-3.337.116h-6.11c-1.367 0-2.47 0-3.337-.116c-.9-.122-1.658-.38-2.26-.982s-.86-1.36-.981-2.26c-.117-.867-.117-1.97-.117-3.337v-6.11c0-1.367 0-2.47.117-3.337c.12-.9.38-1.658.981-2.26c.525-.525 1.17-.79 1.928-.929c.564-.104 1.224-.143 1.987-.159m1.487.741V4.5c0 .414.336.75.75.75h5a.75.75 0 0 0 .75-.75v-1a.75.75 0 0 0-.75-.75h-5a.75.75 0 0 0-.75.75zm7.985.76A2.25 2.25 0 0 1 14.5 6.75h-5a2.25 2.25 0 0 1-2.235-1.99c-.718.016-1.272.052-1.718.134c-.566.104-.895.272-1.138.515c-.277.277-.457.665-.556 1.4c-.101.754-.103 1.756-.103 3.191v6c0 1.435.002 2.436.103 3.192c.099.734.28 1.122.556 1.399c.277.277.665.457 1.4.556c.754.101 1.756.103 3.191.103h6c1.435 0 2.436-.002 3.192-.103c.734-.099 1.122-.28 1.399-.556c.277-.277.457-.665.556-1.4c.101-.755.103-1.756.103-3.191v-6c0-1.435-.002-2.437-.103-3.192c-.099-.734-.28-1.122-.556-1.399c-.244-.243-.572-.41-1.138-.515c-.446-.082-1-.118-1.718-.133M6.25 14.5a.75.75 0 0 1 .75-.75h8a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m0 3.5a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75"
                                    clip-rule="evenodd" />
                            </svg>
                            <span id="modal-deal-title">إنشاء صفقة</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- modal-header -->

                    <div class="modal-body">

                        {{-- Hidden Fields --}}
                        <input type="hidden" name="client_uuid" id="modal-client-uuid" value="">
                        <input type="hidden" name="interest_uuid" id="modal-interest-uuid" value="">

                        {{-- Purpose --}}
                        <div class="purpose-wrapper mb-3">
                            <label class="label required mb-2">الرغبة</label>
                            <div class="purpose-options">

                                <label for="purpose-rent" class="label-content btn-label-purpose is-active-purpose">
                                    <input type="radio" name="purpose" id="purpose-rent" value="rent"
                                        checked="checked">
                                    <span class="purpose-option-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#e3e3e3">
                                            <path
                                                d="M475-160q4 0 8-2t6-4l328-328q12-12 17.5-27t5.5-30q0-16-5.5-30.5T817-607L647-777q-11-12-25.5-17.5T591-800q-15 0-30 5.5T534-777l-11 11 74 75q15 14 22 32t7 38q0 42-28.5 70.5T527-522q-20 0-38.5-7T456-550l-75-74-175 175q-3 3-4.5 6.5T200-435q0 8 6 14.5t14 6.5q4 0 8-2t6-4l136-136 56 56-135 136q-3 3-4.5 6.5T285-350q0 8 6 14t14 6q4 0 8-2t6-4l136-135 56 56-135 136q-3 2-4.5 6t-1.5 8q0 8 6 14t14 6q4 0 7.5-1.5t6.5-4.5l136-135 56 56-136 136q-3 3-4.5 6.5T454-180q0 8 6.5 14t14.5 6Zm-1 80q-37 0-65.5-24.5T375-166q-34-5-57-28t-28-57q-34-5-56.5-28.5T206-336q-38-5-62-33t-24-66q0-20 7.5-38.5T149-506l232-231 131 131q2 3 6 4.5t8 1.5q9 0 15-5.5t6-14.5q0-4-1.5-8t-4.5-6L398-777q-11-12-25.5-17.5T342-800q-15 0-30 5.5T285-777L144-635q-9 9-15 21t-8 24q-2 12 0 24.5t8 23.5l-58 58q-17-23-25-50.5T40-590q2-28 14-54.5T87-692l141-141q24-23 53.5-35t60.5-12q31 0 60.5 12t52.5 35l11 11 11-11q24-23 53.5-35t60.5-12q31 0 60.5 12t52.5 35l169 169q23 23 35 53t12 61q0 31-12 60.5T873-437L545-110q-14 14-32.5 22T474-80Zm-99-560Z" />
                                        </svg>
                                    </span>
                                    <span class="purpose-option-name">تأجير</span>
                                </label>

                                <label for="purpose-buy" class="label-content btn-label-purpose">
                                    <input type="radio" name="purpose" id="purpose-buy" value="buy">
                                    <span class="purpose-option-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#e3e3e3">
                                            <path
                                                d="m558-144 238-74q-5-9-14.5-15.5T760-240H558q-27 0-43-2t-33-8l-57-19q-16-5-23-20t-2-31q5-16 19.5-23.5T450-346l42 14q17 5 38.5 8t58.5 4h11q0-11-6.5-21T578-354l-234-86h-64v220l278 76Zm-21 78-257-72q-8 26-31.5 42T200-80h-80q-33 0-56.5-23.5T40-160v-280q0-33 23.5-56.5T120-520h224q7 0 14 1.5t13 3.5l235 87q33 12 53.5 42t20.5 66h80q50 0 85 33t35 87q0 22-11.5 34.5T833-145L583-67q-11 4-23 4t-23-3Zm-417-94h80v-280h-80v280Zm440-722q12 0 23.5 3.5T606-867l200 143q16 11 25 28t9 37v219q0 17-11.5 28.5T800-400q-17 0-28.5-11.5T760-440v-220L560-800 360-660v20q0 17-11.5 28.5T320-600q-17 0-28.5-11.5T280-640v-19q0-20 9-37t25-28l200-143q11-8 22.5-11.5T560-882Zm0 102Zm-40 140q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6Zm80 0q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6Zm-80 80q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6Zm80 0q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6Z" />
                                        </svg>
                                    </span>
                                    <span class="purpose-option-name">شراء</span>
                                </label>

                            </div>
                        </div><!-- purpose-wrapper -->

                        {{-- Property Type --}}
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
                        ]" />

                    </div><!-- modal-body -->

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">إنشاء الصفقة</button>
                        <button type="button" class="btn btn-outline-main" data-dismiss="modal">رجوع</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-table2excel@1.1.1/dist/jquery.table2excel.min.js"></script>
    <script>
        // =====================================
        // Export table data to Excel
        // =====================================
        $('#exportExcel').on('click', function() {
            $('.table').table2excel({
                name: 'Interests Data',
                exclude: '.noExl',
                filename: 'interests_' + Date.now() + '.xls',
                preserveColors: false
            });
        });


        $(document).ready(function() {
            initSelect2();
        });


        $(document).on('click', '.btn-show-interest-details', function() {
            let interestUuid = $(this).closest('tr.interest-tr').data('interest-uuid');
            $.ajax({
                url: "{{ route('crm.interests.details', ':uuid') }}".replace(':uuid', interestUuid),
                type: 'GET',
                beforeSend: function() {
                    // عرض loading (اختياري)
                    // toastr.info('جاري التحميل...');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // ⭐ حط الـ HTML في container وافتح المودال
                        $('body').append(response.html);
                        $('#interestDetailsModal').modal('show');

                        // ⭐ إزالة المودال بعد الإغلاق (عشان ميتكررش)
                        $('#interestDetailsModal').on('hidden.bs.modal', function() {
                            $(this).remove();
                        });
                    }
                },
                error: function(xhr) {
                    let message = xhr.responseJSON?.message || 'حدث خطأ أثناء تحميل التفاصيل';
                    toastr.error(message);
                }
            });
        });


        // =====================================
        // Submit admin assignment (Laravel AJAX)
        // =====================================
        $(document).on('change', '.select2', function() {
            const adminId = $(this).val();
            if (!adminId) return;

            $.ajax({
                url: $(this).data('action'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    assigned_to: adminId
                },
                success: function(response) {
                    iziToast.success({
                        message: response.message || 'تم تكليف الموظف بنجاح'
                    });
                },
                error: function(xhr) {
                    iziToast.error({
                        message: xhr.responseJSON?.message ||
                            'حدث خطأ أثناء التكليف'
                    });
                }
            });
        });

        // Handle Create Deal Modal
        $(document).on('click', '.btn-open-deal-modal', function() {
            let clientUuid = $(this).data('client-uuid');
            let clientName = $(this).data('client-name');
            let interestUuid = $(this).data('interest-uuid');

            // Reset form
            $('#modal-create-deal form')[0].reset();
            $('#purpose-rent').prop('checked', true);
            $('.btn-label-purpose').removeClass('is-active-purpose');
            $('label[for="purpose-rent"]').addClass('is-active-purpose');

            let propertyTypeSelect = document.querySelector('#modal-create-deal select[name="property_type_id"]');
            if (propertyTypeSelect && propertyTypeSelect.choices) {
                propertyTypeSelect.choices.setChoiceByValue('');
            }

            // Update modal title
            $('#modal-deal-title').text(`صفقة جديدة - ${clientName}`);

            // Set values
            $('#modal-client-uuid').val(clientUuid);
            $('#modal-interest-uuid').val(interestUuid);

            // Open modal
            $('#modal-create-deal').modal('show');
        });
    </script>
@endsection
