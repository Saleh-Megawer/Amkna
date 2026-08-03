<?php
namespace Database\Seeders;

use App\Models\City;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Dashboard\Source;
use App\Models\Neighborhood;
use App\Models\Property\PropertyType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب البيانات الأساسية
        $cities        = City::pluck('id')->toArray();
        $neighborhoods = Neighborhood::pluck('id')->toArray();
        $sources       = Source::where('type', 'client')->pluck('id')->toArray();
        $admins        = Admin::pluck('id')->toArray();
        $propertyTypes = PropertyType::pluck('id')->toArray();

        // أسماء عربية للعملاء
        $firstNames = [
            'محمد', 'أحمد', 'خالد', 'عبدالله', 'محمود', 'كريم', 'عبدالعزيز', 'حسن',
            'علي', 'عمر', 'يوسف', 'إبراهيم', 'عبدالرحمن', 'مصطفى', 'عبدربه', 'أشرف',
            'فاطمة', 'نورة', 'سارة', 'منى', 'هند', 'مريم', 'عائشة', 'سمية', 'دعاء', 'شيماء',
        ];

        $lastNames = [
            'السيد', 'عبدالعال', 'السنوسي', 'القحطاني', 'الجمل', 'الشناوي', 'عفيفي',
            'الغنام', 'بركات', 'السويفي', 'عبدالمجيد', 'المنسي', 'المصري', 'أبو إسماعيل',
            'مرسي', 'عوض', 'الأحمدي', 'زهران', 'الشافعي', 'رفعت',
        ];

        for ($i = 1; $i <= 100; $i++) {

            // تاريخ إنشاء عشوائي في آخر سنة
            $createdAt = Carbon::now()->subDays(rand(1, 365));

            // بيانات العميل
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName  = $lastNames[array_rand($lastNames)];
            $fullName  = $firstName . ' ' . $lastName;

                                                                            // بيانات الاتصال
            $hasEmail      = rand(1, 100) > 30;                             // 70% عندهم إيميل
            $hasPhone      = rand(1, 100) > 10;                             // 90% عندهم جوال
            $hasAccount    = $hasEmail && rand(1, 100) > 70;                // 30% من اللي عندهم إيميل عندهم حساب
            $emailVerified = $hasEmail && $hasAccount && rand(1, 100) > 50; // 50% من الحسابات متحققة

            $client = Client::create([
                'uuid'              => Str::uuid(),
                'name'              => $fullName,
                'email'             => $hasEmail ? strtolower(Str::slug($fullName)) . rand(1, 999) . '@example.com' : null,
                'email_verified_at' => $emailVerified ? $createdAt->copy()->addDays(rand(1, 5)) : null,
                'phone'             => $hasPhone ? '01' . rand(100000000, 199999999) : null,
            //    'phone_alt'         => rand(1, 100) > 70 ? '01' . rand(100000000, 199999999) : null,
                'country_code'      => $hasPhone ? '+20' : null,
                'city_id'           => ! empty($cities) ? $cities[array_rand($cities)] : null,
                'neighborhood_id'   => ! empty($neighborhoods) ? $neighborhoods[array_rand($neighborhoods)] : null,
                'source_id'         => ! empty($sources) ? $sources[array_rand($sources)] : null,
                'assigned_to'       => ! empty($admins) && rand(1, 100) > 20 ? $admins[array_rand($admins)] : null, // 80% مسندين
                'status'            => rand(1, 100) > 10 ? '1' : '0',
                'is_archived'       => rand(1, 100) > 90 ? 1 : 0, // 10% مؤرشفين
                'has_account'       => $hasAccount,
                'last_seen'         => rand(1, 100) > 30 ? Carbon::now()->subDays(rand(1, 90)) : null, // 70% عندهم last_seen
                'created_at'        => $createdAt,
                'updated_at'        => $createdAt->copy()->addDays(rand(1, 30)),
            ]);

            // إنشاء صفقات للعميل (60% من العملاء عندهم صفقات)
            if (rand(1, 100) > 40 && ! empty($propertyTypes)) {
                $numDeals = rand(1, 5); // من 1 إلى 5 صفقات

                for ($d = 0; $d < $numDeals; $d++) {
                    $dealCreatedAt = $createdAt->copy()->addDays(rand(1, 20));
                  //  $dealCreatedAt = Carbon::now()->subDays(rand(1, 50));

                    $isWon         = rand(1, 100) > 60;            // 40% صفقات ناجحة
                    $isLost        = ! $isWon && rand(1, 100) > 70; // 30% من الباقي صفقات خاسرة

                    $amount     = $isWon ? rand(100000, 5000000) : null;
                    $commission = $amount ? $amount * (rand(2, 5) / 100) : null;

                    Deal::create([
                        'uuid'             => Str::uuid(),
                        'client_id'        => $client->id,
                        'source_id'        => ! empty($sources) ? $sources[array_rand($sources)] : null,
                        'assigned_to'      => ! empty($admins) ? $admins[array_rand($admins)] : null,
                        'property_type_id' => $propertyTypes[array_rand($propertyTypes)],
                        'amount'           => $amount,
                        'commission'       => $commission,
                        'budget_min'       => rand(100000, 1000000),
                        'budget_max'       => rand(1000000, 5000000),
                        'rating'           => $isWon ? rand(3, 5) : null,
                        'is_won'           => $isWon,
                        'is_lost'          => $isLost,
                        'purpose'          => rand(0, 1) ? 'rent' : 'buy',
                        'area_min'         => rand(100, 300),
                        'area_max'         => rand(300, 500),
                        'bedrooms'         => rand(2, 6),
                        'bathrooms'        => rand(2, 4),
                        'notes'            => $isWon ? 'صفقة ناجحة - تمت بنجاح' : ($isLost ? 'صفقة خاسرة - العميل لم يكمل' : 'قيد المتابعة'),
                        'created_by'       => ! empty($admins) ? $admins[array_rand($admins)] : null,
                        'created_at'       => $dealCreatedAt,
                        'updated_at'       => $dealCreatedAt->copy()->addDays(rand(1, 30)),
                        'deleted_at'       => $isLost ? $dealCreatedAt->copy()->addDays(rand(10, 50)) : null,
                    ]);
                }
            }

        }

    }
}
