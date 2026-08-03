@extends('dashboard.layouts.master')
@section('title', $linksMap['requests']['title'])

<x-dashboard.css :links="[
    [
        'link' => 'owner-associations/index.css',
    ],
]" />

@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['requests']['title'],
        ],
    ]" /><!-- links bar -->


    <main id="all-requests-page" class="mb-5 pb-5">


        <div class="box mb-3">
            <form method="GET" action="{{ route('owner-associations.requests.all-requests') }}" autocomplete="off">
                <div class="form-row mt-1">

                    <div class="col-lg-10 col-xl-11">
                        <div class="form-row">

                            {{-- Search --}}
                            <div class="col-xl-3 col-sm-6 col-6">
                                <x-form-group class="" :properties="[
                                    'input' => [
                                        'name' => 'search',
                                        'type' => 'text',
                                        'value' => request('search'),
                                        'options' => [
                                            'class' => 'input-multi-search ltr text-right',
                                            'placeholder' => 'بالاسم أو رقم الجوال أو #رقم الطلب',
                                        ],
                                    ],
                                    'label' => [
                                        'text' => 'البحث',
                                    ],
                                ]" />
                            </div>

                            {{-- Status --}}
                            <div class="col-xl-3 col-sm-6 col-6">
                                <div class="form-group">
                                    <label class="form-label">حسب الحالة</label>
                                    <select name="status" class="form-control choices">
                                        <option value="">الكل</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->value }}"
                                                {{ request('status') == $status->value ? 'selected' : '' }}>
                                                {{ $status->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Type --}}
                            <div class="col-xl-3 col-sm-6 col-6">
                                <div class="form-group">
                                    <label class="form-label">نوع الطلب</label>
                                    <select name="type" class="form-control choices">
                                        <option value="">الكل</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->value }}"
                                                {{ request('type') == $type->value ? 'selected' : '' }}>
                                                {{ $type->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Priority --}}
                            <div class="col-xl-3 col-sm-6 col-6">
                                <div class="form-group">
                                    <label class="form-label">الأولوية</label>
                                    <select name="priority" class="form-control choices" data-search="false">
                                        <option value="">الكل</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority->value }}"
                                                {{ request('priority') == $priority->value ? 'selected' : '' }}>
                                                {{ $priority->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Date From --}}
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
                            </div>

                            {{-- Date To --}}
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
                            </div>

                            {{-- Sort Order --}}
                            <div class="col-xl-3 col-sm-6 col-6">
                                <div class="form-group mb-0">
                                    <label class="form-label">الترتيب</label>
                                    <select name="sort-order" class="form-control choices" data-search="false">
                                        <option value="desc"
                                            {{ request('sort-order', 'desc') == 'desc' ? 'selected' : '' }}>الأحدث أولاً
                                        </option>
                                        <option value="asc" {{ request('sort-order') == 'asc' ? 'selected' : '' }}>
                                            الأقدم أولاً</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-lg-2 col-xl-1 mt-3 mt-lg-1 d-flex">
                        <button type="submit" class="btn btn-second btn-block align-self-stretch">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M21 21l-6 -6" />
                            </svg>
                            <span class="d-inline-block d-lg-none">بحث</span>
                        </button>
                    </div>

                </div>
            </form>

            {{-- Clear Filters --}}
            @if (request()->hasAny(['search', 'status', 'type', 'priority', 'date-from', 'date-to']) ||
                    request('sort-order') == 'asc')
                <div class="mt-3">
                    <a href="{{ route('owner-associations.requests.all-requests') }}"
                        class="btn btn-sm btn-outline-danger">
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
        </div>

        {{-- Statistics --}}
        <div class="text-muted mb-3 font-14">
            <a href="{{ route('owner-associations.requests.all-requests') }}" class="stat-link">
                <strong class="text-dark">{{ $stats['total'] }}</strong> إجمالي
            </a>

            <span class="mx-1">|</span>
            <a href="{{ route('owner-associations.requests.all-requests', ['status' => 'pending']) }}"
                class="stat-link text-danger">
                <strong class="text-danger">{{ $stats['pending'] }}</strong> قيد الإنتظار
            </a>

            <span class="mx-1">|</span>
            <a href="{{ route('owner-associations.requests.all-requests', ['status' => 'under_review']) }}"
                class="stat-link">
                <strong class="text-dark">{{ $stats['under_review'] }}</strong> قيد المراجعة
            </a>

            <span class="mx-1">|</span>
            <a href="{{ route('owner-associations.requests.all-requests', ['status' => 'in_progress']) }}"
                class="stat-link">
                <strong class="text-dark">{{ $stats['in_progress'] }}</strong> قيد التنفيذ
            </a>

            <span class="mx-1">|</span>
            <a href="{{ route('owner-associations.requests.all-requests', ['status' => 'completed']) }}" class="stat-link">
                <strong class="text-dark">{{ $stats['completed'] }}</strong> مكتمل
            </a>

            <span class="mx-1">|</span>
            <a href="{{ route('owner-associations.requests.all-requests', ['status' => 'closed']) }}" class="stat-link">
                <strong class="text-dark">{{ $stats['closed'] }}</strong> مغلق
            </a>

            <span class="mx-1">|</span>
            <a href="{{ route('owner-associations.requests.all-requests', ['status' => 'rejected']) }}" class="stat-link">
                <strong class="text-dark">{{ $stats['rejected'] }}</strong> مرفوض
            </a>

            <span class="mx-1">|</span>
            <a href="{{ route('owner-associations.requests.all-requests', ['status' => 'cancelled']) }}"
                class="stat-link">
                <strong class="text-dark">{{ $stats['cancelled'] }}</strong> ملغي
            </a>

        </div>


        <div class="form-box pb-4">
            <h5 class=" font-weight-600 fs-clamp-16-20 mb-3 ">{{ $linksMap['requests']['title'] }}</h5>
            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-modern table-modern-xs table-modern-bordered text-center table-inverse">
                    <thead class="thead-inverse">
                        <tr>
                            <th>التحكم</th>
                            <th>رقم</th>
                            <th>الإجراء الحالي</th>
                            <th>عنوان الطلب</th>
                            <th>العميل</th>
                            <th>الجوال</th>
                            @if (adminAuth('type') === 'admin')
                                <th>المكلف</th>
                            @endif
                            <th>نوع الطلب</th>
                            <th>الأولوية</th>
                            <th>الجمعية</th>
                            <th>الوحدة</th>
                            <th>تاريخ الطلب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $row)
                            <tr>

                                {{-- Actions --}}
                                <td>
                                    <a href="{{ route('owner-associations.requests.show', [$row->ownerAssociation, $row->id]) }}"
                                        class="btn btn-sm btn-soft-main" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                        التفاصيل
                                    </a>
                                </td>

                                {{-- ID --}}
                                <td>#{{ $row->id }}</td>


                                {{-- Status --}}
                                <td>
                                    <span class="badge badge-md {{ $row->status->color() }}">
                                        {{ $row->status->label() }}
                                    </span>
                                </td>


                                <td>
                                    <span class="show-full-text cursor-pointer" data-text="{{ $row->title }}">
                                        {!! Str::limit($row->title, 20, ' <span class="text-primary">المزيد...</span>') !!}
                                    </span>
                                </td>

                                {{-- Client --}}
                                <td>
                                    @if ($row->client)
                                        <a href="{{ route('crm.clients.show', $row->client->uuid) }}" target="_blank"
                                            class="text-primary">
                                            {{ $row->client->name }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Phone --}}
                                <td class="ltr ">
                                    @if ($row->client)
                                        <a href="https://wa.me/{{ ltrim($row->client->country_code, '+') }}{{ $row->client->phone }}"
                                            target="_blank" class="text-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" color="#10882c" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                                <path
                                                    d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                                            </svg>
                                            {{ $row->client->country_code }}{{ $row->client->phone }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>


                                @if (adminAuth('type') === 'admin')
                                    <td class="noExl" style="max-width: 250px;">
                                        <x-dashboard.assign-admin :row="$row" :action="route('owner-associations.requests.assign', [
                                            $row->ownerAssociation,
                                            $row,
                                        ])" />
                                    </td>
                                @endif

                                {{-- Type --}}
                                <td>
                                    <span class="d-inline-block" style="font-size: 18px;">
                                        {!! $row->type->icon() !!}
                                    </span>
                                    {{ $row->type->label() }}
                                </td>

                                {{-- Priority --}}
                                <td>
                                    <span class="badge badge-md {{ $row->priority->color() }}">
                                        {{ $row->priority->label() }}
                                    </span>
                                </td>


                                {{-- Owner Association --}}
                                <td>
                                    <a href="{{ route('owner-associations.show', $row->ownerAssociation->uuid) }}"
                                        target="_blank" title="{{ $row->ownerAssociation->name }}">
                                        {{ Str::limit($row->ownerAssociation->name, 20) }}
                                    </a>
                                </td>


                                {{-- Unit --}}
                                <td>
                                    @if ($row->unit)
                                        {{ $row->unit->unit_number }} - {{ $row->unit->propertyType?->name }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Created At --}}
                                <td class="ltr">
                                    {{ $row->created_at->format('Y-m-d • h:i a') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center pt-4 text-muted">لا توجد طلبات بعد</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>

        {{-- Pagination --}}
        <x-paginate :data="$rows" />


    </main>



@endsection
<x-dashboard.js :links="[
    [
        'link' => 'owner-associations/requests.js',
    ],
]" />
