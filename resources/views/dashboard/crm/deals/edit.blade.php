@extends('dashboard.layouts.master')
@section('title', 'عرض صفقة')
@section('meta')
    <meta name="deal-uuid" content="{{ $row->uuid }}">
    <meta name="deal-id" content="{{ $row->id }}">
@endsection
@section('css')
    <style>
        .choices.is-disabled .choices__inner,
        .choices.is-disabled .choices__input {
            background-color: var(--input-background) !important;
        }
    </style>
@endsection
@section('content')

    {{-- Buttons for links bar --}}
    @switch($currentTab)
        @case('chats')
            @php
                $linksBarButtons = [
                    'can' => 'deals_edit',
                    'name' => '<i class=\'fa fa-plus\'></i> اضافة محادثة',
                    'class' => 'btn-success',
                    'options' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#addChatModal',
                    ],
                ];
            @endphp
        @break

        @case('attachments')
            @php
                $linksBarButtons = [
                    'can' => 'deals_edit',
                    'name' => '+ رفع مرفق جديد',
                    'class' => 'btn-success',
                    'options' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#addAttachmentModal',
                    ],
                ];
            @endphp
        @break

        @case('follow-up')
            @php
                $linksBarButtons = [
                    'can' => 'deals_edit',
                    'name' => '+ إضافة متابعة',
                    'class' => 'btn-success',
                    'options' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#addFollowupModal',
                    ],
                ];
            @endphp
        @break

        @default
    @endswitch

    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap->index->page_title,
            'link' => route('crm.deals.index'),
        ],
        [
            'name' => 'صفقة #' . $row->id,
            'link' => route('crm.deals.edit', $row),
        ],
        [
            'name' => $tabName,
        ],
    ]" :buttons="[$linksBarButtons ?? null]" /><!-- links bar -->


    <main id="deal-edit-page" class="mb-5 pb-5">

        @push('after-navbar')
            <div id="tabs-bar" class="bg-white p-3">
                <div class="d-flex">
                    @foreach ($tabs as $tab)
                        <a href="?tab={{ $tab['link'] }}"
                            class="tab tab-link-page {{ $currentTab == $tab['link'] ? 'active-tab' : '' }}">
                            {{ $tab['name'] }}

                            @switch($tab['link'])
                                @case('chats')
                                    @if ($stat['total_chats'])
                                        ({{ $stat['total_chats'] }})
                                    @endif
                                @break

                                @case('attachments')
                                    @if ($stat['total_attachments'])
                                        ({{ $stat['total_attachments'] }})
                                    @endif
                                @break

                                @case('follow-up')
                                    @if ($stat['total_follow_ups'])
                                        ({{ $stat['total_follow_ups'] }})
                                    @endif
                                @break

                                @default
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div><!--  -->
        @endpush


        @switch($currentTab)
            @case('main')
                @include('dashboard.crm.deals.tabs.main')
            @break

            @case('chats')
                @include('dashboard.crm.deals.tabs.chats')
            @break

            @case('attachments')
                @include('dashboard.crm.deals.tabs.attachments')
            @break

            @case('follow-up')
                @include('dashboard.crm.deals.tabs.followups')
            @break

            @default
                @include('dashboard.crm.deals.tabs.main')
        @endswitch


    </main><!-- section -->


    @push('js')

        <script>
            function disableDealEdit() {
                setTimeout(function() {

                    $('#deal-edit-page input, #deal-edit-page textarea, #deal-edit-page select')
                        .prop('disabled', true);

                    $('#deal-edit-page select').each(function() {
                        if (this.choices) this.choices.disable();
                    });

                    $('#deal-edit-page .choices')
                        .css('pointer-events', 'none')
                        .addClass('is-disabled');

                    $('#deal-edit-page .choices__input').prop('disabled', true);

                    $('#deal-edit-page').on('submit', function(e) {
                        e.preventDefault();
                        return false;
                    });

                }, 500);
            }
        </script>

        @if (isSalesAdmin())
            @if ($row->assigned_to !== adminId())
                <script>
                    disableDealEdit();
                </script>
            @endif
        @else
            @if (!canPermission('deals_edit'))
                <script>
                    disableDealEdit();
                </script>
            @endif
        @endif

    @endpush


@endsection
<x-dashboard.js :links="[
    [
        'link' => 'deals/edit.js',
    ],
    [
        'link' => 'deals/attachments.js',
    ],
    [
        'link' => 'deals/follow-up.js',
    ],
]" />
