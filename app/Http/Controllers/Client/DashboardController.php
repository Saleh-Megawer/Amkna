<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Admin\Admin;
use App\Models\OwnerAssociation\OwnerAssociation;
use App\Models\OwnerAssociation\OwnerAssociationRequest;
use App\Models\OwnerAssociation\OwnerAssociationRequestReply;

class DashboardController extends Controller
{

    public function index()
    {
        $pageTitle = __('client.aside.account_overview');
        $client    = client();

        // إحصائيات سريعة
        $stats = [
            'total_units'      => $client->ownerAssociationUnits()->count(),
            'active_requests'  => OwnerAssociationRequest::where('client_id', $client->id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->count(),
            'pending_requests' => OwnerAssociationRequest::where('client_id', $client->id)
                ->where('status', 'pending')
                ->count(),
            'total_requests'   => OwnerAssociationRequest::where('client_id', $client->id)->count(),
        ];

        // آخر 5 طلبات
        $latestRequests = OwnerAssociationRequest::where('client_id', $client->id)
            ->with(['ownerAssociation:id,name', 'unit:id,unit_number'])
            ->latest()
            ->take(5)
            ->get();

        // آخر تحديثات من الإدارة
        $latestAdminReplies = OwnerAssociationRequestReply::whereHas('request', function ($q) use ($client) {
            $q->where('client_id', $client->id);
        })
            ->where('replier_type', Admin::class)
            ->where('is_internal', false)
            ->with(['request:id,uuid,title', 'replier:id,full_name'])
            ->latest()
            ->take(5)
            ->get();

        // معلومات الاتحادات
        $ownerAssociations = OwnerAssociation::whereHas('units', function ($q) use ($client) {
            $q->where('client_id', $client->id);
        })
            ->withCount(['units' => function ($q) use ($client) {
                $q->where('client_id', $client->id);
            }])
            ->with(['units' => function ($q) use ($client) {
                $q->where('client_id', $client->id)
                    ->select('id', 'owner_association_id', 'unit_number', 'property_type_id')
                    ->with('propertyType:id');
            }])
            ->get();

        return view('clients.dashboard', compact('pageTitle', 'stats', 'latestRequests', 'latestAdminReplies', 'ownerAssociations'));
    }

    // public function sendStudyToMail()
    // {

    //     $id = request('id');
    //     $email = request('email');

    //     // Get Study
    //     $row = Study::where('user_id', userId())->where('id', $id)->first();

    //     if ($row == null) {
    //         return Response::error('الدراسة المطلوبة غير موجودة !', ['style' => 'toastr']);
    //     }

    //     if ($row->paid != '1') {
    //         return Response::warning('لا يمكنك ارسال الدراسة عبر البريد لانها غير مدفوعة', ['style' => 'toastr']);
    //     }

    //     // Send To Mail
    //     Mail::to($email)->send(new SendStudy([
    //         'link' => url('show-study/' . Crypt::encryptString($id))
    //     ]));
    //     // Succes
    //     return Response::success('تم ارسال الدراسة بنجاح', ['style' => 'toastr','reset' => true]);
    // }

}
