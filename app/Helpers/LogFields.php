<?php
namespace App\Helpers;

class LogFields
{
    public static function names()
    {
        return [
            'name'         => 'الاسم',
            'phone'        => 'الجوال',
            'email'        => 'البريد الإلكتروني',
            'status_id'    => 'الحالة',
            'assigned_to'  => 'الموظف المكلّف',
            'country_code' => 'كود الدولة',
            'notes'        => 'الملاحظات',
            'note'         => 'ملاحظة',
        ];
    }
}
