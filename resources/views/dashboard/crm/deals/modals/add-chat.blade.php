<div class="modal fade" id="addChatModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form class="form" method="POST" action="{{ route('crm.deals.chats.store', $row->uuid) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">إضافة محادثة جديدة</h5>
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
                                    <option value="">اختر نوع التواصل</option>
                                    @foreach (\App\Enums\Deal\DealChatContactType::cases() as $type)
                                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- contact_type -->

                        {{-- تاريخ ووقت التواصل --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">تاريخ ووقت التواصل</label>
                                <input type="datetime-local" name="contacted_at" class="form-control" required>
                            </div>
                        </div><!-- contacted_at -->

                        {{-- المدة --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">المدة (بالدقائق)</label>
                                <input type="number" name="duration" class="form-control" min="0"
                                    placeholder="مثال: 15">
                            </div>
                        </div><!-- duration -->

                        {{-- نتيجة المحادثة --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">نتيجة المحادثة</label>
                                <select name="outcome" class="form-control">
                                    <option value="">اختر النتيجة</option>
                                    @foreach (\App\Enums\Deal\DealChatOutcome::cases() as $outcome)
                                        <option value="{{ $outcome->value }}">{{ $outcome->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- outcome -->

                        {{-- الملاحظات --}}
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">الملاحظات</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="اكتب ملاحظاتك هنا..."></textarea>
                            </div>
                        </div><!-- notes -->

                        {{-- الإجراء التالي --}}
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">الإجراء التالي المطلوب</label>
                                <textarea name="next_action" class="form-control" rows="2" placeholder="مثال: الاتصال مرة أخرى بعد أسبوع"></textarea>
                            </div>
                        </div><!-- next_action -->

                    </div><!-- form-box -->
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main px-4">
                        حفظ
                    </button>
                    <button type="button" class="btn btn-outline-main" data-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>