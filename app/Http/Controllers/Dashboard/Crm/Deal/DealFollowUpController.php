<?php
namespace App\Http\Controllers\Dashboard\Crm\Deal;

use App\Enums\Deal\DealFollowUpPriority;
use App\Enums\Deal\DealFollowUpStatus;
use App\Enums\Deal\DealFollowUpType;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Dashboard\Crm\Deal\DealFollowUp;
use App\Traits\Deal\HandlesDealData;
use App\Traits\Deal\HasDealTabs;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DealFollowUpController extends Controller
{

    use HasDealTabs, HandlesDealData;

    public function __construct()
    {
        $this->bootTabs();
        $this->bootSharedData();

        $this->middleware(['permission:deals_view_followups'], ['only' => 'index']);
    }

    public function index(Request $request)
    {
        $query = DealFollowUp::with(['deal.client', 'assignedAdmin', 'creator'])
            ->latest('scheduled_at');

        // Filter: Date Range
        if ($request->filled('date_from')) {
            $query->whereDate('scheduled_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('scheduled_at', '<=', $request->date_to);
        }

        // Filter: Assigned To
        if ($request->filled('assigned-to')) {
            $query->where('assigned_to', $request->input('assigned-to'));
        }

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter: Priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter: Client
        if ($request->filled('client')) {
            $query->whereHas('deal', function ($q) use ($request) {
                $q->where('client_id', $request->client);
            });
        }

        // Sorting
        $sortOrder = $request->input('sort-order', 'desc');
        $query->orderBy('scheduled_at', $sortOrder);

        $followUps = $query->paginate(50);

        // Statistics - Optimized with Single Query
        $stats = DealFollowUp::selectRaw("
    COUNT(*) as total,
    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as cancelled,
    SUM(CASE WHEN DATE(scheduled_at) = CURDATE() THEN 1 ELSE 0 END) as today,
    SUM(CASE WHEN status = ? AND scheduled_at < NOW() THEN 1 ELSE 0 END) as overdue
", [
            DealFollowUpStatus::PENDING->value,
            DealFollowUpStatus::COMPLETED->value,
            DealFollowUpStatus::CANCELLED->value,
            DealFollowUpStatus::PENDING->value,
        ])->first()->toArray();

        // Get admins for filter
        $admins = [];
        if (adminAuth('type') !== 'sales') {
            $admins = Admin::typeSales()->isActive()->get();
        }

        return view('dashboard.crm.deals.all-follow-ups', compact('followUps', 'stats', 'admins'));
    }

    public function store(Request $request, Deal $deal)
    {
        $data = $request->validate([
            'follow_up_type' => ['required', 'string', 'in:' . implode(',', DealFollowUpType::values())],
            'scheduled_at'   => ['required', 'date', 'after:now'],
            'priority'       => ['required', 'string', 'in:' . implode(',', DealFollowUpPriority::values())],
            'assigned_to'    => ['nullable', 'exists:admins,id'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ], [
            'follow_up_type.required' => 'نوع المتابعة مطلوب',
            'follow_up_type.in'       => 'نوع المتابعة غير صحيح',
            'scheduled_at.required'   => 'موعد المتابعة مطلوب',
            'scheduled_at.date'       => 'موعد المتابعة غير صحيح',
            'scheduled_at.after'      => 'موعد المتابعة يجب أن يكون في المستقبل',
            'priority.required'       => 'الأولوية مطلوبة',
            'priority.in'             => 'الأولوية غير صحيحة',
            'assigned_to.exists'      => 'الموظف المحدد غير موجود',
            'notes.max'               => 'الملاحظات لا يمكن أن تتجاوز 1000 حرف',
        ]);

        $data['deal_id']     = $deal->id;
        $data['status']      = DealFollowUpStatus::PENDING->value;
        $data['created_by']  = adminId();
        $data['assigned_to'] = $data['assigned_to'] ?? adminId();

        DealFollowUp::create($data);

        return Response::success('تم إضافة المتابعة بنجاح', [
            'style'  => 'toastr',
            'reload' => true,
        ]);
    }

    public function update(Request $request, Deal $deal, DealFollowUp $followUp)
    {
        $data = $request->validate([
            'follow_up_type' => ['required', 'string', 'in:' . implode(',', DealFollowUpType::values())],
            'scheduled_at'   => ['required', 'date', 'after:now'],
            'priority'       => ['required', 'string', 'in:' . implode(',', DealFollowUpPriority::values())],
            'assigned_to'    => ['nullable', 'exists:admins,id'],
            'notes'          => ['nullable', 'string', 'max:1000'],
            'status'         => ['nullable', 'string', 'in:' . implode(',', DealFollowUpStatus::values())],
        ], [
            'follow_up_type.required' => 'نوع المتابعة مطلوب',
            'follow_up_type.in'       => 'نوع المتابعة غير صحيح',
            'scheduled_at.required'   => 'موعد المتابعة مطلوب',
            'scheduled_at.date'       => 'موعد المتابعة غير صحيح',
            'priority.required'       => 'الأولوية مطلوبة',
            'priority.in'             => 'الأولوية غير صحيحة',
            'assigned_to.exists'      => 'الموظف المحدد غير موجود',
            'notes.max'               => 'الملاحظات لا يمكن أن تتجاوز 1000 حرف',
            'status.in'               => 'الحالة غير صحيحة',
        ]);

        $followUp->update($data);

        return Response::success('تم تحديث المتابعة بنجاح', [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 1.5,

        ]);
    }

    public function show(Deal $deal, DealFollowUp $followUp)
    {
        $followUp->load('deal:id,uuid');

        $html = view('dashboard.crm.deals.modals.edit-followup', compact('followUp'))->render();

        return response()->json([
            'status' => 'success',
            'html'   => $html,
        ]);
    }

    public function markCompleted(Deal $deal, DealFollowUp $followUp)
    {
        $followUp->update([
            'status'       => DealFollowUpStatus::COMPLETED->value,
            'completed_at' => Carbon::now(),
        ]);

        Response::success('تم تحديد المتابعة #' . $followUp->id . ' كـ "تم" بنجاح', [
            'json' => false,
        ]);

        return back();
    }

    public function destroy(Deal $deal, DealFollowUp $followUp)
    {
        $followUp->delete();

        return Response::success('تم حذف المتابعة بنجاح', [
            'style' => 'toastr',
        ]);
    }
}
