<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Dashboard\Crm\Deal\DealFollowUp;
use App\Models\Dashboard\Rental\RentalContract;
use App\Models\Interest;
use App\Models\OwnerAssociation\OwnerAssociation;
use App\Models\OwnerAssociation\OwnerAssociationRequest;
use App\Models\OwnerAssociation\OwnerAssociationRequestReply;
use App\Models\Property\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $admin   = Auth::guard('admin')->user();
        $isSales = $admin->type === 'sales';

        // Base query modifier for sales users
        $salesQuery = function ($query) use ($admin, $isSales) {
            if ($isSales) {
                return $query->where('admin_id', $admin->id)
                    ->orWhere('assigned_to', $admin->id)
                    ->orWhere('created_by', $admin->id);
            }
            return $query;
        };

        // =====================================
        // Statistics Cards
        // =====================================
        $stats = [
            // Clients Statistics
            'clients'            => [
                'total'          => $this->getClientsCount($admin, $isSales),
                'new_this_month' => $this->getNewClientsThisMonth($admin, $isSales),
                'active'         => $this->getActiveClientsCount($admin, $isSales),
                'with_deals'     => $this->getClientsWithDealsCount($admin, $isSales),
            ],

            // Deals Statistics
            'deals'              => [
                'total'       => $this->getDealsCount($admin, $isSales),
                'won'         => $this->getWonDealsCount($admin, $isSales),
                'lost'        => $this->getLostDealsCount($admin, $isSales),
                'in_progress' => $this->getInProgressDealsCount($admin, $isSales),
                'total_value' => $this->getTotalDealsValue($admin, $isSales),
                'won_value'   => $this->getWonDealsValue($admin, $isSales),
            ],

            // Properties Statistics
            'properties'         => [
                'total'     => $this->getPropertiesCount($admin, $isSales),
                'available' => $this->getAvailablePropertiesCount($admin, $isSales),
                'rented'    => $this->getRentedPropertiesCount($admin, $isSales),
                'sold'      => $this->getSoldPropertiesCount($admin, $isSales),
                'for_rent'  => $this->getPropertiesForRentCount($admin, $isSales),
                'for_sale'  => $this->getPropertiesForSaleCount($admin, $isSales),
            ],

            // Interests Statistics
            'interests'          => [
                'total'     => $this->getInterestsCount($admin, $isSales),
                'new'       => $this->getNewInterestsCount($admin, $isSales),
                'assigned'  => $this->getAssignedInterestsCount($admin, $isSales),
                'converted' => $this->getConvertedInterestsCount($admin, $isSales),
            ],

            // Owner Associations Statistics
            'owner_associations' => [
                'total'               => $this->getOwnerAssociationsCount($admin, $isSales),
                'total_units'         => $this->getTotalUnitsCount($admin, $isSales),
                'requests_pending'    => $this->getPendingRequestsCount($admin, $isSales),
                'requests_this_month' => $this->getRequestsThisMonthCount($admin, $isSales),
            ],

            // Rental Contracts Statistics
            'rental_contracts'   => [
                'total'         => $this->getRentalContractsCount($admin, $isSales),
                'active'        => $this->getActiveContractsCount($admin, $isSales),
                'expiring_soon' => $this->getExpiringContractsCount($admin, $isSales),
                'total_revenue' => $this->getTotalRevenueCount($admin, $isSales),
            ],

            // Follow-ups Statistics
            'follow_ups'         => [
                'pending'   => $this->getPendingFollowUpsCount($admin, $isSales),
                'overdue'   => $this->getOverdueFollowUpsCount($admin, $isSales),
                'today'     => $this->getTodayFollowUpsCount($admin, $isSales),
                'this_week' => $this->getThisWeekFollowUpsCount($admin, $isSales),
            ],
        ];

        // =====================================
        // Recent Data for Columns
        // =====================================

        // Latest Owner Association Requests
        $latestOARequests = OwnerAssociationRequest::query()
            ->with(['ownerAssociation:id,uuid,name', 'client:id,name,phone', 'unit:id,unit_number'])
            ->when($isSales, function ($query) use ($admin) {
                $query->whereHas('ownerAssociation', function ($q) use ($admin) {
                    $q->where('admin_id', $admin->id);
                });
            })
            ->latest()
            ->limit(10)
            ->get();

        // Latest Interests
        $latestInterests = Interest::query()
            ->with(['client:id,name,phone,avatar', 'property:id,uuid,main_image', 'assignedTo:id,full_name'])
            ->when($isSales, function ($query) use ($admin) {
                $query->where('assigned_to', $admin->id);
            })
            ->latest()
            ->limit(10)
            ->get();

        // Latest Deal Follow-ups (Upcoming)
        $latestFollowUps = DealFollowUp::query()
            ->with(['deal.client:id,name,phone', 'assignedAdmin:id,full_name'])
            ->when($isSales, function ($query) use ($admin) {
                $query->where('assigned_to', $admin->id);
            })
            ->where('status', 'pending')
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at', 'asc')
            ->limit(10)
            ->get();

        // Latest OA Request Replies
        $latestReplies = OwnerAssociationRequestReply::query()
            ->with([
                'request.ownerAssociation:id,name,uuid',
                'request.client:id,name',
                'replier',
            ])
            ->when($isSales, function ($query) use ($admin) {
                $query->whereHas('request.ownerAssociation', function ($q) use ($admin) {
                    $q->where('admin_id', $admin->id);
                });
            })
            ->latest()
            ->limit(10)
            ->get();

        // =====================================
        // Charts Data
        // =====================================

        // Deals by Status Chart
        $dealsByStatus = Deal::query()
            ->when($isSales, function ($query) use ($admin) {
                $query->where('assigned_to', $admin->id)
                    ->orWhere('created_by', $admin->id);
            })
            ->select(
                DB::raw('CASE
                    WHEN is_won = 1 THEN "won"
                    WHEN is_lost = 1 THEN "lost"
                    ELSE "in_progress"
                END as status'),
                DB::raw('count(*) as count')
            )
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Monthly Deals Trend (Last 6 months)
        $monthlyDeals = Deal::query()
            ->when($isSales, function ($query) use ($admin) {
                $query->where('assigned_to', $admin->id)
                    ->orWhere('created_by', $admin->id);
            })
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Properties by Purpose
        $propertiesByPurpose = Property::query()
            ->when($isSales, function ($query) use ($admin) {
                $query->where('admin_id', $admin->id);
            })
            ->whereNotNull('purpose')
            ->select('purpose', DB::raw('count(*) as count'))
            ->groupBy('purpose')
            ->pluck('count', 'purpose')
            ->toArray();

        return view('dashboard.home', compact(
            'stats',
            'latestOARequests',
            'latestInterests',
            'latestFollowUps',
            'latestReplies',
            'dealsByStatus',
            'monthlyDeals',
            'propertiesByPurpose',
            'isSales'
        ));
    }

    // =====================================
    // Helper Methods for Statistics
    // =====================================

    private function getClientsCount($admin, $isSales)
    {
        return Client::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->count();
    }

    private function getNewClientsThisMonth($admin, $isSales)
    {
        return Client::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    private function getActiveClientsCount($admin, $isSales)
    {
        return Client::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->where('status', 1)
            ->where('is_archived', false)
            ->count();
    }

    private function getClientsWithDealsCount($admin, $isSales)
    {
        return Client::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->has('deals')
            ->count();
    }

    private function getDealsCount($admin, $isSales)
    {
        return Deal::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->count();
    }

    private function getWonDealsCount($admin, $isSales)
    {
        return Deal::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->where('is_won', true)
            ->count();
    }

    private function getLostDealsCount($admin, $isSales)
    {
        return Deal::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->where('is_lost', true)
            ->count();
    }

    private function getInProgressDealsCount($admin, $isSales)
    {
        return Deal::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->where('is_won', false)
            ->where('is_lost', false)
            ->count();
    }

    private function getTotalDealsValue($admin, $isSales)
    {
        return Deal::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->sum('amount');
    }

    private function getWonDealsValue($admin, $isSales)
    {
        return Deal::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id)->orWhere('created_by', $admin->id))
            ->where('is_won', true)
            ->sum('amount');
    }

    private function getPropertiesCount($admin, $isSales)
    {
        return Property::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->count();
    }

    private function getAvailablePropertiesCount($admin, $isSales)
    {
        return Property::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->where('availability_status', 'available')
            ->count();
    }

    private function getRentedPropertiesCount($admin, $isSales)
    {
        return Property::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->where('availability_status', 'rented')
            ->count();
    }

    private function getSoldPropertiesCount($admin, $isSales)
    {
        return Property::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->where('availability_status', 'sold')
            ->count();
    }

    private function getPropertiesForRentCount($admin, $isSales)
    {
        return Property::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->where('purpose', 'rent')
            ->count();
    }

    private function getPropertiesForSaleCount($admin, $isSales)
    {
        return Property::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->where('purpose', 'buy')
            ->count();
    }

    private function getInterestsCount($admin, $isSales)
    {
        return Interest::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id))
            ->count();
    }

    private function getNewInterestsCount($admin, $isSales)
    {
        return Interest::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id))
            ->where('status', 'new')
            ->count();
    }

    private function getAssignedInterestsCount($admin, $isSales)
    {
        return Interest::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id))
            ->whereIn('status', ['assigned', 'contacted', 'in_progress'])
            ->count();
    }

    private function getConvertedInterestsCount($admin, $isSales)
    {
        return Interest::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id))
            ->where('status', 'converted')
            ->count();
    }

    private function getOwnerAssociationsCount($admin, $isSales)
    {
        return OwnerAssociation::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->count();
    }

    private function getTotalUnitsCount($admin, $isSales)
    {
        return DB::table('owner_association_units')
            ->when($isSales, function ($q) use ($admin) {
                $q->where('admin_id', $admin->id);
            })
            ->count();
    }

    private function getPendingRequestsCount($admin, $isSales)
    {
        return OwnerAssociationRequest::query()
            ->when($isSales, function ($q) use ($admin) {
                $q->whereHas('ownerAssociation', fn($query) => $query->where('admin_id', $admin->id));
            })
            ->where('status', 'pending')
            ->count();
    }

    private function getRequestsThisMonthCount($admin, $isSales)
    {
        return OwnerAssociationRequest::query()
            ->when($isSales, function ($q) use ($admin) {
                $q->whereHas('ownerAssociation', fn($query) => $query->where('admin_id', $admin->id));
            })
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    private function getRentalContractsCount($admin, $isSales)
    {
        return RentalContract::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->count();
    }

    private function getActiveContractsCount($admin, $isSales)
    {
        return RentalContract::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->where('status', 'active')
            ->count();
    }

    private function getExpiringContractsCount($admin, $isSales)
    {
        return RentalContract::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->where('status', 'active')
            ->whereBetween('end_date', [now(), now()->addDays(30)])
            ->count();
    }

    private function getTotalRevenueCount($admin, $isSales)
    {
        return RentalContract::query()
            ->when($isSales, fn($q) => $q->where('admin_id', $admin->id))
            ->where('status', 'active')
            ->sum('total_rent_amount');
    }

    private function getPendingFollowUpsCount($admin, $isSales)
    {
        return DealFollowUp::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id))
            ->where('status', 'pending')
            ->count();
    }

    private function getOverdueFollowUpsCount($admin, $isSales)
    {
        return DealFollowUp::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id))
            ->where('status', 'pending')
            ->where('scheduled_at', '<', now())
            ->count();
    }

    private function getTodayFollowUpsCount($admin, $isSales)
    {
        return DealFollowUp::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id))
            ->where('status', 'pending')
            ->whereDate('scheduled_at', today())
            ->count();
    }

    private function getThisWeekFollowUpsCount($admin, $isSales)
    {
        return DealFollowUp::query()
            ->when($isSales, fn($q) => $q->where('assigned_to', $admin->id))
            ->where('status', 'pending')
            ->whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
    }
}
