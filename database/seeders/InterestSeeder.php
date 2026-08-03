<?php
namespace Database\Seeders;

use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Interest;
use App\Models\Property\Property;
use App\Models\Property\PropertyType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Number of interests to generate
        $count = 80;

        // Pull reference data arrays
        $clientIds       = Client::pluck('id')->toArray();
        $propertyIds     = Property::pluck('id')->toArray();
        $propertyTypeIds = PropertyType::pluck('id')->toArray();

        if (empty($clientIds)) {
            $this->command->info('No clients found — skipping interests seeder.');
            return;
        }

        // نماذج الرسائل
        // $messageSamples = [
        //     'أرغب في معرفة المزيد من التفاصيل عن هذا العقار.',
        //     'هل يمكن تحديد موعد للمعاينة؟',
        //     'ما هي شروط الدفع المتاحة؟',
        //     'هل العقار متاح للمعاينة خلال عطلة نهاية الأسبوع؟',
        //     'أحتاج إلى معلومات عن الأسعار والخصومات.',
        //     'هل يوجد إمكانية للتفاوض على السعر؟',
        //     'أريد معرفة تفاصيل الموقع والمرافق القريبة.',
        //     'هل يمكن الحصول على صور إضافية للعقار؟',
        //     'أبحث عن عقار مماثل في نفس المنطقة.',
        //     'ما هي الأوراق المطلوبة لإتمام الصفقة؟',
        //     'هل يمكن الدفع بالتقسيط؟',
        //     'أحتاج إلى استشارة عقارية.',
        //     null, // بعض الاهتمامات بدون رسالة
        // ];

        // // حالات الـ lead
        // $statuses = [
        //     'new',
        //     'assigned',
        //     'contacted',
        //     'in_progress',
        //     // 'converted',
        //     'not_interested',
        //     'closed',
        // ];

        // $type = 'property';

        // for ($i = 0; $i < $count; $i++) {
        //     // اختيار عميل عشوائي
        //     $clientId = $clientIds[array_rand($clientIds)];

        //     // ربط بعقار لو النوع property
        //     $propertyId = null;

        //     if ($type === 'property') {
        //         if (! empty($propertyIds) && rand(1, $count) <= ($count / 2)) {
        //             $propertyId = $propertyIds[array_rand($propertyIds)];
        //         }
        //     }

        //     // اختيار رسالة عشوائية
        //     $message = $messageSamples[array_rand($messageSamples)];

        //     // حالة الـ lead
        //     $status = $statuses[array_rand($statuses)];

        //     // تاريخ الإنشاء خلال آخر 90 يوم
        //     $createdAt = Carbon::now()->subDays(rand(0, 90))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
        //     $updatedAt = (clone $createdAt)->addDays(rand(0, 30))->addHours(rand(0, 23));

        //     // بناء البيانات
        //     $interestData = [
        //         'uuid'        => Str::uuid(),
        //         'client_id'   => $clientId,
        //         'property_id' => $propertyId,
        //         'type'        => $type,
        //         'message'     => $message,
        //         'status'      => $status,
        //         'created_at'  => $createdAt,
        //         'updated_at'  => $updatedAt,
        //     ];

        //     // إنشاء الاهتمام (الـ Observer هيعين الموظف تلقائياً)
        //     Interest::create($interestData);
        // }

        // $this->command->info("Generated {$count} interests.");
    }
}
