<?php
namespace App\Http\Controllers\Dashboard\Crm\Client;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Crm\Client\ClientNote;
use App\Traits\Client\EnsuresClientOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientNoteController extends Controller
{

    use EnsuresClientOwnership;

    public function store(Request $request, Client $client)
    {

        // Validate Data
        $data = $request->validate([
            'note' => 'required|min:10|max:1500',
        ]);

        // Set
        $data['created_by'] = adminId();
        $data['client_id']  = $client->id;

        // Create New Client Note
        $note =  ClientNote::create($data);

        // Log the action
        activity('client')
            ->causedBy(adminId())   // من قام بالعملية
            ->performedOn($client)  // العميل نفسه
            ->event('note-created') // نوع الحدث
            ->withProperties([
                'note_id'    => $note->id, // رقم الملاحظة (مفيد جداً)
                'attributes' => [
                    'note' => Str::limit($data['note'], 75), // القيمة الجديدة
                ],
            ])
            ->log('تم إضافة ملاحظة جديدة');

            

        // Return Response
        return Response::success('تم إضافة الملاحظة بنجاح', [
            'style'    => 'toastr',
            'reset'    => true,
            'reload'   => true,
            'time_out' => 2,
        ]);
    }

    public function update(Client $client, ClientNote $clientNote)
    {
        $this->ensureClientOwnership($client, $clientNote);

        $data = request()->validate([
            'note' => 'required|min:10|max:1500',
        ]);

        // Log التعديل
        activity('client')
            ->causedBy(adminId())
            ->performedOn($client)
            ->event('note-updated')
            ->withProperties([
                'attributes' => [
                    'note' => $data['note'], // القيمة الجديدة
                ],
                'old'        => [
                    'note' => $clientNote->note, // القيمة القديمة
                ],
            ])
            ->log('تم تحديث ملاحظة');

        // Update
        $clientNote->update($data);

        return Response::success('تم تحديث الملاحظة بنجاح', [
            'style' => 'toastr',
            'reset' => true,
        ]);
    }

    public function destroy(Client $client, ClientNote $clientNote)
    {
        // Check ownership
        $this->ensureClientOwnership($client, $clientNote);

        //
        activity('client')
            ->causedBy(adminId())
            ->performedOn($client)
            ->event('note-deleted')
            ->withProperties([
                'note_id'      => $clientNote->id,
                'note_excerpt' => Str::limit($clientNote->note, 75),
            ])
            ->log('تم حذف ملاحظة للعميل');

        // Now it's safe to delete
        $clientNote->delete();

        return Response::success('Note deleted successfully', ['style' => 'toastr']);
    }

    public function getNote(Client $client, ClientNote $clientNote)
    {
        // Check ownership
        $this->ensureClientOwnership($client, $clientNote);
        return response()->json($clientNote->note);
    }

}
