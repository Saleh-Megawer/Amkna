<div class="modal fade" id="addFollowupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form class="form" method="POST" action="{{ route('crm.deals.follow-ups.store', $row->uuid) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">إضافة متابعة جديدة</h5>
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
                                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- follow_up_type -->

                        {{-- موعد المتابعة --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">موعد المتابعة</label>
                                <input type="datetime-local" name="scheduled_at" class="form-control" required>
                            </div>
                        </div><!-- scheduled_at -->

                        {{-- الأولوية --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">الأولوية</label>
                                <select name="priority" class="form-control" required>
                                    <option value="">اختر الأولوية</option>
                                    @foreach (\App\Enums\Deal\DealFollowUpPriority::cases() as $priority)
                                        <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- priority -->

                        {{-- مسؤول المتابعة --}}
                        @if(!empty($admins))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">مسؤول المتابعة</label>
                                <select name="assigned_to" class="form-control">
                                    <option value="">اختر المسؤول</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ adminId() == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- assigned_to -->
                        @endif

                        {{-- الملاحظات --}}
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">الملاحظات</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="اكتب ملاحظاتك هنا..." maxlength="1000"></textarea>
                            </div>
                        </div><!-- notes -->

                    </div><!-- form-row -->
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
