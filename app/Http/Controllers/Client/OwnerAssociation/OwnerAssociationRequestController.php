<?php
namespace App\Http\Controllers\Client\OwnerAssociation;

use App\Enums\OwnerAssociation\RequestPriority;
use App\Enums\OwnerAssociation\RequestType;
use App\Helpers\File;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\OwnerAssociation\OwnerAssociation;
use App\Models\OwnerAssociation\OwnerAssociationRequest;
use App\Models\OwnerAssociation\OwnerAssociationRequestAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class OwnerAssociationRequestController extends Controller
{
    /**
     * عرض كل الطلبات للعميل
     */
    public function index()
    {

        $client = auth('client')->user();

        $requests = OwnerAssociationRequest::with([
            'ownerAssociation:id,name',
            'unit:id,unit_number',
            'assignedAdmin:id,full_name',
        ])
            ->where('client_id', $client->id)
            ->latest()
            ->paginate(15);

        return view('client.owner-associations.requests.index', compact('requests'));
    }

    /**
     * صفحة إنشاء طلب جديد
     */
    public function create($ownerAssociationUuid)
    {

        if ($ownerAssociationUuid == "no-selection") {

            $client = client();

            $ownerAssociations = OwnerAssociation::whereHas('units', function ($query) use ($client) {
                $query->where('client_id', $client->id);
            })->get();

            return view('clients.owner-associations.requests.no-selection', [
                'all_owner_association' => $ownerAssociations,

            ]);

        }
        // جلب الاتحاد
        $ownerAssociation = OwnerAssociation::where('uuid', $ownerAssociationUuid)->firstOrFail();

        // التحقق من أن العميل له وحدة في هذا الاتحاد
        $clientUnits = client()->ownerAssociationUnits()
            ->where('owner_association_id', $ownerAssociation->id)
            ->with('propertyType:id')
            ->get();

        if ($clientUnits->isEmpty()) {
            if (request()->expectsJson()) {
                return Response::error('ليس لديك صلاحية تقديم طلب في هذا الاتحاد', ['style' => 'toastr']);
            }
            abort(403, 'ليس لديك صلاحية تقديم طلب في هذا الاتحاد');
        }

        $priorities = collect(RequestPriority::cases())
            ->map(fn(RequestPriority $p) => [
                'id'   => $p->value,
                'name' => $p->label(),
            ])->values()->toArray();

        $types = RequestType::options();

        return view('clients.owner-associations.requests.create', compact('ownerAssociation', 'clientUnits', 'priorities', 'types'));
    }

    /**
     * حفظ طلب جديد
     */
    public function store(Request $request, $ownerAssociationUuid)
    {

        // جلب الاتحاد
        $ownerAssociation = OwnerAssociation::where('uuid', $ownerAssociationUuid)->firstOrFail();

        // التحقق من الصلاحية
        $hasUnit = client()->ownerAssociationUnits()
            ->where('owner_association_id', $ownerAssociation->id)
            ->exists();

        if (! $hasUnit) {
            if ($request->expectsJson()) {
                return Response::error('ليس لديك صلاحية تقديم طلب في هذا الاتحاد', ['style' => 'toastr']);
            }
            abort(403);
        }

        // Validation
        $validated = $request->validate([
            'unit_id'       => 'nullable|exists:owner_association_units,id',
            'type'          => ['required', new Enum(RequestType::class)],
            'title'         => 'required|string|max:255',
            'description'   => 'required|string|max:5000',
            'priority'      => ['nullable', new Enum(RequestPriority::class)],
            'attachments'   => 'nullable|array',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB
        ], [
            'type.required'        => 'نوع الطلب مطلوب',
            'type.in'              => 'نوع الطلب غير صحيح',
            'title.required'       => 'موضوع الطلب مطلوب',
            'description.required' => 'وصف الطلب مطلوب',
            'attachments.*.mimes'  => 'الملفات المسموحة: jpg, jpeg, png, pdf, doc, docx',
            'attachments.*.max'    => 'حجم الملف يجب ألا يتجاوز 5 ميجابايت',
        ]);

        DB::beginTransaction();

        try {

            // إنشاء الطلب
            $ownerAssociationRequest = OwnerAssociationRequest::create([
                'uuid'                 => Str::uuid(),
                'owner_association_id' => $ownerAssociation->id,
                'unit_id'              => $validated['unit_id'] ?? null,
                'client_id'            => clientId(),
                'type'                 => $validated['type'],
                'title'                => $validated['title'],
                'description'          => $validated['description'],
                'priority'             => $validated['priority'] ?? RequestPriority::NORMAL,
                'status'               => 'pending',
            ]);

            // رفع المرفقات باستخدام File Class
            if ($request->hasFile('attachments')) {

                $uploadedFiles = File::multiUpload('attachments', [
                    'path'  => 'owner-associations/requests/' . $ownerAssociationRequest->id,
                    'small' => '200*200',
                ]);

                foreach ($uploadedFiles as $uploadedFile) {
                    OwnerAssociationRequestAttachment::create([
                        'owner_association_request_id' => $ownerAssociationRequest->id,
                        'file_name'                    => $uploadedFile['file_name'],
                        'file_path'                    => 'owner-associations/requests/' . $ownerAssociationRequest->id . '/' . $uploadedFile['file_name'],
                        'file_type'                    => $uploadedFile['extension'],
                    ]);
                }
            }

            DB::commit();

            return Response::success('تم إرسال الطلب بنجاح', [
                'style'    => 'toastr',
                'redirect' => route('main.clients.owner-associations.requests.show', $ownerAssociationRequest->uuid),
                'time_out' => 1.5,
                'reset'    => true,
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            return Response::error('حدث خطأ أثناء إرسال الطلب: ' . $e->getMessage(), ['style' => 'toastr']);

        }

    }

    /**
     * عرض تفاصيل طلب
     */
    public function show($uuid)
    {

        $client = client();

        $request = OwnerAssociationRequest::with([
            'ownerAssociation:id,uuid,name',
            'unit:id,unit_number,property_type_id',
            'unit.propertyType:id',
            'assignedAdmin:id,full_name',
            'replies' => function ($query) {
                $query->where('is_internal', false)
                    ->with(['replier'])
                    ->orderBy('created_at', 'asc');
            },
        ])
            ->where('uuid', $uuid)
            ->where('client_id', $client->id)
            ->firstOrFail();

        // dd($request->replies->toArray());
        // جيب الـ ownerAssociation من الـ relation
        $ownerAssociation = $request->ownerAssociation;
        $pageTitle        = __('client.owner_associations.request_details');

        return view('clients.owner-associations.requests.show', compact(
            'request',
            'pageTitle',
            'ownerAssociation',
        ));
    }

    /**
     * إضافة رد/تعليق على الطلب
     */
    public function addReply(Request $request, $uuid)
    {

        $client = auth('client')->user();

        $ownerAssociationRequest = OwnerAssociationRequest::where('uuid', $uuid)
            ->where('client_id', $client->id)
            ->firstOrFail();

        // التحقق من أن الطلب مازال مفتوح
        if ($ownerAssociationRequest->isClosed()) {
            if ($request->expectsJson()) {
                return Response::error('لا يمكن إضافة رد على طلب مغلق', ['style' => 'toastr']);
            }
            return back()->with('error', 'لا يمكن إضافة رد على طلب مغلق');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ], [
            'message.required' => 'الرسالة مطلوبة',
        ]);

        $ownerAssociationRequest->replies()->create([
            'replier_type' => get_class($client),
            'replier_id'   => $client->id,
            'message'      => $validated['message'],
            'type'         => 'comment',
            'is_internal'  => false,
        ]);

        if ($request->expectsJson()) {
            return Response::success('تم إضافة التعليق بنجاح', [
                'style'    => 'toastr',
                'reload'   => true,
                'time_out' => 1000,
            ]);
        }

        return back()->with('success', 'تم إضافة التعليق بنجاح');
    }

    /**
     * إلغاء الطلب (فقط لو pending)
     */
    public function cancel(Request $request, $uuid)
    {
        $client = auth('client')->user();

        $ownerAssociationRequest = OwnerAssociationRequest::where('uuid', $uuid)
            ->where('client_id', $client->id)
            ->where('status', 'pending')
            ->firstOrFail();

        DB::beginTransaction();

        try {
            $ownerAssociationRequest->update(['status' => 'cancelled']);

            // إضافة رد تلقائي
            $ownerAssociationRequest->replies()->create([
                'replier_type' => get_class($client),
                'replier_id'   => $client->id,
                'message'      => 'تم إلغاء الطلب من قبل العميل',
                'type'         => 'status_change',
                'is_internal'  => false,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return Response::success('تم إلغاء الطلب بنجاح', [
                    'style'    => 'toastr',
                    'reload'   => true,
                    'time_out' => 1500,
                ]);
            }

            return back()->with('success', 'تم إلغاء الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return Response::error('حدث خطأ أثناء إلغاء الطلب', ['style' => 'toastr']);
            }

            return back()->with('error', 'حدث خطأ أثناء إلغاء الطلب');
        }
    }

}
