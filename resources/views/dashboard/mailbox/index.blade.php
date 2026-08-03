@extends('dashboard.layouts.master')
@section('title', 'البريد الوارد')
<x-dashboard.css link="mail/mailbox.css" />

@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'البريد الوارد',
        ],
    ]" />

    <section id="mailbox">
        <div class="row">



            <div class="col-lg-12">

                <small class=" d-block mb-3 ">
                    <span>الإجمالي ( {{ $countMails }} ) </span>
                    -
                    <span>مقروء ( {{ $countReadMails }} ) </span>
                    -
                    <span>غير مقروءة ( {{ $countUnReadMails }} ) </span>
                </small>

                <div class="tab-pane  fade show active" id="Inbox" role="tabpanel" aria-labelledby="Inbox-tab">
                    @if (count($mails) > 0)
                        <div class="box pt-3 px-0">


                            <div id="multi-actions" class="px-2 pb-2">

                                <button id="btn-checked-all" class="tip" title="Select All">
                                    <input type="checkbox" name="" id="input-checked-all">
                                </button><!-- Input Check All -->

                                {{--
                                <button id="refresh" class="tip" title="{{ dbTrans('mailbox.Refresh') }}">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                </button><!-- Refresh --> --}}

                                <form id="form-actions" class="delete d-inline-block"
                                    action="{{ route('mail-multi-actions') }}" method="post">
                                    @csrf
                                    <div class=" input-normal-style">
                                        <!-- Actions -->
                                        <input type="submit" id="trash" name="action" class="d-none" value="trash">
                                        <input type="submit" id="read" name="action" class="d-none" value="read">

                                        <!-- Read -->
                                        <label for="read" class="tip cursor-pointer" title="تغير إلي مقروء">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </label>

                                        <!-- Trash -->
                                        <label for="trash" class="tip cursor-pointer" title="حذف">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14H6L5 6" />
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M9 6V4h6v2" />
                                            </svg>
                                        </label>

                                    </div>
                                </form>

                            </div><!-- multi actions -->

                            <div id="mails">
                                <div id="mails-body">
                                    @foreach ($mails as $row)
                                        <div class="mail px-3 @if ($row->read == 0) {{ 'unread' }} @endif">
                                            <div class="row">

                                                <div class=" col-xl-3 col-lg-4 col-md-3 ">
                                                    <div class="checkboxes d-inline-block">
                                                        <input form="form-actions" type="checkbox" name="id[]"
                                                            value="{{ $row->id }}" id="{{ $row->id }}">
                                                    </div><!-- check box -->
                                                    <div class="send-by d-inline-block">
                                                        <a class="@if ($row->read == 0) {{ 'theme-text-color' }} @else {{ 'text-main' }} @endif"
                                                            href="{{ adminUrl('mail/read/' . $row->id) }}">
                                                            <h6 class="mb-0">{{ $row->name }}</h6>
                                                        </a>
                                                    </div>
                                                </div><!-- sender name -->


                                                <div class="content col-xl-7 col-lg-8 col-md-7">
                                                    <p class="mb-0">{{ Str::limit($row->subject, 120, '...') }}</p>
                                                </div><!-- mail content -->


                                                <div class="send-at offset-xl-0 col-xl-2 offset-lg-4 col-lg-4 col-md-2">
                                                    <small>{{ parseTime($row->created_at) }}</small>
                                                </div><!-- send at -->


                                            </div>
                                        </div><!-- end of mail -->
                                    @endforeach
                                </div>
                                <div class="overlay"></div>
                            </div>

                        </div>
                    @else
                        <div class="box text-center text-secondary">
                            <i class="fa-solid fa-inbox fa-3x pt-2"></i>
                            <h5 class="text-center pb-4 pt-3">صندوق الوارد فارغ</h5>
                        </div>
                    @endif
                </div><!-- Inbox -->

                <div class="tab-pane fade" id="Sent" role="tabpanel" aria-labelledby="Sent-tab">
                    <x-panel-with-heading title="{{ dbTrans('mailbox.sent') }}">
                        <h6 class=" text-center font-weight-bold text-secondary">
                            {{ dbTrans('mailbox.This Section Is Coming Soon') }}</h6>
                    </x-panel-with-heading>
                </div><!-- Sent -->


                <div class="tab-pane fade" id="Trash" role="tabpanel" aria-labelledby="Trash-tab">
                    <x-panel-with-heading title="{{ dbTrans('mailbox.trash') }}">
                        <h6 class=" text-center font-weight-bold text-secondary">
                            {{ dbTrans('mailbox.This Section Is Coming Soon') }}</h6>
                    </x-panel-with-heading>
                </div><!-- Trash -->

                <div class="mb-5">
                    <x-paginate :data="$mails" />
                </div>

            </div>

        </div><!-- end row -->
    </section><!-- end section -->

@endsection

<x-dashboard.js link="mail/mailbox.js" type="module" />
