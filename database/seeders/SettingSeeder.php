<?php
namespace Database\Seeders;

use App\Models\Dashboard\Settings;
use App\Models\Faqs\Faqs;
use App\Models\Faqs\FaqsTranslation;
use App\Models\Pages;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (Settings::count() == 0) {
            Settings::create([
                'logo'        => 'logo.png',
                'footer_logo' => 'footer.png',
                // 'website_name' => 'Sahd Property',
                // 'website_desc' => 'شركة سهد للتطوير العقاري هي شركة رائدة في مجال التطوير العقاري والتسويق، ملتزمة بتقديم حلول عقارية متكاملة تلبي احتياجات العملاء والمستثمرين على حد',
                'email'       => 'info@amkna.com',
                'phone'       => '',
                'facebook'    => '',
                'whatsapp'    => '',
                'snapchat'    => '',
                'tiktok'      => '',
                'youtube'     => '',
            ]);
        }

        Pages::create([
            'page'              => 'home',
            'slider'            => '{"76657907":{"rank":0,"file_name":"banner-home.webp","type":"image","id":76657907}}',
            'header_title_desc' => '{"442130739":{"lang":"en","title":"Find Your Property in\r\nEgypt with *Sahd*","desc":null,"id":442130739},"753524184":{"lang":"ar","title":"مكانك القادم يبدأ هنا","desc":null,"id":753524184}}',
        ]);

        $faqs = [
            [
                'title' => [
                    'ar' => 'ما هي منصتكم العقارية؟',
                    'en' => 'What is your real estate platform?',
                ],
                'desc'  => [
                    'ar' => 'نحن منصة عقارية متخصصة تربط البائعين والمشترين والمستأجرين...',
                    'en' => 'We are a specialized real estate platform connecting sellers, buyers, and renters...',
                ],
            ],
            [
                'title' => [
                    'ar' => 'هل التسجيل في المنصة مجاني؟',
                    'en' => 'Is registration on the platform free?',
                ],
                'desc'  => [
                    'ar' => 'نعم، التسجيل والبحث عن العقارات مجاني تماماً...',
                    'en' => 'Yes, registration and property search are completely free...',
                ],
            ],

            [
                'title' => [
                    'ar' => 'كيف يمكنني التواصل مع البائع؟',
                    'en' => 'How can I contact the seller?',
                ],
                'desc'  => [
                    'ar' => 'بعد العثور على العقار المناسب يمكنك التواصل مباشرة...',
                    'en' => 'After finding the right property, you can contact the seller directly...',
                ],
            ],

            [

                'title' => [
                    'ar' => 'كيف أضيف إعلان عقار؟',
                    'en' => 'How do I add a property listing?',
                ],
                'desc'  => [
                    'ar' => 'سجل دخولك ثم اضغط إضافة عقار...',
                    'en' => 'Log in then click Add Property...',
                ],
            ],

            [

                'title' => [
                    'ar' => 'هل يمكنني تعديل إعلاني بعد النشر؟',
                    'en' => 'Can I edit my listing after publication?',
                ],
                'desc'  => [
                    'ar' => 'نعم يمكنك التعديل في أي وقت...',
                    'en' => 'Yes, you can edit anytime...',
                ],
            ],

            [

                'title' => [
                    'ar' => 'كم عدد الصور التي يمكنني إضافتها؟',
                    'en' => 'How many photos can I add?',
                ],
                'desc'  => [
                    'ar' => 'يمكنك إضافة حتى 20 صورة...',
                    'en' => 'You can add up to 20 photos...',
                ],
            ],

            [

                'title' => [
                    'ar' => 'ما هي طرق الدفع المتاحة؟',
                    'en' => 'What payment methods are available?',
                ],
                'desc'  => [
                    'ar' => 'نقبل فيزا وماستركارد والتحويل البنكي...',
                    'en' => 'We accept Visa, Mastercard, bank transfer...',
                ],
            ],

            [

                'title' => [
                    'ar' => 'هل يمكنني استرداد الأموال؟',
                    'en' => 'Can I get a refund?',
                ],
                'desc'  => [
                    'ar' => 'يمكنك طلب الاسترداد خلال 7 أيام...',
                    'en' => 'You can request a refund within 7 days...',
                ],
            ],

            [

                'title' => [
                    'ar' => 'كيف أغير كلمة المرور؟',
                    'en' => 'How do I change my password?',
                ],
                'desc'  => [
                    'ar' => 'من إعدادات الحساب اختر تغيير كلمة المرور...',
                    'en' => 'Go to Account Settings and change password...',
                ],
            ],

            [

                'title' => [
                    'ar' => 'هل يمكنني حذف حسابي؟',
                    'en' => 'Can I delete my account?',
                ],
                'desc'  => [
                    'ar' => 'يمكنك حذف الحساب نهائياً من الإعدادات...',
                    'en' => 'You can permanently delete your account...',
                ],
            ],
        ];

        /**
         *
         *
         *
         *
         *
         *
         */
        $arabicFaqs = [
            [
                'title' => 'ما هي منصتكم العقارية؟',
                'desc'  => 'نحن منصة عقارية متخصصة تربط البائعين والمشترين والمستأجرين. نوفر مجموعة واسعة من العقارات السكنية والتجارية في مناطق مختلفة مع خدمات متقدمة لتسهيل عملية البحث والشراء.',
            ],
            [
                'title' => 'هل التسجيل في المنصة مجاني؟',
                'desc'  => 'نعم، التسجيل والبحث عن العقارات مجاني تماماً. نفرض رسوماً فقط على الخدمات المميزة مثل القوائم المميزة أو التقارير التفصيلية للعقارات.',
            ],
            [
                'title' => 'كيف يمكنني التواصل مع البائع؟',
                'desc'  => 'بعد العثور على العقار المناسب، يمكنك النقر على زر "اتصل الآن" أو "واتساب" للتواصل مباشرة مع البائع أو الوكيل العقاري.',
            ],
            [
                'title' => 'كيف أضيف إعلان عقار؟',
                'desc'  => 'سجل دخولك إلى حسابك، ثم انقر على "إضافة عقار". املأ جميع التفاصيل المطلوبة، أضف صوراً عالية الجودة، وحدد السعر. سيتم مراجعة إعلانك ونشره خلال 24 ساعة.',
            ],
            [
                'title' => 'هل يمكنني تعديل إعلاني بعد النشر؟',
                'desc'  => 'نعم، يمكنك تعديل تفاصيل إعلانك في أي وقت من لوحة التحكم الخاصة بك. تظهر التغييرات فوراً بعد الحفظ.',
            ],
            [
                'title' => 'كم عدد الصور التي يمكنني إضافتها؟',
                'desc'  => 'يمكنك إضافة حتى 20 صورة لكل إعلان. نوصي باستخدام صور واضحة وعالية الجودة تظهر جميع أجزاء العقار.',
            ],
            [
                'title' => 'ما هي طرق الدفع المتاحة؟',
                'desc'  => 'نقبل الدفع عبر بطاقات الائتمان، التحويل البنكي، والمحافظ الإلكترونية. جميع المعاملات آمنة ومشفرة.',
            ],
            [
                'title' => 'هل يمكنني استرداد الأموال؟',
                'desc'  => 'نعم، يمكنك طلب استرداد الأموال خلال 7 أيام من الدفع في حالة وجود مشكلة تقنية.',
            ],
            [
                'title' => 'كيف أغير كلمة المرور؟',
                'desc'  => 'انتقل إلى إعدادات الحساب واختر تغيير كلمة المرور ثم احفظ التغييرات.',
            ],
            [
                'title' => 'هل يمكنني حذف حسابي؟',
                'desc'  => 'نعم، يمكنك حذف حسابك بشكل دائم من الإعدادات وسيتم حذف جميع بياناتك.',
            ],
        ];

        $englishFaqs = [
            [
                'title' => 'What is your real estate platform?',
                'desc'  => 'We are a specialized real estate platform connecting sellers, buyers, and renters with advanced services.',
            ],
            [
                'title' => 'Is registration on the platform free?',
                'desc'  => 'Yes, registration and property search are completely free. Premium services are paid.',
            ],
            [
                'title' => 'How can I contact the seller?',
                'desc'  => 'You can contact the seller directly via Call Now or WhatsApp.',
            ],
            [
                'title' => 'How do I add a property listing?',
                'desc'  => 'Log in, click Add Property, fill details, upload photos and publish.',
            ],
            [
                'title' => 'Can I edit my listing after publication?',
                'desc'  => 'Yes, you can edit your listing anytime from your dashboard.',
            ],
            [
                'title' => 'How many photos can I add?',
                'desc'  => 'You can upload up to 20 photos per listing.',
            ],
            [
                'title' => 'What payment methods are available?',
                'desc'  => 'We accept credit cards, bank transfer, and e-wallets.',
            ],
            [
                'title' => 'Can I get a refund?',
                'desc'  => 'Yes, refunds can be requested within 7 days in case of issues.',
            ],
            [
                'title' => 'How do I change my password?',
                'desc'  => 'Go to Account Settings and update your password.',
            ],
            [
                'title' => 'Can I delete my account?',
                'desc'  => 'Yes, you can permanently delete your account from settings.',
            ],
        ];

        foreach ($arabicFaqs as $index => $arItem) {

            $faq = Faqs::create();

            // Arabic translation
            FaqsTranslation::create([
                'faqs_id' => $faq->id,
                'locale'  => 'ar',
                'title'   => $arItem['title'],
                'desc'    => $arItem['desc'],
            ]);

            // English translation (same index)
            FaqsTranslation::create([
                'faqs_id' => $faq->id,
                'locale'  => 'en',
                'title'   => $englishFaqs[$index]['title'],
                'desc'    => $englishFaqs[$index]['desc'],
            ]);
        }
    }
}
