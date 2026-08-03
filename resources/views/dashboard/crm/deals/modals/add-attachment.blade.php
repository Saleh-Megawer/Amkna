<div class="modal fade" id="addAttachmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addAttachmentForm" method="POST" action="{{ route('crm.deals.attachments.store', $row->uuid) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">رفع مرفق جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">

                        {{-- نوع المرفق --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">نوع المرفق</label>
                                <select name="attachment_type" class="form-control" required>
                                    <option value="">اختر نوع المرفق</option>
                                    @foreach (\App\Enums\Deal\DealAttachmentType::cases() as $type)
                                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- attachment_type -->

                        {{-- رفع الملف --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">الملفات</label>
                                <input type="file" name="files[]" class="form-control" multiple required>
                                <small class="form-text text-muted">يمكنك اختيار أكثر من ملف (الحد الأقصى لكل ملف:
                                    10 ميجابايت)</small>
                            </div><!-- files -->

                        </div><!-- file -->

                        {{-- الملاحظات --}}
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">ملاحظات</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="ملاحظات عن المرفق (اختياري)"></textarea>
                            </div>
                        </div><!-- notes -->

                        {{-- Progress Bar --}}
                        <div class="col-12">
                            <div class="progress d-none" id="uploadProgress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    style="width: 0%"></div>
                            </div>
                        </div>

                    </div><!-- form-row -->
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-main px-4">
                        رفع
                    </button>
                    <button type="button" class="btn btn-outline-main" data-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
