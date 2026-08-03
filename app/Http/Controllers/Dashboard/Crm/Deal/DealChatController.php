<?php
namespace App\Http\Controllers\Dashboard\Crm\Deal;

use App\Enums\Deal\DealChatContactType;
use App\Enums\Deal\DealChatOutcome;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Dashboard\Crm\Deal\DealChat;
use Illuminate\Http\Request;

class DealChatController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin'], ['only' => 'destroy']);
    }

    public function store(Request $request, Deal $deal)
    {

        $data = $request->validate([
            'contact_type' => ['required', 'string', 'in:' . implode(',', DealChatContactType::values())],
            'contacted_at' => ['required', 'date'],
            'duration'     => ['nullable', 'integer', 'min:0'],
            'notes'        => ['nullable', 'string', 'max:5000'],
            'outcome'      => ['nullable', 'string', 'in:' . implode(',', DealChatOutcome::values())],
            'next_action'  => ['nullable', 'string', 'max:1000'],
        ], [
            'contact_type.required' => 'نوع التواصل مطلوب',
            'contact_type.in'       => 'نوع التواصل غير صحيح',
            'contacted_at.required' => 'تاريخ التواصل مطلوب',
            'contacted_at.date'     => 'تاريخ التواصل غير صحيح',
            'duration.integer'      => 'المدة يجب أن تكون رقمًا صحيحًا',
            'duration.min'          => 'المدة لا يمكن أن تكون أقل من صفر',
            'notes.max'             => 'الملاحظات لا يمكن أن تتجاوز 5000 حرف',
            'outcome.in'            => 'نتيجة المحادثة غير صحيحة',
            'next_action.max'       => 'الإجراء التالي لا يمكن أن يتجاوز 1000 حرف',
        ]);

        $data['deal_id']    = $deal->id;
        $data['created_by'] = adminId();

        DealChat::create($data);

        return Response::success('تم إضافة المحادثة بنجاح', [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 1.5,
        ]);
    }

    public function update(Request $request, Deal $deal, DealChat $chat)
    {
        $data = $request->validate([
            'contact_type' => ['required', 'string', 'in:' . implode(',', DealChatContactType::values())],
            'contacted_at' => ['required', 'date'],
            'duration'     => ['nullable', 'integer', 'min:0'],
            'notes'        => ['nullable', 'string', 'max:5000'],
            'outcome'      => ['nullable', 'string', 'in:' . implode(',', DealChatOutcome::values())],
            'next_action'  => ['nullable', 'string', 'max:1000'],
        ], [
            'contact_type.required' => 'نوع التواصل مطلوب',
            'contact_type.in'       => 'نوع التواصل غير صحيح',
            'contacted_at.required' => 'تاريخ التواصل مطلوب',
            'contacted_at.date'     => 'تاريخ التواصل غير صحيح',
            'duration.integer'      => 'المدة يجب أن تكون رقمًا صحيحًا',
            'duration.min'          => 'المدة لا يمكن أن تكون أقل من صفر',
            'notes.max'             => 'الملاحظات لا يمكن أن تتجاوز 5000 حرف',
            'outcome.in'            => 'نتيجة المحادثة غير صحيحة',
            'next_action.max'       => 'الإجراء التالي لا يمكن أن يتجاوز 1000 حرف',
        ]);

        $chat->update($data);

        return Response::success('تم تحديث المحادثة بنجاح', [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 1.5,
        ]);
    }

    public function show(Deal $deal, DealChat $chat)
    {
        $chat->load('deal:id,uuid');

        $html = view('dashboard.crm.deals.modals.edit-chat', compact('chat'))->render();

        return response()->json([
            'status' => 'success',
            'html'   => $html,
        ]);
    }

    public function destroy(Deal $deal, DealChat $chat)
    {

        $chat->delete();
        return Response::success('تم حذف المحادثة بنجاح', [
            'style' => 'toastr',
        ]);

    }

}
