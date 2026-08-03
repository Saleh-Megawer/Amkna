<?php

namespace App\Http\Controllers\Dashboard\Financial;

use App\Enums\Financial\FinancialTransactionStatus;
use App\Enums\Financial\FinancialTransactionType;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Financial\FinancialTransaction;
use Illuminate\Http\Request;

class FinancialTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = FinancialTransaction::with([
            'transactionable', 
            'admin', 
            'paidBy', 
            'receivedFrom'
        ]);

        // Filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('receipt_number', 'like', '%' . $request->search . '%')
                  ->orWhere('amount', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Sort
        $sortOrder = $request->get('sort-order', 'desc');
        $query->orderBy('transaction_date', $sortOrder)
              ->orderBy('created_at', $sortOrder);

        $transactions = $query->paginate(50);

        // Statistics
        $stats = [
            'total' => FinancialTransaction::count(),
            'paid' => FinancialTransaction::where('status', FinancialTransactionStatus::PAID)->count(),
            'pending' => FinancialTransaction::where('status', FinancialTransactionStatus::PENDING)->count(),
            'cancelled' => FinancialTransaction::where('status', FinancialTransactionStatus::CANCELLED)->count(),
            'total_revenue' => FinancialTransaction::where('type', FinancialTransactionType::REVENUE)
                ->where('status', FinancialTransactionStatus::PAID)
                ->sum('amount'),
            'total_expenses' => FinancialTransaction::where('type', FinancialTransactionType::EXPENSE)
                ->where('status', FinancialTransactionStatus::PAID)
                ->sum('amount'),
        ];

        // Get unique categories for filter
        $categories = FinancialTransaction::distinct()->pluck('category')->filter();

        return view('dashboard.financial.transactions.index', compact(
            'transactions',
            'stats',
            'categories'
        ));
    }

    public function create()
    {
        return view('dashboard.financial.transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:revenue,expense',
            'category' => 'required|string',
            'amount' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
            'payment_method' => 'nullable|in:cash,bank_transfer,check,card',
            'receipt_number' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled',
            'paid_by' => 'nullable|exists:clients,id',
            'received_from' => 'nullable|exists:clients,id',
        ]);

        $validated['admin_id'] = auth()->id();

        FinancialTransaction::create($validated);

        return redirect()
            ->route('financial.transactions.index')
            ->with('success', 'تم إضافة المعاملة المالية بنجاح');
    }

    public function show($uuid)
    {
        $transaction = FinancialTransaction::where('uuid', $uuid)
            ->with(['transactionable', 'admin', 'paidBy', 'receivedFrom'])
            ->firstOrFail();

        return view('dashboard.financial.transactions.show', compact('transaction'));
    }

    public function edit($uuid)
    {
        $transaction = FinancialTransaction::where('uuid', $uuid)->firstOrFail();

        return view('dashboard.financial.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $uuid)
    {
        $transaction = FinancialTransaction::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'type' => 'required|in:revenue,expense',
            'category' => 'required|string',
            'amount' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
            'payment_method' => 'nullable|in:cash,bank_transfer,check,card',
            'receipt_number' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled',
            'paid_by' => 'nullable|exists:clients,id',
            'received_from' => 'nullable|exists:clients,id',
        ]);

        $transaction->update($validated);

        return redirect()
            ->route('financial.transactions.index')
            ->with('success', 'تم تحديث المعاملة المالية بنجاح');
    }

    public function destroy($uuid)
    {
        $transaction = FinancialTransaction::where('uuid', $uuid)->firstOrFail();
        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المعاملة المالية بنجاح'
        ]);
    }
}
