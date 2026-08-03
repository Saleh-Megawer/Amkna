<?php
namespace Database\Seeders;

use App\Models\City;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Neighborhood;
use App\Models\Property\Property;
use App\Models\Property\PropertyAmenity;
use App\Models\Property\PropertyAttachment;
use App\Models\Property\PropertyFacade;
use App\Models\Property\PropertyFeature;
use App\Models\Property\PropertyFinishingType;
use App\Models\Property\PropertyType;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    private array $arTypes = [
        'شقة', 'فيلا', 'دوبلكس', 'بنتهاوس',
        'استوديو', 'شقة دوبلكس', 'فيلا توين', 'شاليه', 'روف',
    ];

    private array $arAdjectives = [
        'فاخرة', 'مودرن', 'راقية', 'استثمارية', 'واسعة',
        'جديدة', 'مؤثثة', 'بتشطيب فاخر', 'عصرية', 'كلاسيكية',
        'مميزة', 'هادئة', 'عائلية', 'على أعلى مستوى',
    ];

    private array $arSpecialFeatures = [
        'مع مسبح خاص', 'مع حديقة خاصة', 'مع موقف خاص',
        'بإطلالة رائعة', 'مع سطح خاص', 'مع ملحق خارجي',
        'مع غرفة خادمة', 'مع مصعد خاص',
        'مع موقف سيارات مغلق', 'مع غرفة أطفال',
    ];

    private array $arLocation = [
        'في حي راقٍ', 'بالقرب من الخدمات', 'في موقع استراتيجي',
        'بالقرب من المترو', 'على شارع رئيسي', 'في مجتمع سكني متكامل',
        'بالقرب من المدارس الدولية', 'في أفضل أحياء المدينة',
        'مطل على معلم بارز', 'في قلب المدينة',
        'قريب من المستشفيات', 'في منطقة هادئة',
    ];

    private array $arCities = [
        'القاهرة', 'الإسكندرية', 'الجيزة', 'الغردقة', 'شرم الشيخ', 'الأقصر',
    ];

    private array $enTypes = [
        'Apartment', 'Villa', 'Duplex', 'Penthouse',
        'Studio', 'Duplex Apartment', 'Twin Villa', 'Chalet', 'Rooftop',
    ];

    private array $enAdjectives = [
        'Luxury', 'Modern', 'Premium', 'Investment', 'Spacious',
        'New', 'Furnished', 'High-End Finishing', 'Contemporary', 'Classic',
        'Distinguished', 'Peaceful', 'Family', 'Top Tier',
    ];

    private array $enSpecialFeatures = [
        'with Private Pool', 'with Private Garden', 'with Private Parking',
        'with Stunning View', 'with Private Terrace', 'with External Annex',
        'with Maids Room', 'with Private Elevator',
        'with Closed Garage', 'with Kids Room',
    ];

    private array $enLocation = [
        'in Elite Neighborhood', 'Close to All Services', 'in Strategic Location',
        'Near Metro Station', 'on Main Street', 'in Integrated Residential Community',
        'Near International Schools', 'in Best District',
        'Overlooking a Landmark', 'in City Center',
        'Close to Hospitals', 'in Quiet Area',
    ];

    private array $enCities = [
        'Cairo', 'Alexandria', 'Giza', 'Hurghada', 'Sharm El Sheikh', 'Luxor',
    ];

    private array $arSentences = [];
    private array $enSentences = [];

    private array $floors = ['1', '2', '3', '4', '5', 'G', 'M', '10', '15', '20'];

    public function __construct()
    {
        $this->arSentences = [
            'العقار يقع في موقع حيوي يتميز بسهولة الوصول إلى جميع الخدمات والمرافق الأساسية.',
            'الموقع قريب من الطرق الرئيسية مما يسهل التنقل إلى جميع أجزاء المدينة.',
            'يتميز الموقع بقربه من المساجد والمدارس والمستشفيات والمراكز التجارية الكبرى.',
            'العقار في موقع استراتيجي يشهد طلباً متزايداً على العقارات السكنية والتجارية.',
            'المنطقة محاطة بالخدمات المتكاملة من محطات وقود ومحلات تجارية وحدائق عامة.',

            'التشطيب فاخر باستخدام أجود المواد العالمية التي تضمن المتانة والجمال.',
            'جميع التشطيبات الداخلية عالية الجودة مع أرضيات رخامية وأسقف جبسية أنيقة.',
            'المطبخ مجهز بالكامل بأحدث الأجهزة الإيطالية والألمانية مع خزائن عصرية.',
            'دورات المياه بتشطيب فاخر مع أدوات صحية راقية وخلاطات ذهبية.',
            'النوافذ والأبواب عازلة للصوت والحرارة من أجود الأنواع العالمية.',
            'تكييف مركزي مخفي يغطي جميع أنحاء العقار بأعلى كفاءة.',

            'العقار استثماري ممتاز مع عائد إيجاري مرتفع يصل إلى ٨٪ سنوياً.',
            'المنطقة تشهد تطوراً عمرانياً سريعاً مما يضمن زيادة قيمة العقار مستقبلاً.',
            'معدل الإشغال في المنطقة مرتفع جداً مما يضمن عدم وجود فراغات.',
            'العقار مناسب للاستثمار طويل الأجل مع ضمان استقرار العوائد.',
            'طلب مستمر على العقارات في هذه المنطقة من المستثمرين والأفراد.',

            'مساحات داخلية واسعة تناسب العائلات الكبيرة وتوفر خصوصية تامة.',
            'غرف النوم واسعة ومشرقة مع خزائن حائط مدمجة في جميع الغرف.',
            'صالة عائلية كبيرة تتسع لجميع أفراد الأسرة مع إضاءة طبيعية ممتازة.',
            'غرفة طعام منفصلة ومجلس رجال واسع بتصميم راقٍ.',
            'الحديقة الخلفية مساحة خضراء كبيرة مثالية للأطفال والعائلة.',
            'ملحق خارجي مع غرفة خادمة وغرفة غسيل وحوش واسع.',

            'صيانة دورية مجانية تشمل جميع أنظمة العقار الكهربائية والميكانيكية.',
            'خدمات أمنية متكاملة على مدار الساعة مع نظام كاميرات مراقبة.',
            'مواقف سيارات متعددة تتسع لثلاث سيارات أو أكثر.',
            'مصعد عالي الجودة يخدم جميع الطوابق بسرعة وأمان.',
            'خزان ماء مستقل ونظام ضغط ماء عالي في جميع الأدوار.',

            'العقار قريب من الحدائق العامة والمنتزهات والملاعب الرياضية.',
            'يوجد مول تجاري كبير على بعد دقائق من العقار.',
            'جميع المرافق الترفيهية متوفرة في المنطقة من صالات رياضية ونوادي.',
            'قريب من أشهر المطاعم والمقاهي في المنطقة.',
            'المنطقة مجهزة بشبكات حديثة للصرف الصحي والكهرباء والألياف البصرية.',

            'نظام أمني متكامل بكاميرات مراقبة عالية الدقة وإنذار ضد السرقة.',
            'حارس أمن على مدار الساعة مع نظام تسجيل للزوار.',
            'المنطقة آمنة وهادئة مع إنارة شوارع ممتازة وتغطية أمنية كاملة.',
            'نظام إطفاء حريق متكامل وكاشفات دخان في جميع الغرف.',
            'أسوار عالية مع بوابة إلكترونية ونظام دخول ذكي.',

            'إطلالة رائعة على معالم المدينة من النوافذ الكبيرة والشرفة الواسعة.',
            'الشرفة تطل على منظر خلاب وتوفر مساحة إضافية للاسترخاء.',
            'إضاءة طبيعية ممتازة طوال اليوم بفضل النوافذ الزجاجية الكبيرة.',
            'الواجهة الزجاجية توفر إطلالة بانورامية على المنطقة المحيطة.',
            'شرفة سطح خاصة مع إطلالة ٣٦٠ درجة على أفق المدينة.',
        ];

        $this->enSentences = [
            'The property is located in a vibrant area with easy access to all services and essential facilities.',
            'Close to major roads, providing easy access to all parts of the city.',
            'Located near mosques, schools, hospitals, and major shopping centers.',
            'Strategically located in a high-demand area for residential and commercial properties.',
            'The neighborhood is surrounded by integrated services including gas stations, shops, and public parks.',

            'Premium finishing using the finest international materials ensuring durability and elegance.',
            'All interior finishes are high quality with marble flooring and elegant gypsum ceilings.',
            'The kitchen is fully equipped with latest Italian and German appliances with modern cabinets.',
            'Bathrooms have luxury finishes with high-end sanitary ware and gold-plated mixers.',
            'Windows and doors are sound and heat insulated from top international brands.',
            'Central hidden air conditioning covering all areas of the property with highest efficiency.',

            'Excellent investment property with high rental yield reaching 8% annually.',
            'The area is experiencing rapid urban development ensuring future property value appreciation.',
            'Occupancy rate in the area is very high, ensuring no vacancy periods.',
            'Suitable for long-term investment with guaranteed stable returns.',
            'Continuous demand for properties in this area from investors and individuals.',

            'Spacious interiors suitable for large families providing complete privacy.',
            'Bedrooms are spacious and bright with built-in wardrobes in all rooms.',
            'Large family living room accommodating all family members with excellent natural lighting.',
            'Separate dining room and spacious men\'s majlis with elegant design.',
            'Back garden is a large green space perfect for children and family.',
            'External annex with maid\'s room, laundry room, and wide courtyard.',

            'Free periodic maintenance covering all electrical and mechanical systems.',
            'Integrated security services around the clock with CCTV camera system.',
            'Multiple parking spaces accommodating three or more cars.',
            'High quality elevator serving all floors with speed and safety.',
            'Independent water tank and high water pressure system on all floors.',

            'Close to public parks, promenades, and sports fields.',
            'A large shopping mall is minutes away from the property.',
            'All entertainment facilities available in the area including gyms and clubs.',
            'Close to famous restaurants and cafes in the region.',
            'The area is equipped with modern sewage, electricity, and fiber optic networks.',

            'Integrated security system with high definition CCTV cameras and anti-theft alarm.',
            '24/7 security guard with visitor registration system.',
            'Safe and quiet area with excellent street lighting and complete security coverage.',
            'Integrated fire suppression system and smoke detectors in all rooms.',
            'High walls with electronic gate and smart entry system.',

            'Amazing city view from large windows and spacious balcony.',
            'The balcony overlooks a stunning view and provides extra relaxation space.',
            'Excellent natural lighting throughout the day thanks to large glass windows.',
            'Glass facade provides panoramic view of the surrounding area.',
            'Private rooftop terrace with 360-degree view of the city skyline.',
        ];
    }

    public function run()
    {
        $cities       = City::all();
        $types        = PropertyType::all();
        $finishes     = PropertyFinishingType::all();
        $features     = PropertyFeature::all();
        $amenities    = PropertyAmenity::all();
        $admins       = Admin::all();
        $facades      = PropertyFacade::all();

        if ($cities->isEmpty()) {
            throw new Exception("No cities found. Run CityNeighborhoodSeeder first.");
        }
        if ($types->isEmpty()) {
            throw new Exception("No property types found.");
        }
        if ($finishes->isEmpty()) {
            throw new Exception("No finishing types found.");
        }
        if ($features->isEmpty()) {
            throw new Exception("No property features found.");
        }
        if ($amenities->isEmpty()) {
            throw new Exception("No property amenities found.");
        }
        if ($admins->isEmpty()) {
            throw new Exception("No admins found.");
        }

        $neighborhoodsGrouped = Neighborhood::all()->groupBy('city_id');

        $mainImages = [];
        for ($i = 1; $i <= 69; $i++) {
            $mainImages[] = $i . '.webp';
        }

        $attachmentNumbers = range(1, 69);

        $unitImages = [];
        for ($i = 1; $i <= 8; $i++) {
            $unitImages[] = $i . '.webp';
        }

        $citiesWithNeighborhoods = $cities->filter(fn($c) => $neighborhoodsGrouped->has($c->id));
        if ($citiesWithNeighborhoods->isEmpty()) {
            throw new Exception("No cities with neighborhoods found.");
        }

        $total    = 10;
        $featuresCount = $features->count();
        $amenitiesCount = $amenities->count();
        $facadesArray = $facades->pluck('id')->toArray();
        $adminsArray = $admins->pluck('id')->toArray();
        $typesArray = $types->pluck('id')->toArray();
        $finishesArray = $finishes->pluck('id')->toArray();
        $featuresArray = $features->pluck('id')->toArray();
        $amenitiesArray = $amenities->pluck('id')->toArray();
        $mainImagesCount = count($mainImages);
        $attachmentNumbersCount = count($attachmentNumbers) - 1;
        $unitImagesCount = count($unitImages) - 1;
        $imageIndex = 0;

        for ($i = 1; $i <= $total; $i++) {
            $city = $citiesWithNeighborhoods->random();
            $neighborhood = $neighborhoodsGrouped[$city->id]->random();

            $purpose = mt_rand(0, 1) === 0 ? 'sale' : 'rent';

            $propTypeIndex = mt_rand(0, count($this->arTypes) - 1);

            [$arTitle, $enTitle] = $this->generateTitles($propTypeIndex, $purpose);

            $priceData = $this->generatePriceByType($propTypeIndex, $purpose);

            $salePrice     = $priceData['sale'];
            $rentMonthly   = $priceData['monthly'];
            $rentQuarterly = $priceData['quarterly'];
            $rentSemiAnnually = $priceData['semi_annually'];
            $rentAnnually  = $priceData['annually'];

            $area = $this->generateAreaByType($propTypeIndex);
            $bedrooms = $this->generateBedroomsByType($propTypeIndex);
            $bathrooms = $bedrooms !== null ? max(1, $bedrooms - mt_rand(0, 1)) : null;

            $arDesc = $this->generateArabicDescription();
            $enDesc = $this->generateEnglishDescription();

            $property = Property::create([
                'uuid'                       => Str::uuid(),
                'main_image'                 => $mainImages[$imageIndex++ % $mainImagesCount],
                'purpose'                    => $purpose,
                'area'                       => $area,
                'sale_price'                 => $salePrice,
                'rent_price_monthly'         => $rentMonthly,
                'rent_price_quarterly'       => $rentQuarterly,
                'rent_price_semi_annually'   => $rentSemiAnnually,
                'rent_price_annually'        => $rentAnnually,
                'bedrooms'                   => $bedrooms,
                'bathrooms'                  => $bathrooms,
                'floor'                      => $this->floors[mt_rand(0, count($this->floors) - 1)],
                'number_of_floors'           => in_array($propTypeIndex, [1, 6]) ? mt_rand(1, 3) : mt_rand(1, 15),
                'plan_number'                => 'PLN-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'plot_number'                => 'PLT-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'license_number'             => 'LIC-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
                'youtube_video_url'          => null,
                'facade_id'                  => !empty($facadesArray) ? $facadesArray[mt_rand(0, count($facadesArray) - 1)] : null,
                'admin_id'                   => $adminsArray[mt_rand(0, count($adminsArray) - 1)],
                'google_map_iframe'          => null,
                'city_id'                    => $city->id,
                'neighborhood_id'            => $neighborhood?->id,
                'property_type_id'           => $typesArray[mt_rand(0, count($typesArray) - 1)],
                'property_finishing_type_id' => $finishesArray[mt_rand(0, count($finishesArray) - 1)],
                'is_archived'                => false,
                'approval_status'            => 'approved',
                'title_normalized_ar'        => normalizeArabic($arTitle),
                'description_normalized_ar'  => normalizeArabic($arDesc),
                'title_normalized_en'        => Str::lower($enTitle),
                'description_normalized_en'  => Str::lower($enDesc),
                'availability_status'        => 'available',
                'views_count'                => mt_rand(0, 10000),
            ]);

            $property->translations()->create([
                'locale'      => 'ar',
                'title'       => $arTitle,
                'description' => $arDesc,
            ]);

            // English disabled - app is Arabic only
            // $property->translations()->create([
            //     'locale'      => 'en',
            //     'title'       => $enTitle,
            //     'description' => $enDesc,
            // ]);

            $featurePickCount = min(mt_rand(1, 5), $featuresCount);
            $selectedFeatures = [];
            $usedFeatureKeys = [];
            for ($f = 0; $f < $featurePickCount; $f++) {
                $key = mt_rand(0, $featuresCount - 1);
                if (!isset($usedFeatureKeys[$key])) {
                    $usedFeatureKeys[$key] = true;
                    $selectedFeatures[] = $featuresArray[$key];
                }
            }
            if (!empty($selectedFeatures)) {
                $property->features()->sync($selectedFeatures);
            }

            $amenityPickCount = min(mt_rand(2, 7), $amenitiesCount);
            $selectedAmenities = [];
            $usedAmenityKeys = [];
            for ($a = 0; $a < $amenityPickCount; $a++) {
                $key = mt_rand(0, $amenitiesCount - 1);
                if (!isset($usedAmenityKeys[$key])) {
                    $usedAmenityKeys[$key] = true;
                    $selectedAmenities[] = $amenitiesArray[$key];
                }
            }
            if (!empty($selectedAmenities)) {
                $property->amenities()->sync($selectedAmenities);
            }

            $numAttachments = mt_rand(5, 12);
            for ($a = 0; $a < $numAttachments; $a++) {
                PropertyAttachment::create([
                    'property_id'     => $property->id,
                    'attachment_name' => $attachmentNumbers[mt_rand(0, $attachmentNumbersCount)] . '.webp',
                    'extension'       => 'webp',
                    'type'            => 'image',
                ]);
            }

            $numUnits = mt_rand(2, 5);
            for ($u = 0; $u < $numUnits; $u++) {
                    $unitData = [
                        'unit_number' => mt_rand(1, 100) <= 70 ? 'U-' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT) : null,
                        'area'        => mt_rand(1, 100) <= 80 ? mt_rand(30, 500) : null,
                        'bedrooms'    => mt_rand(1, 100) <= 80 ? mt_rand(1, 5) : null,
                        'bathrooms'   => mt_rand(1, 100) <= 80 ? mt_rand(1, 4) : null,
                        'price'       => mt_rand(1, 100) <= 80 ? mt_rand(100000, 3000000) : null,
                        'image'       => $unitImages[mt_rand(0, $unitImagesCount)],
                        'admin_id'    => $adminsArray[mt_rand(0, count($adminsArray) - 1)],
                    ];
                    $property->units()->create($unitData);
                }

            if ($i % 100 === 0) {
                $this->command->info("Created {$i} / {$total} properties...");
            }
        }

        $this->command->info("✔ Completed: {$total} properties seeded successfully.");
    }

    private function generateTitles(int $typeIndex, string $purpose): array
    {
        $arType = $this->arTypes[$typeIndex];
        $enType = $this->enTypes[$typeIndex];

        $arAdj = $this->arAdjectives[mt_rand(0, count($this->arAdjectives) - 1)];
        $enAdj = $this->enAdjectives[mt_rand(0, count($this->enAdjectives) - 1)];

        $purposeAr = $purpose === 'sale' ? 'للبيع' : 'للإيجار';
        $purposeEn = $purpose === 'sale' ? 'for Sale' : 'for Rent';

        $cityAr = $this->arCities[mt_rand(0, count($this->arCities) - 1)];
        $cityEn = $this->enCities[array_search($cityAr, $this->arCities)];

        $specialIdx = mt_rand(0, count($this->arSpecialFeatures) - 1);
        $locIdx = mt_rand(0, count($this->arLocation) - 1);

        $area = $this->generateAreaByType($typeIndex);

        $arExtra = ['بمساحة واسعة', 'بتصميم عصري', 'بتشطيب راقٍ', 'بإطلالة مميزة', 'مساحات كبيرة'];
        $enExtra = ['Spacious Layout', 'Modern Design', 'Premium Finish', 'Great View', 'Large Areas'];

        $partsAr = [$arType, $arAdj, $purposeAr];
        $partsEn = [$enAdj, $enType, $purposeEn];

        $partsAr[] = "مساحة {$area}م";
        $partsEn[] = "{$area} Sqm";

        $partsAr[] = $this->arSpecialFeatures[$specialIdx];
        $partsEn[] = $this->enSpecialFeatures[$specialIdx];

        $partsAr[] = $this->arLocation[$locIdx];
        $partsEn[] = $this->enLocation[$locIdx];

        $partsAr[] = "في {$cityAr}";
        $partsEn[] = "in {$cityEn}";

        $arTitle = implode(' ', $partsAr);
        $enTitle = implode(' ', $partsEn);

        if (mb_strlen($arTitle) < 50) {
            $arTitle .= ' ' . $arExtra[mt_rand(0, count($arExtra) - 1)];
        }
        if (mb_strlen($enTitle) < 50) {
            $enTitle .= ' - ' . $enExtra[mt_rand(0, count($enExtra) - 1)];
        }

        return [$arTitle, $enTitle];
    }

    private function generateArabicDescription(): string
    {
        $count = mt_rand(4, 8);
        $max = count($this->arSentences) - 1;
        $selected = [];

        for ($i = 0; $i < $count; $i++) {
            $selected[] = $this->arSentences[mt_rand(0, $max)];
        }

        $selected = array_values(array_unique($selected));

        if (count($selected) < $count) {
            $remaining = $count - count($selected);
            for ($i = 0; $i < $remaining; $i++) {
                $selected[] = $this->arSentences[mt_rand(0, $max)];
            }
        }

        shuffle($selected);
        return implode("\n", $selected);
    }

    private function generateEnglishDescription(): string
    {
        $count = mt_rand(4, 8);
        $max = count($this->enSentences) - 1;
        $selected = [];

        for ($i = 0; $i < $count; $i++) {
            $selected[] = $this->enSentences[mt_rand(0, $max)];
        }

        $selected = array_values(array_unique($selected));

        if (count($selected) < $count) {
            $remaining = $count - count($selected);
            for ($i = 0; $i < $remaining; $i++) {
                $selected[] = $this->enSentences[mt_rand(0, $max)];
            }
        }

        shuffle($selected);
        return implode("\n", $selected);
    }

    private function generatePriceByType(int $typeIndex, string $purpose): array
    {
        $isVilla = in_array($typeIndex, [1, 6]);
        $isLuxury = in_array($typeIndex, [3, 7, 8]);

        if ($purpose === 'sale') {
            if ($isVilla) {
                $sale = mt_rand(800000, 15000000);
            } elseif ($isLuxury) {
                $sale = mt_rand(1200000, 12000000);
            } else {
                $sale = mt_rand(200000, 4000000);
            }
            return ['sale' => $sale, 'monthly' => null, 'quarterly' => null, 'semi_annually' => null, 'annually' => null];
        }

        if ($isVilla) {
            $monthly = mt_rand(5000, 30000);
        } elseif ($isLuxury) {
            $monthly = mt_rand(8000, 40000);
        } else {
            $monthly = mt_rand(1500, 10000);
        }

        return [
            'sale' => null,
            'monthly' => $monthly,
            'quarterly' => $monthly * 3,
            'semi_annually' => $monthly * 6,
            'annually' => $monthly * 12,
        ];
    }

    private function generateAreaByType(int $typeIndex): ?float
    {
        $isVilla = in_array($typeIndex, [1, 6]);

        if ($isVilla) {
            return mt_rand(250, 1500);
        }
        return mt_rand(60, 500);
    }

    private function generateBedroomsByType(int $typeIndex): ?int
    {
        $isVilla = in_array($typeIndex, [1, 6]);
        $isStudio = $typeIndex === 4;

        if ($isStudio) {
            return 0;
        }
        if ($isVilla) {
            return mt_rand(3, 7);
        }
        return mt_rand(1, 5);
    }
}
