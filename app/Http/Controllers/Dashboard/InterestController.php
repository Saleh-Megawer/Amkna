<?php
namespace App\Http\Controllers\Dashboard;

use App\Enums\Interest\InterestStatus;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    /**
     * Register permissions middleware.
     */
    public function __construct()
    {

        $this->middleware('permission:interests_view_details')->only('details');

      //  $this->middleware('permission:interests_add_deal')->only('storeDeal');

        $this->middleware('permission:interests_update_deal_status')->only('updateStatus');

        $this->middleware('permission:interests_change_assigned_user')->only('assign');
    }

    /**
     * Display interests list with statistics.
     */
    public function index(Request $request)
    {

        /**
         * Permission
         */
        if (! isSalesAdmin()) {
            if (! canPermission('interests_view_page')) {
                return abort(403);
            }
        }

        $pageTitle = isSalesAdmin()
            ? 'اهتمامات عملائي'
            : 'اهتمامات العملاء';

        $admins = [];

        // Load sales admins for assignment dropdown
        if (adminAuth('type') !== 'sales') {
            $admins = getActiveAvailableSalesAdmins();
        }

        // Load interests with relations and filters
        $rows = Interest::with(['client', 'assignedTo', 'deal'])
            ->when(isSalesAdmin(), function ($query) {
                $query->where('assigned_to', adminId());
            })
            ->filter($request->all())
            ->paginate(20);

        // Build statistics query
        $statsQuery = Interest::query();

        if (isSalesAdmin()) {
            $statsQuery->where('assigned_to', adminId());
        }

        $stats = $statsQuery->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as contacted,
            SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as assigned,
            SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as in_progress,
            SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as converted,
            SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as closed
        ", [
            InterestStatus::CONTACTED->value,
            InterestStatus::ASSIGNED->value,
            InterestStatus::IN_PROGRESS->value,
            InterestStatus::CONVERTED->value,
            InterestStatus::CLOSED->value,
        ])->first();

        $stats = (object) ($stats ?? [
            'total'       => 0,
            'contacted'   => 0,
            'assigned'    => 0,
            'in_progress' => 0,
            'converted'   => 0,
            'closed'      => 0,
        ]);

        return view('dashboard.interest.index', compact(
            'rows',
            'admins',
            'stats',
            'pageTitle'
        ));
    }

    /**
     * Update interest status.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'interest_id' => 'required|exists:interests,id',
            'status'      => 'required|in:assigned,contacted,in_progress,converted,not_interested,closed',
        ]);

        $interest = Interest::findOrFail($request->interest_id);

        // Prevent sales admin from modifying others interests
        if (isSalesAdmin() && $interest->assigned_to !== adminId()) {
            return Response::error('غير مصرح لك بتحديث هذا الاهتمام', ['style' => 'toastr']);
        }

        $interest->update([
            'status'  => $request->status,
            'is_read' => 1,
        ]);

        $buttonHtml      = view('dashboard.interest.partials._status-button', compact('interest'))->render();
        $statusBadgeHtml = view('dashboard.interest.partials._status-badge', compact('interest'))->render();

        return Response::success('تم تحديث الحالة بنجاح', [
            'style' => 'toastr',
            'data'  => [
                'is_closed'       => $interest->isClosed(),
                'buttonHtml'      => $buttonHtml,
                'statusBadgeHtml' => $statusBadgeHtml,
            ],
        ]);
    }

    /**
     * Create a deal from interest.
     */
    public function storeDeal(Request $request)
    {
        $request->validate([
            'purpose'          => 'required|in:rent,buy',
            'property_type_id' => 'required|exists:property_types,id',
        ]);

        $client = Client::where('uuid', $request->client_uuid)->first();

        if (! $client) {
            return Response::error('العميل غير موجود', ['style' => 'toastr']);
        }

        $interest = Interest::where('uuid', $request->interest_uuid)->first();

        if (! $interest) {
            return Response::error('سجل الاهتمام غير موجود', ['style' => 'toastr']);
        }

        if ($interest->client_id !== $client->id) {
            return Response::error('الاهتمام غير مرتبط بهذا العميل', ['style' => 'toastr']);
        }

        // Security check for sales admin
        if (isSalesAdmin() && $interest->assigned_to !== adminId()) {
            return Response::error('غير مصرح لك بإنشاء صفقة لهذا الاهتمام', ['style' => 'toastr']);
        }

        $interest->update([
            'status' => InterestStatus::CONVERTED,
        ]);

        $deal = Deal::create([
            'purpose'          => $request->purpose,
            'property_type_id' => $request->property_type_id,
            'client_id'        => $client->id,
            'interest_id'      => $interest->id,
            'created_by'       => adminId(),
            'assigned_to'      => adminId(),
        ]);

        if ($interest->property_id) {
            $deal->properties()->attach($interest->property_id);
        }

        return Response::success('تم الإضافة بنجاح، جاري التحويل...', [
            'style'    => 'toastr',
            'reset'    => true,
            'redirect' => route('crm.deals.edit', $deal->uuid),
            'time_out' => 2,
        ]);
    }

    /**
     * Assign interest to another admin.
     */
    public function assign(Request $request, Interest $interest)
    {
        $request->validate([
            'assigned_to' => 'required|exists:admins,id',
        ]);

        $interest->update([
            'assigned_to' => $request->assigned_to,
            'assigned_at' => now(),
        ]);

        return Response::success('تم تكليف الموظف بنجاح', ['style' => 'toastr']);
    }

    /**
     * Show interest details modal.
     */
    public function details(Interest $interest)
    {
        if (isSalesAdmin() && $interest->assigned_to !== adminId()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'غير مصرح لك بعرض هذا الاهتمام',
            ], 403);
        }

        $interest->load([
            'client',
            'assignedTo',
            'deal',
            'activities' => fn($q) => $q->latest()->with('causer'),
        ]);

        // Collect admins involved in assignment history
        $adminIds = $interest->activities
            ->flatMap(function ($activity) {
                $props = $activity->properties;
                return array_filter([
                    $props['old']['assigned_to'] ?? null,
                    $props['attributes']['assigned_to'] ?? null,
                ]);
            })
            ->unique();

        $admins = Admin::whereIn('id', $adminIds)->get()->keyBy('id');

        // Map statuses for UI badges
        $statuses = collect(InterestStatus::cases())->mapWithKeys(fn($status) => [
            $status->value => [
                'label' => $status->label(),
                'color' => $status->badgeClass(),
            ],
        ]);

        if (! $interest->is_read) {
            $interest->update(['is_read' => 1]);
        }

        $html = view(
            'dashboard.interest.partials._details-modal',
            compact('interest', 'admins', 'statuses')
        )->render();

        return response()->json([
            'status' => 'success',
            'html'   => $html,
        ]);
    }
}
