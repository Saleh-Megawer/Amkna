<div class="card">
    <div class="table-responsive">
        <table class="table table-modern table-modern-sm">
            <thead>
                <tr>
                    <th class=" text-center">رقم</th>
                    <th>الإجراءات</th>
                    <th>الأولوية</th>
                    <th>الحالة</th>
                    <th>النوع</th>
                    <th>الموعد</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($row->followUps->sortByDesc('scheduled_at') as $followup)
                    <tr class="parents">

                        <td style="width: 65px" class="text-center">#{{ $followup->id }}</td>

                        <td>
                            <div class="d-flex">

                                @can('deals_edit_followup')
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit-follow-up ml-1"
                                        data-follow-up-id="{{ $followup->id }}">
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

                                    @if ($followup->status->value == 'pending')
                                        <form
                                            action="{{ route('crm.deals.follow-ups.mark-completed', [$row, $followup->id]) }}"
                                            method="POST">
                                            @method('PATCH')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success ml-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l5 5l10 -10" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                @endcan

                                @can('deals_delete_followup')
                                    <x-dashboard.delete-form :action="route('crm.deals.follow-ups.delete', [$row, $followup->id])" button-class="btn btn-sm btn-outline-danger "
                                        icon-only />
                                @endcan

                            </div>
                        </td>

                        <td>
                            <span class="badge {{ $followup->priority->badgeClass() }}">
                                {{ $followup->priority->label() }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $followup->status->badgeClass() }}">
                                {{ $followup->status->label() }}
                            </span>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <span class="ml-2">{!! $followup->follow_up_type->icon() !!}</span>
                                <div>
                                    <div>{{ $followup->follow_up_type->label() }}</div>
                                    @if ($followup->notes)
                                        <x-dashboard.text-preview :text="$followup->notes" limit="45" />
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $followup->scheduled_at->format('Y-m-d') }}</div>
                            <div class="text-muted small ltr">{{ $followup->scheduled_at->format('h:i A') }}</div>
                            @if ($followup->assignedUser)
                                <div class="text-muted small">{{ $followup->assignedUser->full_name }}</div>
                            @endif
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2" width="48"
                                    height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 21h-5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3"></path>
                                    <path d="M16 3v4"></path>
                                    <path d="M8 3v4"></path>
                                    <path d="M4 11h16"></path>
                                    <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                                <div>لا توجد متابعات</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- تضمين الـ Modal --}}
@include('dashboard.crm.deals.modals.add-followup')
