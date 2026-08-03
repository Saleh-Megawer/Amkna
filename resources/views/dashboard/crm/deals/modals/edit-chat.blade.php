<div class="modal fade" id="editChatModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form class="form" method="POST" action="{{ route('crm.deals.chats.update', [$chat->deal, $chat->id]) }}">
                @csrf
                @method('PATCH')

                <div class="modal-header">
                    <h5 class="modal-title">تعديل المحادثة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">

                        {{-- نوع التواصل --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">نوع التواصل</label>
                                <select name="contact_type" class="form-control" required>
                                    @foreach (\App\Enums\Deal\DealChatContactType::cases() as $type)
                                        <option value="{{ $type->value }}"
                                            {{ $chat->contact_type->value == $type->value ? 'selected' : '' }}>
                                            {{ $type->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- contact_type -->

                        {{-- تاريخ ووقت التواصل --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">تاريخ ووقت التواصل</label>
                                <input type="datetime-local" name="contacted_at" class="form-control"
                                    value="{{ $chat->contacted_at->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div><!-- contacted_at -->

                        {{-- المدة --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">المدة (بالدقائق)</label>
                                <input type="number" name="duration" class="form-control" min="0"
                                    value="{{ $chat->duration }}" placeholder="مثال: 15">
                            </div>
                        </div><!-- duration -->

                        {{-- نتيجة المحادثة --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">نتيجة المحادثة</label>
                                <select name="outcome" class="form-control">
                                    <option value="">اختر النتيجة</option>
                                    @foreach (\App\Enums\Deal\DealChatOutcome::cases() as $outcome)
                                        <option value="{{ $outcome->value }}"
                                            {{ $chat->outcome?->value == $outcome->value ? 'selected' : '' }}>
                                            {{ $outcome->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- outcome -->

                        {{-- الملاحظات --}}
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">الملاحظات</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="اكتب ملاحظاتك هنا...">{{ $chat->notes }}</textarea>
                            </div>
                        </div><!-- notes -->

                        {{-- الإجراء التالي --}}
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">الإجراء التالي المطلوب</label>
                                <textarea name="next_action" class="form-control" rows="2" placeholder="مثال: الاتصال مرة أخرى بعد أسبوع">{{ $chat->next_action }}</textarea>
                            </div>
                        </div><!-- next_action -->

                    </div><!-- form-row -->
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main px-4">
                        تحديث
                    </button>
                    <button type="button" class="btn btn-outline-main" data-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
