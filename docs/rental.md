# نظام إدارة التأجير العقاري - Real Estate Rental Management System

## 📋 نظرة عامة (Overview)

نظام إدارة التأجير العقاري هو جزء من CRM عقاري شامل يهدف إلى إدارة عقود التأجير، تتبع الدفعات، المصروفات، والإحصائيات المالية.

**تاريخ الإنشاء:** 10 فبراير 2026  
**الإصدار:** 1.0  
**Framework:** Laravel (PHP)

---

## 🎯 المتطلبات الوظيفية (Functional Requirements)

### 1. إدارة ملفات التأجير
- **الحالة الأولى:** ربط العقد بعقار موجود مسبقاً في جدول `properties`
  - اختيار عقار من القاعدة
  - تحديث حالة توفر العقار إلى "مأجر"
- **الحالة الثانية:** إضافة عقد تأجير بإدخال بيانات العقار يدوياً (بدون ربط)
  - إدخال معلومات العقار كاملة
  - استخدام البيانات المرجعية (مدن، مناطق، أنواع عقارات)

### 2. نظام تقفيل التأجيرات
- تسجيل تاريخ التقفيل
- حساب إجمالي المبالغ المحصلة فعلياً من الدفعات
- إضافة ملاحظات الإغلاق
- تحديث حالة العقار المرتبط (إن وجد) إلى "متاح"

### 3. نظام المصروفات والمستحقات
- جدول مشترك (Polymorphic) يُستخدم في أكثر من مكان في النظام
- تسجيل المصروفات (صيانة، كهرباء، ماء، إلخ)
- تسجيل الإيرادات (دفعات الإيجار، استرداد التأمين)
- ربط كل معاملة بالعقد المناسب

### 4. نظام الدفعات المجدولة
- توليد جدول دفعات تلقائي عند إنشاء العقد
- تتبع حالة كل دفعة (معلقة، مدفوعة، متأخرة، ملغاة)
- ربط الدفعات بالمعاملات المالية الفعلية

### 5. الإحصائيات والتقارير
- إجمالي التأجيرات (النشطة، المنتهية)
- الأرباح المحصلة والمتوقعة
- العمولات المحصلة
- المتأخرات
- أكثر 3 أنواع عقارات مؤجرة
- تقارير مالية شاملة

### 6. نظام التجديد
- إنشاء عقد جديد عند التجديد (بدون ربط بالعقد القديم)
- نفس العقار يمكن أن يكون له عقود متعددة عبر الزمن

---

## 🗄️ هيكل قاعدة البيانات (Database Schema)

### الجداول المطلوبة (6 جداول)

#### 1. rental_contracts (جدول العقود الرئيسي)

**الوصف:** يحتوي على جميع المعلومات الأساسية لعقود التأجير

**الحقول:**

```php
Schema::create('rental_contracts', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique()->index();
    
    // Contract Information
    $table->string('contract_number')->unique()->comment('رقم العقد - يتولد تلقائياً مثل RC-2026-0001');
    $table->date('start_date')->comment('تاريخ بداية العقد');
    $table->date('end_date')->comment('تاريخ نهاية العقد');
    
    // Financial Information
    $table->unsignedInteger('total_rent_amount')->comment('إجمالي الإيجار المتفق عليه');
    $table->string('payment_frequency')->comment('نظام الدفع: daily, monthly, yearly');
    $table->unsignedInteger('expected_payment_amount')->comment('قيمة الدفعة الواحدة المتوقعة');
    
    // Property Relation (nullable للحالة الثانية)
    $table->foreignId('property_id')
        ->nullable()
        ->constrained('properties')
        ->nullOnDelete()
        ->comment('العقار المرتبط - nullable للتأجيرات المستقلة');
    
    // Parties (Owner & Tenant)
    $table->foreignId('owner_client_id')
        ->constrained('clients')
        ->cascadeOnDelete()
        ->comment('المالك');
    
    $table->foreignId('tenant_client_id')
        ->constrained('clients')
        ->cascadeOnDelete()
        ->comment('المستأجر');
    
    // Deposit (التأمين)
    $table->unsignedInteger('deposit_amount')->default(0)->comment('مبلغ التأمين');
    $table->string('deposit_status')->default('pending')->comment('pending, paid, refunded, deducted');
    $table->timestamp('deposit_paid_at')->nullable()->comment('تاريخ دفع التأمين');
    
    // Commission (العمولة)
    $table->unsignedInteger('commission_amount')->default(0)->comment('عمولة الشركة');
    $table->string('commission_status')->default('pending')->comment('pending, collected');
    $table->timestamp('commission_collected_at')->nullable()->comment('تاريخ تحصيل العمولة');
    
    // Status
    $table->string('status')->default('draft')->comment('draft, active, expired, terminated, cancelled');
    
    // Closure Information
    $table->date('closure_date')->nullable()->comment('تاريخ التقفيل');
    $table->text('closure_notes')->nullable()->comment('ملاحظات التقفيل');
    
    // Admin & Notes
    $table->foreignId('admin_id')
        ->nullable()
        ->constrained('admins')
        ->nullOnDelete()
        ->comment('الموظف المسؤول');
    
    $table->text('notes')->nullable()->comment('ملاحظات عامة');
    
    $table->timestamps();
    $table->softDeletes();
    
    // Indexes
    $table->index('status');
    $table->index('start_date');
    $table->index('end_date');
    $table->index(['owner_client_id', 'tenant_client_id']);
});
2. rental_property_details (تفاصيل العقار للتأجيرات المستقلة)
الوصف: يحتوي على معلومات العقار للتأجيرات التي لا ترتبط بعقار موجود في جدول properties

الحقول:

php
Schema::create('rental_property_details', function (Blueprint $table) {
    $table->id();
    
    $table->foreignId('rental_contract_id')
        ->constrained('rental_contracts')
        ->cascadeOnDelete();
    
    // Location
    $table->foreignId('city_id')
        ->nullable()
        ->constrained('cities')
        ->nullOnDelete();
    
    $table->foreignId('neighborhood_id')
        ->nullable()
        ->constrained('neighborhoods')
        ->nullOnDelete();
    
    // Property Type
    $table->foreignId('property_type_id')
        ->nullable()
        ->constrained('property_types')
        ->nullOnDelete();
    
    // Details
    $table->text('address')->nullable()->comment('العنوان التفصيلي');
    $table->float('area')->nullable()->comment('المساحة');
    $table->unsignedTinyInteger('bedrooms')->nullable()->comment('عدد الغرف');
    $table->unsignedTinyInteger('bathrooms')->nullable()->comment('عدد الحمامات');
    $table->string('floor', 50)->nullable()->comment('الدور');
    $table->text('description')->nullable()->comment('وصف العقار');
    
    $table->timestamps();
});
3. rental_payment_schedules (جدول الدفعات المجدولة)
الوصف: يحتوي على جميع الدفعات المتوقعة على مدار فترة العقد، يتم إنشاؤه تلقائياً عند إنشاء العقد

الحقول:

php
Schema::create('rental_payment_schedules', function (Blueprint $table) {
    $table->id();
    
    $table->foreignId('rental_contract_id')
        ->constrained('rental_contracts')
        ->cascadeOnDelete();
    
    $table->unsignedInteger('payment_number')->comment('رقم الدفعة: 1, 2, 3...');
    $table->date('due_date')->comment('تاريخ الاستحقاق');
    $table->unsignedInteger('amount')->comment('مبلغ الدفعة');
    
    $table->string('status')->default('pending')->comment('pending, paid, overdue, cancelled');
    $table->timestamp('paid_at')->nullable()->comment('تاريخ الدفع الفعلي');
    
    // Link to financial transaction
    $table->foreignId('payment_reference')
        ->nullable()
        ->constrained('financial_transactions')
        ->nullOnDelete()
        ->comment('ربط بالمعاملة المالية في حالة الدفع');
    
    $table->text('notes')->nullable();
    
    $table->timestamps();
    
    // Indexes
    $table->index(['rental_contract_id', 'status']);
    $table->index('due_date');
});
مثال على البيانات:

عقد من 1/1/2026 إلى 31/12/2026، إيجار شهري 1000 جنيه:

id	payment_number	due_date	amount	status	paid_at	payment_reference
1	1	2026-02-01	1000	paid	2026-02-05	555
2	2	2026-03-01	1000	pending	NULL	NULL
3	3	2026-04-01	1000	pending	NULL	NULL
...	...	...	...	...	...	...
12	12	2027-01-01	1000	pending	NULL	NULL
4. financial_transactions (المعاملات المالية - Polymorphic)
الوصف: جدول مشترك لتسجيل جميع المصروفات والإيرادات، يمكن استخدامه مع عقود التأجير واتحادات الملاك وأي نموذج آخر

الحقول:

php
Schema::create('financial_transactions', function (Blueprint $table) {
    $table->id();
    
    // Polymorphic Relation
    $table->morphs('transactionable'); // transactionable_type, transactionable_id
    
    // Transaction Type
    $table->string('type')->comment('expense, revenue');
    
    $table->string('category')->comment('rent_payment, maintenance, electricity, water, commission, deposit_refund, etc.');
    
    // Financial Details
    $table->unsignedInteger('amount')->comment('المبلغ');
    $table->date('transaction_date')->comment('تاريخ المعاملة');
    $table->text('description')->nullable()->comment('الوصف');
    
    // Payment Information
    $table->string('payment_method')->nullable()->comment('cash, bank_transfer, check, card');
    $table->string('receipt_number')->nullable()->comment('رقم الإيصال/الفاتورة');
    
    $table->string('status')->default('pending')->comment('pending, paid, cancelled');
    
    // Parties
    $table->foreignId('paid_by')
        ->nullable()
        ->constrained('clients')
        ->nullOnDelete()
        ->comment('من دفع (للمصروفات)');
    
    $table->foreignId('received_from')
        ->nullable()
        ->constrained('clients')
        ->nullOnDelete()
        ->comment('من استلم منه (للإيرادات)');
    
    // Admin
    $table->foreignId('admin_id')
        ->nullable()
        ->constrained('admins')
        ->nullOnDelete()
        ->comment('الموظف الذي سجل المعاملة');
    
    $table->timestamps();
    
    // Indexes
    $table->index(['transactionable_type', 'transactionable_id']);
    $table->index(['type', 'status']);
    $table->index('transaction_date');
});
أمثلة على الاستخدام:

دفعة إيجار:

php
transactionable_type = 'rental_contract'
transactionable_id = 5
type = 'revenue'
category = 'rent_payment'
amount = 1000
transaction_date = '2026-02-05'
status = 'paid'
مصروف صيانة:

php
transactionable_type = 'rental_contract'
transactionable_id = 5
type = 'expense'
category = 'maintenance'
amount = 500
transaction_date = '2026-03-10'
status = 'paid'
5. rental_contract_attachments (مرفقات العقود)
الوصف: يحتوي على جميع الملفات المرفقة بالعقد (عقود PDF، صور، مستندات)

الحقول:

php
Schema::create('rental_contract_attachments', function (Blueprint $table) {
    $table->id();
    
    $table->foreignId('rental_contract_id')
        ->constrained('rental_contracts')
        ->cascadeOnDelete();
    
    $table->string('file_name')->comment('اسم الملف');
    $table->string('file_path')->comment('مسار الملف');
    $table->string('file_type')->nullable()->comment('contract_pdf, id_copy, property_deed, photo, other');
    
    $table->foreignId('uploaded_by')
        ->nullable()
        ->constrained('admins')
        ->nullOnDelete()
        ->comment('الموظف الذي رفع الملف');
    
    $table->text('notes')->nullable();
    
    $table->timestamps();
});
6. تعديل جدول properties (إضافة حالة التوفر)
الوصف: إضافة عمود لتتبع حالة توفر العقار

Migration:

php
Schema::table('properties', function (Blueprint $table) {
    $table->string('availability_status')
        ->default('available')
        ->after('approval_status')
        ->comment('available, reserved, rented, sold');
    
    $table->index('availability_status');
});
🔧 الـ Enums المطلوبة
1. RentalContractStatus
php
<?php

namespace App\Enums;

enum RentalContractStatus: string
{
    case Draft = 'draft';           // مسودة
    case Active = 'active';         // نشط
    case Expired = 'expired';       // منتهي
    case Terminated = 'terminated'; // ملغي
    case Cancelled = 'cancelled';   // مرفوض
    
    public function label(): string
    {
        return match($this) {
            self::Draft => 'مسودة',
            self::Active => 'نشط',
            self::Expired => 'منتهي',
            self::Terminated => 'ملغي',
            self::Cancelled => 'مرفوض',
        };
    }
}
2. PropertyAvailabilityStatus
php
<?php

namespace App\Enums;

enum PropertyAvailabilityStatus: string
{
    case Available = 'available'; // متاح
    case Reserved = 'reserved';   // محجوز
    case Rented = 'rented';       // مأجر
    case Sold = 'sold';           // مباع
    
    public function label(): string
    {
        return match($this) {
            self::Available => 'متاح',
            self::Reserved => 'محجوز',
            self::Rented => 'مأجر',
            self::Sold => 'مباع',
        };
    }
}
3. DepositStatus
php
<?php

namespace App\Enums;

enum DepositStatus: string
{
    case Pending = 'pending';     // معلق
    case Paid = 'paid';           // مدفوع
    case Refunded = 'refunded';   // مسترد
    case Deducted = 'deducted';   // مخصوم
    
    public function label(): string
    {
        return match($this) {
            self::Pending => 'معلق',
            self::Paid => 'مدفوع',
            self::Refunded => 'مسترد',
            self::Deducted => 'مخصوم',
        };
    }
}
4. CommissionStatus
php
<?php

namespace App\Enums;

enum CommissionStatus: string
{
    case Pending = 'pending';     // معلق
    case Collected = 'collected'; // محصل
    
    public function label(): string
    {
        return match($this) {
            self::Pending => 'معلق',
            self::Collected => 'محصل',
        };
    }
}
5. PaymentFrequency
php
<?php

namespace App\Enums;

enum PaymentFrequency: string
{
    case Daily = 'daily';       // يومي
    case Monthly = 'monthly';   // شهري
    case Yearly = 'yearly';     // سنوي
    
    public function label(): string
    {
        return match($this) {
            self::Daily => 'يومي',
            self::Monthly => 'شهري',
            self::Yearly => 'سنوي',
        };
    }
}
6. PaymentScheduleStatus
php
<?php

namespace App\Enums;

enum PaymentScheduleStatus: string
{
    case Pending = 'pending';     // معلق
    case Paid = 'paid';           // مدفوع
    case Overdue = 'overdue';     // متأخر
    case Cancelled = 'cancelled'; // ملغي
    
    public function label(): string
    {
        return match($this) {
            self::Pending => 'معلق',
            self::Paid => 'مدفوع',
            self::Overdue => 'متأخر',
            self::Cancelled => 'ملغي',
        };
    }
}
7. FinancialTransactionType
php
<?php

namespace App\Enums;

enum FinancialTransactionType: string
{
    case Expense = 'expense';   // مصروف
    case Revenue = 'revenue';   // إيراد
    
    public function label(): string
    {
        return match($this) {
            self::Expense => 'مصروف',
            self::Revenue => 'إيراد',
        };
    }
}
8. FinancialTransactionStatus
php
<?php

namespace App\Enums;

enum FinancialTransactionStatus: string
{
    case Pending = 'pending';     // معلق
    case Paid = 'paid';           // مدفوع
    case Cancelled = 'cancelled'; // ملغي
    
    public function label(): string
    {
        return match($this) {
            self::Pending => 'معلق',
            self::Paid => 'مدفوع',
            self::Cancelled => 'ملغي',
        };
    }
}
9. PaymentMethod
php
<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Cash = 'cash';                   // نقدي
    case BankTransfer = 'bank_transfer';  // تحويل بنكي
    case Check = 'check';                 // شيك
    case Card = 'card';                   // بطاقة
    
    public function label(): string
    {
        return match($this) {
            self::Cash => 'نقدي',
            self::BankTransfer => 'تحويل بنكي',
            self::Check => 'شيك',
            self::Card => 'بطاقة',
        };
    }
}
🔄 سير العمل (Workflow)
1. إنشاء عقد تأجير جديد
الحالة الأولى: ربط بعقار موجود
الخطوات:

المستخدم يفتح نموذج إضافة عقد تأجير

يختار عقار من قائمة العقارات المتاحة (properties)

يملأ بيانات العقد:

تواريخ البداية والنهاية

المبلغ الإجمالي

نظام الدفع (يومي، شهري، سنوي)

قيمة الدفعة المتوقعة

المالك والمستأجر

التأمين والعمولة

عند الحفظ:

إنشاء سجل في rental_contracts

توليد contract_number تلقائياً (RC-2026-0001)

إنشاء جدول الدفعات تلقائياً في rental_payment_schedules

تحديث properties.availability_status إلى 'rented'

الحالة الثانية: إدخال يدوي بدون عقار
الخطوات:

المستخدم يفتح نموذج إضافة عقد تأجير

يختار "إدخال بيانات العقار يدوياً"

يملأ بيانات العقد (نفس الخطوات السابقة)

يملأ بيانات العقار:

المدينة والمنطقة

نوع العقار

العنوان، المساحة، الغرف، إلخ

عند الحفظ:

إنشاء سجل في rental_contracts (بدون property_id)

إنشاء سجل في rental_property_details

توليد contract_number تلقائياً

إنشاء جدول الدفعات تلقائياً في rental_payment_schedules

2. توليد جدول الدفعات تلقائياً
Logic:

php
// مثال: عقد من 1/1/2026 إلى 31/12/2026، شهري، 1000 جنيه

$contract = RentalContract::create([...]);

$startDate = $contract->start_date;
$endDate = $contract->end_date;
$frequency = $contract->payment_frequency; // 'monthly'
$amount = $contract->expected_payment_amount; // 1000

$paymentNumber = 1;
$currentDate = $startDate->copy()->addMonth(); // أول دفعة بعد شهر

while ($currentDate <= $endDate) {
    RentalPaymentSchedule::create([
        'rental_contract_id' => $contract->id,
        'payment_number' => $paymentNumber,
        'due_date' => $currentDate,
        'amount' => $amount,
        'status' => 'pending',
    ]);
    
    $paymentNumber++;
    $currentDate->addMonth();
}
النتيجة: 12 دفعة في جدول rental_payment_schedules

3. تسجيل دفعة إيجار
الخطوات:

الـ Admin يفتح العقد

يعرض جدول الدفعات من rental_payment_schedules

يختار دفعة (status: pending)

يسجل الدفع:

المبلغ المدفوع (قد يكون مختلف عن المتوقع)

طريقة الدفع

تاريخ الدفع

رقم الإيصال

عند الحفظ:

إنشاء سجل في financial_transactions:

php
type = 'revenue'
category = 'rent_payment'
transactionable_type = 'rental_contract'
transactionable_id = $contractId
amount = 1000
status = 'paid'
تحديث rental_payment_schedules:

php
status = 'paid'
paid_at = now()
payment_reference = $transactionId
4. تسجيل مصروف على التأجيرة
مثال: صيانة تكييف بمبلغ 500 جنيه

الخطوات:

الـ Admin يفتح العقد

ينتقل إلى قسم "المصروفات"

يضيف مصروف جديد:

النوع: مصروف

الفئة: صيانة

المبلغ: 500

التاريخ

الوصف

عند الحفظ:

إنشاء سجل في financial_transactions:

php
type = 'expense'
category = 'maintenance'
transactionable_type = 'rental_contract'
transactionable_id = $contractId
amount = 500
status = 'paid'
5. تقفيل العقد
الخطوات:

الـ Admin يفتح العقد

يضغط على "تقفيل العقد"

يملأ:

تاريخ التقفيل

ملاحظات

النظام يحسب:

إجمالي المحصل من الدفعات:

sql
SELECT SUM(amount) FROM rental_payment_schedules
WHERE rental_contract_id = X AND status = 'paid'
عند الحفظ:

تحديث rental_contracts:

php
status = 'expired' or 'terminated'
closure_date = today()
closure_notes = '...'
تحديث properties.availability_status = 'available' (إذا كان مرتبط بعقار)

تحديث الدفعات المتبقية إلى 'cancelled'

6. التجديد
الخطوات:

إنشاء عقد جديد تماماً

ربطه بنفس العقار (إذا كان موجود)

نفس المالك (أو مالك جديد)

نفس المستأجر (أو مستأجر جديد)

شروط جديدة (المبلغ قد يتغير)

ملاحظة: لا يوجد ربط بين العقد القديم والجديد في قاعدة البيانات

📊 الإحصائيات والتقارير
1. إجمالي التأجيرات النشطة
sql
SELECT COUNT(*) FROM rental_contracts 
WHERE status = 'active'
2. إجمالي الأرباح المحصلة
sql
SELECT SUM(amount) FROM financial_transactions 
WHERE type = 'revenue' 
AND category = 'rent_payment'
AND status = 'paid'
3. العمولات المحصلة
sql
SELECT SUM(commission_amount) FROM rental_contracts 
WHERE commission_status = 'collected'
4. العقود المنتهية
sql
SELECT COUNT(*) FROM rental_contracts 
WHERE status = 'expired'
5. المتأخرات
sql
SELECT SUM(amount) FROM rental_payment_schedules
WHERE status = 'pending'
AND due_date < CURDATE()
أو حسب العقد:

sql
SELECT 
    rc.id,
    rc.contract_number,
    SUM(rps.amount) as overdue_amount
FROM rental_contracts rc
JOIN rental_payment_schedules rps ON rps.rental_contract_id = rc.id
WHERE rps.status = 'pending'
AND rps.due_date < CURDATE()
GROUP BY rc.id
6. أكثر 3 أنواع عقارات مؤجرة
sql
SELECT 
    pt.id,
    pt_trans.name as property_type_name,
    COUNT(rc.id) as total_contracts
FROM rental_contracts rc
JOIN properties p ON p.id = rc.property_id
JOIN property_types pt ON pt.id = p.property_type_id
LEFT JOIN property_type_translations pt_trans ON pt_trans.property_type_id = pt.id
WHERE rc.status = 'active'
AND pt_trans.locale = 'ar'
GROUP BY pt.id
ORDER BY total_contracts DESC
LIMIT 3
7. تقرير مالي شامل لعقد معين
sql
SELECT 
    -- معلومات العقد
    rc.contract_number,
    rc.total_rent_amount,
    rc.deposit_amount,
    rc.commission_amount,
    
    -- المحصل من الدفعات
    (SELECT SUM(amount) FROM rental_payment_schedules 
     WHERE rental_contract_id = rc.id AND status = 'paid') as collected_rent,
    
    -- المتبقي
    (SELECT SUM(amount) FROM rental_payment_schedules 
     WHERE rental_contract_id = rc.id AND status = 'pending') as remaining_rent,
    
    -- المتأخرات
    (SELECT SUM(amount) FROM rental_payment_schedules 
     WHERE rental_contract_id = rc.id 
     AND status = 'pending' 
     AND due_date < CURDATE()) as overdue_rent,
    
    -- المصروفات
    (SELECT SUM(amount) FROM financial_transactions 
     WHERE transactionable_type = 'rental_contract' 
     AND transactionable_id = rc.id 
     AND type = 'expense' 
     AND status = 'paid') as total_expenses,
    
    -- صافي الربح
    ((SELECT SUM(amount) FROM rental_payment_schedules 
      WHERE rental_contract_id = rc.id AND status = 'paid')
     - 
     (SELECT COALESCE(SUM(amount), 0) FROM financial_transactions 
      WHERE transactionable_type = 'rental_contract' 
      AND transactionable_id = rc.id 
      AND type = 'expense' 
      AND status = 'paid')) as net_profit

FROM rental_contracts rc
WHERE rc.id = ?
🔐 Contract Number Generation Logic
الصيغة
text
RC-{YEAR}-{SEQUENCE}
مثال:

RC-2026-0001 → أول عقد في 2026

RC-2026-0025 → العقد رقم 25 في 2026

RC-2027-0001 → أول عقد في 2027 (التسلسل يبدأ من جديد)

التطبيق
في Model Observer:

php
<?php

namespace App\Observers;

use App\Models\RentalContract;

class RentalContractObserver
{
    public function creating(RentalContract $contract)
    {
        // توليد رقم العقد تلقائياً
        $contract->contract_number = $this->generateContractNumber();
    }
    
    private function generateContractNumber(): string
    {
        $year = date('Y');
        
        // الحصول على آخر عقد في نفس السنة
        $lastContract = RentalContract::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        // حساب التسلسل
        $sequence = $lastContract ? ($lastContract->id + 1) : 1;
        
        // صيغة رقم العقد
        return 'RC-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
تسجيل الـ Observer:

php
// في AppServiceProvider.php

use App\Models\RentalContract;
use App\Observers\RentalContractObserver;

public function boot()
{
    RentalContract::observe(RentalContractObserver::class);
}
🔗 العلاقات (Relationships)
RentalContract Model
php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\RentalContractStatus;

class RentalContract extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'uuid',
        'contract_number',
        'start_date',
        'end_date',
        'total_rent_amount',
        'payment_frequency',
        'expected_payment_amount',
        'property_id',
        'owner_client_id',
        'tenant_client_id',
        'deposit_amount',
        'deposit_status',
        'deposit_paid_at',
        'commission_amount',
        'commission_status',
        'commission_collected_at',
        'status',
        'closure_date',
        'closure_notes',
        'admin_id',
        'notes',
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'deposit_paid_at' => 'datetime',
        'commission_collected_at' => 'datetime',
        'closure_date' => 'date',
        'status' => RentalContractStatus::class,
    ];
    
    // Relations
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
    public function propertyDetails()
    {
        return $this->hasOne(RentalPropertyDetail::class);
    }
    
    public function owner()
    {
        return $this->belongsTo(Client::class, 'owner_client_id');
    }
    
    public function tenant()
    {
        return $this->belongsTo(Client::class, 'tenant_client_id');
    }
    
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    
    public function paymentSchedules()
    {
        return $this->hasMany(RentalPaymentSchedule::class);
    }
    
    public function transactions()
    {
        return $this->morphMany(FinancialTransaction::class, 'transactionable');
    }
    
    public function attachments()
    {
        return $this->hasMany(RentalContractAttachment::class);
    }
    
    // Helper Methods
    
    public function totalCollected()
    {
        return $this->paymentSchedules()
            ->where('status', 'paid')
            ->sum('amount');
    }
    
    public function totalRemaining()
    {
        return $this->paymentSchedules()
            ->where('status', 'pending')
            ->sum('amount');
    }
    
    public function totalOverdue()
    {
        return $this->paymentSchedules()
            ->where('status', 'pending')
            ->where('due_date', '<', now())
            ->sum('amount');
    }
}
RentalPaymentSchedule Model
php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPaymentSchedule extends Model
{
    protected $fillable = [
        'rental_contract_id',
        'payment_number',
        'due_date',
        'amount',
        'status',
        'paid_at',
        'payment_reference',
        'notes',
    ];
    
    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];
    
    public function contract()
    {
        return $this->belongsTo(RentalContract::class, 'rental_contract_id');
    }
    
    public function transaction()
    {
        return $this->belongsTo(FinancialTransaction::class, 'payment_reference');
    }
    
    public function isOverdue()
    {
        return $this->status === 'pending' && $this->due_date < now();
    }
}
FinancialTransaction Model
php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    protected $fillable = [
        'transactionable_type',
        'transactionable_id',
        'type',
        'category',
        'amount',
        'transaction_date',
        'description',
        'payment_method',
        'receipt_number',
        'status',
        'paid_by',
        'received_from',
        'admin_id',
    ];
    
    protected $casts = [
        'transaction_date' => 'date',
    ];
    
    public function transactionable()
    {
        return $this->morphTo();
    }
    
    public function paidBy()
    {
        return $this->belongsTo(Client::class, 'paid_by');
    }
    
    public function receivedFrom()
    {
        return $this->belongsTo(Client::class, 'received_from');
    }
    
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
✅ Checklist للتطبيق
Phase 1: Database Setup
 إنشاء جميع الـ Migrations (6 migrations)

 إنشاء جميع الـ Enums (9 enums)

 تشغيل الـ migrations

 اختبار العلاقات

Phase 2: Models & Logic
 إنشاء Models مع العلاقات

 إنشاء Observer لتوليد contract_number

 إنشاء Service/Action لتوليد payment_schedules

 إنشاء Helper Methods للحسابات

Phase 3: API/Controllers
 CRUD للعقود (RentalContractController)

 API لتسجيل الدفعات

 API للمصروفات

 API للتقفيل

 API للإحصائيات

Phase 4: Frontend/UI
 صفحة قائمة العقود

 نموذج إضافة/تعديل عقد

 صفحة تفاصيل العقد

 جدول الدفعات

 جدول المصروفات

 Dashboard للإحصائيات

Phase 5: Testing
 Unit Tests للـ Models

 Feature Tests للـ APIs

 اختبار الـ Workflows كاملة

📝 ملاحظات مهمة
1. Contract Number Uniqueness
تأكد من unique constraint على contract_number

استخدم DB Transaction عند إنشاء العقد لتجنب race conditions

2. Payment Schedules Generation
يتم تنفيذها في Event/Observer بعد حفظ العقد

تأكد من استخدام DB Transaction

احسب التواريخ بدقة حسب payment_frequency

3. Overdue Status
يمكن حسابه ديناميكياً (computed)

أو تحديثه بـ Cron Job يومي

الخيار الأول أفضل لتجنب تعقيد الصيانة

4. Soft Deletes
استخدم Soft Deletes على rental_contracts

لا تحذف البيانات المالية نهائياً

احتفظ بالـ audit trail

5. Validation
تأكد من أن end_date > start_date

total_rent_amount يجب أن يكون قابل للقسمة على expected_payment_amount

property_id و rental_property_details لا يمكن أن يكونا موجودين معاً

6. Performance
Index على الحقول المستخدمة في البحث والفلترة

استخدم Eager Loading لتجنب N+1 queries

Cache الإحصائيات الثقيلة

🎨 واجهة المستخدم المقترحة
صفحة قائمة العقود
جدول يعرض:

رقم العقد

العقار/العنوان

المالك

المستأجر

تاريخ البداية والنهاية

الحالة

الإجمالي المحصل / الإجمالي المتوقع

الإجراءات (عرض، تعديل، حذف)

فلاتر:

الحالة

التاريخ

المالك/المستأجر

نوع العقار

زر "إضافة عقد جديد"

صفحة تفاصيل العقد
أقسام:

معلومات العقد الأساسية

رقم العقد، التواريخ، الحالة

المالك والمستأجر

العقار (إن وجد)

التأمين والعمولة

جدول الدفعات (Payment Schedule)

جدول يعرض جميع الدفعات

الحالة (معلق، مدفوع، متأخر)

زر "تسجيل دفعة" لكل دفعة معلقة

المعاملات المالية

الدفعات المسجلة

المصروفات

زر "إضافة مصروف"

المرفقات

قائمة الملفات المرفقة

زر "رفع ملف"

الملخص المالي

الإجمالي المتوقع

المحصل

المتبقي

المتأخرات

المصروفات

صافي الربح

🚀 Next Steps
مراجعة هذا التوثيق والموافقة عليه

بدء كتابة الـ Migrations

إنشاء الـ Models والعلاقات

تطوير الـ Backend Logic

بناء الـ APIs

تطوير الـ Frontend

الاختبار والتحسين

تاريخ آخر تحديث: 10 فبراير 2026
الإصدار: 1.0
الحالة: جاهز للتطبيق ✅

📞 ملاحظات إضافية
هذا التوثيق شامل لكل جوانب النظام

تم تصميمه ليكون مرجع دائم أثناء التطوير

أي تعديلات مستقبلية يجب توثيقها في هذا الملف

احتفظ به في repository الخاص بالمشروع

Good Luck! 🎉