<div class="activity-timeline">

    @forelse($logs as $log)
        <div class="activity-item d-flex">

            {{-- نقطة الخط --}}
            <div class="activity-line ml-2">
                <span class="dot"></span>
            </div>

            {{-- المحتوى --}}
            <div class="activity-content flex-grow-1">

                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong>
                        {{-- ✅ اعرض description مع تنسيق للـ updated --}}
                        @if ($log->description === 'updated')
                            تحديث بيانات
                        @else
                            {{ $log->description }}
                        @endif
                    </strong>

                    <div class="text-muted small icon ltr">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 12l3 2" />
                            <path d="M12 7v5" />
                        </svg>
                        {{ $log->created_at->format('Y-m-d • H:i') }}
                    </div>
                </div>

                {{-- إظهار الشخص الي عمل التعديل --}}
                <div title="القائم بالإجراء" class="text-muted icon small mb-2 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                    </svg>
                    {{ optional($log->causer)->full_name ?? 'النظام' }}
                </div>

                {{-- ✅ التفاصيل --}}
                @php
                    $properties = is_string($log->properties) 
                        ? json_decode($log->properties, true) 
                        : $log->properties->toArray();
                @endphp

                {{-- ✅ حالة تغيير الموظف المكلّف --}}
                @if ($log->description === 'تم تغيير الموظف المكلّف')
                    <div class="activity-details text-muted">
                        {{ $properties['message'] ?? '' }}
                    </div>

                {{-- ✅ بقية الحالات --}}
                @elseif (isset($properties['attributes']) || isset($properties['old']))
                    @switch($log->event)
                        {{-- إضافة ملاحظة --}}
                        @case('note-created')
                            <div class="activity-details text-muted">
                                نص الملاحظة :
                                "<span>{{ $properties['attributes']['note'] ?? '' }}</span>"
                            </div>
                        @break

                        {{-- تعديل ملاحظة --}}
                        @case('note-updated')
                            <div class="activity-details text-muted">
                                تم تغيير الملاحظة:
                                من "<span>{{ $properties['old']['note'] ?? '-' }}</span>"
                                إلى "<span>{{ $properties['attributes']['note'] ?? '' }}</span>"
                            </div>
                        @break

                        {{-- تعديل بيانات العميل --}}
                        @case('updated')
                            <div class="activity-details text-muted">
                                @foreach ($properties['attributes'] ?? [] as $field => $newValue)
                                    <div>
                                        تم تغيير
                                        <strong>{{ log_field($field) }}</strong>:
                                        من "<span>{{ $properties['old'][$field] ?? '-' }}</span>"
                                        إلى "<span>{{ $newValue }}</span>"
                                    </div>
                                @endforeach
                            </div>
                        @break

                        @default
                            <div class="activity-details text-muted">
                                @foreach ($properties['attributes'] ?? [] as $field => $newValue)
                                    <div>
                                        تم تغيير
                                        <strong>{{ log_field($field) }}</strong>:
                                        من "<span>{{ $properties['old'][$field] ?? '-' }}</span>"
                                        إلى "<span>{{ $newValue }}</span>"
                                    </div>
                                @endforeach
                            </div>
                    @endswitch
                @endif

                {{-- ملاحظات إن وجدت --}}
                @if (isset($properties['note_excerpt']))
                    <div class="activity-details text-muted mt-1">
                        نص الملاحظة :
                        {{ $properties['note_excerpt'] }}
                    </div>
                @endif

            </div>

        </div>
    @empty
        <p class="text-muted text-center py-3">لا يوجد نشاط بعد</p>
    @endforelse  

</div>
