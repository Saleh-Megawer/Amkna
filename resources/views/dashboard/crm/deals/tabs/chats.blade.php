@if ($row->chats->isEmpty())
    <div class="text-center box py-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted mb-3">
            <path
                d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1">
            </path>
        </svg>
        <p class="text-muted mb-0">لا توجد محادثات مسجلة حتى الآن</p>
    </div>
@else
    <div class="box form-box table-responsive">
        <table class="table table-modern text-center table-modern-sm table-inverse">
            <thead>
                <tr>
                    <th>الإجراءات</th>
                    <th>نوع التواصل</th>
                    <th>التاريخ والوقت</th>
                    <th>المدة</th>
                    <th>النتيجة</th>
                    <th>الملاحظات</th>
                    <th>الإجراء التالي</th>
                    <th>بواسطة</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($row->chats as $chat)
                    <tr class="parents">
                        <td>

                            <div class="d-flex justify-content-center">

                                @can('deals_edit')
                                    <button type="button" class="btn btn-sm btn-outline-primary ml-1 btn-edit-chat"
                                        data-chat-id="{{ $chat->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path
                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                            </path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                    </button>
                                @endcan

                                @role('admin')
                                    <x-dashboard.delete-form :action="route('crm.deals.chats.delete', [$row, $chat->id])" button-class="btn btn-sm btn-outline-danger "
                                        icon-only />
                                @endrole

                            </div><!--  -->

                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                {!! $chat->contact_type->icon() !!}
                                <span class="mr-1">{{ $chat->contact_type->label() }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="ltr">
                                {{ $chat->contacted_at->locale('ar')->translatedFormat('Y-m-d') }}
                                <small class="text-muted">{{ $chat->contacted_at->format('h:i A') }}</small>
                            </div>

                        </td>
                        <td>
                            @if ($chat->duration)
                                <span class="badge badge-outline-secondary">{{ $chat->duration }} دقيقة</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($chat->outcome)
                                <span class="badge badge-md font-11 font-weight-500 {{ $chat->outcome->badgeClass() }}">
                                    {!! $chat->outcome->icon() !!}
                                    {{ $chat->outcome->label() }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($chat->notes)
                                <x-dashboard.text-preview title="الملاحظات" :text="$chat->notes" />
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($chat->next_action)
                                <x-dashboard.text-preview title="الإجراء التالي" :text="$chat->next_action" />
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $chat->creator->name ?? 'غير معروف' }}</small>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif


{{-- Include Modals --}}
@can('deals_edit')
    @include('dashboard.crm.deals.modals.add-chat')
@endcan

{{-- @include('dashboard.crm.deals.modals.edit-chat') --}}
