@php
    $client = $interest->client;
    $status = $interest->status->value;

    $icons = [
        'in_progress' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-progress">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                        <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                        <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                        <path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                        <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                    </svg>',
        //
        'not_interested' =>
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><line x1="160" y1="96" x2="96" y2="160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="96" y1="96" x2="160" y2="160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><circle cx="128" cy="128" r="96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>',
        //
        'closed' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M5.7 5.7l12.6 12.6" />
                    </svg>',
        //
        '' => '',
    ];
@endphp

<div style="gap: 5px" class="d-flex justify-content-between align-items-center text-right">


    @if (isSalesAdmin() || canPermission('interests_view_details'))
        <button class="btn-show-interest-details btn btn-sm btn-soft-main w-100 d-inline-block tip"
            title="عرض كل التفاصيل">
            <svg xmlns="http://www.w3.org/2000/svg" width="16px" viewBox="0 0 256 256">
                <rect width="256" height="256" fill="none" />
                <circle cx="124" cy="84" r="16" />
                <circle cx="128" cy="128" r="96" fill="none" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="24" />
                <path d="M120,124a8,8,0,0,1,8,8v36a8,8,0,0,0,8,8" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
            </svg>
        </button>
    @endif


    @if (isSalesAdmin() || canPermission('interests_add_deal'))
        {{-- Create Deal Button --}}
        @if (!$interest->isClosed())
            @if ($client)
                @if ($interest->canCreateDeal())
                    <div style="min-width: 120px">
                        <button type="button" class="btn btn-sm btn-block btn-success btn-open-deal-modal"
                            data-client-uuid="{{ $client->uuid }}" data-interest-uuid="{{ $interest->uuid }}"
                            data-client-name="{{ $client->name }}" title="إنشاء صفقة">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            إنشاء صفقة
                        </button>
                    </div>
                @elseif ($interest->hasDeal())
                    <div class="w-100">
                        <a target="_blank" class="btn btn-sm btn-block btn-soft-main"
                            href="{{ route('crm.deals.edit', $interest->deal->uuid) }}">
                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <rect width="256" height="256" fill="none" />
                                <path d="M128,56C48,56,16,128,16,128s32,72,112,72,112-72,112-72S208,56,128,56Z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="24" />
                                <circle cx="128" cy="128" r="32" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="24" />
                            </svg>
                            عرض الصفقة
                        </a>
                    </div>
                @endif
            @endif
        @endif

    @endif

    @if (isSalesAdmin() || canPermission('interests_update_deal_status'))
        @switch($status)
            {{-- New: زر تكليف --}}
            @case('new')
                {{-- <form class="form-interests-status d-inline-block" method="POST" action="{{ route('crm.interests.update-status') }}">
                @csrf
            <input type="hidden" name="interest_id" value="{{ $interest->id }}">
            <input type="hidden" name="status" value="assigned">
            <button type="submit" class="btn btn-sm btn-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-check">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                    <path d="M15 19l2 2l4 -4" />
                </svg>
                تكليف
            </button>
              </form> --}}
                NEW
            @break

            {{-- Assigned: زر سجل التواصل --}}
            @case('assigned')
                <form class="form-interests-status d-inline-block" method="POST"
                    action="{{ route('crm.interests.update-status') }}">
                    @csrf
                    <input type="hidden" name="interest_id" value="{{ $interest->id }}">
                    <input type="hidden" name="status" value="contacted">
                    <button type="submit" class="btn btn-sm btn-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                        {{ $interest->status->actionLabel() }}
                    </button>
                </form>
            @break

            {{-- Contacted: Dropdown --}}
            @case('contacted')
                @include('dashboard.interest.partials._status-dropdown', [
                    'interest' => $interest,
                    'options' => [
                        [
                            'status' => 'in_progress',
                            'label' => 'جاري المتابعة',
                            'icon' => $icons['in_progress'],
                            'color' => 'primary',
                        ],
                        [
                            'status' => 'not_interested',
                            'label' => 'غير مهتم',
                            'icon' => $icons['not_interested'],
                            'color' => 'danger',
                        ],
                        [
                            'status' => 'closed',
                            'label' => 'إغلاق',
                            'icon' => $icons['closed'],
                            'color' => 'secondary',
                        ],
                    ],
                ])
            @break

            {{-- In Progress: Dropdown --}}
            @case('in_progress')
                @include('dashboard.interest.partials._status-dropdown', [
                    'interest' => $interest,
                    'options' => [
                        [
                            'status' => 'not_interested',
                            'label' => 'غير مهتم',
                            'icon' => $icons['not_interested'],
                            'color' => 'danger',
                        ],
                        [
                            'status' => 'closed',
                            'label' => 'إغلاق',
                            'icon' => $icons['closed'],
                            'color' => 'secondary',
                        ],
                    ],
                ])
            @break

            @case('not_interested')
                <form class="form-interests-status d-inline-block w-100" method="POST"
                    action="{{ route('crm.interests.update-status') }}">
                    @csrf
                    <input type="hidden" name="interest_id" value="{{ $interest->id }}">
                    <input type="hidden" name="status" value="in_progress">
                    <button type="submit" class="btn btn-sm btn-outline-main btn-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-reload">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" />
                            <path d="M20 4v5h-5" />
                        </svg>
                        {{ $interest->status->actionLabel() }}
                    </button>
                </form>
            @break

            {{-- Converted / Not Interested / Closed: عرض الحالة فقط --}}
            @case('closed')
                <div style="cursor: not-allowed" class="badge badge-sm w-100 {{ $interest->status->badgeClass() }}">
                    {{ $interest->status->label() }}
                </div>
            @break
        @endswitch
    @endif
    
</div><!-- end flex -->
