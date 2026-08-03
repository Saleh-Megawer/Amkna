{{-- Change Payment Status Modal --}}
<div class="modal fade" id="changePaymentStatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">

            {{-- Header --}}
            <div class="modal-header bg-white border-bottom">
                <h5 class="modal-title font-weight-bold text-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" class="ml-2">
                        <path d="M9 11l3 3l8 -8" />
                        <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                    </svg>
                    تأكيد إثبات السداد
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <form id="changePaymentStatusForm">
                    @csrf
                    @method('PATCH')
                    {{-- Current Request Info --}}
                    {{-- <div class="mb-4 p-3 bg-light rounded">
                        <h6 class="font-weight-bold mb-2 change-status-title"></h6>
                        <div class="d-flex align-items-center">
                            <small class="text-muted ml-2">الإجراء الحالي : </small>
                            <span class="badge badge-md font-11 change-status-current-badge"></span>
                        </div>
                    </div> --}}

                    {{-- New Status --}}
                    <div class="form-group">
                        <label class="font-weight-600">الحالة <span class="text-danger">*</span></label>
                        <select name="status" id="paymentStatusSelect" class="form-control" required>
                            <option disabled selected value="">اختر الحالة</option>
                            <option value="verified">✅ تم التحقق بنجاح</option>
                            <option value="rejected">❌ مرفوض</option>
                        </select>
                    </div>

                    {{-- Verified Fields --}}
                    <div id="verifiedFields" style="display: none;">

                        {{-- المبلغ المدفوع --}}
                        <div class="form-group">
                            <label class="font-weight-600">المبلغ المدفوع <span class="text-danger">*</span></label>
                            <input type="number" name="paid_amount" class="form-control" placeholder="0.00"
                                step="0.01" min="0">
                        </div>

                        {{-- فترة الاشتراك --}}
                        <div class=" input-normal-style">
                            <label class="font-weight-600">فترة الاشتراك <span class="text-danger">*</span></label>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-6">
                                    <label class="small text-muted">من</label>
                                    <input type="date" name="subscription_from" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label class="small text-muted">إلى</label>
                                    <input type="date" name="subscription_to" class="form-control">
                                </div>
                            </div>
                        </div>


                        {{-- ملاحظات --}}
                        <div class="form-group mb-0">
                            <label class="font-weight-600">ملاحظات <small class="text-muted">(اختياري)</small></label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="أضف ملاحظات حول التحقق..."></textarea>
                            <small class="form-text text-muted">ستظهر هذه الملاحظات في تفاصيل الطلب</small>
                        </div>

                    </div>

                    {{-- Rejected Fields --}}
                    <div id="rejectedFields" style="display: none;">

                        {{-- سبب الرفض --}}
                        <div class="form-group mb-0">
                            <label class="font-weight-600">سبب الرفض <span class="text-danger">*</span></label>
                            <textarea name="rejection_reason" class="form-control" rows="3" placeholder="اكتب سبب رفض إثبات السداد..."></textarea>
                            <small class="form-text text-muted">سيظهر هذا السبب للعميل</small>
                        </div>

                    </div>

                    <input type="hidden" name="request_id" id="change-payment-request-id">

                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-white border-top">
                <button type="button" class="btn btn-main" id="submitChangePaymentStatus">
                    <span class="btn-text">حفظ التغييرات</span>
                    <span class="btn-loading" style="display: none;">
                        <span class="spinner-border spinner-border-sm ml-2"></span>
                        جاري الحفظ...
                    </span>
                </button>
                <button type="button" class="btn btn-outline-main" data-dismiss="modal">إلغاء</button>
            </div>

        </div>
    </div>
</div>
