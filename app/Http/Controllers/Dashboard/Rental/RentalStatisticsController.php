<?php

namespace App\Http\Controllers\Dashboard\Rental;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Rental\RentalContract;
use App\Models\Dashboard\Rental\RentalPaymentSchedule;
use App\Models\Dashboard\Financial\FinancialTransaction;
use App\Models\Dashboard\Property;
use App\Enums\Rental\RentalContractStatus;
use App\Enums\Financial\FinancialTransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalStatisticsController extends Controller
{
    public function index()
    {
        $stats = [
            'total_contracts' => $this->getTotalContracts(),
            'active_contracts' => $this->getActiveContracts(),
            'expired_contracts' => $this->getExpiredContracts(),
            'total_revenue' => $this->getTotalRevenue(),
            'total_expenses' => $this->getTotalExpenses(),
            'total_commissions' => $this->getTotalCommissions(),
            'total_overdue' => $this->getTotalOverdue(),
            'top_property_types' => $this->getTopPropertyTypes(),
            'monthly_revenue' => $this->getMonthlyRevenue(),
        ];

        return view('dashboard.rental.statistics.index', compact('stats'));
    }

    private function getTotalContracts()
    {
        return RentalContract::count();
    }

    private function getActiveContracts()
    {
        return RentalContract::where('status', RentalContractStatus::ACTIVE->value)->count();
    }

    private function getExpiredContracts()
    {
        return RentalContract::where('status', RentalContractStatus::EXPIRED->value)->count();
    }

    private function getTotalRevenue()
    {
        return FinancialTransaction::where('type', FinancialTransactionType::REVENUE->value)
            ->where('category', 'rent_payment')
            ->where('status', 'paid')
            ->sum('amount');
    }

    private function getTotalExpenses()
    {
        return FinancialTransaction::where('type', FinancialTransactionType::EXPENSE->value)
            ->where('status', 'paid')
            ->sum('amount');
    }

    private function getTotalCommissions()
    {
        return RentalContract::where('commission_status', 'collected')
            ->sum('commission_amount');
    }

    private function getTotalOverdue()
    {
        return RentalPaymentSchedule::where('status', 'pending')
            ->where('due_date', '<', now())
            ->sum('amount');
    }

    private function getTopPropertyTypes()
    {
        return RentalContract::select('property_types.id', DB::raw('COUNT(rental_contracts.id) as total'))
            ->join('properties', 'properties.id', '=', 'rental_contracts.property_id')
            ->join('property_types', 'property_types.id', '=', 'properties.property_type_id')
            ->where('rental_contracts.status', RentalContractStatus::ACTIVE->value)
            ->whereNotNull('rental_contracts.property_id')
            ->groupBy('property_types.id')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->with('propertyType')
            ->get();
    }

    private function getMonthlyRevenue()
    {
        return FinancialTransaction::select(
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('type', FinancialTransactionType::REVENUE->value)
            ->where('category', 'rent_payment')
            ->where('status', 'paid')
            ->whereYear('transaction_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function contractReport($contractId)
    {
        $contract = RentalContract::with([
            'property',
            'propertyDetails',
            'owner',
            'tenant',
            'paymentSchedules',
            'transactions'
        ])->findOrFail($contractId);

        $report = [
            'total_rent' => $contract->total_rent_amount,
            'collected' => $contract->totalCollected(),
            'remaining' => $contract->totalRemaining(),
            'overdue' => $contract->totalOverdue(),
            'expenses' => $contract->transactions()
                ->where('type', FinancialTransactionType::EXPENSE->value)
                ->where('status', 'paid')
                ->sum('amount'),
            'net_profit' => $contract->totalCollected() - $contract->transactions()
                ->where('type', FinancialTransactionType::EXPENSE->value)
                ->where('status', 'paid')
                ->sum('amount'),
        ];

        return view('dashboard.rental.statistics.contract-report', compact('contract', 'report'));
    }
}
