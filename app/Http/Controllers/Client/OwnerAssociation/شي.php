<?php
namespace App\Http\Controllers\Admin\OwnerAssociation;

use App\Helpers\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Admin\Admin;
use App\Models\OwnerAssociation\OwnerAssociation;
use App\Models\OwnerAssociation\OwnerAssociationRequest;
use App\Models\OwnerAssociation\OwnerAssociationRequestAttachment;

class OwnerAssociationRequestController extends Controller
{
    /**
     * عرض كل الطلبات
     */
    public function index(Request $request)
    {
        $query = OwnerAssociationRequest::with([
            'ownerAssociation:id,name',
            'unit:id,unit_number',
            'client:id,name,phone',
            'assignedAdmin:id,name',
        ]);

        // فلترة حسب الاتحاد
        if ($request->filled('owner_association_id')) {
            $query->where('owner_association_id', $request->owner_association_id);
        }

        // فلترة حسب النوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب الموظف المكلف
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // بحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $requests = $query->latest()->paginate(20);

        // للفلاتر
        $ownerAssociations = OwnerAssociation::select('id', 'name')->get();
        $admins            = Admin::select('id', 'name')->get();

        return view('admin.owner-associations.requests.index', compact(
            'requests',
            'ownerAssociations',
            'admins'
        ));
    }

    /**
     * عرض تفاصيل الطلب
     */
    public function show($uuid)
    {
        $request = OwnerAssociationRequest::with([
            'ownerAssociation:id,name',
            'unit:id,unit_number,property_type_id',
            'unit.propertyType:id,name',
            'client:id,name,phone,email',
            'assignedAdmin:id,name',
            'attachments',
            'replies.replier',
        ])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // جلب الموظفين للإسناد
        $admins = Admin::select('id', 'name')->get();

        return view('admin.owner-associations.requests.show', compact('request', 'admins'));
    }

    /**
     * تحديث حالة الطلب
     */
    public function updateStatus(Request $request, $uuid)
    {
        $validated = $request->validate([
            'status'           => 'required|in:pending,under_review,in_progress,completed,closed,rejected,cancelled',
            'admin_notes'      => 'nullable|string|max:1000',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:1000',
        ], [
            'status.required'              => 'الحالة مطلوبة',
            'rejection_reason.required_if' => 'سبب الرفض مطلوب',
        ]);

        $ownerAssociationRequest = OwnerAssociationRequest::where('uuid', $uuid)->firstOrFail();

        $oldStatus = $ownerAssociationRequest->status;

        DB::beginTransaction();

        try {
            // تحديث الحالة
            $updateData = [
                'status' => $validated['status'],
            ];

            if ($request->filled('admin_notes')) {
                $updateData['admin_notes'] = $validated['admin_notes'];
            }

            if ($validated['status'] === 'rejected' && $request->filled('rejection_reason')) {
                $updateData['rejection_reason'] = $validated['rejection_reason'];
            }

            // تحديث التواريخ
            if ($validated['status'] === 'under_review' && ! $ownerAssociationRequest->reviewed_at) {
                $updateData['reviewed_at'] = now();
            }

            if ($validated['status'] === 'completed' && ! $ownerAssociationRequest->completed_at) {
                $updateData['completed_at'] = now();
            }

            if (in_array($validated['status'], ['closed', 'rejected', 'cancelled']) && ! $ownerAssociationRequest->closed_at) {
                $updateData['closed_at'] = now();
            }

            $ownerAssociationRequest->update($updateData);

            // إضافة رد تلقائي لتغيير الحالة
            if ($oldStatus !== $validated['status']) {
                $statusChangeMessage = "تم تغيير الحالة من \"{$ownerAssociationRequest->getOriginal('status')}\" إلى \"{$validated['status']}\"";

                if ($validated['status'] === 'rejected' && $request->filled('rejection_reason')) {
                    $statusChangeMessage .= "\n\nسبب الرفض: " . $validated['rejection_reason'];
                }

                $ownerAssociationRequest->replies()->create([
                    'replier_type' => Admin::class,
                    'replier_id'   => auth('admin')->id(),
                    'message'      => $statusChangeMessage,
                    'type'         => 'status_change',
                    'is_internal'  => false,
                ]);
            }

            DB::commit();

            return back()->with('success', 'تم تحديث حالة الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * إسناد الطلب لموظف
     */
    public function assign(Request $request, $uuid)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:admins,id',
        ], [
            'assigned_to.required' => 'يجب اختيار موظف',
        ]);

        $ownerAssociationRequest = OwnerAssociationRequest::where('uuid', $uuid)->firstOrFail();

        $oldAssignee = $ownerAssociationRequest->assigned_to;

        $ownerAssociationRequest->update([
            'assigned_to' => $validated['assigned_to'],
        ]);

        // إضافة رد تلقائي
        $admin   = Admin::find($validated['assigned_to']);
        $message = $oldAssignee
            ? "تم تغيير الموظف المكلف إلى: {$admin->name}"
            : "تم إسناد الطلب إلى: {$admin->name}";

        $ownerAssociationRequest->replies()->create([
            'replier_type' => Admin::class,
            'replier_id'   => auth('admin')->id(),
            'message'      => $message,
            'type'         => 'update',
            'is_internal'  => false,
        ]);

        return back()->with('success', 'تم إسناد الطلب بنجاح');
    }

    /**
     * إضافة رد من الإدارة
     */
    public function addReply(Request $request, $uuid)
    {
        $validated = $request->validate([
            'message'       => 'required|string|max:2000',
            'is_internal'   => 'nullable|boolean',
            'attachments'   => 'nullable|array|max:3',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'message.required' => 'الرسالة مطلوبة',
        ]);

        $ownerAssociationRequest = OwnerAssociationRequest::where('uuid', $uuid)->firstOrFail();

        DB::beginTransaction();

        try {
            // إضافة الرد
            $reply = $ownerAssociationRequest->replies()->create([
                'replier_type' => Admin::class,
                'replier_id'   => auth('admin')->id(),
                'message'      => $validated['message'],
                'type'         => 'comment',
                'is_internal'  => $request->boolean('is_internal', false),
            ]);

            // رفع المرفقات لو موجودة
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // استخدام File Class
                    $fileName = File::upload('attachments', [
                        'path' => 'owner-associations/requests/' . $ownerAssociationRequest->id . '/replies',
                        'hash' => true,
                    ]);

                    if ($fileName) {
                        OwnerAssociationRequestAttachment::create([
                            'request_id' => $ownerAssociationRequest->id,
                            'file_name'  => $file->getClientOriginalName(),
                            'file_path'  => 'owner-associations/requests/' . $ownerAssociationRequest->id . '/replies/' . $fileName,
                            'file_type'  => $file->extension(),
                            'file_size'  => round($file->getSize() / 1024, 2),
                            'mime_type'  => $file->getMimeType(),
                        ]);
                    }
                }
            }

            DB::commit();

            return back()->with('success', 'تم إضافة الرد بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف الطلب
     */
    public function destroy($uuid)
    {
        $request = OwnerAssociationRequest::where('uuid', $uuid)->firstOrFail();

        // حذف المرفقات من السيرفر
        foreach ($request->attachments as $attachment) {
            File::delete(
                'owner-associations/requests/' . $request->id,
                basename($attachment->file_path)
            );
        }

        $request->delete();

        return redirect()
            ->route('admin.owner-associations.requests.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }

    /**
     * تحديث الأولوية
     */
    public function updatePriority(Request $request, $uuid)
    {
        $validated = $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $ownerAssociationRequest = OwnerAssociationRequest::where('uuid', $uuid)->firstOrFail();

        $ownerAssociationRequest->update([
            'priority' => $validated['priority'],
        ]);

        return back()->with('success', 'تم تحديث الأولوية بنجاح');
    }

    /**
     * إحصائيات الطلبات
     */
    public function statistics()
    {
        $stats = [
            'total'       => OwnerAssociationRequest::count(),
            'pending'     => OwnerAssociationRequest::where('status', 'pending')->count(),
            'in_progress' => OwnerAssociationRequest::where('status', 'in_progress')->count(),
            'completed'   => OwnerAssociationRequest::where('status', 'completed')->count(),
            'by_type'     => OwnerAssociationRequest::selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->get(),
            'by_priority' => OwnerAssociationRequest::selectRaw('priority, count(*) as count')
                ->groupBy('priority')
                ->get(),
        ];

        return view('admin.owner-associations.requests.statistics', compact('stats'));
    }
}
