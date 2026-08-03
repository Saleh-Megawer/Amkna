<?php
namespace App\Http\Controllers\Dashboard\OwnerAssociation;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\OwnerAssociation\OwnerAssociation;
use App\Traits\OwnerAssociations\FindsOwnerAssociationsByUuid;
use App\Traits\OwnerAssociations\HasOwnerAssociationsTabs;
use Illuminate\Http\Request;

class OwnerAssociationController extends Controller
{

    use HasOwnerAssociationsTabs, FindsOwnerAssociationsByUuid;

    public function __construct()
    {
        $this->bootTabs();
    }

    /**
     * Display a listing of owner associations.
     */
    public function index()
    {

        $associations = OwnerAssociation::with(['manager'])->latest()->paginate(20);
        return view('dashboard.owner-associations.index', compact('associations'));
    }

    /**
     * Store a newly created owner association in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'manager_client_id' => 'nullable|exists:clients,id',
            'notes'             => 'nullable|string|max:3000',
        ]);

        $data['admin_id'] = adminId();

        $row = OwnerAssociation::create($data);

        // Return Response
        return Response::success('تم إنشاء ملف اتحاد ملاك بنجاح', [
            'style'    => 'toastr',
            'reset'    => true,
            'redirect' => route('owner-associations.show', $row->uuid),
            'time_out' => 2,
        ]);

    }

    /**
     * Update the specified owner association.
     */
    public function update(Request $request, OwnerAssociation $ownerAssociation)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'manager_client_id' => 'nullable|exists:clients,id',
            'notes'             => 'nullable|string|max:3000',
        ]);

        $ownerAssociation->update($data);

        // Return Response
        return Response::success('تم تحديث ملف اتحاد الملاك بنجاح', [
            'style'    => 'toastr',
            'redirect' => route('owner-associations.show', $ownerAssociation->uuid),
            'time_out' => 2,
        ]);

    }

    /**
     * Display the specified owner association.
     */
    public function show(OwnerAssociation $ownerAssociation)
    {

        $ownerAssociation->load(['units.client', 'units.propertyType']);
        $numberOfOwners = $ownerAssociation->units->pluck('client_id')->unique()->filter()->count();
        $requestsCount  = $ownerAssociation->requests()->count();
        return view('dashboard.owner-associations.show',
            // array_merge(
            //     $this->getViewData(),
            [
                'numberOfOwners'   => $numberOfOwners,
                'ownerAssociation' => $ownerAssociation,
                'requestsCount'    => $requestsCount,
            ]
            //  )
        );
    }

    /**
     * Remove the specified owner association.
     */
    public function destroy(OwnerAssociation $ownerAssociation)
    {
        // Optional: prevent delete if has units
        if ($ownerAssociation->units()->exists()) {
            Response::error('لا يمكن حذف اتحاد ملاك يحتوي على وحدات', ['style' => 'toastr', 'json' => false]);
            return back();
        }

        $ownerAssociation->delete();

        Response::success('تم حذف ملف اتحاد الملاك بنجاح', [
            'redirect' => route('owner-associations.index'),
            'json'     => false,
        ]);

        return redirect(route('owner-associations.index'));
    }

}
