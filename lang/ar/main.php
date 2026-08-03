<?php
return [
    // Global
    'app_name' => 'أمكنة',

    /**
     * Register
     * - client
     * -- form
     */

    'home'     => [
        'latest_properties'         => 'أحدث العقارات',
        'most_viewed_properties'    => 'الأكثر مشاهدة',
        'properties_for_rent'       => 'عقارات للإيجار',
        'properties_for_sale'       => 'عقارات للبيع',
        'explore_latest_properties' => 'استكشف المشاريع الجديدة',
        'search_by_budget'          => 'ابحث حسب ميزانيتك',
        'budget_subtitle'           => 'اختر الفئة المناسبة لك واستعرض أفضل العقارات المتاحة',
        'budget_starts_from'        => 'يبدأ من',
        'budget_above'              => 'أكثر من',
        'sar_currency'              => 'الجنيه المصري',
        'view_properties'           => 'عرض العقارات',
        'popular_cities'            => 'المدن الشائعة',
        'cities_subtitle'           => 'تصفح العقارات في أشهر المدن المصرية',
        'browse_neighborhoods'      => 'تصفح الأحياء',
        'neighborhoods_subtitle'    => 'استكشف العقارات في أشهر الأحياء',
        'explore_city'              => 'استكشف العقارات',
        'city_riyadh'               => 'القاهرة',
        'city_jeddah'               => 'الإسكندرية',
        'city_dammam'               => 'الجيزة',
        'city_khobar'               => 'الغردقة',
        'why_choose_us'             => 'لماذا تختارنا؟',
        'why_subtitle'              => 'نحن المنصة العقارية الأكثر ثقة وانتشاراً',
        'why_reliable'              => 'موثوق',
        'why_reliable_desc'         => 'منصة عقارية معتمدة وموثوقة',
        'why_updated'               => 'بيانات محدثة',
        'why_updated_desc'          => 'عقارات محدثة بشكل مستمر',
        'why_options'               => 'خيارات متعددة',
        'why_options_desc'          => 'تشكيلة واسعة من العقارات',
        'why_support'               => 'دعم العملاء',
        'why_support_desc'          => 'فريق دعم متاح لمساعدتك',
        'most_viewed_subtitle'      => 'العقارات الأكثر إقبالاً من المستخدمين',
        'rent_subtitle'             => 'اعثر على منزل أحلامك للإيجار',
        'sale_subtitle'             => 'أفضل الفرص لشراء عقارك المثالي',
    ],

    'register' => [
        'client' => [
            'title'       => 'أنشئ حسابك في :app',
            'description' => 'احفظ العقارات، وتابع اهتماماتك، وشاهد الإعلانات اللي تواصلت عليها — كل هذا في مكان واحد.',

            'form'        => [
                'name'             => 'الاسم',
                'name_placeholder' => 'الاسم الأول واسم العائلة',
                'email'            => 'البريد الإلكتروني (اختياري)',
                'phone'            => 'الهاتف',
                'phone_number'     => 'رقم الهاتف',
                'password'         => 'كلمة المرور',
                'submit'           => 'تسجيل',
                'have_account'     => 'عندك حساب؟ سجّل الدخول',
                'password_help'    => 'استخدم 8+ أحرف مع حرف كبير/صغير ورقم.',
            ],
        ],
    ],

    /** Footer **/
    'footer'   => [
        'quick_links'       => 'روابط هامة',
        'home'              => 'الرئيسية',
        'projects'          => 'المشاريع',
        'my_blog'           => 'مدونتي',
        'services'          => 'الخدمات',
        'contact_us'        => 'اتصل بنا',
        'about_us'          => 'من نحن',
        'privacy_policy'    => 'سياسة الخصوصية',
        'faqs'              => 'الأسئلة الشائعة',
        //
        'featured_articles' => 'مقالات مميزة',
        //
        'follow_us'         => 'تابعنا',
        //
        'my_websites'       => 'مواقعي',
        // Badges
        'soon'              => 'قريباً',
        'new'               => 'جديد',
        //
        'copyright'         => 'حقوق النشر',

        // New Footer Items
        'description'       => 'شريكك الموثوق في العثور على العقار المثالي. اكتشف منزل أحلامك من خلال قوائمنا الشاملة.',
        'all_properties'    => 'جميع العقارات',
        'for_sale'          => 'للبيع',
        'for_rent'          => 'للإيجار',
        'support'           => 'الدعم',
        'contact'           => 'اتصل بنا',
        'terms'             => 'شروط الخدمة',
        'login'             => 'تسجيل الدخول',
        'register'          => 'تسجيل حساب',
        'newsletter'        => 'اشترك في النشرة الإخبارية',
        'email_placeholder' => 'بريدك الإلكتروني',
        'rights'            => 'جميع الحقوق محفوظة',
        'terms_short'       => 'الشروط',
        'sitemap'           => 'خريطة الموقع',
    ],

    'property' => [
        'properties'                       => 'العقارات',
        'no_results_found'                 => 'لم يتم العثور على نتائج',
        'per_month'                        => 'في الشهر',
        'sale'                             => 'بيع',
        'rent'                             => 'إيجار',
        'square_meter'                     => 'م²',
        'bedroom'                          => 'غرفة نوم',
        'bathroom'                         => 'حمام',
        'call'                             => 'اتصل',
        // New translations for details section
        'type'                             => 'النوع',
        'area'                             => 'المساحة',
        'bedrooms'                         => 'غرف النوم',
        'bathrooms'                        => 'الحمامات',
        'floor'                            => 'الطابق',
        'front_view'                       => 'الواجهة',
        'purpose'                          => 'الغرض',
        'finishing'                        => 'التشطيب',
        'region'                           => 'المنطقة',
        'license_number'                   => 'رقم الرخصة',
        'plan_number'                      => 'رقم المخطط',
        'plot_number'                      => 'رقم القطعة',
        'price'                            => 'السعر',
        'models'                           => 'النماذج',
        //
        'features'                         => 'المميزات',
        'amenities'                        => 'المرافق',
        'interested_title'                 => 'سجل اهتمامك',
        'contact_prompt'                   => 'هل لديك أسئلة؟ أرسل لنا تفاصيلك وسنساعدك على الفور.',
        // ...
        'full_name'                        => 'الاسم بالكامل',
        'phone'                            => 'الهاتف',
        'message'                          => 'الرسالة',
        'email_optional'                   => 'البريد الإلكتروني ( اختياري )',
        'placeholder_name'                 => 'اسمك',
        'placeholder_phone'                => 'رقم الهاتف والواتساب',
        'placeholder_email'                => 'عنوان البريد الإلكتروني',
        'placeholder_interest_message'     => 'مرحباً :name 👋 اكتب رسالتك أو استفسارك هنا',
        //
        'interest_already_registered'      => 'لقد سجلت اهتمامك بهذا العقار بالفعل. فريقنا سيتواصل معك قريباً.',
        'interest_registered_successfully' => 'تم تسجيل اهتمامك بنجاح. فريقنا سيتواصل معك قريباً.',
        // ...
        'request_received_title'           => 'تم استلام طلبك',
        'request_received_message'         => 'سيتواصل معك أحد مستشارينا قريباً.',
        // Page Sections
        'details'                          => 'التفاصيل',
        'description'                      => 'الوصف',
        'read_more'                        => 'قراءة المزيد',
        'location'                         => 'الموقع',
        // Media
        'watch_video'                      => 'شاهد الفيديو',
        // CTA
        'send_interest'                    => 'إرسال الاهتمام',
    ],

    'filters'  => [
        'filters'                => 'فلترة العقارات',
        'properties_found_label' => 'العقارات',
        'location'               => 'الموقع',
        'location_placeholder'   => 'المدينة أو الحي',
        'property_type'          => 'نوع العقار',
        'section'                => 'القسم',
        'price'                  => 'السعر',
        'area'                   => 'المساحة',
        'rooms'                  => 'عدد الغرف',
        'baths'                  => 'دورات المياه',
        'all'                    => 'الكل',
        'search'                 => 'البحث',
        'sar'                    => 'ج.م',
        'm2'                     => 'م²',
        'for_rent'               => 'للإيجار',
        'for_sale'               => 'للبيع',
        'city'                   => 'مدينة',
        'neighborhood'           => 'حي',
        //

        //
        'sort'                   => 'ترتيب',
        'newest'                 => 'الأحدث',
        'price_low_to_high'      => 'السعر الأقل للأعلى',
        'price_high_to_low'      => 'السعر الأعلى للأقل',
        //
        'clear_all'              => 'مسح',
    ],

    /** Contact Page **/
    'contact'  => [
        // Meta Tags
        'meta_title'          => 'اتصل بنا',
        'meta_desc'           => 'تواصل مع فريق :app_name - نحن هنا لمساعدتك في جميع استفساراتك العقارية',

        // Hero Section
        'title'               => 'اتصل بنا',
        'sub_title'           => 'لنتحدث',
        'desc'                => 'سواء كان لديك سؤال أو استفسار، فريقنا جاهز للرد',

        // Contact Methods
        'get_in_touch'        => 'تواصل معنا',
        'whatsapp'            => 'واتساب',
        'chat_now'            => 'تحدث الآن',
        'phone'               => 'الهاتف',
        'email'               => 'البريد الإلكتروني',
        'send_message'        => 'أرسل رسالتك',

        // Aria Labels
        'whatsapp_aria'       => 'تحدث معنا على واتساب',
        'phone_aria'          => 'اتصل بنا عبر الهاتف',
        'email_aria'          => 'أرسل لنا بريداً إلكترونياً',

        // Form Fields
        'name'                => 'الاسم بالكامل',
        'name_placeholder'    => 'أدخل اسمك بالكامل',
        'email_placeholder'   => 'example@email.com',
        'phone_placeholder'   => '+20 123 456 7890',
        'subject'             => 'الموضوع',
        'subject_placeholder' => 'عن ماذا تريد التحدث؟',
        'message'             => 'رسالتك',
        'message_placeholder' => 'اكتب رسالتك هنا...',
        'send_btn'            => 'إرسال الرسالة',

        // Location Section
        'our_location'        => 'موقعنا',
        // 'default_address'     => 'شارع التحرير، الطابق الخامس',
        // 'default_city'        => 'القاهرة',
        // 'country'             => 'مصر',
        // 'working_hours'       => 'ساعات العمل',
        // 'saturday_thursday'   => 'السبت - الخميس',
        // 'friday'              => 'الجمعة',
        //  'am'                  => 'صباحاً',
        //  'pm'                  => 'مساءً',
        //  'closed'              => 'مغلق',
        'map_title'           => 'خريطة موقعنا',
    ],

    /** Privacy Policy Page **/
    'privacy'  => [
        'meta_title'   => 'سياسة الخصوصية',
        'meta_desc'    => 'اقرأ سياسة الخصوصية الخاصة بنا وتعرف على كيفية حماية بياناتك الشخصية',
        'title'        => 'سياسة الخصوصية',
        'last_updated' => 'آخر تحديث',

        'contact_us'   => [
            'title'   => 'اتصل بنا',
            'content' => 'إذا كان لديك أي أسئلة حول سياسة الخصوصية هذه، يرجى الاتصال بنا:',
        ],
    ],

    /** FAQs Page **/
    'faqs'     => [
        'meta_title'         => 'الأسئلة الشائعة',
        'meta_desc'          => 'إجابات على الأسئلة الأكثر شيوعاً حول منصتنا العقارية',
        'title'              => 'الأسئلة الشائعة',
        'subtitle'           => 'إجابات سريعة على أسئلتك الأكثر شيوعاً',
        'search_placeholder' => 'ابحث عن سؤالك هنا...',
        'still_questions'    => [
            'title'    => 'لا تزال لديك أسئلة؟',
            'subtitle' => 'فريقنا هنا لمساعدتك. لا تتردد في الاتصال بنا',
            'button'   => 'اتصل بنا',
        ],
    ],

];
