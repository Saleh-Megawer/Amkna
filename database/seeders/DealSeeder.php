<?php
namespace Database\Seeders;

use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Dashboard\Source;
use App\Models\Dashboard\Tag;
use App\Models\Property\PropertyFacade;
use App\Models\Property\PropertyType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Number of deals to generate
        $count = 60;

        // Pull reference data arrays (may be empty)
        $clientIds = Client::pluck('id')->toArray();
        $sourceIds = Source::where('type', 'client')->pluck('id')->toArray();
        // $statusIds       = Status::where('type', 'client')->pluck('id')->toArray();
        $adminIds        = Admin::pluck('id')->toArray();
        $propertyTypeIds = PropertyType::pluck('id')->toArray();
        $facadeIds       = PropertyFacade::pluck('id')->toArray();
        $tagIds          = Tag::where('type', 'client')->pluck('id')->toArray();

        if (empty($clientIds)) {
            $this->command->info('No clients found — skipping deals seeder.');
            return;
        }

        $notesSamples = [
            'يحتاج إلى رد سريع ويفضّل المواعيد خلال عطلة نهاية الأسبوع.',
            'طلب خيارات خطط الدفع.',
            'بانتظار موافقة المالك.',
            'طلب صور ومخطط الوحدة.',
            'يتم المتابعة بعد 3 أيام.',
            'تم إرسال العرض وفي انتظار الرد.',
            'العميل يفضّل دور مرتفع وإطلالة جيدة.',
            'تم مناقشة خيارات التمويل العقاري.',
            'يُفضل تحويله إلى مسؤول مبيعات أعلى للتفاوض.',
        ];

        $purposes = ['buy', 'rent'];

        for ($i = 0; $i < $count; $i++) {
            // Pick random references (allow nullable)
            $clientId = $clientIds[array_rand($clientIds)];
            $sourceId = $sourceIds ? $sourceIds[array_rand($sourceIds)] : null;
            //  $statusId       = $statusIds ? $statusIds[array_rand($statusIds)] : null;
            $assignedTo     = $adminIds ? $adminIds[array_rand($adminIds)] : null;
            $propertyTypeId = $propertyTypeIds ? $propertyTypeIds[array_rand($propertyTypeIds)] : null;
            $facadeId       = $facadeIds ? $facadeIds[array_rand($facadeIds)] : null;

            // Purpose and amount logic
            $purpose = $purposes[array_rand($purposes)];

            if ($purpose === 'buy') {
                                                 // Typical purchase values
                $amount = rand(300000, 8000000); // EG/SA realistic numbers
            } else {
                // Rent monthly
                $amount = rand(1500, 40000);
            }

            // Budget min/max around amount (if rent use monthly context)
            $budgetMin = max(0, intval($amount * (rand(70, 90) / 100)));
            $budgetMax = intval($amount * (rand(100, 120) / 100));

            // Commission: 1% - 5% of amount (for rent could be 0.5% - 2 months)
            $commission = round($amount * (rand(100, 500) / 10000), 2);

            // Other numeric props
            $areaMin   = rand(30, 120);
            $areaMax   = $areaMin + rand(10, 150);
            $bedrooms  = rand(0, 5);
            $bathrooms = max(1, rand(1, 4));
            $rating    = rand(1, 5);

                                  // Random boolean for won/lost but biased small chance for won
            $isWon  = rand(0, 1); // ~12% deals won
            $isLost = rand(0, 1);

            // Random creation date in last 180 days
            $createdAt = Carbon::now()->subDays(rand(0, 180))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $updatedAt = (clone $createdAt)->addDays(rand(0, 30))->addHours(rand(0, 23));

            // Build deal payload
            $dealData = [
                'uuid'             => Str::uuid(),
                'client_id'        => $clientId,
                'source_id'        => $sourceId,
                //  'status_id'        => $statusId,
                'assigned_to'      => $assignedTo,
                'property_type_id' => $propertyTypeId,
                'amount'           => $amount,
                'commission'       => $commission,
                'budget_min'       => $budgetMin,
                'budget_max'       => $budgetMax,
                'rating'           => $rating,
                'is_won'           => $isWon,
                'is_lost'          => $isLost,
                'facade_id'        => $facadeId,
                'area_min'         => $areaMin,
                'area_max'         => $areaMax,
                'bedrooms'         => $bedrooms,
                'bathrooms'        => $bathrooms,
                'purpose'          => $purpose,
                'notes'            => $notesSamples[array_rand($notesSamples)],
                'created_by'       => $adminIds ? $adminIds[array_rand($adminIds)] : null,
                'created_at'       => $createdAt,
                'updated_at'       => $updatedAt,
            ];

            // Create deal
            $deal = Deal::create($dealData);

            // Attach random tags (0..3)
            if ($tagIds && rand(0, 1)) {
                $attachCount = rand(1, min(3, count($tagIds)));
                $randomTags  = collect($tagIds)->random($attachCount)->toArray();
                $deal->tags()->attach($randomTags);
            }
        }

        $this->command->info("Generated {$count} deals.");
    }
}
