@extends('dashboard.layouts.master')
@section('title', $linksMap['requests']['title'] . ' - ' . $ownerAssociation->name . ' - ' .
    $linksMap['index']['title'])

    <x-dashboard.css :links="[
        [
            'link' => 'owner-associations/index.css',
        ],
    ]" />
@section('meta')
    <meta name="owner-association-uuid" content="{{ $ownerAssociation->uuid }}">
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['index']['title'],
            'link' => $linksMap['index']['url'],
        ],
        [
            'name' => Str::limit($ownerAssociation->name, 20),
            'link' => route('owner-associations.show', $ownerAssociation),
        ],
        [
            'name' => $linksMap['requests']['title'],
        ],
    ]" /><!-- links bar -->



    <main id="requests-page">

        {{-- Stats Cards --}}
        <div class="row mb-2">

            {{-- Priority Cards Loop --}}
            @foreach ($stats['priorityCards'] as $card)
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stats-card stats-card-{{ $card['color'] }}">
                        <div class="stats-card-icon">
                            {!! $card['icon'] !!}
                        </div>
                        <div class="stats-card-content">
                            <div class="stats-card-value">{{ $card['count'] }}</div>
                            <div class="stats-card-label">أهمية {{ $card['label'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="row">


            <div class="col-xl-4 col-lg-5 col-md-5">

                <form method="GET" action="{{ route('owner-associations.requests.index', $ownerAssociation->uuid) }}"
                    autocomplete="off">

                    <x-panel-with-heading title="تصفية الطلبات">
                        <div class="form-row">

                            <div class="col-xl-12">
                                <div class="form-group mb-3 ">
                                    <label class="form-label">البحث</label>
                                    <input type="text" name="search" class="form-control ltr text-right"
                                        placeholder="بحث في العنوان..." value="{{ request('search') }}">
                                </div>
                            </div>{{-- Search --}}

                            <div class="col-xl-12">
                                <div class="form-group mb-3 ">
                                    <label class="form-label">الحالة</label>
                                    <select name="status" class="form-control choices">
                                        <option value="">الكل</option>
                                        @foreach ($filterOptions['statuses'] as $status)
                                            <option value="{{ $status['value'] }}"
                                                {{ request('status') == $status['value'] ? 'selected' : '' }}>
                                                {{ $status['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> {{-- Status Filter --}}

                            <div class="col-xl-12">
                                <div class="form-group mb-3 ">
                                    <label class="form-label">النوع</label>
                                    <select name="type" class="form-control choices">
                                        <option value="">الكل</option>
                                        @foreach ($filterOptions['types'] as $type)
                                            <option value="{{ $type['value'] }}"
                                                {{ request('type') == $type['value'] ? 'selected' : '' }}>
                                                {{ $type['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>{{-- Type Filter --}}

                            {{-- Priority Filter --}}
                            <div class="col-xl-12">
                                <div class="form-group mb-3 ">
                                    <label class="form-label">الأولوية</label>
                                    <select name="priority" class="form-control choices">
                                        <option value="">الكل</option>
                                        @foreach ($filterOptions['priorities'] as $priority)
                                            <option value="{{ $priority['value'] }}"
                                                {{ request('priority') == $priority['value'] ? 'selected' : '' }}>
                                                {{ $priority['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">من تاريخ</label>
                                    <input type="date" name="date_from" class="form-control"
                                        value="{{ request('date_from') }}">
                                </div>
                            </div>{{-- Date From --}}

                            <div class="col-6">
                                <div class="form-group mb-3 mb-lg-0">
                                    <label class="form-label">إلى تاريخ</label>
                                    <input type="date" name="date_to" class="form-control"
                                        value="{{ request('date_to') }}">
                                </div>
                            </div>{{-- Date To --}}

                            <div class="col-12 mt-0 mt-lg-3">
                                <div class="form-row">

                                    <div
                                        class="{{ request()->hasAny(['search', 'status', 'type', 'priority', 'date_from', 'date_to']) ? 'col-6' : 'col-12' }}">
                                        <button type="submit" class="btn btn-second px-0 btn-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                <path d="M21 21l-6 -6" />
                                            </svg>
                                            <span class="">بحث</span>
                                        </button>
                                    </div>

                                    <div class="col-6">
                                        {{-- Clear Filters Button --}}
                                        @if (request()->hasAny(['search', 'status', 'type', 'priority', 'date_from', 'date_to']))
                                            <a href="{{ route('owner-associations.requests.index', $ownerAssociation->uuid) }}"
                                                class="btn btn-outline-danger px-0 btn-block">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                                مسح البحث
                                            </a>
                                        @endif
                                    </div>

                                </div>



                            </div>

                        </div><!-- end row -->
                    </x-panel-with-heading>
                </form>


            </div> {{-- Filters Section --}}
            <div class="col-xl-8 col-lg-7 col-md-7">

                @forelse($requests as $request)
                    <div class="parents card request-card mb-3">

                        {{-- Card Header --}}
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span class="ml-2">{!! $request->type->icon() !!}</span>
                                <span class="font-weight-600">{{ $request->type->label() }}</span>
                            </div>

                            <div class="d-flex">
                                <span title="الإجراء الحالي"
                                    class="tip badge font-11 badge-md {{ $request->status->color() }} ml-1">
                                    {{ $request->status->label() }}
                                </span>
                                <span title="الأولوية"
                                    class="tip badge font-11 badge-md {{ $request->priority->color() }}">
                                    {{ $request->priority->label() }}
                                </span>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold mb-2">{{ $request->title }}</h5>
                            <p class="card-text text-muted mb-3">{{ Str::limit($request->description, 100) }}</p>

                            {{-- Meta Info في سطر واحد --}}
                            <div class="d-flex align-items-center text-muted small flex-wrap">
                                {{-- Client --}}
                                <div class="d-flex align-items-center ml-3 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        class="ml-1">
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    </svg>
                                    <a
                                        href="{{ route('crm.clients.show', $request->client) }}">{{ $request->client->name }}</a>
                                </div>

                                {{-- Unit --}}
                                @if ($request->unit)
                                    <div class="d-flex align-items-center ml-3 mb-1">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            class="ml-1">
                                            <path d="M3 21l18 0" />
                                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" />
                                        </svg>

                                        <span>وحدة #{{ $request->unit->unit_number }}</span>
                                    </div>
                                @endif

                                {{-- Attachments --}}
                                @if ($request->attachments_count > 0)
                                    <div class="d-flex align-items-center ml-3 mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            class="ml-1">
                                            <path
                                                d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" />
                                        </svg>
                                        <span>{{ $request->attachments_count }} مرفق</span>
                                    </div>
                                @endif

                                {{-- Replies --}}
                                @if ($request->replies_count > 0)
                                    <div class="d-flex align-items-center ml-3 mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            class="ml-1">
                                            <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                                            <path d="M12 12l0 .01" />
                                            <path d="M8 12l0 .01" />
                                            <path d="M16 12l0 .01" />
                                        </svg>
                                        <span>{{ $request->replies_count }} رسالة</span>
                                    </div>
                                @endif


                                {{-- Date --}}
                                <div class="d-flex align-items-center ml-3 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        class="ml-1">
                                        <path
                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                        <path d="M16 3v4" />
                                        <path d="M8 3v4" />
                                        <path d="M4 11h16" />
                                    </svg>
                                    <span>{{ $request->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Card Footer --}}
                        <div class="card-footer bg-light d-flex justify-content-end">
                            <div class="">

                                <a href="{{ route('owner-associations.requests.show', [$ownerAssociation->uuid, $request->id]) }}"
                                    class="btn btn-outline-main btn-sm ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                    عرض
                                </a>

                                <button class="btn btn-outline-main btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    </svg>
                                </button>

                                <div class="dropdown-menu dropdown-basic dropdown-menu-left">



                                    @if ($request->isPaymentRequest())
                                        @if ($request->payment)
                                            <button class="dropdown-item btn-change-payment-status"
                                                data-request-id="{{ $request->id }}"
                                                data-request-title="{{ $request->title }}"
                                                data-current-status="{{ $request->status->value }}"
                                                data-current-status-label="{{ $request->status->label() }}"
                                                data-current-status-color="{{ $request->status->color() }}"
                                                data-payment-status="{{ $request->payment->status ?? '' }}"
                                                data-payment-amount="{{ $request->payment->paid_amount ?? '' }}"
                                                data-payment-from="{{ $request->payment->subscription_from?->format('Y-m-d') ?? '' }}"
                                                data-payment-to="{{ $request->payment->subscription_to?->format('Y-m-d') ?? '' }}"
                                                data-payment-rejection="{{ $request->payment->rejection_reason ?? '' }}"
                                                data-payment-notes="{{ $request->payment->notes ?? '' }}">
                                                تعديل بيانات السداد
                                            </button>
                                        @else
                                            <button class="dropdown-item btn-change-payment-status"
                                                data-request-id="{{ $request->id }}"
                                                data-request-title="{{ $request->title }}"
                                                data-current-status="{{ $request->status->value }}"
                                                data-current-status-label="{{ $request->status->label() }}"
                                                data-current-status-color="{{ $request->status->color() }}"
                                                data-payment-status="" data-payment-amount="" data-payment-from=""
                                                data-payment-to="" data-payment-rejection="" data-payment-notes="">
                                                تأكيد الدفع
                                            </button>
                                        @endif
                                    @else
                                        <button type="button" class="dropdown-item btn-change-status"
                                            data-request-id="{{ $request->id }}"
                                            data-request-title="{{ $request->title }}"
                                            data-current-status="{{ $request->status->value }}"
                                            data-current-status-label="{{ $request->status->label() }}"
                                            data-current-status-color="{{ $request->status->color() }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-status-change">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 18a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M16 18a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M6 12v-2a6 6 0 1 1 12 0v2" />
                                                <path d="M15 9l3 3l3 -3" />
                                            </svg>
                                            تغيير الحالة
                                        </button>
                                    @endif


                                    {{-- <form class="dropdown-item ajax-delete"
                                        action="{{ route('owner-associations.requests.destroy', [$ownerAssociation->uuid, $request->id]) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button style="color: #ff0000" type="submit"
                                            data-delete="هل انت متأكد من حذف : {{ $request->title }}"
                                            class="p-0 font-16 bg-transparent">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                            حذف
                                        </button>
                                    </form> --}}


                                    <x-dashboard.delete-form form-class="dropdown-item" :action="route('owner-associations.requests.destroy', [
                                        $ownerAssociation->uuid,
                                        $request->id,
                                    ])"
                                        confirm="عند حذف هذا الطلب سيتم حذف جميع العناصر المرتبطة به بشكل نهائي."
                                        :name="$request->title" />

                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" class="text-muted mb-3">
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <path d="M10 12l4 0" />
                            </svg>
                            <h5 class="text-muted">لا توجد طلبات</h5>
                            <p class="text-muted mb-0">جرب تغيير الفلاتر أو البحث</p>
                        </div>
                    </div>
                @endforelse

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $requests->links() }}
                </div>

            </div>



        </div>




    </main>





    {{-- View Request Modal --}}
    <div class="modal fade" id="viewRequestModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">

                {{-- Header --}}
                <div class="modal-header bg-white border-bottom">
                    <h5 class="modal-title font-weight-bold text-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" class="ml-2">
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        </svg>
                        تفاصيل الطلب
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body p-0">

                    {{-- Loading State --}}
                    <div class="request-details-loading text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">جاري التحميل...</span>
                        </div>
                        <p class="text-muted mt-3 mb-0">جاري تحميل البيانات...</p>
                    </div>

                    {{-- Content --}}
                    <div class="request-details-content" style="display: none;">

                        {{-- Top Section: Type & Badges --}}
                        <div class="px-4 py-3 bg-light border-bottom">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="d-flex align-items-center mb-2 mb-md-0">
                                    <span class="request-type-icon ml-2"></span>
                                    <span class="request-type-label font-weight-600 text-dark"></span>
                                </div>
                                <div>
                                    <span class="badge request-priority-badge ml-2"
                                        style="font-size: 0.8rem; padding: 0.4rem 0.75rem;"></span>
                                    <span class="badge request-status-badge"
                                        style="font-size: 0.8rem; padding: 0.4rem 0.75rem;"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Main Content --}}
                        <div class="px-4 py-4">

                            {{-- Title --}}
                            <div class="mb-4">
                                <h4 class="request-title font-weight-bold text-dark mb-0"></h4>
                            </div>

                            {{-- Description --}}
                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted mb-2"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px;">الوصف</h6>
                                <p class="request-description text-secondary mb-0"
                                    style="line-height: 1.8; white-space: pre-line;"></p>
                            </div>

                            <hr class="my-4">

                            {{-- Info Grid --}}
                            <div class="row">

                                {{-- Client --}}
                                <div class="col-md-6 mb-4">
                                    <h6 class="text-uppercase text-muted mb-2"
                                        style="font-size: 0.75rem; letter-spacing: 0.5px;">العميل</h6>
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            class="ml-2 text-primary">
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        </svg>
                                        <span class="request-client font-weight-600 text-dark"></span>
                                    </div>
                                </div>

                                {{-- Unit --}}
                                <div class="col-md-6 mb-4">
                                    <h6 class="text-uppercase text-muted mb-2"
                                        style="font-size: 0.75rem; letter-spacing: 0.5px;">الوحدة</h6>
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            class="ml-2 text-info">
                                            <path d="M3 21l18 0" />
                                            <path d="M9 8l1 0" />
                                            <path d="M9 12l1 0" />
                                            <path d="M9 16l1 0" />
                                            <path d="M14 8l1 0" />
                                            <path d="M14 12l1 0" />
                                            <path d="M14 16l1 0" />
                                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" />
                                        </svg>
                                        <span class="request-unit font-weight-600 text-dark"></span>
                                    </div>
                                </div>

                                {{-- Date --}}
                                <div class="col-md-6 mb-4">
                                    <h6 class="text-uppercase text-muted mb-2"
                                        style="font-size: 0.75rem; letter-spacing: 0.5px;">تاريخ الإنشاء</h6>
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            class="ml-2 text-secondary">
                                            <path
                                                d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h16" />
                                        </svg>
                                        <span class="request-created-at text-dark"></span>
                                    </div>
                                </div>

                            </div>

                            {{-- Admin Notes (Optional) --}}
                            <div class="request-admin-notes-section" style="display: none;">
                                <hr class="my-4">
                                <h6 class="text-uppercase text-muted mb-3"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px;">ملاحظات الإدارة</h6>
                                <div class="alert alert-info border-0 mb-0" style="background-color: #e7f3ff;">
                                    <p class="request-admin-notes mb-0 text-dark" style="line-height: 1.8;"></p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer bg-white border-top">
                    <button type="button" class="btn btn-outline-main px-4" data-dismiss="modal">إغلاق</button>
                </div>

            </div>
        </div>
    </div>


    @include('dashboard.owner-associations.requests.partials._payment-modal')
    @include('dashboard.owner-associations.requests.partials._change-status-modal')




@endsection
<x-dashboard.js :links="[
    [
        'link' => 'owner-associations/requests.js',
    ],
]" />
