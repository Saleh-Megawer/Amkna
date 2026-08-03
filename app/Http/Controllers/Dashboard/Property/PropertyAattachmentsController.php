<?php
namespace App\Http\Controllers\Dashboard\Property;

use App\Helpers\File;
use App\Helpers\FileUploader;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Property\Property;
use App\Models\Property\PropertyAttachment;
use App\Traits\Property\FindsPropertyByUuid;
use Illuminate\Http\Request;

class PropertyAattachmentsController extends Controller
{
    use FindsPropertyByUuid;

    public $propertyId;

    public function __construct()
    {

    }

    // Store

    public function store(PropertyAttachment $propertyAttachment)
    {

        $propertyId = $this->getPropertyId();

        if (! $propertyId) {
            return Response::error('الوحدة العقارية المطلوبة غير متاحة في النظام', ['style' => 'toastr']);
        }

        // only_compress
        // $fileName = File::upload('image', [
        //     'path'      => $propertyAttachment::PATH,
        //     'large'     => $propertyAttachment::LARGE,
        //     'small'     => $propertyAttachment::SMALL,
        //     'extension' => $propertyAttachment::EXTENSION,
        //     'hash'      => $propertyAttachment::HASH_NAME,
        // ]);

        $fileName = FileUploader::upload('image', [
            'path'      => $propertyAttachment::PATH,
            'max_width' => 1400,
            'quality'   => 70,
            'medium'    => Property::MEDIUM,
            'small'     => Property::SMALL,
            'hash'      => Property::HASH_NAME,
            'extension' => Property::EXTENSION,
        ]);

        $attachment = PropertyAttachment::create([
            'attachment_name' => $fileName,
            'property_id'     => $propertyId,
            'extension'       => 'webp',
            'type'            => 'image',
        ]);

        return response()->json([
            'success'       => true,
            'attachment_id' => $attachment->id,
            'property_id'   => $propertyId,
            'fileName'      => $fileName,
        ]);

    }

    public function destroy(Request $request)
    {
        $row = PropertyAttachment::find($request->id);

        if ($row) {
            File::delete(PropertyAttachment::PATH, $row->attachment_name);
            $row->delete();
        }

        return response()->json(['success' => true]);
    }

    public function get($uuid = null)
    {

        // Get Property UUID From Request
        $uuid = request('property_uuid', $uuid);

        // Select Property Row From DB
        $property = Property::where('uuid', $uuid)->select('id', 'main_image')->first();

        /**
         *
         *
         *
         */
        // GET Attachment From Dir
        $mainImageName = $property->main_image;
        $mainImagePath = largePath(Property::PATH . '/' . $mainImageName);

        $property_main_image = [
            'id'   => $property->id,
            'url'  => smallAsset(Property::PATH . '/' . $mainImageName),
            'name' => $mainImageName,
            'size' => file_exists($mainImagePath) ? filesize($mainImagePath) : 0,
        ];

        /**
         *
         * Attachment
         *
         */

        $attachmentPath = PropertyAttachment::PATH; // Attachment PATH

        $attachmentsList = $property->attachments->map(function ($attach) use ($attachmentPath) {

            // GET Attachment From Dir
            $path = largePath($attachmentPath . '/' . $attach->attachment_name);

            // Prepare Data
            return [
                'id'   => $attach->id,
                'url'  => smallAsset($attachmentPath . '/' . $attach->attachment_name),
                'name' => $attach->attachment_name,
                'size' => file_exists($path) ? filesize($path) : 0,
            ];
        });

        return response()->json([
            'attachments' => $attachmentsList,
            'main_image'  => $property_main_image,
        ]);
    }

}
