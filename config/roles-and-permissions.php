<?php
return [

    //
    'owner'               => ['owner' => 'owner'],
    //
    'sales'               => ['sales' => 'sales'],
    //
    'admin'               => [
        'admins'                      => 'عرض صفحة المشرفين',
        'show_another_admins_profile' => 'السماح بمشاهدة ملف مشرف آخر',
        'create_admin'                => 'إمكانية إضافة مشرف جديد',
        'activate_deactivate_admin'   => 'فتح التحكم لتغيير حالة حساب المشرفين',
    ],
    //
    'interests'           => [
        'interests_view_page'            => 'السماح بالدخول إلى صفحة إهتمامات العملاء',
        'interests_advanced_search'      => 'السماح باستخدام البحث المتقدم داخل الإهتمامات',
        'interests_view_details'         => 'السماح بعرض جميع تفاصيل الإهتمام والبيانات المرتبطة به',
        'interests_add_deal'             => 'السماح بإضافة صفقة جديدة مرتبطة بهذا الإهتمام',
        'interests_update_deal_status'   => 'السماح بتعديل حالة الصفقة أو تغيير الإجراء الحالي لها',
        'interests_change_assigned_user' => 'السماح بتغيير الموظف المسؤول عن متابعة هذا الإهتمام',
        'interests_delete'               => 'السماح بحذف الإهتمام نهائياً من النظام', // Not Use For Now
        'interests_export_data'          => 'السماح بتصدير بيانات الإهتمامات',
    ],
    //
    'properties'          => [
        'properties_view_all'        => 'السماح بعرض جميع الوحدات داخل النظام',
        'properties_allow_search'    => 'السماح باستخدام البحث المتقدم في الوحدات',
        'properties_create'          => 'السماح بإضافة وحدة جديدة إلى النظام',
        'properties_edit'            => 'السماح بتعديل بيانات الوحدة',
        'properties_delete'          => 'السماح بحذف الوحدة نهائياً من النظام',
        'properties_allow_copy_link' => 'السماح بنسخ رابط صفحة الوحدة للمشاركة',
    ],
    //
    'clients'             => [
        'clients_view_all_page'   => 'السماح بالدخول إلى صفحة جميع العملاء داخل النظام',
        'clients_allow_search'    => 'السماح باستخدام البحث المتقدم داخل العملاء',
        'clients_view_details'    => 'السماح بعرض بيانات وتفاصيل حساب العميل',
        'clients_delete'          => 'السماح بحذف حساب العميل نهائياً من النظام',
        'clients_ban_account'     => 'السماح بحظر حساب العميل ومنعه من استخدام النظام',
        'clients_edit'            => 'السماح بتعديل بيانات حساب العميل',
        'clients_export_data'     => 'السماح بتصدير بيانات العملاء بصيغ مختلفة مثل Excel أو PDF',
        'clients_create'          => 'السماح بإنشاء حساب عميل جديد داخل النظام',
        'clients_view_statistics' => 'السماح بعرض إحصائيات وتحليلات أداء العملاء داخل النظام',
    ],
    //
    'deals'               => [
        'deals_view_all_page'         => 'السماح بالدخول إلى صفحة جميع الصفقات داخل النظام',
        'deals_export_data'           => 'السماح بتصدير بيانات الصفقات بصيغ مختلفة مثل Excel أو PDF',
        'deals_create'                => 'السماح بإضافة صفقة جديدة إلى النظام',
        'deals_allow_search'          => 'السماح باستخدام البحث المتقدم داخل الصفقات',
        'deals_view_details'          => 'السماح بعرض تفاصيل الصفقة وبياناتها الكاملة',
        'deals_view_statistics'       => 'السماح بعرض تحليلات وإحصائيات أداء الصفقات داخل النظام',
        'deals_edit'                  => 'السماح بتعديل بيانات الصفقة وجميع ملحقاتها',
        'deals_change_status'         => 'السماح بتغيير حالة الصفقة داخل النظام',
        'deals_assign_admin'          => 'السماح بتعيين أو تغيير المسؤول عن متابعة الصفقة',
        'deals_delete'                => 'السماح بحذف الصفقة نهائياً من النظام',
        'deals_view_followups'        => 'السماح بعرض صفحة جميع متابعات الصفقات',
        'deals_edit_followup'         => 'السماح بتعديل متابعة الصفقة',
        'deals_delete_followup'       => 'السماح بحذف متابعة / متابعات معينة مرتبطة بالصفقة من النظام',
        'deals_change_assigned_admin' => 'السماح بتغيير الموظف المسؤول عن الصفقة',

    ],
    //
    'owner_associations'  => [
        'owner_associations_create'             => 'السماح بإنشاء ملف اتحاد ملاك جديد',
        'owner_associations_delete'             => 'السماح بحذف ملف اتحاد الملاك نهائياً',
        'owner_associations_edit'               => 'السماح بتعديل بيانات اتحاد الملاك',
        'owner_associations_add_units'          => 'السماح بإضافة وحدات داخل اتحاد الملاك',
        'owner_associations_add_surveys'        => 'السماح بإنشاء استطلاعات رأي للملاك',
        'owner_associations_view_requests_page' => 'السماح بعرض صفحة طلبات وشكاوى الملاك',
        'owner_associations_edit_requests'      => 'السماح بتعديل طلبات وشكاوى الملاك',
        'owner_associations_delete_requests'    => 'السماح بحذف طلبات وشكاوى الملاك',
        'owner_associations_open_live_chat'     => 'السماح بفتح المحادثة المباشرة على الطلبات والشكاوى',

    ],
    //
    'city'                => [
        'city_view'   => 'عرض جميع المدن',
        'city_create' => 'السماح باضافة مدينة جديدة',
        'city_edit'   => 'السماح بالتعديل علي المدن',
        'city_delete' => 'السماح بحذف مدينة',
    ],
    //
    'neighborhood'        => [
        'neighborhood_view'   => 'عرض جميع المناطق',
        'neighborhood_create' => 'السماح باضافة منطقة جديدة',
        'neighborhood_edit'   => 'السماح بالتعديل علي المناطق',
        'neighborhood_delete' => 'السماح بحذف منطقة',
    ],
    //
    'property_furnishing' => [
        'property_furnishing_view'   => 'عرض مستويات التشطيب',
        'property_furnishing_create' => 'السماح باضافة مستوي تشطيب جديد',
        'property_furnishing_edit'   => 'السماح بالتعديل علي مستويات التشطيب',
        'property_furnishing_delete' => 'السماح بحذف مستوي تشطيب',
    ],
    //
    'property_features'   => [
        'property_features_view'   => 'عرض أنواع المميزات',
        'property_features_create' => 'السماح باضافة نوع من المميزات جديد',
        'property_features_edit'   => 'السماح بالتعديل علي أنواع المميزات',
        'property_features_delete' => 'السماح بحذف نوع من المميزات',
    ],
    //
    'property_amenities'  => [
        'property_amenities_view'   => 'عرض وسائل الراحة',
        'property_amenities_create' => 'السماح باضافة وسيلة راحة جديدة',
        'property_amenities_edit'   => 'السماح بالتعديل علي وسائل الراحة',
        'property_amenities_delete' => 'السماح بحذف من وسائل الراحة',
    ],
    //
    'property_types'      => [
        'property_types_view'   => 'عرض أنواع العقارات',
        'property_types_create' => 'السماح بإضافة نوع عقار جديد',
        'property_types_edit'   => 'السماح بالتعديل على أنواع العقارات',
        'property_types_delete' => 'السماح بحذف نوع عقار',
    ],
    //
    'property_facades'    => [
        'property_facades_view'   => 'عرض واجهات العقارات',
        'property_facades_create' => 'السماح بإضافة واجهة عقار جديدة',
        'property_facades_edit'   => 'السماح بالتعديل على واجهات العقارات',
        'property_facades_delete' => 'السماح بحذف واجهة عقار',
    ],
    //
    'website_setting'     => [
        'website_setting_manage' => 'السماح بالتحكم في إعدادات الموقع',
        'website_faq_manage'     => 'السماح بالتحكم في الأسئلة الشائعة',
        'website_privacy_manage' => 'السماح بالتحكم في سياسة الخصوصية',
        'website_terms_manage'   => 'السماح بالتحكم في الشروط والأحكام',
    ],

    /////////////////////////////
    /////////////////////////////
    /////////////////////////////
    /////////////////////////////
    /////////////////////////////
    /////////////////////////////
    /////////////////////////////
    /////////////////////////////
    /////////////////////////////
    /////////////////////////////
    /////////////////////////////

];
