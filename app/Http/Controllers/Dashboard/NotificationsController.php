<?php
namespace App\Http\Controllers\Dashboard;

use App\Enums\Deal\DealFollowUpStatus;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Crm\Deal\DealFollowUp;
use App\Models\Interest;
use App\Models\OwnerAssociation\OwnerAssociationRequest;

class NotificationsController extends Controller
{

    public function __construct()
    {

    }

    public function notificationsCount()
    {
        return response()->json([
            'interests'        => $this->getUnreadInterestsCount(),
            'owner_requests'   => $this->getUnreadOwnerRequestsCount(),
            'deals_follow_ups' => $this->getTodayFollowUpsCount(),
        ]);
    }

    private function getUnreadOwnerRequestsCount()
    {
        $query = OwnerAssociationRequest::where('status', 'pending');

        if (isSalesAdmin()) {
            $query->where('assigned_to', adminId());
        }

        $count = $query->count();

        return [
            'count'   => $count,
            'has_new' => $count > 0,
        ];
    }

    private function getUnreadInterestsCount()
    {
        $adminId   = adminId();
        $adminType = adminAuth('type');

        $query = Interest::where('is_read', 0);
        //  ->where('created_at', '>=', now()->subMinutes(30));

        if ($adminType === 'sales') {
            $query->where('assigned_to', $adminId);
        }

        $count = $query->count();

        return [
            'count'   => $count,
            'has_new' => $count > 0,
        ];
    }

    private function getTodayFollowUpsCount()
    {
        $adminId   = adminId();
        $adminType = adminAuth('type');

        $query = DealFollowUp::where('status', DealFollowUpStatus::PENDING->value)
            ->whereDate('scheduled_at', today());

        if ($adminType === 'sales') {
            $query->where('assigned_to', $adminId);
        }

        $count = $query->count();

        return [
            'count'   => $count,
            'has_new' => $count > 0,
        ];
    }

}
