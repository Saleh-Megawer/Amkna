<?php
namespace App\Models\OwnerAssociation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class OwnerAssociationRequestAttachment extends Model
{
    protected $guarded = [];

    // ============================================
    // العلاقات
    // ============================================

    public function request(): BelongsTo
    {
        return $this->belongsTo(OwnerAssociationRequest::class, 'owner_association_request_id');
    }

    // ============================================
    // Accessors
    // ============================================

    public function getFileUrlAttribute(): string
    {
        return $this->file_path ? largeAsset($this->file_path) : asset('images/default-thumb.png');
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->file_path ? smallAsset($this->file_path) : asset('images/default-thumb.png');
    }

    // public function getFileSizeFormattedAttribute(): string
    // {
    //     $kb = $this->file_size;

    //     if ($kb < 1024) {
    //         return round($kb, 2) . ' KB';
    //     }

    //     return round($kb / 1024, 2) . ' MB';
    // }

    public function getFileTypeTextAttribute(): string
    {
        return match ($this->file_type) {
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'صورة',
            'pdf'   => 'مستند PDF',
            'doc', 'docx' => 'مستند Word',
            'xls', 'xlsx' => 'جدول Excel',
            'txt'   => 'ملف نصي',
            'zip', 'rar'  => 'ملف مضغوط',
            default => 'ملف',
        };
    }

    public function getFileIconAttribute(): string
    {
        return match ($this->file_type) {
            'jpg', 'jpeg', 'png', 'gif', 'webp' => asset('shared/file-types/image.png'),
            'svg'   => asset('shared/file-types/svg.png'),
            'pdf'   => asset('shared/file-types/pdf.png'),
            'doc', 'docx' => asset('shared/file-types/word.png'),
            'xls', 'xlsx' => asset('shared/file-types/excel.png'),
            'txt'   => asset('shared/file-types/text.png'),
            'zip', 'rar'  => asset('shared/file-types/archive.png'),
            default => asset('shared/file-types/file.png'),
        };
    }

    public function getFileIconClassAttribute(): string
    {
        return match ($this->file_type) {
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'fa fa-file-image text-success',
            'pdf'   => 'fa fa-file-pdf text-danger',
            'doc', 'docx' => 'fa fa-file-word text-primary',
            'xls', 'xlsx' => 'fa fa-file-excel text-success',
            'txt'   => 'fa fa-file-alt text-secondary',
            'zip', 'rar'  => 'fa fa-file-archive text-warning',
            default => 'fa fa-file text-muted',
        };
    }

    // ============================================
    // Helper Methods
    // ============================================

    public function isImage(): bool
    {
        return in_array($this->file_type, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    public function isPdf(): bool
    {
        return $this->file_type === 'pdf';
    }

    public function isDocument(): bool
    {
        return in_array($this->file_type, ['doc', 'docx', 'xls', 'xlsx', 'txt', 'pdf']);
    }

    public function canPreview(): bool
    {
        return $this->isImage() || $this->isPdf();
    }

    public function download(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return Storage::download($this->file_path, $this->file_name);
    }

    public function deleteFile(): bool
    {
        if (Storage::exists($this->file_path)) {
            return Storage::delete($this->file_path);
        }

        return false;
    }

    // ============================================
    // Events
    // ============================================

    protected static function booted()
    {
        // حذف الملف من التخزين عند حذف السجل
        static::deleting(function ($attachment) {
            $attachment->deleteFile();
        });
    }
}
