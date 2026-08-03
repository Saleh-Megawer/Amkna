<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Check If File Exist
 * $imgNotFoundWidth Default Width = 400
 * $imgNotFoundWidth = [128, 400, 628 , 1024]
 */
// if (! function_exists('getImage')) {
//     function getImage(string $file, int $notFoundWidth = 470): string
//     {
//         $fullPath = public_path('storage/' . $file);

//         if (file_exists($fullPath)) {
//             return asset('storage/' . $file);
//         }

//         return asset("dashboard/images/errors/404-error-{$notFoundWidth}px.webp");
//     }
// }

// if (! function_exists('checkFile')) {
//     function checkFile(string $path): bool
//     {
//         return file_exists(public_path($path));
//     }
// }

function interventionImageAccept($array = true)
{
    $items = ['JPG', 'JPEG', 'PNG', 'TIFF', 'JFIF', 'PJPEG', 'PJP', 'WEBP', 'BMP', 'TIF', 'TIFF'];
    if ($array == true) {
        // UPPER CASE
        return $items;
    } else {
        return implode(',', $items);
    }
}

function processFileName($oldFileName, $separator = '-')
{
    $fileName = $oldFileName;
    // This Characters We Will Removed From File Name
    $listOfCharactersToRemoveFromFileName = [' ', '!', '`', '~', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '-', '+', '=', '{', '}', '[', ']', '\\', '|', '\'', '"', ';', ':', '/', '?', '>', '.', '<', ',', '–', '—'];
    // Loop And Check If Isset This Char In File Name
    foreach ($listOfCharactersToRemoveFromFileName as $key) {
        $fileName = str_replace($key, $separator, $fileName);
    }
    // After Remove Characters And Set $separator Explode Name And Loop
    $explodeNameAfterRemoveCharacters = explode($separator, $fileName);
    $fileNameParts                    = []; // Empty Array To Set New Name
    foreach ($explodeNameAfterRemoveCharacters as $part) {
        // After Explode And Loop This  $separator will change to null value
        // Here In If check if value = null no set in $fileNameParts
        if ($part != null) {
            array_push($fileNameParts, $part);
        }
    }
    return $fileName = implode($separator, $fileNameParts) . $separator . time();
}

// Using In App\Helpers\File.php
if (! function_exists("imageStream")) {

    function imageStream(string $tmpPath, string $uploadToPath, string $fileName, string $size, string $sizeSeparator = '*')
    {

        $width   = explode($sizeSeparator, $size)[0];                                                  // Width
        $heigth  = explode($sizeSeparator, $size)[1];                                                  // Heigth
        $quality = isset(explode($sizeSeparator, $size)[2]) ? explode($sizeSeparator, $size)[2] : 100; // Quality

        $makeImage = Image::make($tmpPath)->resize(intval($width), intval($heigth))->stream(null, $quality);
        Storage::disk('local')->put($uploadToPath . $fileName, $makeImage);

        // $makeImage->save(storage_path("app/" . $uploadToPath . $fileName), $quality);
    }
}

/**
 * Create Random Name
 * 1- If Random Name For File,Image..... Set IN Params $file = 'jpg' Or 'pdf' Or .....
 * v2
 */
function randomName($file = null)
{
    if ($file !== null) {
        $file = '.' . str_replace('.', '', $file);
    }
    return time() . '_' . rand(10000, 5000000000) . $file;
}

/**
 * Resize and upload image with max width 1500px and keep aspect ratio.
 *
 * @param \Illuminate\Http\UploadedFile $file
 * @param string $uploadPath  Example: 'public/uploads/large'
 * @param string|null $fileName Optional custom name
 * @param int $maxWidth Maximum width for the image
 * @param int $quality Compression quality (1-100)
 * @return string Path to saved image
 */
function resizeAndUploadImage($tmpPath, string $uploadToPath, $fileName = null, int $maxWidth = 1500, int $quality = 75)
{

    $image = Image::make($tmpPath);

    if ($image->width() > $maxWidth) {
        $image->resize($maxWidth, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }

    $makeImage = (string) $image->stream(null, $quality);

    Storage::disk('local')->put($uploadToPath . $fileName, $makeImage);

}

function compressAndUploadImage($tmpPath, string $uploadToPath, $fileName = null, int $quality = 75)
{
    $image = Image::make($tmpPath);

    $makeImage = (string) $image->encode(null, $quality);

    Storage::disk('local')->put($uploadToPath . $fileName, $makeImage);
}

/**
 * الحصول على مسار صورة Meta
 */
if (! function_exists('metaImage')) {
    function metaImage(string $imageName): string
    {
        return asset('assets/images/meta/' . $imageName);
    }
}

/**
 * إنشاء اسم عشوائي للملف
 */
if (! function_exists('randomFileName')) {
    function randomFileName(?string $extension = null) : string
    {
        $timestamp = time();
        $random    = rand(10000, 5000000000);

        if ($extension) {
            $extension = '.' . ltrim($extension, '.');
            return "{$timestamp}_{$random}{$extension}";
        }

        return "{$timestamp}_{$random}";
    }
}

