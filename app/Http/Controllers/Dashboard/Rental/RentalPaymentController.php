<?php
namespace App\Http\Controllers\Dashboard\Rental;

use App\Enums\Financial\FinancialTransactionStatus;
use App\Enums\Financial\FinancialTransactionType;
use App\Enums\Rental\PaymentScheduleStatus;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Financial\FinancialTransaction;
use App\Models\Dashboard\Rental\RentalPaymentSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalPaymentController extends Controller
{

    // public function index($contractId)
    // {
    //     $payments = RentalPaymentSchedule::where('rental_contract_id', $contractId)
    //         ->with('transaction')
    //         ->orderBy('due_date')
    //         ->get();

    //     return view('dashboard.rental.payments.index', compact('payments', 'contractId'));
    // }

    public function store(Request $request, $scheduleId)
    {
        $validated = $request->validate([
            //  'amount'           => 'required|integer|min:0',
            'transaction_date' => 'required|date',
            'payment_method'   => 'required|in:cash,bank_transfer,check,card',
            // 'receipt_number'   => 'nullable|string',
            'notes'            => 'nullable|string',
        ]);

        $schedule = RentalPaymentSchedule::findOrFail($scheduleId);

        if ($schedule->status->value === 'paid') {
            return back()->with('error', 'الدفعة مدفوعة بالفعل');
        }

        DB::beginTransaction();
        try {
            // Create Financial Transaction
            $transaction = FinancialTransaction::create([
                'transactionable_type' => 'App\Models\Dashboard\Rental\RentalContract',
                'transactionable_id'   => $schedule->rental_contract_id,
                'type'                 => FinancialTransactionType::REVENUE->value,
                'category'             => 'rent_payment',
                'amount'               => $schedule->amount,
                'transaction_date'     => $validated['transaction_date'],
                'payment_method'       => $validated['payment_method'],
                // 'receipt_number'       => $validated['receipt_number'] ?? null,
                'status'               => FinancialTransactionStatus::PAID->value,
                'received_from'        => $schedule->rentalContract->tenant_client_id,
                'admin_id'             => adminId(),
                'description'          => $validated['notes'] ?? 'دفعة إيجار رقم ' . $schedule->payment_number,
            ]);

            // Update Payment Schedule
            $schedule->update([
                'status'            => PaymentScheduleStatus::PAID->value,
                'paid_at'           => now(),
                'payment_reference' => $transaction->id,
                'notes'             => $validated['notes'] ?? null,
            ]);

            DB::commit();

            return Response::success('تم تسجيل الدفعة بنجاح', [
                'reload'   => true,
                'time_out' => 1,
                'style'    => 'toastr',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return Response::success('حدث خطأ أثناء تسجيل الدفعة', [
                'style' => 'toastr',
            ]);
        }
    }

    // public function cancel($scheduleId)
    // {
    //     $schedule = RentalPaymentSchedule::findOrFail($scheduleId);

    //     if ($schedule->status->value === 'paid') {
    //         return back()->with('error', 'لا يمكن إلغاء دفعة مدفوعة');
    //     }

    //     $schedule->update([
    //         'status' => PaymentScheduleStatus::CANCELLED->value,
    //     ]);

    //     return back()->with('success', 'تم إلغاء الدفعة بنجاح');
    // }

    public function getPaymentModal($scheduleId)
    {
        $schedule = RentalPaymentSchedule::with('rentalContract')->findOrFail($scheduleId);

        $html = view('dashboard.rental.partials._payment-modal', compact('schedule'))->render();

        return response()->json(['html' => $html]);
    }

}
