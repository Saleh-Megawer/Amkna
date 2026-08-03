{{-- Payment Modal --}}
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تسجيل دفعة رقم {{ $schedule->payment_number }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form class="form" method="POST" action="{{ route('rental.payments.store', $schedule) }}"
                data-schedule-id="{{ $schedule->id }}">
                @csrf
                <div class="modal-body">

                    <div class="alert alert-info">
                        تاريخ الاستحقاق: <strong class="ltr d-inline-block">{{ $schedule->due_date_formatted }}</strong>
                        <br>
                        المبلغ المستحق: <strong class="ltr d-inline-block">{!! currency_icon('xs', '#0c5460') . ' ' . number_format($schedule->amount) !!}</strong>
                    </div>

                    <div class="form-group">
                        <label class="required">تاريخ الدفع</label>
                        <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label class="required">طريقة الدفع</label>
                        <select name="payment_method" class="form-control choices" required>
                            <option value="">اختر طريقة الدفع</option>
                            <option value="cash">نقدي</option>
                            <option value="bank_transfer">تحويل بنكي</option>
                            <option value="check">شيك</option>
                            <option value="card">بطاقة</option>
                        </select>
                    </div>
                    {{-- 
                    <div class="form-group">
                        <label>رقم الإيصال</label>
                        <input type="text" name="receipt_number" class="form-control">
                    </div> --}}

                    <div class="form-group">
                        <label>ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-main">
                        تسجيل الدفع
                    </button>
                    <button type="button" class="btn btn-outline-main" data-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
