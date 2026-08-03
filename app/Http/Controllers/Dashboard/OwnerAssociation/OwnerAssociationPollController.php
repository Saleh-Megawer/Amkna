<?php
namespace App\Http\Controllers\Dashboard\OwnerAssociation;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\OwnerAssociation\OwnerAssociation;
use App\Models\OwnerAssociation\OwnerAssociationPoll;
use Illuminate\Http\Request;

class OwnerAssociationPollController extends Controller
{

    /**
     * Store a newly created unit in storage.
     */
    public function store(Request $request, OwnerAssociation $ownerAssociation)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['owner_association_id'] = $ownerAssociation->id;
        $data['created_by']           = adminId();
        $data['is_active']            = $request->has('is_active') ? 1 : 0;

        OwnerAssociationPoll::create($data);

        return Response::success('تم إضافة الاستطلاع بنجاح', [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 2,
        ]);
    }

    public function edit(OwnerAssociation $ownerAssociation, OwnerAssociationPoll $poll)
    {
        // Manual ownership check
        if ($poll->owner_association_id !== $ownerAssociation->id) {
            return Response::error('خطأ في تعديل الاستطلاع غير متوافق مع ملف الاتحاد !', ['style' => 'toastr']);
        }

        return response()->json([
            'id'          => $poll->id,
            'uuid'        => $poll->uuid,
            'title'       => $poll->title,
            'description' => $poll->description,
            'is_active'   => $poll->is_active,
        ]);
    }

    /**
     * Update the specified poll in storage.
     */
    public function update(Request $request, OwnerAssociation $ownerAssociation, OwnerAssociationPoll $poll)
    {
        // Manual ownership check
        if ($poll->owner_association_id !== $ownerAssociation->id) {
            return Response::error('خطأ في تعديل الاستطلاع غير متوافق مع ملف الاتحاد !', ['style' => 'toastr']);
        }

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => 'nullable|string|max:2500',
            'is_active'   => 'nullable|boolean',
        ]);

        // تحويل checkbox للـ boolean
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $poll->update($data);

        return Response::success('تم تحديث الاستطلاع بنجاح', [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 1.5,
        ]);
    }

    /**
     * Remove the specified unit from storage.
     */
    public function destroy(OwnerAssociation $ownerAssociation, OwnerAssociationPoll $poll)
    {

        // Manual ownership check
        if ($poll->owner_association_id !== $ownerAssociation->id) {
            return Response::error('خطأ في حذف الاستطلاع !', ['style' => 'toastr']);
        }

        $poll->delete();

        return Response::success('تم حذف الاستطلاع بنجاح', [
            'style' => 'toastr',
        ]);

    }

}
