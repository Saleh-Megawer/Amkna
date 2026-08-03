<?php
namespace App\Http\Controllers\Dashboard\Rental;

use App\Enums\Financial\FinancialTransactionStatus;
use App\Enums\Financial\FinancialTransactionType;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Financial\FinancialTransaction;
use App\Models\Dashboard\Rental\RentalContract;
use Illuminate\Http\Request;

class RentalExpenseController extends Controller
{
    public function index($contractId)
    {
        $contract = RentalContract::findOrFail($contractId);

        $expenses = FinancialTransaction::where('transactionable_type', 'App\Models\Dashboard\Rental\RentalContract')
            ->where('transactionable_id', $contractId)
            ->where('type', FinancialTransactionType::EXPENSE->value)
            ->with('admin')
            ->latest()
            ->get();

        return view('dashboard.rental.expenses.index', compact('expenses', 'contract'));
    }

    public function create($contractId)
    {
        $contract = RentalContract::findOrFail($contractId);
        return view('dashboard.rental.expenses.create', compact('contract'));
    }

    public function store(Request $request, $contractId)
    {
        $validated = $request->validate([
            'category'         => 'required|string',
            'amount'           => 'required|integer|min:0',
            'transaction_date' => 'required|date',
            'payment_method'   => 'required|in:cash,bank_transfer,check,card',
            'receipt_number'   => 'nullable|string',
            'description'      => 'required|string',
        ]);

        $contract = RentalContract::findOrFail($contractId);

        FinancialTransaction::create([
            'transactionable_type' => 'App\Models\Dashboard\Rental\RentalContract',
            'transactionable_id'   => $contract->id,
            'type'                 => FinancialTransactionType::EXPENSE->value,
            'category'             => $validated['category'],
            'amount'               => $validated['amount'],
            'transaction_date'     => $validated['transaction_date'],
            'payment_method'       => $validated['payment_method'],
            'receipt_number'       => $validated['receipt_number'] ?? null,
            'status'               => FinancialTransactionStatus::PAID->value,
            'description'          => $validated['description'],
            'admin_id'             => auth()->id(),
        ]);

        return redirect()
            ->route('dashboard.rental.expenses.index', $contractId)
            ->with('success', 'تم إضافة المصروف بنجاح');
    }

    public function destroy($expenseId)
    {
        $expense    = FinancialTransaction::findOrFail($expenseId);
        $contractId = $expense->transactionable_id;

        $expense->delete();

        return redirect()
            ->route('dashboard.rental.expenses.index', $contractId)
            ->with('success', 'تم حذف المصروف بنجاح');
    }
}
