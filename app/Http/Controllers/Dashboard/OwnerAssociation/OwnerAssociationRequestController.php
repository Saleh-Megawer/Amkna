<?php
namespace App\Http\Controllers\Dashboard\OwnerAssociation;

use App\Enums\OwnerAssociation\RequestPriority;
use App\Enums\OwnerAssociation\RequestStatus;
use App\Enums\OwnerAssociation\RequestType;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Admin\Admin;
use App\Models\OwnerAssociation\OwnerAssociation;
use App\Models\OwnerAssociation\OwnerAssociationRequest;
use App\Models\OwnerAssociation\OwnerAssociationRequestReply;
use App\Traits\OwnerAssociations\HasOwnerAssociationsTabs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OwnerAssociationRequestController extends Controller
{

    use HasOwnerAssociationsTabs;

    public function __construct()
    {
        $this->bootTabs();
    }

    public function index(Request $request, OwnerAssociation $ownerAssociation)
    {

        $query = $ownerAssociation->requests()
            ->with(['client', 'unit.propertyType'])
            ->withCount(['attachments', 'replies']);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $requests = $query->paginate(20)->withQueryString();

        // Stats
        $priorityCards = collect(RequestPriority::cases())->map(function ($priority) use ($ownerAssociation) {
            $colorClass = explode(' ', $priority->color())[0];
            $color      = str_replace('bg-', '', $colorClass);

            return [
                'label' => $priority->label(),
                'count' => $ownerAssociation->requests()->where('priority', $priority->value)->count(),
                'color' => $color,
                'icon'  => $priority->icon(),
            ];
        });

        $stats = [
            'total'         => $ownerAssociation->requests()->count(),
            'priorityCards' => $priorityCards,
        ];

        // Filter Options للـ Blade
        $filterOptions = [
            'statuses'   => collect(RequestStatus::cases())->map(fn($s) => [
                'value' => $s->value,
                'label' => $s->label(),
            ]),
            'types'      => collect(RequestType::cases())->map(fn($t) => [
                'value' => $t->value,
                'label' => $t->label(),
            ]),
            'priorities' => collect(RequestPriority::cases())->map(fn($p) => [
                'value' => $p->value,
                'label' => $p->label(),
            ]),
        ];

        return view('dashboard.owner-associations.requests.index', [
            'ownerAssociation' => $ownerAssociation,
            'requests'         => $requests,
            'stats'            => $stats,
            'filterOptions'    => $filterOptions,
        ]);
    }

    public function allRequests()
    {

        // Build query
        $query = OwnerAssociationRequest::with([
            'client',
            'unit.propertyType',
            'ownerAssociation',
        ]);

        // Filter by status if provided
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Filter by type if provided
        if (request('type')) {
            $query->where('type', request('type'));
        }

        // Filter by priority if provided
        if (request('priority')) {
            $query->where('priority', request('priority'));
        }

        // Date filters
        if (request('date-from')) {
            $query->whereDate('created_at', '>=', request('date-from'));
        }

        if (request('date-to')) {
            $query->whereDate('created_at', '<=', request('date-to'));
        }

        // Search
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Sort order
        $sortOrder = request('sort-order', 'desc');
        $query->orderBy('created_at', $sortOrder);

        // Build statistics query

        if (isSalesAdmin()) {
            $query->where('assigned_to', adminId());
        }

        // Latest first
        $rows = $query->latest()->paginate(50);

        // Statistics - الأسرع!
        $total = OwnerAssociationRequest::selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "under_review" THEN 1 ELSE 0 END) as under_review,
                SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = "closed" THEN 1 ELSE 0 END) as closed,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled')
            ->first();

        $stats = [
            'total'        => $total->total,
            'pending'      => $total->pending,
            'under_review' => $total->under_review,
            'in_progress'  => $total->in_progress,
            'completed'    => $total->completed,
            'closed'       => $total->closed,
            'rejected'     => $total->rejected,
            'cancelled'    => $total->cancelled,
        ];

        // Get all statuses and types from Enums
        $statuses   = RequestStatus::cases();
        $types      = RequestType::cases();
        $priorities = RequestPriority::cases();

        return view('dashboard.owner-associations.requests.all', compact('rows', 'stats', 'statuses', 'types', 'priorities'));
    }

    public function edit(OwnerAssociation $ownerAssociation, $requestId)
    {

        $request = $ownerAssociation->requests()->findOrFail($requestId);

        $unitInfo = null;

        if ($request->unit) {
            $unitInfo = 'وحدة #' . $request->unit->unit_number;
            if ($request->unit->propertyType) {
                $unitInfo .= ' - ' . $request->unit->propertyType->name;
            }
        }

        return response()->json([
            'id'             => $request->id,
            'title'          => $request->title,
            'description'    => $request->description,

            'type_icon'      => $request->type->icon(),
            'type_label'     => $request->type->label(),

            'priority_label' => $request->priority->label(),
            'priority_color' => $request->priority->color(),

            'status_label'   => $request->status->label(),
            'status_color'   => $request->status->color(),

            'client_name'    => $request->client->name,
            'unit_info'      => $unitInfo,

            'admin_notes'    => $request->admin_notes,
            'created_at'     => $request->created_at->format('Y-m-d H:i'),
        ]);
    }

    public function updateStatus(Request $request, OwnerAssociation $ownerAssociation, $requestId)
    {
        $ownerRequest = $ownerAssociation->requests()->findOrFail($requestId);

        $data = $request->validate([
            'status'      => 'required|in:' . implode(',', array_column(RequestStatus::cases(), 'value')),
            'admin_notes' => 'nullable|string',
        ]);

        // Update status
        $ownerRequest->status = $data['status'];

        // Update admin notes if provided
        if ($request->filled('admin_notes')) {
            $ownerRequest->admin_notes = $data['admin_notes'];
        }

        // Update timestamps based on status
        if ($data['status'] === 'under_review' && ! $ownerRequest->reviewed_at) {
            $ownerRequest->reviewed_at = now();
        }

        if ($data['status'] === 'completed' && ! $ownerRequest->completed_at) {
            $ownerRequest->completed_at = now();
        }

        if ($data['status'] === 'closed' && ! $ownerRequest->closed_at) {
            $ownerRequest->closed_at = now();
        }

        $ownerRequest->save();

        return Response::success('تم تحديث حالة الطلب بنجاح', [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 1.5,
        ]);
    }

    public function destroy(Request $httpRequest, OwnerAssociation $ownerAssociation, $requestId)
    {

        $request = $ownerAssociation->requests()->findOrFail($requestId);

        // Delete whole request folder with all files
        Storage::deleteDirectory('owner-associations/requests/' . $requestId);

        Storage::disk('public')->deleteDirectory('large/owner-associations/requests/' . $requestId);
        Storage::disk('public')->deleteDirectory('small/owner-associations/requests/' . $requestId);

        // Delete attachments records (optional but recommended)
        $request->attachments()->delete();

        // Delete request
        $request->delete();

        if ($httpRequest->expectsJson()) {
            return Response::success('تم حذف الطلب وجميع البيانات المرتبطة به بنجاح.', [
                'style' => 'toastr',
            ]);
        }

        Response::success('تم حذف الطلب وجميع البيانات المرتبطة به بنجاح.', [
            'json' => false,
        ]);
        return redirect()->route('owner-associations.requests.index', $ownerAssociation);
    }

    /**
     * Assign deals to another admin.
     */
    public function assign(Request $request, OwnerAssociation $ownerAssociation, $requestId)
    {

        $ownerRequest = $ownerAssociation->requests()->findOrFail($requestId);

        $request->validate([
            'assigned_to' => 'required|exists:admins,id',
        ]);

        $ownerRequest->update([
            'assigned_to' => $request->assigned_to,
        ]);

        return Response::success('تم تكليف الموظف ليعمل الطلب', ['style' => 'toastr']);
    }
    /**
     * Update the specified owner association.
     */
    public function update(Request $request, OwnerAssociation $ownerAssociation)
    {

    }

    public function show(OwnerAssociation $ownerAssociation, $requestId)
    {
        $request = OwnerAssociationRequest::with([
            'client',
            'unit.propertyType',
            'attachments',
            'replies' => function ($query) {
                $query->with('replier')->latest(); // ← ضيف latest() هنا
            },
            'assignedAdmin',
        ])->findOrFail($requestId);

        // تأكد إن الطلب تابع للجمعية
        abort_if($request->owner_association_id !== $ownerAssociation->id, 404);

        return view('dashboard.owner-associations.requests.show', compact('ownerAssociation', 'request'));
    }

    ///////////////////////////////
    ///////////////////////////////
    ///////////////////////////////
    ///////////////////////////////
    ///////////////////////////////
    ///////////////////////////////

    public function storeReply(Request $request, OwnerAssociation $ownerAssociation, $requestId)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $ownerRequest = OwnerAssociationRequest::findOrFail($requestId);

        // تأكد إن الطلب تابع للجمعية
        abort_if($ownerRequest->owner_association_id !== $ownerAssociation->id, 404);

        // إنشاء الرد
        $reply = $ownerRequest->replies()->create([
            'message'      => $validated['message'],
            'replier_type' => Admin::class,
            'replier_id'   => auth()->id(),
            'type'         => 'comment',
            'is_internal'  => false,
        ]);

        $replies = $ownerRequest->replies()->with('replier')->latest()->get();

        // Render الـ partial
        // Render الـ partial
        $html = view('dashboard.owner-associations.requests.partials._replies-list', [
            'replies'          => $replies,
            'ownerAssociation' => $ownerAssociation,
            'request'          => $ownerRequest,
        ])->render();

        return response()->json([
            'success'       => true,
            'message'       => 'تم إضافة الرد بنجاح',
            'html'          => $html,
            'replies_count' => $replies->count(),
        ]);
    }

    public function destroyReply(OwnerAssociation $ownerAssociation, $requestId, $replyId)
    {
        $ownerRequest = OwnerAssociationRequest::findOrFail($requestId);

        // تأكد إن الطلب تابع للجمعية
        abort_if($ownerRequest->owner_association_id !== $ownerAssociation->id, 404);

        $reply = OwnerAssociationRequestReply::findOrFail($replyId);

        // تأكد إن الرد تابع للطلب
        abort_if($reply->request_id !== $ownerRequest->id, 404);

        // تحقق من الصلاحية
        if (! $reply->canBeDeleted()) {
            return Response::error('لا يمكن حذف هذا الرد', ['style' => 'toastr']);

        }

        $reply->delete();

        return Response::success('تم حذف الرسالة بنجاح', ['style' => 'toastr']);

    }

    ///////////////////////////////
    ///////////////////////////////
    ///////////////////////////////
    ///////////////////////////////
    ///////////////////////////////
    ///////////////////////////////

    /**
     * التحقق من إثبات السداد أو رفضه
     */
    public function verifyPayment(Request $request, OwnerAssociation $ownerAssociation, $requestId)
    {
        $ownerRequest = $ownerAssociation->requests()
            ->where('type', 'subscription_payment')
            ->findOrFail($requestId);

        $data = $request->validate([
            'status'            => ['required', 'in:verified,rejected'],
            'paid_amount'       => ['required_if:status,verified', 'nullable', 'numeric', 'min:0'],
            'subscription_from' => ['required_if:status,verified', 'nullable', 'date'],
            'subscription_to'   => ['required_if:status,verified', 'nullable', 'date', 'after_or_equal:subscription_from'],
            'notes'             => ['nullable', 'string'],
            'rejection_reason'  => ['required_if:status,rejected', 'nullable', 'string'],
        ]);

        DB::transaction(function () use ($ownerRequest, $data) {

            if ($data['status'] === 'verified') {

                $ownerRequest->payment()->updateOrCreate(
                    ['request_id' => $ownerRequest->id],
                    [
                        'status'            => 'verified',
                        'paid_amount'       => $data['paid_amount'],
                        'subscription_from' => $data['subscription_from'],
                        'subscription_to'   => $data['subscription_to'],
                        'rejection_reason'  => null,
                        'verified_by'       => auth('admin')->id(),
                        'verified_at'       => now(),
                    ]
                );

                $ownerRequest->status       = 'completed';
                $ownerRequest->completed_at = $ownerRequest->completed_at ?? now();
                $ownerRequest->updated_at   = now();

                if (isset($data['admin_notes'])) {
                    $ownerRequest->admin_notes = $data['admin_notes'];
                }

            } else {

                $ownerRequest->payment()->updateOrCreate(
                    ['request_id' => $ownerRequest->id],
                    [
                        'status'            => 'rejected',
                        'rejection_reason'  => $data['rejection_reason'],
                        'paid_amount'       => null,
                        'subscription_from' => null,
                        'subscription_to'   => null,
                        'verified_by'       => auth('admin')->id(),
                        'verified_at'       => now(),
                    ]
                );

                $ownerRequest->status     = 'rejected';
                $ownerRequest->updated_at = now();

            }

            $ownerRequest->save();

        });

        return Response::success('تم تحديث حالة الطلب بنجاح', [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 1.5,
        ]);
    }

    // public function destroyReply(OwnerAssociation $ownerAssociation, $requestId, $replyId)
    // {
    //     $ownerRequest = OwnerAssociationRequest::findOrFail($requestId);

    //     // تأكد إن الطلب تابع للجمعية
    //     abort_if($ownerRequest->owner_association_id !== $ownerAssociation->id, 404);

    //     $reply = OwnerAssociationRequestReply::findOrFail($replyId);

    //     // تأكد إن الرد تابع للطلب
    //     abort_if($reply->request_id !== $ownerRequest->id, 404);

    //     // تحقق من الصلاحية
    //     if (! $reply->canBeDeleted()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'لا يمكن حذف هذا الرد',
    //         ], 403);
    //     }

    //     $reply->delete();

    //     // إعادة تحميل الردود
    //     $replies = $ownerRequest->replies()->with('replier')->latest()->get();

    //     // Render الـ partial
    //     $html = view('owner-associations.requests.partials._replies-list', compact('replies'))->render();

    //     return response()->json([
    //         'success'       => true,
    //         'message'       => 'تم حذف الرد بنجاح',
    //         'html'          => $html,
    //         'replies_count' => $replies->count(),
    //     ]);
    // }

}
