<?php
namespace App\Http\Controllers\Client\OwnerAssociation;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\OwnerAssociation\OwnerAssociation;
use App\Models\OwnerAssociation\OwnerAssociationRequest;
use Illuminate\Http\Request;

class OwnerAssociationController extends Controller
{
    /**
     * عرض قائمة الاتحادات التي العميل مسجل فيها
     */
    public function index()
    {
        $client = client();

        
        // جلب الاتحادات اللي العميل عنده فيها وحدات
        $ownerAssociations = OwnerAssociation::whereHas('units', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })
            ->withCount([
                'units as my_units_count' => function ($query) use ($client) {
                    $query->where('client_id', $client->id);
                },
                'units as total_units_count',
            ])->get()
            ->map(function ($association) use ($client) {

                // عدد الطلبات المفتوحة
                $association->open_requests_count = OwnerAssociationRequest::where('owner_association_id', $association->id)
                    ->where('client_id', $client->id)
                    ->whereIn('status', ['pending', 'under_review', 'in_progress'])
                    ->count();

                // عدد كل الطلبات
                $association->total_requests_count = OwnerAssociationRequest::where('owner_association_id', $association->id)
                    ->where('client_id', $client->id)
                    ->count();

                return $association;
            });

        $pageTitle = __('client.owner_associations.title');
        return view('clients.owner-associations.index', compact('ownerAssociations', 'pageTitle'));
    }

    /**
     * عرض تفاصيل اتحاد واحد
     */
    public function show($uuid)
    {

     
        $pageTitle = __('client.owner_associations.title');

        $client = client();

        // جلب الاتحاد
        $ownerAssociation = OwnerAssociation::where('uuid', $uuid)
            ->with([
                'admin:id,full_name,phone,email',
                'manager:id,name,phone,email',
            ])
            ->firstOrFail();

        // التحقق من أن العميل له وحدة في هذا الاتحاد
        $hasUnit = $ownerAssociation->units()
            ->where('client_id', $client->id)
            ->exists();

        if (! $hasUnit) {
            if (request()->expectsJson()) {
                return Response::error('ليس لديك صلاحية الوصول لهذا الاتحاد', ['style' => 'toastr']);
            }
            abort(403, 'ليس لديك صلاحية الوصول لهذا الاتحاد');
        }

        // وحدات العميل
        $myUnits = $ownerAssociation->units()
            ->where('client_id', $client->id)
            ->with('propertyType:id')
            ->get();

        // إحصائيات الطلبات
        $requestsStats = [
            'total'       => OwnerAssociationRequest::where('owner_association_id', $ownerAssociation->id)
                ->where('client_id', $client->id)
                ->count(),

            'pending'     => OwnerAssociationRequest::where('owner_association_id', $ownerAssociation->id)
                ->where('client_id', $client->id)
                ->where('status', 'pending')
                ->count(),

            'in_progress' => OwnerAssociationRequest::where('owner_association_id', $ownerAssociation->id)
                ->where('client_id', $client->id)
                ->where('status', 'in_progress')
                ->count(),

            'completed'   => OwnerAssociationRequest::where('owner_association_id', $ownerAssociation->id)
                ->where('client_id', $client->id)
                ->where('status', 'completed')
                ->count(),
        ];

        // آخر الطلبات
        $recentRequests = OwnerAssociationRequest::where('owner_association_id', $ownerAssociation->id)
            ->where('client_id', $client->id)
            ->with(['unit:id,unit_number', 'assignedAdmin:id,full_name'])
            ->latest()
            ->limit(5)
            ->get();

        return view('clients.owner-associations.show', compact(
            'ownerAssociation',
            'myUnits',
            'requestsStats',
            'recentRequests',
            'pageTitle'
        ));
    }

    /**
     * عرض طلبات اتحاد معين
     */
    public function requests($uuid)
    {
        $client = client();

        // جلب الاتحاد
        $ownerAssociation = OwnerAssociation::where('uuid', $uuid)->firstOrFail();

        // التحقق من الصلاحية
        $hasUnit = $ownerAssociation->units()
            ->where('client_id', $client->id)
            ->exists();

        if (! $hasUnit) {
            if (request()->expectsJson()) {
                return Response::error('ليس لديك صلاحية الوصول لهذا الاتحاد', ['style' => 'toastr']);
            }
            abort(403);
        }

        // جلب الطلبات
        $requests = OwnerAssociationRequest::where('owner_association_id', $ownerAssociation->id)
            ->where('client_id', $client->id)
            ->with([
                'unit:id,unit_number',
                'assignedAdmin:id,full_name',
            ])
            ->latest()
            ->paginate(15);

        return view('clients.owner-associations.requests.index', compact('requests', 'ownerAssociation'));
    }
}
