<?php
namespace App\Enums\Interest;

enum InterestStatus: string {

    case NEW            = 'new';
    case ASSIGNED       = 'assigned';
    case CONTACTED      = 'contacted';
    case IN_PROGRESS    = 'in_progress';
    case CONVERTED      = 'converted';
    case NOT_INTERESTED = 'not_interested';
    case CLOSED         = 'closed';

    /**
     * Get the label for the status
     */
    public function label(): string
    {
        return match ($this) {
            self::NEW            => 'اهتمام جديد',
            self::ASSIGNED       => 'لا يوجد إجراء',
            self::CONTACTED      => 'تم التواصل',
            self::IN_PROGRESS    => 'قيد المتابعة',
            self::CONVERTED      => 'تحول لصفقة',
            self::NOT_INTERESTED => 'غير مهتم',
            self::CLOSED         => 'مغلق',
        };
    }

    public function actionLabel(): string
    {
        return match ($this) {
            self::NEW            => 'تعيين مسؤول مبيعات',
            self::ASSIGNED       => 'سجّل التواصل',
            self::CONTACTED      => 'بدء المتابعة',     // أو: نقل للمتابعة
            self::IN_PROGRESS    => 'إنهاء المتابعة', // أو: تحديث الحالة
            self::NOT_INTERESTED => 'إعادة المتابعة',
            self::CONVERTED      => null,
            self::CLOSED         => null,
        };
    }

    /**
     * Get the badge class for the status
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::NEW            => 'badge-soft-secondary', // رمادي (نادر)
            self::ASSIGNED       => 'badge-soft-warning',   // برتقالي ⚠️ (يحتاج إجراء فوري)
            self::CONTACTED      => 'badge-soft-info',      // أزرق فاتح (تم الاتصال)
            self::IN_PROGRESS    => 'badge-soft-primary',   // أزرق داكن (جاري المتابعة)
            self::CONVERTED      => 'badge-soft-success',   // أخضر ✅ (ناجح)
            self::NOT_INTERESTED => 'badge-soft-danger',    // أحمر ❌ (فشل)
            self::CLOSED         => 'badge-soft-dark',      // أسود (منتهي)
        };
    }

    /**
     * Get the icon SVG for the status
     */
    public function icon(): string
    {
        return match ($this) {
            self::NEW            => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/></svg>',
            //
            self::ASSIGNED       => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/></svg>',
            //
            self::CONTACTED      => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"/></svg>',
            //
            self::IN_PROGRESS    => '',
            //
            self::CONVERTED      => '',
            //
            self::NOT_INTERESTED => '',
            //
            self::CLOSED         => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12"/><path d="M6 6l12 12"/></svg>',

        };
    }

    /**
     * Get all statuses as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all statuses with labels
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $status) {
            $options[$status->value] = $status->label();
        }
        return $options;
    }

   
}
