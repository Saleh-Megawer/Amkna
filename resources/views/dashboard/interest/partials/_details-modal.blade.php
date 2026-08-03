{{-- _details-modal.blade.php --}}

<div class="modal fade" id="interestDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header bg-light">
                <h5 class="modal-title">
                    الاهتمام #{{ $interest->id }}
                    <span class="badge font-12 badge-sm {{ $interest->status->badgeClass() }} mr-1">
                        {{ $interest->status->label() }}
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Nav Tabs --}}
            <div class="modal-body">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                            التفاصيل
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="logs-tab" data-toggle="tab" href="#logs" role="tab">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            سجل النشاط
                            @if ($interest->activities->count() > 0)
                                <span class="badge badge-soft-primary">{{ $interest->activities->count() }}</span>
                            @endif
                        </a>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content mt-3">

                    {{-- تفاصيل --}}
                    <div class="tab-pane fade show active" id="details" role="tabpanel">

                        {{-- بيانات العميل --}}
                        <div class="card mb-3">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 font-weight-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    بيانات العميل
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <p class="mb-2">
                                            <strong class="text-muted">الاسم:</strong>
                                            <a href="{{ route('crm.clients.show', $interest->client->uuid) }}"
                                                target="_blank" class="mr-2">
                                                {{ $interest->client->name }}
                                            </a>
                                        </p>

                                        <p class="mb-2">
                                            <strong class="text-muted">الرقم التعريفي:</strong>
                                            <span class="mr-2">#{{ $interest->client->id }}</span>
                                        </p>

                                    </div>
                                    <div class="col-md-6">

                                        <p class="mb-2">
                                            <strong class="text-muted">الجوال:</strong>
                                            <a target="__blank"
                                                href="https://wa.me/{{ ltrim($interest->client->country_code, '+') }}{{ $interest->client->phone }}">
                                                <bdi class="ltr mr-2">
                                                    {{ $interest->client->country_code != null ? '(' . $interest->client->country_code . ') ' : '' }}{{ $interest->client->phone }}
                                                </bdi>
                                            </a>
                                        </p>

                                        @if ($interest->client->email)
                                            <p class="mb-2">
                                                <strong class="text-muted">البريد:</strong>
                                                <a href="mailto:{{ $interest->client->email }}"
                                                    class="mr-2">{{ $interest->client->email }}</a>
                                            </p>
                                        @endif
                                        @if ($interest->client->city)
                                            <p class="mb-2">
                                                <strong class="text-muted">المدينة:</strong>
                                                <span class="mr-2">{{ $interest->client->city }}</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- معلومات الاهتمام --}}
                        <div class="card mb-3">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 font-weight-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="16" x2="12" y2="12"></line>
                                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                    </svg>
                                    معلومات الاهتمام
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong class="text-muted">النوع:</strong>
                                            <span class="mr-2">{{ $interest->type->label() }}</span>
                                        </p>

                                        <p class="mb-2">
                                            <strong class="text-muted">الحالة:</strong>
                                            <span class="badge badge-sm {{ $interest->status->badgeClass() }} mr-2">
                                                {{ $interest->status->label() }}
                                            </span>
                                        </p>

                                        <p class="mb-2">
                                            <strong class="text-muted">تاريخ الإنشاء:</strong>
                                            <span
                                                class="mr-2">{{ $interest->created_at->format('Y/m/d h:i A') }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">

                                        <p class="mb-2">
                                            <strong class="text-muted">المكلف:</strong>
                                            <span
                                                class="mr-2">{{ $interest->assignedTo->full_name ?? 'غير مكلف' }}</span>
                                        </p>
                                        @if ($interest->deal)
                                            <p class="mb-2">
                                                <strong class="text-muted">الصفقة:</strong>
                                                <a href="{{ route('crm.deals.edit', $interest->deal->uuid) }}"
                                                    target="_blank" class="mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                        height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path
                                                            d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6">
                                                        </path>
                                                        <polyline points="15 3 21 3 21 9"></polyline>
                                                        <line x1="10" y1="14" x2="21"
                                                            y2="3"></line>
                                                    </svg>
                                                    عرض الصفقة
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- الرسالة --}}
                        @if ($interest->message)
                            <div class="card">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 font-weight-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                            </path>
                                        </svg>
                                        الرسالة
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0 text-muted">{{ $interest->message }}</p>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- سجل النشاط --}}
                    <div class="tab-pane fade" id="logs" role="tabpanel">
                        @if ($interest->activities->count() > 0)
                            <div style="max-height: 450px; overflow-y: auto;" class="pl-2">
                                @foreach ($interest->activities as $activity)
                                    <div class="pb-3">
                                        {{-- Header --}}
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 text-black font-weight-600">
                                                    @if ($activity->description == 'created')
                                                        تم إنشاء الاهتمام
                                                    @else
                                                        تم التحديث
                                                    @endif
                                                </h6>
                                            </div>
                                            <small class="text-muted text-nowrap">
                                                {{ $activity->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        {{-- Changes --}}
                                        @if ($activity->description == 'updated' && $activity->properties)
                                            @php
                                                $old = $activity->properties->get('old', []);
                                                $new = $activity->properties->get('attributes', []);
                                            @endphp

                                            <div class="bg-light p-2 rounded mb-2">

                                                <small class="text-muted mb-1">
                                                    @if ($activity->causer)
                                                        <span class="mb-0 font-13 text-secondary font-weight-500">
                                                            بواسطة : {{ $activity->causer->full_name }}
                                                        </span>
                                                        تم تغير
                                                    @endif
                                                </small>

                                                {{-- المكلف --}}
                                                @if (isset($new['assigned_to']) && isset($old['assigned_to']) && $old['assigned_to'] != $new['assigned_to'])
                                                    <small class="text-muted">المكلف</small>

                                                    <div class="log-row mt-1">
                                                        <div class="d-flex align-items-center">
                                                            <small class="text-muted text-decoration-line-through">
                                                                {{ $admins[$old['assigned_to']]->full_name ?? 'غير مكلف' }}
                                                            </small>

                                                            <span class="mx-2">
                                                                <svg width="16" height="16"
                                                                    viewBox="0 0 24 24" fill="none" stroke="#999"
                                                                    stroke-width="2">
                                                                    <path d="M19 12H5M12 19l-7-7 7-7" />
                                                                </svg>
                                                            </span>

                                                            <small class="text-dark font-weight-500">
                                                                {{ $admins[$new['assigned_to']]->full_name ?? 'غير مكلف' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- الحالة --}}
                                                @if (isset($new['status']) && isset($old['status']) && $old['status'] != $new['status'])
                                                    <small class="text-muted">الحالة</small>
                                                    <div class="log-row mt-1">


                                                        <div class="d-flex align-items-center">
                                                            <span class="badge border badge-light badge-sm">
                                                                {{ $statuses[$old['status']]['label'] ?? $old['status'] }}
                                                            </span>

                                                            <span class="mx-2">
                                                                <svg width="16" height="16"
                                                                    viewBox="0 0 24 24" fill="none" stroke="#999"
                                                                    stroke-width="2">
                                                                    <path d="M19 12H5M12 19l-7-7 7-7" />
                                                                </svg>
                                                            </span>

                                                            <span
                                                                class="badge {{ $statuses[$new['status']]['color'] }} badge-sm">
                                                                {{ $statuses[$new['status']]['label'] ?? $new['status'] }}
                                                            </span>
                                                        </div>
                                                    </div><!-- end log-row -->
                                                @endif

                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                    style="width: 64px; height: 64px;">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                        stroke="#ccc" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="12" y1="18" x2="12" y2="12" />
                                        <line x1="9" y1="15" x2="15" y2="15" />
                                    </svg>
                                </div>
                                <p class="text-muted small mb-0">لا يوجد سجل نشاط</p>
                            </div>
                        @endif
                    </div>




                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-main" data-dismiss="modal">إغلاق</button>
            </div>

        </div>
    </div>
</div>
