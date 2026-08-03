<div class="box">
    <div class="mb-2">
        <span class="mb-1 font-weight-500 d-block">المرفقات ({{ $row->attachments->count() }})</span>
        @if (!$row->attachments->isEmpty())
            <div class="text-muted small mt-0">
                @if ($attachmentStats['contract'] > 0)
                    <strong class="text-dark">{{ $attachmentStats['contract'] }}</strong> عقود
                @endif
                @if ($attachmentStats['invoice'] > 0)
                    <span class="mx-1">|</span>
                    <strong class="text-dark">{{ $attachmentStats['invoice'] }}</strong> فواتير
                @endif
                @if ($attachmentStats['image'] > 0)
                    <span class="mx-1">|</span>
                    <strong class="text-dark">{{ $attachmentStats['image'] }}</strong> صور
                @endif
                @if ($attachmentStats['document'] > 0)
                    <span class="mx-1">|</span>
                    <strong class="text-dark">{{ $attachmentStats['document'] }}</strong> مستندات
                @endif
                @if ($attachmentStats['id_card'] > 0)
                    <span class="mx-1">|</span>
                    <strong class="text-dark">{{ $attachmentStats['id_card'] }}</strong> بطاقات
                @endif
                @if ($attachmentStats['other'] > 0)
                    <span class="mx-1">|</span>
                    <strong class="text-dark">{{ $attachmentStats['other'] }}</strong> أخرى
                @endif
            </div>
        @endif
    </div>

    @if ($row->attachments->isEmpty())
        <div class="text-center py-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="text-muted mb-3">
                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
            </svg>
            <p class="text-muted mb-0">لا توجد مرفقات مرفوعة حتى الآن</p>
        </div>
    @else
        <div class="form-row">
            @foreach ($row->attachments as $attachment)
                <div class="col-xl-4 col-lg-6 col-sm-6 my-1 parents">
                    <div class="border rounded p-3 d-flex align-items-center">

                        <div class="ml-3 flex-shrink-0">
                            @if ($attachment->isImage())
                                <a target="_blank" href="{{ $attachment->file_url }}">
                                    <img src="{{ $attachment->thumbnail_url }}" class="rounded"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                </a>
                            @else
                                <img style="width: 50px; height: 50px;" src="{{ $attachment->file_icon }}"
                                    alt="">
                            @endif
                        </div>

                        <div class="flex-grow-1" style="min-width: 0; overflow: hidden;">
                            <h6 class="mb-1 text-truncate ltr" title="{{ $attachment->file_name }}">
                                {{ $attachment->file_name }}
                            </h6>
                            <div class="d-flex">
                                <small
                                    class="font-11 d-block ml-2 badge {{ $attachment->attachment_type->badgeClass() }}">{{ $attachment->attachment_type->label() }}</small>
                                <small class="text-muted d-block">{{ $attachment->formatted_file_size }}</small>
                            </div>
                        </div>

                        <a download href="{{ $attachment->file_url }}"
                            class="btn btn-sm pb-2 btn-soft-main flex-shrink-0 mr-2 ml-1" title="تحميل">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                <path d="M7 11l5 5l5 -5" />
                                <path d="M12 4l0 12" />
                            </svg>
                        </a>


                        @role('admin')
                            <x-dashboard.delete-form :action="route('crm.deals.attachments.delete', [$row, $attachment->id])" button-class="btn btn-sm btn-outline-danger "
                                icon-only icon-size="20px" />
                        @endrole

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Include Modal --}}
@include('dashboard.crm.deals.modals.add-attachment')
