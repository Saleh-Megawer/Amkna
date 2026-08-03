<?php
namespace App\Http\Controllers\Dashboard\OwnerAssociation;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\OwnerAssociation\OwnerAssociation;
use App\Models\OwnerAssociation\OwnerAssociationUnit;
use App\Models\Property\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OwnerAssociationUnitController extends Controller
{

    
    /**
     * Show the form for creating a new unit inside an owner association.
     */
    public function create(OwnerAssociation $ownerAssociation)
    {
        $clients       = Client::select('id', 'name')->get();
        $propertyTypes = PropertyType::select('id', 'name')->get();

        return view(
            'dashboard.owner-associations.units.create',
            compact('ownerAssociation', 'clients', 'propertyTypes')
        );
    }

    /**
     * Store a newly created unit in storage.
     */
    public function store(Request $request, OwnerAssociation $ownerAssociation)
    {

        $data = $request->validate([
            'property_type_id' => 'required|exists:property_types,id',
            'unit_number'      => ['required', 'string', 'max:50',
                Rule::unique('owner_association_units')
                    ->where('owner_association_id', $ownerAssociation->id)
                    ->where('property_type_id', $request->property_type_id),
            ],
            'floor'            => 'nullable|string|max:50',
            'client_id'        => 'nullable|exists:clients,id',
        ]);

        $data['owner_association_id'] = $ownerAssociation->id;
        $data['admin_id']             = adminId();

        OwnerAssociationUnit::create($data);

        return Response::success('تم إضافة الوحدة بنجاح', [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 2,
        ]);
    }

    /**
     * Show the form for editing the specified unit.
     */
    // public function edit(OwnerAssociationUnit $unit)
    // {
    //     $clients       = Client::select('id', 'name')->get();
    //     $propertyTypes = PropertyType::select('id', 'name')->get();

    //     return view(
    //         'dashboard.owner-associations.units.edit',
    //         compact('unit', 'clients', 'propertyTypes')
    //     );
    // }

    public function edit(OwnerAssociation $ownerAssociation, OwnerAssociationUnit $unit)
    {
        // Manual ownership check
        if ($unit->owner_association_id !== $ownerAssociation->id) {
            return Response::error('خطأ في تعديل الوحدة غير متوافقة مع ملف الاتحاد !', ['style' => 'toastr']);
        }

        $clientName = $unit->client != null ? $unit->client?->name . ' — ' . $unit->client?->phone : null;

        return response()->json([
            'id'               => $unit->id,
            'property_type_id' => $unit->property_type_id,
            'unit_number'      => $unit->unit_number,
            'floor'            => $unit->floor,
            'client_id'        => $unit->client_id,
            'client_name'      => $clientName,
        ]);
    }

    /**
     * Update the specified unit in storage.
     */
    public function update(Request $request, OwnerAssociation $ownerAssociation, OwnerAssociationUnit $unit)
    {

        // Manual ownership check
        if ($unit->owner_association_id !== $ownerAssociation->id) {
            return Response::error('خطأ في تعديل الوحدة غير متوافقة مع ملف الاتحاد !', ['style' => 'toastr']);
        }

        $data = $request->validate([
            'property_type_id' => 'required|exists:property_types,id',

            'unit_number'      => [
                'required',
                'string',
                'max:50',
                Rule::unique('owner_association_units')
                    ->where('owner_association_id', $unit->owner_association_id)
                    ->where('property_type_id', $request->property_type_id)
                    ->ignore($unit->id),
            ],

            'floor'            => 'nullable|string|max:50',
            'client_id'        => 'nullable|exists:clients,id',
        ]);

        $unit->update($data);

        return Response::success('تم تحديث الوحدة بنجاح', [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 1.5,
        ]);
    }



    /**
     * Remove the specified unit from storage.
     */
    public function destroy(OwnerAssociation $ownerAssociation, OwnerAssociationUnit $unit)
    {

        // Manual ownership check
        if ($unit->owner_association_id !== $ownerAssociation->id) {
            return Response::error('خطأ في حذف الوحدة غير متوافقة مع ملف الاتحاد !', ['style' => 'toastr']);
        }

        $ownerAssociationId = $unit->owner_association_id;

        $unit->delete();

        return Response::success('تم حذف الوحدة بنجاح', [
            'style'    => 'toastr',
        ]);
     
    }




}
