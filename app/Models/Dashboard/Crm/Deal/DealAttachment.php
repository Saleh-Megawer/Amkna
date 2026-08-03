<?php
namespace App\Models\Dashboard\Crm\Deal;

use App\Enums\Deal\DealAttachmentType;
use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealAttachment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'attachment_type' => DealAttachmentType::class,
    ];

    // ============================================
    // Relationships
    // ============================================

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }

    // ============================================
    // Accessors
    // ============================================

    // public function getFileTypeAttribute(): string
    // {
    //     $extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
    //     return strtolower($extension);
    // }

    public function getFileUrlAttribute(): string
    {
        return $this->file_path ? largeAsset($this->file_path) : asset('images/default-thumb.png');
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->file_path ? smallAsset($this->file_path) : asset('images/default-thumb.png');
    }

    public function getFormattedFileSizeAttribute(): string
    {
        if (! $this->file_size) {
            return '-';
        }

        $bytes = $this->file_size;

        if ($bytes < 1024) {
            return $bytes . ' B';
        } elseif ($bytes < 1048576) {
            return round($bytes / 1024, 2) . ' KB';
        } else {
            return round($bytes / 1048576, 2) . ' MB';
        }
    }

    public function getFileTypeTextAttribute(): string
    {
        return match ($this->extension) {
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
        return match ($this->extension) {
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
        return match ($this->extension) {
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
        return in_array($this->extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    public function isPdf(): bool
    {
        return $this->extension === 'pdf';
    }

    public function isDocument(): bool
    {
        return in_array($this->extension, ['doc', 'docx', 'xls', 'xlsx', 'txt', 'pdf']);
    }

}
