<div class="modal fade" id="editFollowupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form class="form" method="POST"
                action="{{ route('crm.deals.follow-ups.update', [$followUp->deal, $followUp->id]) }}">
                @csrf
                @method('PATCH')

                <div class="modal-header">
                    <h5 class="modal-title">تعديل المتابعة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">

                        {{-- نوع المتابعة --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">نوع المتابعة</label>
                                <select name="follow_up_type" class="form-control" required>
                                    <option value="">اختر نوع المتابعة</option>
                                    @foreach (\App\Enums\Deal\DealFollowUpType::cases() as $type)
                                        <option value="{{ $type->value }}" @selected($followUp->follow_up_type->value == $type->value)>
                                            {{ $type->label() }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        {{-- موعد المتابعة --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">موعد المتابعة</label>
                                <input type="datetime-local" name="scheduled_at" class="form-control"
                                    value="{{ $followUp->scheduled_at->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>

                        {{-- الأولوية --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">الأولوية</label>
                                <select name="priority" class="form-control" required>
                                    <option value="">اختر الأولوية</option>
                                    @foreach (\App\Enums\Deal\DealFollowUpPriority::cases() as $priority)
                                        <option value="{{ $priority->value }}" @selected($followUp->priority->value == $priority->value)>
                                            {{ $priority->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- مسؤول المتابعة --}}
                        @if (!empty($admins))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">مسؤول المتابعة</label>
                                    <select name="assigned_to" class="form-control">
                                        <option value="">اختر المسؤول</option>
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->id }}" @selected($followUp->assigned_to == $admin->id)>
                                                {{ $admin->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif


                        {{-- الحالة --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-control">
                                    @foreach (\App\Enums\Deal\DealFollowUpStatus::cases() as $status)
                                        <option value="{{ $status->value }}" @selected($followUp->status->value == $status->value)>
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        {{-- الملاحظات --}}
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">الملاحظات</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="اكتب ملاحظاتك هنا..." maxlength="1000">{{ $followUp->notes }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main px-4">
                        حفظ التعديلات
                    </button>
                    <button type="button" class="btn btn-outline-main" data-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
