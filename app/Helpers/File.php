<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class File
{
    /*
     | IF you need upload thumbnails image set in options["small" => "width*height" , "medium" => "width*height"]
     | 1- thumbnails type [ small , medium ]
     | 2- width * height
     |
     |
     |
     */

    /**
     * @param string $inputName = input attr name
     * @param array $options
     */
    public static function upload(string $inputName, array $options = [])
    {
        // Disk
        $disk = 'public';

        $deleteOldFile = isset($options['delete']) ? $options['delete'] : null; // Delete Old File
        /*
         |
         | File Options
         | And Prepare And Default Options
         |
         */
        $hash          = isset($options['hash']) && $options['hash'] == true ? true : false;           // Hash Name
        $realSize      = isset($options['real_size']) && $options['real_size'] == true ? true : false; // Hash Name
        $only_compress = isset($options['only_compress']) ? $options['only_compress'] : false;

        // Paths To Upload
        $largeUploadPath  = isset($options['path']) ? $disk . '/large/' . $options['path'] . '/' : $disk;
        $smallUploadPath  = isset($options['path']) ? $disk . '/small/' . $options['path'] . '/' : $disk . '/small/';
        $mediumUploadPath = isset($options['path']) ? $disk . '/medium/' . $options['path'] . '/' : $disk . '/medium/';
        // Image Sizes
        $sizeLarge     = isset($options['large']) ? $options['large'] : null;
        $sizeMedium    = isset($options['medium']) ? $options['medium'] : null;
        $sizeSmall     = isset($options['small']) ? $options['small'] : null;
        $sizeSeparator = '*'; // size separator mark

        // Check If Has File In Request Else Exit Script
        $file = request()->hasFile($inputName) ? request($inputName) : false;

        if ($file == true) {
            /*
            |
            | Check IF Has Delete Option Delete File From Project Before Upload New
            |
            */
            if ($deleteOldFile != null) {
                Storage::delete([
                    $largeUploadPath . $deleteOldFile,
                    $mediumUploadPath . $deleteOldFile,
                    $smallUploadPath . $deleteOldFile,
                ]);
            }
        } else {
            return $deleteOldFile;
            exit;
        }

        /*
         |
         | File Info
         |
         */
                                                                              // $realMimeType      = $file->getMimeType(); // File Mime Type
        $mimeType          = $file->getClientMimeType();                      // File Mime Type
        $originalName      = explode('.', $file->getClientOriginalName())[0]; // File Original Name
        $originalExtension = $file->getClientOriginalExtension();             // File Original Extension
        $tmpPath           = $file->getRealPath();                            // File Original Path

        /*
         |
         | File Options
         | And Prepare And Default Options
         |
         */
        $extension = isset($options['extension']) ? $options['extension'] : $originalExtension; // IF not isset extension set default ( $originalExtension )

        // Check IF Need Hash Name
        if ($hash == true) {

            $fileName = Str::slug(Str::limit($originalName, 50)) . '-' . time();
        } else {
            /*
            |
            | Prepare Name
            | Set Original Name But And Remove Space and Litters
            |
            */
            $fileName = processFileName($originalName);
        }
        // Set Extension After Prepare File Name
        $fileName = $fileName . '.' . $extension;

        /*
         |
         | Resize Image Defaut Set In Large Dir IF Not Exist Dimensions like => "large" => "1000*960"
         | Image Sizes => Large & medium & small
         */

        if ($sizeLarge != null) {
            //  helper function from App\Helpers\Functions\image.php
            imageStream($tmpPath, $largeUploadPath, $fileName, $sizeLarge, $sizeSeparator);
        } // End Check IF Have Width And Height
        else {
            // Upload File IF Not Have Any Size
            if ($only_compress) {
                compressAndUploadImage($tmpPath, $largeUploadPath, $fileName, 70);
            } else {
                // Upload File IF Not Have Any Size
                //
                if ($realSize) {
                    request()->file($inputName)->storeAs($largeUploadPath, $fileName);
                } else {
                    resizeAndUploadImage($tmpPath, $largeUploadPath, $fileName, 1400, 60);
                }
            }

        }

        // Medium
        if ($sizeMedium != null) {
            // helper function from App\Helpers\Functions\image.php
            imageStream($tmpPath, $mediumUploadPath, $fileName, $sizeMedium, $sizeSeparator);
        }

        // Small
        if ($sizeSmall != null) {
            // helper function from App\Helpers\Functions\image.php
            imageStream($tmpPath, $smallUploadPath, $fileName, $sizeSmall, $sizeSeparator);
        }

        // Return File Name
        return $fileName;
    }

    public static function multiUpload(string $inputName, array $options = [])
    {
        // Disk
        $disk = 'public';

        /*
         |
         | File Options
         | And Prepare And Default Options
         |
         */
        // Paths To Upload
        $largeUploadPath  = isset($options['path']) ? $disk . '/large/' . $options['path'] . '/' : $disk;
        $smallUploadPath  = isset($options['path']) ? $disk . '/small/' . $options['path'] . '/' : $disk . '/small/';
        $mediumUploadPath = isset($options['path']) ? $disk . '/medium/' . $options['path'] . '/' : $disk . '/medium/';
        // Image Sizes
        $sizeLarge     = isset($options['large']) ? $options['large'] : null;
        $sizeMedium    = isset($options['medium']) ? $options['medium'] : null;
        $sizeSmall     = isset($options['small']) ? $options['small'] : null;
        $sizeSeparator = '*'; // size separator mark

        // Check If Has File In Request Else Exit Script
        $files = request()->hasFile($inputName) ? request($inputName) : false;

        // Check IF Have Files IN Request
        if (! empty($files)) {

            // All Names
            $data = [];

            foreach ($files as $file) {


                $fileSize = file_exists($file->getRealPath()) ? filesize($file->getRealPath()) : 0;

                /*
                |
                | File Info
                |
                */
                $clientMimeType    = $file->getClientMimeType();                      // File Mime Type
                $mimeType          = $file->getMimeType();                            // File Mime Type
                $originalName      = explode('.', $file->getClientOriginalName())[0]; // File Original Name
                $originalExtension = $file->getClientOriginalExtension();             // File Original Extension
                $tmpPath           = $file->getRealPath();                            // File Original Path

                // Mime Type Items
                $mimeTypeName = explode('/', $mimeType)[0];
                $mimeTypeExt  = explode('/', $mimeType)[1];
                /*
                |
                | File Options
                | And Prepare And Default Options
                | isset($options['extension'])
                */
                $extension = $originalExtension;

                // Check IF Real Mime Type = Image
                if ($mimeTypeName == 'image') {
                    // Check If This Image Extension Can Use From Intervention Lib
                    if (in_array(strtoupper($mimeTypeExt), interventionImageAccept())) {
                        if (isset($options['extension'])) {
                            $extension = $options['extension']; // If Can Set The Extension
                        }
                    }
                } elseif ($mimeTypeName == 'application') {
                    // Set Case
                    switch ($mimeTypeExt) {
                        case "x-dosexec":
                            $extension = 'exe';
                            break;
                    }
                } elseif ($mimeTypeName == 'text') {
                    $extension = $originalExtension;
                }

                // processFileName()

                $fileName = processFileName($originalName) . '-' . rand(1000, 100000) . '.' . $extension;

                // Small
                if ($mimeTypeName == 'image') {
                    if ($sizeSmall != null) {
                        if (in_array(strtoupper($mimeTypeExt), interventionImageAccept())) {
                            imageStream($tmpPath, $smallUploadPath, $fileName, $sizeSmall, $sizeSeparator);
                        }
                    }
                }

                // Medium
                if ($mimeTypeName == 'image') {
                    if ($sizeMedium != null) {
                        if (in_array(strtoupper($mimeTypeExt), interventionImageAccept())) {
                            imageStream($tmpPath, $mediumUploadPath, $fileName, $sizeMedium, $sizeSeparator);
                        }
                    }
                }

                // Check If Th Real Mime Type Not application && The Extension Not Exist In filesExtensions array
                if ($mimeTypeName == 'image') {
                    if (in_array(strtoupper($mimeTypeExt), interventionImageAccept())) {
                        // Check IF Not Have Any Size
                        if ($sizeLarge != null) {
                            imageStream($tmpPath, $largeUploadPath, $fileName, $sizeLarge, $sizeSeparator);
                        } else {
                            $file->move(storage_path("app/" . $largeUploadPath), $fileName);
                        }
                    } else {

                        $file->move(storage_path("app/" . $largeUploadPath), $fileName);
                    }
                } else {
                    $file->move(storage_path("app/" . $largeUploadPath), $fileName);
                }

                $fullPath = storage_path("app/" . $largeUploadPath . $fileName);
                array_push($data, [
                    'file_name'      => $fileName,
                    'extension'      => $extension,
                    'mime_type'      => $mimeType,
                    'real_mime_type' => $mimeTypeName,
                    'file_size'      => $fileSize,
                    'file_path'      => $options['path'],
                ]);
            } // End Of Check IF Have Files In Request

            return $data;
        }
    }

    public static function delete($path, $fileName)
    {
        Storage::delete('public/' . $fileName);
        Storage::delete('public/large/' . $path . '/' . $fileName);
        Storage::delete('public/medium/' . $path . '/' . $fileName);
        Storage::delete('public/small/' . $path . '/' . $fileName);
    }
}
