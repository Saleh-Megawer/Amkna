<?php
namespace App\Http\Controllers\Dashboard\Crm\Deal;

use App\Enums\Deal\DealAttachmentType;
use App\Helpers\File;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Dashboard\Crm\Deal\DealAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DealAttachmentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['role:admin'], ['only' => 'destroy']);
    }

    public function store(Request $request, Deal $deal)
    {
        $data = $request->validate([
            'attachment_type' => ['required', 'string', 'in:' . implode(',', DealAttachmentType::values())],
            'files'           => ['required', 'array', 'max:10'], // حد أقصى 10 ملفات
            'files.*'         => [
                'required',
                'file',
                'max:10240',                                                     // 10MB
                'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,zip,rar,txt', // الامتدادات المسموحة
            ],
            'notes'           => ['nullable', 'string', 'max:1000'],
        ], [
            'attachment_type.required' => 'نوع المرفق مطلوب',
            'attachment_type.in'       => 'نوع المرفق غير صحيح',
            'files.required'           => 'يجب اختيار ملف واحد على الأقل',
            'files.max'                => 'لا يمكن رفع أكثر من 10 ملفات في المرة الواحدة',
            'files.*.required'         => 'جميع الملفات مطلوبة',
            'files.*.file'             => 'يجب أن تكون جميع المرفقات ملفات صحيحة',
            'files.*.max'              => 'حجم الملف يجب ألا يتجاوز 10 ميجابايت',
            'files.*.mimes'            => 'نوع الملف غير مسموح. الأنواع المسموحة: صور، PDF، Word، Excel، ZIP، RAR، TXT',
            'notes.max'                => 'الملاحظات لا يمكن أن تتجاوز 1000 حرف',
        ]);

        // استخدام multiUpload من File class
        $uploadPath    = 'deals/' . $deal->id . '/attachments';
        $uploadedFiles = File::multiUpload('files', [
            'path'  => $uploadPath,
            'small' => '200*200',
        ]);

        $uploadedCount = 0;

        foreach ($uploadedFiles as $fileData) {
            DealAttachment::create([
                'deal_id'         => $deal->id,
                'attachment_type' => $data['attachment_type'],
                'file_name'       => $fileData['file_name'],
                'file_path'       => $uploadPath . '/' . $fileData['file_name'],
                'file_size'       => $fileData['file_size'] ?? null,
                'mime_type'       => $fileData['mime_type'],
                'extension'       => $fileData['extension'] ?? pathinfo($fileData['file_name'], PATHINFO_EXTENSION),
                'notes'           => $data['notes'] ?? null,
                'uploaded_by'     => adminId(),
            ]);

            $uploadedCount++;
        }

        return Response::success("تم رفع {$uploadedCount} مرفق بنجاح", [
            'style'    => 'toastr',
            'reload'   => true,
            'time_out' => 1.5,
        ]);
    }

    public function destroy(Deal $deal, DealAttachment $attachment)
    {

        // deals/210/attachments/Git-بالعربي-1770617025-94528.pdf
        File::delete($attachment->file_path, '');

        $attachment->delete();

        return Response::success('تم حذف المرفق بنجاح', [
            'style' => 'toastr',
        ]);
    }

    public function download(DealAttachment $attachment)
    {

        $filePath = 'public/large/deals/attachments/' . $attachment->file_path;

        if (! Storage::exists($filePath)) {
            return Response::error('الملف غير موجود', [
                'style' => 'toastr',
            ]);
        }

        return Storage::download($filePath, $attachment->file_name);
    }
}
