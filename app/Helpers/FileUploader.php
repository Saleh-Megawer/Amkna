<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * File Upload Helper Class
 *
 * يوفر وظائف شاملة لرفع وإدارة الملفات والصور
 * مع دعم إنشاء نسخ مصغرة متعددة الأحجام
 */
class FileUploader
{
    // المسارات الافتراضية للتخزين
    private const DISK              = 'public';
    private const SIZE_SEPARATOR    = '*';
    private const DEFAULT_MAX_WIDTH = 1400;
    private const DEFAULT_QUALITY   = 60;

    // أنواع الصور المدعومة من مكتبة Intervention
    private const SUPPORTED_IMAGE_TYPES = [
        'JPG', 'JPEG', 'PNG', 'TIFF', 'JFIF',
        'PJPEG', 'PJP', 'WEBP', 'BMP', 'TIF',
    ];

    /**
     * رفع ملف واحد مع إمكانية إنشاء نسخ مصغرة
     *
     * الخيارات المتاحة:
     * - 'path' => 'products' : المسار النسبي للتخزين
     * - 'hash' => true : استخدام hash للاسم بدلاً من الاسم الأصلي
     * - 'delete' => 'old-file.jpg' : حذف ملف قديم قبل الرفع
     * - 'extension' => 'webp' : تغيير امتداد الملف
     * - 'keep_original' => true : رفع الصورة بمقاساتها الأصلية بدون أي تعديل
     * - 'compress_only' => true : ضغط الصورة فقط مع الحفاظ على الأبعاد
     * - 'max_width' => 1920 : أقصى عرض مع الحفاظ على aspect ratio
     * - 'quality' => 85 : جودة الضغط (1-100)
     * - 'large' => '1920*1080*85' : مقاسات محددة للنسخة الكبيرة
     * - 'medium' => '800*600*80' : مقاسات محددة للنسخة المتوسطة
     * - 'small' => '300*200*75' : مقاسات محددة للنسخة الصغيرة
     *
     * @param string $inputName اسم حقل الإدخال
     * @param array $options خيارات الرفع
     * @return string|null اسم الملف المرفوع
     */
    public static function upload(string $inputName, array $options = []): ?string
    {
        // التحقق من وجود الملف
        if (! request()->hasFile($inputName)) {
            return $options['delete'] ?? null;
        }

        $file = request()->file($inputName);

        // حذف الملف القديم إذا كان موجوداً
        self::deleteOldFile($options);

        // استخراج معلومات الملف
        $fileInfo = self::extractFileInfo($file, $options);

        // رفع الملف بالأحجام المختلفة
        self::uploadWithSizes($file, $fileInfo, $options);

        return $fileInfo['fileName'];
    }

    /**
     * رفع ملفات متعددة
     *
     * @param string $inputName اسم حقل الإدخال
     * @param array $options خيارات الرفع
     * @return array معلومات الملفات المرفوعة
     */
    public static function multiUpload(string $inputName, array $options = []): array
    {
        if (! request()->hasFile($inputName)) {
            return [];
        }

        $files         = request()->file($inputName);
        $uploadedFiles = [];

        foreach ($files as $file) {
            $fileInfo = self::extractFileInfo($file, $options, true);
            self::uploadWithSizes($file, $fileInfo, $options);

            $uploadedFiles[] = [
                'file_name'      => $fileInfo['fileName'],
                'extension'      => $fileInfo['extension'],
                'mime_type'      => $fileInfo['mimeType'],
                'real_mime_type' => $fileInfo['mimeTypeName'],
            ];
        }

        return $uploadedFiles;
    }

    /**
     * حذف الملف من جميع المسارات
     *
     * @param string $path المسار النسبي
     * @param string $fileName اسم الملف
     */
    public static function delete(string $path, string $fileName): void
    {
        $paths = [
            self::DISK . '/' . $fileName,
            self::DISK . '/large/' . $path . '/' . $fileName,
            self::DISK . '/medium/' . $path . '/' . $fileName,
            self::DISK . '/small/' . $path . '/' . $fileName,
        ];

        Storage::delete($paths);
    }

    /**
     * استخراج معلومات الملف الأساسية
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param array $options
     * @param bool $isMulti هل الرفع متعدد
     * @return array معلومات الملف
     */
    private static function extractFileInfo($file, array $options, bool $isMulti = false): array
    {
        $mimeType     = $file->getMimeType();
        $mimeTypeName = explode('/', $mimeType)[0];
        $mimeTypeExt  = explode('/', $mimeType)[1];

        $originalName      = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $originalExtension = $file->getClientOriginalExtension();

        // تحديد الامتداد النهائي
        $extension = self::determineExtension(
            $mimeTypeName,
            $mimeTypeExt,
            $originalExtension,
            $options
        );

        // إنشاء اسم الملف
        $fileName = self::generateFileName($originalName, $extension, $options, $isMulti);

        return [
            'fileName'     => $fileName,
            'extension'    => $extension,
            'mimeType'     => $mimeType,
            'mimeTypeName' => $mimeTypeName,
            'mimeTypeExt'  => $mimeTypeExt,
            'tmpPath'      => $file->getRealPath(),
        ];
    }

    /**
     * تحديد الامتداد المناسب للملف
     *
     * @param string $mimeTypeName نوع الملف الرئيسي (image, application, text)
     * @param string $mimeTypeExt امتداد نوع الملف
     * @param string $originalExtension الامتداد الأصلي
     * @param array $options الخيارات
     * @return string الامتداد النهائي
     */
    private static function determineExtension(string $mimeTypeName, string $mimeTypeExt, string $originalExtension, array $options): string
    {
        // إذا كانت صورة ومدعومة من Intervention
        if ($mimeTypeName === 'image' &&
            in_array(strtoupper($mimeTypeExt), self::SUPPORTED_IMAGE_TYPES)) {
            return $options['extension'] ?? $originalExtension;
        }

        // حالات خاصة للملفات التنفيذية
        if ($mimeTypeName === 'application' && $mimeTypeExt === 'x-dosexec') {
            return 'exe';
        }

        return $originalExtension;
    }

    /**
     * إنشاء اسم الملف حسب الخيارات
     *
     * @param string $originalName الاسم الأصلي
     * @param string $extension الامتداد
     * @param array $options الخيارات
     * @param bool $isMulti هل الرفع متعدد
     * @return string اسم الملف النهائي
     */
    private static function generateFileName(string $originalName, string $extension, array $options, bool $isMulti = false): string
    {
        $useHash = $options['hash'] ?? false;

        if ($useHash) {
            // استخدام slug مع تحديد طول 50 حرف وإضافة timestamp
            $name = Str::slug(Str::limit($originalName, 50)) . '-' . time();
        } else {
            // معالجة الاسم الأصلي وإزالة الأحرف الخاصة
            $name = self::processFileName($originalName);
        }

        // إضافة رقم عشوائي للملفات المتعددة لتجنب التكرار
        if ($isMulti) {
            $name .= '-' . rand(1000, 100000);
        }

        return $name . '.' . $extension;
    }

    /**
     * رفع الملف بالأحجام المختلفة (كبير، متوسط، صغير)
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param array $fileInfo معلومات الملف
     * @param array $options خيارات الرفع
     */
    private static function uploadWithSizes($file, array $fileInfo, array $options): void
    {
        $paths = self::buildUploadPaths($options);
        $sizes = self::extractSizes($options);

        $tmpPath     = $fileInfo['tmpPath'];
        $fileName    = $fileInfo['fileName'];
        $isImage     = $fileInfo['mimeTypeName'] === 'image';
        $isSupported = in_array(strtoupper($fileInfo['mimeTypeExt']), self::SUPPORTED_IMAGE_TYPES);

        // رفع النسخة الكبيرة (أو الملف الأصلي)
        self::uploadLargeVersion(
            $file,
            $tmpPath,
            $fileName,
            $paths['large'],
            $sizes['large'],
            $options,
            $isImage,
            $isSupported
        );

        // رفع النسخة المتوسطة (للصور المدعومة فقط)
        if ($isImage && $isSupported && $sizes['medium']) {
            self::resizeAndSave($tmpPath, $paths['medium'], $fileName, $sizes['medium']);
        }

        // رفع النسخة الصغيرة (للصور المدعومة فقط)
        if ($isImage && $isSupported && $sizes['small']) {
            self::resizeAndSave($tmpPath, $paths['small'], $fileName, $sizes['small']);
        }
    }

    /**
     * رفع النسخة الكبيرة من الملف مع خيارات متعددة
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $tmpPath المسار المؤقت
     * @param string $fileName اسم الملف
     * @param string $path مسار الحفظ
     * @param string|null $size الحجم المطلوب
     * @param array $options الخيارات
     * @param bool $isImage هل هي صورة
     * @param bool $isSupported هل مدعومة من Intervention
     */
    private static function uploadLargeVersion(
        $file,
        string $tmpPath,
        string $fileName,
        string $path,
        ?string $size,
        array $options,
        bool $isImage,
        bool $isSupported
    ): void {
        // إذا كانت صورة غير مدعومة أو ملف عادي، رفع مباشر
        if (! $isImage || ! $isSupported) {
            $file->move(storage_path("app/" . $path), $fileName);
            return;
        }

        // **خيار 1: رفع بالمقاسات الأصلية بدون أي تعديل**
        if ($options['keep_original'] ?? false) {
            Storage::putFileAs($path, $file, $fileName);
            return;
        }

        // **خيار 2: ضغط فقط مع الحفاظ على الأبعاد**
        if ($options['compress_only'] ?? false) {
            $quality = $options['quality'] ?? 70;
            self::compressAndSave($tmpPath, $path, $fileName, $quality);
            return;
        }

        // **خيار 3: مقاسات محددة (عرض × ارتفاع)**
        if ($size) {
            self::resizeAndSave($tmpPath, $path, $fileName, $size);
            return;
        }

        // **خيار 4 (الافتراضي): عرض محدد مع aspect ratio**
        $maxWidth = $options['max_width'] ?? self::DEFAULT_MAX_WIDTH;
        $quality  = $options['quality'] ?? self::DEFAULT_QUALITY;
        self::resizeWithMaxWidth($tmpPath, $path, $fileName, $maxWidth, $quality);
    }

    /**
     * تغيير حجم الصورة لمقاسات محددة
     *
     * @param string $tmpPath المسار المؤقت
     * @param string $uploadPath مسار الحفظ
     * @param string $fileName اسم الملف
     * @param string $size الحجم بصيغة "width*height*quality"
     */
    private static function resizeAndSave(
        string $tmpPath,
        string $uploadPath,
        string $fileName,
        string $size
    ): void {
        [$width, $height, $quality] = self::parseSizeString($size);

        $image = Image::make($tmpPath)
            ->resize(intval($width), intval($height))
            ->stream(null, $quality);

        Storage::disk('local')->put($uploadPath . $fileName, $image);
    }

    /**
     * ضغط الصورة مع الحفاظ على الأبعاد الأصلية
     *
     * @param string $tmpPath المسار المؤقت
     * @param string $uploadPath مسار الحفظ
     * @param string $fileName اسم الملف
     * @param int $quality جودة الضغط (1-100)
     */
    private static function compressAndSave(
        string $tmpPath,
        string $uploadPath,
        string $fileName,
        int $quality
    ): void {
        $image = Image::make($tmpPath)->encode(null, $quality);
        Storage::disk('local')->put($uploadPath . $fileName, $image);
    }

    /**
     * تغيير حجم الصورة مع الحفاظ على النسبة (aspect ratio)
     * إذا كانت الصورة أصغر من العرض المطلوب، تُرفع بحجمها الأصلي
     *
     * @param string $tmpPath المسار المؤقت
     * @param string $uploadPath مسار الحفظ
     * @param string $fileName اسم الملف
     * @param int $maxWidth أقصى عرض مسموح
     * @param int $quality جودة الضغط (1-100)
     */
    private static function resizeWithMaxWidth(
        string $tmpPath,
        string $uploadPath,
        string $fileName,
        int $maxWidth,
        int $quality
    ): void {
        $image = Image::make($tmpPath);

        // فقط إذا كان العرض الأصلي أكبر من المطلوب
        if ($image->width() > $maxWidth) {
            $image->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio(); // الحفاظ على النسبة
                $constraint->upsize();      // منع التكبير
            });
        }

        $stream = $image->stream(null, $quality);
        Storage::disk('local')->put($uploadPath . $fileName, $stream);
    }

    /**
     * بناء مسارات الرفع المختلفة
     *
     * @param array $options الخيارات التي تحتوي على المسار
     * @return array مصفوفة بمسارات large, medium, small
     */
    private static function buildUploadPaths(array $options): array
    {
        $basePath = $options['path'] ?? '';
        $disk     = self::DISK;

        return [
            'large' => $basePath ? "{$disk}/large/{$basePath}/" : $disk,
            'medium' => $basePath ? "{$disk}/medium/{$basePath}/" : "{$disk}/medium/",
            'small' => $basePath ? "{$disk}/small/{$basePath}/" : "{$disk}/small/",
        ];
    }

    /**
     * استخراج أحجام الصور من الخيارات
     *
     * @param array $options الخيارات
     * @return array مصفوفة بأحجام large, medium, small
     */
    private static function extractSizes(array $options): array
    {
        return [
            'large'  => $options['large'] ?? null,
            'medium' => $options['medium'] ?? null,
            'small'  => $options['small'] ?? null,
        ];
    }

    /**
     * تحليل نص الحجم (مثل: "800*600*85")
     *
     * @param string $size النص بصيغة "width*height*quality"
     * @return array مصفوفة [width, height, quality]
     */
    private static function parseSizeString(string $size): array
    {
        $parts = explode(self::SIZE_SEPARATOR, $size);

        return [
            $parts[0] ?? 0,   // العرض
            $parts[1] ?? 0,   // الارتفاع
            $parts[2] ?? 100, // الجودة (افتراضي 100)
        ];
    }

    /**
     * حذف الملف القديم قبل رفع ملف جديد
     *
     * @param array $options الخيارات التي تحتوي على اسم الملف القديم
     */
    private static function deleteOldFile(array $options): void
    {
        if (! isset($options['delete'])) {
            return;
        }

        $paths       = self::buildUploadPaths($options);
        $oldFileName = $options['delete'];

        Storage::delete([
            $paths['large'] . $oldFileName,
            $paths['medium'] . $oldFileName,
            $paths['small'] . $oldFileName,
        ]);
    }

    /**
     * معالجة اسم الملف وإزالة الأحرف الخاصة
     *
     * @param string $fileName الاسم الأصلي
     * @param string $separator الفاصل المستخدم (افتراضي: -)
     * @return string الاسم المعالج مع timestamp
     */
    private static function processFileName(string $fileName, string $separator = '-'): string
    {
        // الأحرف التي سيتم إزالتها من اسم الملف
        $invalidChars = [
            ' ', '!', '`', '~', '@', '#', '$', '%', '^', '&', '*',
            '(', ')', '_', '-', '+', '=', '{', '}', '[', ']', '\\',
            '|', '\'', '"', ';', ':', '/', '?', '>', '.', '<', ',', '–', '—',
        ];

        // استبدال الأحرف الخاصة بالفاصل
        $processed = str_replace($invalidChars, $separator, $fileName);

        // تقسيم وإزالة القيم الفارغة
        $parts = array_filter(
            explode($separator, $processed),
            fn($part) => ! empty($part)
        );

        // إضافة timestamp لضمان عدم التكرار
        return implode($separator, $parts) . $separator . time();
    }

    /**
     * التحقق من دعم نوع الصورة من مكتبة Intervention
     *
     * @param string $extension امتداد الملف
     * @return bool هل مدعوم أم لا
     */
    public static function isImageSupported(string $extension): bool
    {
        return in_array(strtoupper($extension), self::SUPPORTED_IMAGE_TYPES);
    }

    /**
     * الحصول على قائمة أنواع الصور المدعومة
     *
     * @param bool $asArray إرجاع كـ array أو string
     * @return array|string قائمة الأنواع المدعومة
     */
    public static function getSupportedImageTypes(bool $asArray = true)
    {
        if ($asArray) {
            return self::SUPPORTED_IMAGE_TYPES;
        }

        return implode(',', self::SUPPORTED_IMAGE_TYPES);
    }

}











// use App\Helpers\FileUploader;

// // مثال 1: رفع صورة بمقاساتها الأصلية
// $fileName = FileUploader::upload('product_image', [
//     'path' => 'products',
//     'keep_original' => true,
//     'hash' => true
// ]);

// // مثال 2: ضغط فقط
// $fileName = FileUploader::upload('banner', [
//     'path' => 'banners',
//     'compress_only' => true,
//     'quality' => 80
// ]);

// // مثال 3: عرض 1920 مع aspect ratio
// $fileName = FileUploader::upload('hero_image', [
//     'path' => 'heroes',
//     'max_width' => 1920,
//     'quality' => 85
// ]);

// // مثال 4: 3 نسخ مختلفة
// $fileName = FileUploader::upload('product_image', [
//     'path' => 'products',
//     'large' => '1920*1080*85',
//     'medium' => '800*600*80',
//     'small' => '300*200*75',
//     'delete' => $oldProduct->image // حذف الصورة القديمة
// ]);

// // مثال 5: رفع متعدد
// $files = FileUploader::multiUpload('gallery_images', [
//     'path' => 'gallery',
//     'max_width' => 1500,
//     'medium' => '600*400*80',
//     'small' => '200*150*70'
// ]);

// // مثال 6: حذف صورة
// FileUploader::delete('products', 'product-image-123456.jpg');

// // مثال 7: عرض الصورة في Blade
// <img src="{{ getImage('large/products/' . $product->image) }}" alt="{{ $product->name }}">
