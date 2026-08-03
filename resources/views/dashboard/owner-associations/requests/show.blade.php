@extends('dashboard.layouts.master')
@section('title', $linksMap['requests']['title'] . ' - ' . $ownerAssociation->name . ' - ' .
    $linksMap['index']['title'])
    <x-dashboard.css :links="[
        [
            'link' => 'owner-associations/requests/show.css',
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
            'link' => route('owner-associations.requests.index', $ownerAssociation),
        ],
        [
            'name' => '#' . $request->id,
        ],
    ]" /><!-- links bar -->


    <main id="request-show-page" class="mb-5 pb-5">


        <div class="row">

            {{-- Main Content --}}
            <div class="col-lg-8 mb-4">

                <div class="card mb-4">

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
                            <span title="الأولوية" class="tip badge font-11 badge-md {{ $request->priority->color() }}">
                                {{ $request->priority->label() }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}

                    <div class="card-body px-0">
                        <div class="px-4">
                            <h5 class="card-title font-weight-bold mb-2">{{ $request->title }}</h5>
                            <p class="card-text text-muted mb-0">{{ Str::limit($request->description, 100) }}</p>
                        </div>

                        <hr>
                        {{-- بيانات السداد لو موجودة --}}
                        @if ($request->isPaymentRequest() && $request->payment)
                            <div class="px-4">
                                <div class="row text-sm mt-2">

                                    {{-- المبلغ --}}
                                    @if ($request->payment->paid_amount)
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <small class="text-muted d-block">المبلغ المدفوع</small>
                                            <span class="font-weight-bold">{!! number_format($request->payment->paid_amount, 2) . ' ' . currency_icon('xs') !!}</span>
                                        </div>
                                    @endif

                                    {{-- فترة الاشتراك --}}
                                    @if ($request->payment->subscription_from && $request->payment->subscription_to)
                                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                                            <small class="text-muted d-block">فترة الاشتراك</small>
                                            <span class="font-weight-bold">
                                                {{ $request->payment->subscription_from->format('Y-m-d') }}

                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left-dashed">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12h6m3 0h1.5m3 0h.5" />
                                                    <path d="M5 12l6 6" />
                                                    <path d="M5 12l6 -6" />
                                                </svg>

                                                {{ $request->payment->subscription_to->format('Y-m-d') }}
                                            </span>
                                        </div>
                                    @endif

                                    {{-- حالة السداد --}}
                                    <div class="col-lg-6 col-md-12 col-12 mb-2">
                                        <small class="text-muted d-block">حالة السداد</small>
                                        <span class="badge badge-{{ $request->payment->status_color }}">
                                            {{ $request->payment->status_label }}
                                        </span>
                                    </div>

                                    {{-- حالة السداد --}}
                                    <div class="col-lg-6 col-md-12 col-12 mb-2">
                                        <small class="text-muted d-block">بواسطة</small>
                                        <span>{{ $request->payment->verifiedBy?->full_name ?? '-' }}</span>
                                    </div>


                                    {{-- سبب الرفض --}}
                                    @if ($request->payment->rejection_reason)
                                        <div class="col-12 mb-2">
                                            <small class="text-muted d-block">سبب الرفض</small>
                                            <span class="text-danger">{{ $request->payment->rejection_reason }}</span>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endif

                    </div>


                    {{-- Card Footer --}}
                    <div class="card-footer bg-light d-flex justify-content-end">
                        {{-- Actions --}}
                        <div class="buttons-action d-flex">
                            @if ($request->isPaymentRequest())
                            
                                @if ($request->payment)
                                    <button class="btn btn-sm btn-soft-main ml-1 btn-change-payment-status"
                                        data-request-id="{{ $request->id }}" data-request-title="{{ $request->title }}"
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
                                    <button class="btn btn-sm btn-success ml-1 btn-change-payment-status"
                                        data-request-id="{{ $request->id }}" data-request-title="{{ $request->title }}"
                                        data-current-status="{{ $request->status->value }}"
                                        data-current-status-label="{{ $request->status->label() }}"
                                        data-current-status-color="{{ $request->status->color() }}" data-payment-status=""
                                        data-payment-amount="" data-payment-from="" data-payment-to=""
                                        data-payment-rejection="" data-payment-notes="">
                                        تأكيد الدفع
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-sm btn-main ml-1 btn-change-status"
                                    data-request-id="{{ $request->id }}" data-request-title="{{ $request->title }}"
                                    data-current-status="{{ $request->status->value }}"
                                    data-current-status-label="{{ $request->status->label() }}"
                                    data-current-status-color="{{ $request->status->color() }}">
                                    تغيير الحالة
                                </button>
                            @endif

                            <x-dashboard.delete-form :action="route('owner-associations.requests.destroy', [
                                $ownerAssociation->uuid,
                                $request->id,
                            ])" :ajax="false"
                                confirm="عند حذف هذا الطلب سيتم حذف جميع العناصر المرتبطة به بشكل نهائي"
                                button-class="btn btn-sm btn-outline-danger" :name="$request->title" icon-only icon-size="20" />

                        </div>
                    </div>

                </div>

                {{-- Section 4: المرفقات --}}
                @if ($request->attachments->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <span class="mb-0">المرفقات ({{ $request->attachments->count() }})</span>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                @foreach ($request->attachments as $attachment)
                                    <div class="col-xl-4 col-lg-6 col-sm-6 my-1">
                                        <div class="border rounded p-3 d-flex align-items-center">
                                            <div class="ml-3 flex-shrink-0">
                                                @if ($attachment->isImage())
                                                    <a target="_blank" href="{{ $attachment->file_url }}">
                                                        <img src="{{ $attachment->thumbnail_url }}" class="rounded"
                                                            style="width: 45px; height: 45px; object-fit: cover;">
                                                    </a>
                                                @else
                                                    <img style="width: 45px; height: 45px;"
                                                        src="{{ $attachment->file_icon }}" alt="">
                                                @endif
                                            </div>
                                            <div class="flex-grow-1" style="min-width: 0; overflow: hidden;">
                                                <h6 class="mb-1 text-truncate ltr" title="{{ $attachment->file_name }}">
                                                    {{ $attachment->file_name }}
                                                </h6>
                                            </div>
                                            <a download href="{{ largeAsset($attachment->file_path) }}"
                                                class="btn btn-sm pb-2 btn-soft-main flex-shrink-0 mr-2" title="تحميل">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                    <path d="M7 11l5 5l5 -5" />
                                                    <path d="M12 4l0 12" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Section 5: الردود --}}
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <span class="mb-0">محادثة الطلب ( <span
                                id="replies-count">{{ $request->replies->count() }}</span> )
                        </span>

                    </div>
                    <div class="card-body px-0">

                        {{-- قائمة الردود --}}
                        <div id="replies-container">
                            @include('dashboard.owner-associations.requests.partials._replies-list', [
                                'replies' => $request->replies,
                                'ownerAssociation' => $ownerAssociation,
                                'request' => $request,
                            ])
                        </div>

                        <form class="px-4" id="add-reply-form"
                            data-url="{{ route('owner-associations.requests.replies.store', [$ownerAssociation->uuid, $request->id]) }}">
                            @csrf
                            <div class="form-group">
                                <textarea name="message" id="reply-message" class="form-control" rows="3" placeholder="اكتب ردك هنا..."
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-main" id="btn-add-reply">
                                <span class="btn-text">إضافة رد</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </form>

                    </div>
                </div>


            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- معلومات الطلب --}}
                <div class="card request-info">
                    <div class="card-header">
                        <span>معلومات الطلب</span>
                    </div>
                    <div class="card-body">

                        {{-- العميل --}}
                        <div class="info-item with-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                            <div class="info-content">
                                <small>العميل</small>
                                <a
                                    href="{{ route('crm.clients.show', $request->client) }}">{{ $request->client->name }}</a>
                            </div>
                        </div>

                        {{-- الوحدة --}}
                        @if ($request->unit)
                            <div class="info-item with-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-building">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 21l18 0" />
                                    <path d="M9 8l1 0" />
                                    <path d="M9 12l1 0" />
                                    <path d="M9 16l1 0" />
                                    <path d="M14 8l1 0" />
                                    <path d="M14 12l1 0" />
                                    <path d="M14 16l1 0" />
                                    <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" />
                                </svg>
                                <div class="info-content">
                                    <small>الوحدة</small>
                                    <span class=" d-flex align-content-center">
                                        #{{ $request->unit->unit_number }}
                                        @if ($request->unit->propertyType)
                                            <small
                                                class="text-muted mb-0  mt-1 mr-1">({{ $request->unit->propertyType->name }})</small>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif

                        {{-- النوع --}}
                        <div class="info-item inline">
                            <small>النوع</small>
                            <span class="value">{!! $request->type->icon() !!} {{ $request->type->label() }}</span>
                        </div>

                        {{-- الأولوية --}}
                        <div class="info-item inline">
                            <small>الأولوية</small>
                            <span
                                class="badge {{ $request->priority->color() }}">{{ $request->priority->label() }}</span>
                        </div>

                        {{-- الموظف المسؤول --}}
                        @if ($request->assignedAdmin)
                            <div class="info-item inline">
                                <small>الموظف المسؤول</small>
                                <span class="value">{{ $request->assignedAdmin->name }}</span>
                            </div>
                        @endif

                        {{-- تاريخ الإنشاء --}}
                        <div class="info-item inline">
                            <small>تاريخ الإنشاء</small>
                            <span class="value ltr">{{ $request->created_at->format('Y-m-d H:ia') }}</span>
                        </div>

                        {{-- آخر تحديث --}}
                        <div class="info-item inline">
                            <small>آخر تحديث</small>
                            <span class="value">{{ $request->updated_at->diffForHumans() }}</span>
                        </div>

                    </div>
                </div>



            </div>


        </div>



    </main>

    @if ($request->isPaymentRequest())
        @include('dashboard.owner-associations.requests.partials._payment-modal')
    @else
        @include('dashboard.owner-associations.requests.partials._change-status-modal')
    @endif



@endsection
<x-dashboard.js :links="[
    [
        'link' => 'owner-associations/requests.js',
    ],
]" />
