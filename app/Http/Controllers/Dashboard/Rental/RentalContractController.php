<?php
namespace App\Http\Controllers\Dashboard\Rental;

use App\Enums\Property\PropertyAvailabilityStatus;
use App\Enums\Rental\PaymentFrequency;
use App\Enums\Rental\PaymentScheduleStatus;
use App\Enums\Rental\RentalContractStatus;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Rental\RentalContract;
use App\Models\Dashboard\Rental\RentalPaymentSchedule;
use App\Models\Dashboard\Rental\RentalPropertyDetail;
use App\Models\Property\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class RentalContractController extends Controller
{

    public function index(Request $request)
    {
        $query = RentalContract::with(['property', 'owner', 'tenant', 'admin']);

        // البحث برقم العقد أو اسم المستأجر
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('contract_number', 'like', "%{$search}%")
                    ->orWhereHas('tenant', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // فلتر الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلتر نوع العقار
        if ($request->filled('property_type')) {
            $query->whereHas('property', function ($q) use ($request) {
                $q->where('property_type_id', $request->property_type);
            });
        }

        // فلتر من تاريخ
        if ($request->filled('from_date')) {
            $query->where('start_date', '>=', $request->from_date);
        }

        // فلتر إلى تاريخ
        if ($request->filled('to_date')) {
            $query->where('end_date', '<=', $request->to_date);
        }

        // الترتيب
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy('created_at', $sortOrder);

        $contracts = $query->paginate(20)->withQueryString();

        //
        $rentalContractStatusOptions = RentalContractStatus::options();

        return view('dashboard.rental.contracts.index', compact('contracts', 'rentalContractStatusOptions'));
    }

    public function create()
    {
        $paymentFrequencyOptions = PaymentFrequency::options();
        return view('dashboard.rental.contracts.create', compact('paymentFrequencyOptions'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'start_date'        => ['required', 'date'],
            'end_date'          => ['required', 'date', 'after:start_date'],

            'total_rent_amount' => ['required', 'integer', 'min:0'],
            'payment_frequency' => ['required', new Enum(PaymentFrequency::class)],
            //   'expected_payment_amount' => ['required', 'integer', 'min:0'],

            'property_id'       => ['nullable', 'exists:properties,id'],

            'owner_client_id'   => ['required', 'exists:clients,id'],
            'tenant_client_id'  => ['required', 'exists:clients,id'],

            'deposit_amount'    => ['nullable', 'integer', 'min:0'],
            'commission_amount' => ['nullable', 'integer', 'min:0'],
            'notes'             => ['nullable', 'string'],

            // External property
            'city_id'           => ['required_without:property_id', 'exists:cities,id'],
            'neighborhood_id'   => ['nullable', 'exists:neighborhoods,id'],
            'property_type_id'  => ['required_without:property_id', 'exists:property_types,id'],
            'address'           => ['nullable', 'string'],
            'area'              => ['nullable', 'numeric'],
            'bedrooms'          => ['nullable', 'integer', 'min:0'],
            'bathrooms'         => ['nullable', 'integer', 'min:0'],
            'floor'             => ['nullable', 'string'],
            'description'       => ['nullable', 'string'],

            'deed_number'       => ['nullable', 'string', 'max:100', Rule::unique('rental_contracts', 'deed_number')],
        ]);

        /* ===========================================
        Smart business rules
        =========================================== */

        $validator->after(function ($validator) use ($request) {

            $start = \Carbon\Carbon::parse($request->start_date);
            $end   = \Carbon\Carbon::parse($request->end_date);

            $days = $start->diffInDays($end);
            $freq = $request->payment_frequency;

            // أقل من 28 يوم → يومي فقط
            if ($days < 28 && $freq !== PaymentFrequency::DAILY->value) {
                $validator->errors()->add(
                    'payment_frequency',
                    'العقود الأقل من شهر يجب أن تكون بنظام دفع يومي'
                );
            }

            // أقل من 11 شهر → ممنوع السنوي
            if ($days < 330 && $freq === PaymentFrequency::YEARLY->value) {
                $validator->errors()->add(
                    'payment_frequency',
                    'الدفع السنوي يتطلب عقد لمدة سنة تقريبًا'
                );
            }

            if ($request->expected_payment_amount > $request->total_rent_amount) {
                $validator->errors()->add(
                    'expected_payment_amount',
                    'قيمة الدفعة لا يمكن أن تتجاوز إجمالي الإيجار'
                );
            }

        });

        $validated = $validator->validate();

        return DB::transaction(function () use ($validated) {

            // احسب عدد الدفعات من الفترة الزمنية
            $numberOfPayments = $this->calculateNumberOfPayments(
                $validated['start_date'],
                $validated['end_date'],
                $validated['payment_frequency']
            );
            $expectedPaymentAmount = ceil($validated['total_rent_amount'] / $numberOfPayments);

            $contract = RentalContract::create([
                'start_date'              => $validated['start_date'],
                'end_date'                => $validated['end_date'],
                'total_rent_amount'       => $validated['total_rent_amount'],
                'deed_number'             => $validated['deed_number'],
                'payment_frequency'       => $validated['payment_frequency'],
                'expected_payment_amount' => $expectedPaymentAmount, // ← محسوب تلقائياً
                'property_id'             => $validated['property_id'] ?? null,
                'owner_client_id'         => $validated['owner_client_id'],
                'tenant_client_id'        => $validated['tenant_client_id'],
                'deposit_amount'          => $validated['deposit_amount'] ?? 0,
                'commission_amount'       => $validated['commission_amount'] ?? 0,
                'status'                  => RentalContractStatus::DRAFT->value,
                'admin_id'                => adminId(),
                'notes'                   => $validated['notes'] ?? null,
            ]);

            // External property snapshot
            if (! $contract->property_id) {
                $contract->propertyDetail()->create([
                    'city_id'          => $validated['city_id'],
                    'neighborhood_id'  => $validated['neighborhood_id'] ?? null,
                    'property_type_id' => $validated['property_type_id'],
                    'address'          => $validated['address'] ?? null,
                    'area'             => $validated['area'] ?? null,
                    'bedrooms'         => $validated['bedrooms'] ?? null,
                    'bathrooms'        => $validated['bathrooms'] ?? null,
                    'floor'            => $validated['floor'] ?? null,
                    'description'      => $validated['description'] ?? null,
                ]);
            } else {
                Property::whereKey($contract->property_id)
                    ->update(['availability_status' => PropertyAvailabilityStatus::RENTED->value]);
            }

            $this->generatePaymentSchedules($contract);

            return Response::success('تم إنشاء العقد بنجاح', [
                'style'    => 'toastr',
                'reset'    => true,
                'time_out' => 1.5,
                'redirect' => route('rental.contracts.show', $contract),
            ]);

        });
    }

    public function changeStatus(Request $request, RentalContract $contract)
    {
        $newStatus = $request->status;

        if (! $newStatus) {
            return Response::error('يجب تحديد الحالة الجديدة', [
                'style' => 'toastr',
            ]);
        }

        // ✅ Get value from Enum
        $oldStatus = $contract->getRawOriginal('status');

        // Check if status is already the same
        if ($oldStatus === $newStatus) {
            return Response::error('العقد بالفعل في هذه الحالة', [
                'style' => 'toastr',
            ]);
        }

        // ✅ Validate that new status is valid Enum value
        $validStatuses = array_column(RentalContractStatus::cases(), 'value');

        if (! in_array($newStatus, $validStatuses)) {
            return Response::error('الحالة المحددة غير صحيحة', [
                'style' => 'toastr',
            ]);
        }

        DB::beginTransaction();
        try {

            $contract->update([
                'status' => $newStatus,
            ]);

            // Additional actions based on new status
            switch ($newStatus) {
                case RentalContractStatus::ACTIVE->value:
                    // Generate payment schedules if not exists
                    if ($contract->paymentSchedules()->count() === 0) {
                        $this->generatePaymentSchedules($contract);
                    }
                    break;

                case RentalContractStatus::CANCELLED->value:
                case RentalContractStatus::TERMINATED->value:
                    // Cancel all pending payments
                    $contract->paymentSchedules()
                        ->where('status', PaymentScheduleStatus::PENDING->value)
                        ->update(['status' => PaymentScheduleStatus::CANCELLED->value]);
                    break;
            }

            DB::commit();

            return Response::success('تم تحديث حالة العقد بنجاح', [
                'style'    => 'toastr',
                'time_out' => 1.5,
                'reload'   => true,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return Response::error('حدث خطأ أثناء تحديث حالة العقد: ' . $e->getMessage(), [
                'style' => 'toastr',
            ]);
        }
    }

    public function show(RentalContract $rentalContract)
    {
        // Load العلاقات
        $rentalContract->load([
            'property',
            'propertyDetails',
            'owner',
            'tenant',
            'admin',
            'paymentSchedules',
            'transactions',
            'attachments',
        ]);

        // احسب الـ Stats
        $stats = [
            'collected'      => $rentalContract->paymentSchedules()
                ->where('status', 'paid')
                ->sum('amount'),

            'remaining'      => $rentalContract->paymentSchedules()
                ->where('status', 'pending')
                ->sum('amount'),

            'overdue'        => $rentalContract->paymentSchedules()
                ->where('status', 'pending')
                ->where('due_date', '<', now()->toDateString())
                ->sum('amount'),

            'total_expenses' => $rentalContract->transactions()
                ->where('type', 'expense')
                ->sum('amount'),
        ];

        $contract = $rentalContract;

        $logs = $contract->activities()->latest()->get();

        $availableStatuses = RentalContractStatus::options();

        return view('dashboard.rental.contracts.show', compact('contract', 'stats', 'logs', 'availableStatuses'));
    }

    public function edit(RentalContract $rentalContract)
    {

        $contract = $rentalContract->load([
            'property',
            'propertyDetails',
            'owner',
            'tenant',
        ]);

        $paymentFrequencyOptions = PaymentFrequency::options();

        return view('dashboard.rental.contracts.edit', compact('contract', 'paymentFrequencyOptions'));
    }

    public function update(Request $request, RentalContract $contract)
    {

        $validator = Validator::make($request->all(), [

            'start_date'           => ['required', 'date'],
            'end_date'             => ['required', 'date', 'after:start_date'],

            'total_rent_amount'    => ['required', 'integer', 'min:0'],
            'payment_frequency'    => ['required', new Enum(PaymentFrequency::class)],

            'property_id'          => ['nullable', 'exists:properties,id'],

            'owner_client_id'      => ['required', 'exists:clients,id'],
            'tenant_client_id'     => ['required', 'exists:clients,id'],

            'deposit_amount'       => ['nullable', 'integer', 'min:0'],
            'commission_amount'    => ['nullable', 'integer', 'min:0'],
            'notes'                => ['nullable', 'string'],

            // External property
            'city_id'              => ['required_without:property_id', 'exists:cities,id'],
            'neighborhood_id'      => ['nullable', 'exists:neighborhoods,id'],
            'property_type_id'     => ['required_without:property_id', 'exists:property_types,id'],
            'address'              => ['nullable', 'string'],
            'area'                 => ['nullable', 'numeric'],
            'bedrooms'             => ['nullable', 'integer', 'min:0'],
            'bathrooms'            => ['nullable', 'integer', 'min:0'],
            'floor'                => ['nullable', 'string'],
            'description'          => ['nullable', 'string'],

            // Financial status checkboxes
            'deposit_paid'         => ['nullable', 'boolean'],
            'commission_collected' => ['nullable', 'boolean'],

            'deed_number'          => ['nullable', 'string', 'max:100', Rule::unique('rental_contracts', 'deed_number')->ignore($contract->id)],
        ]);

        $validator->after(function ($validator) use ($request, $contract) {

            $start = Carbon::parse($request->start_date);
            $end   = Carbon::parse($request->end_date);

            $days = $start->diffInDays($end);
            $freq = $request->payment_frequency;

            // أقل من 28 يوم → يومي فقط
            if ($days < 28 && $freq !== PaymentFrequency::DAILY->value) {
                $validator->errors()->add(
                    'payment_frequency',
                    'العقود الأقل من شهر يجب أن تكون بنظام دفع يومي'
                );
            }

            // أقل من 11 شهر → ممنوع السنوي
            if ($days < 330 && $freq === PaymentFrequency::YEARLY->value) {
                $validator->errors()->add(
                    'payment_frequency',
                    'الدفع السنوي يتطلب عقد لمدة سنة تقريبًا'
                );
            }

            // Check owner != tenant
            if ($request->owner_client_id == $request->tenant_client_id) {
                $validator->errors()->add(
                    'tenant_client_id',
                    'المالك والمستأجر لا يمكن أن يكونا نفس الشخص'
                );
            }

            // ⚠️ تحقق من المبلغ المدفوع vs المبلغ الجديد
            $totalPaid = $contract->paymentSchedules()
                ->where('status', 'paid')
                ->sum('amount');

            if ($totalPaid > $request->total_rent_amount) {
                $validator->errors()->add(
                    'total_rent_amount',
                    "المبلغ المدفوع بالفعل ({$totalPaid} ج.م) أكبر من إجمالي الإيجار الجديد"
                );
            }

        });

        $validated = $validator->validate();

        DB::beginTransaction();
        try {

            // Update Contract
            $contract->update([
                'start_date'        => $validated['start_date'],
                'end_date'          => $validated['end_date'],
                'total_rent_amount' => $validated['total_rent_amount'],
                'deed_number'       => $validated['deed_number'],
                'payment_frequency' => $validated['payment_frequency'],
                'property_id'       => $validated['property_id'] ?? null,
                'owner_client_id'   => $validated['owner_client_id'],
                'tenant_client_id'  => $validated['tenant_client_id'],
                'deposit_amount'    => $validated['deposit_amount'] ?? 0,
                'commission_amount' => $validated['commission_amount'] ?? 0,
                'notes'             => $validated['notes'] ?? null,
            ]);

            // Update deposit status
            if ($request->has('deposit_paid') && $request->deposit_paid) {
                $contract->update([
                    'deposit_status'  => 'paid',
                    'deposit_paid_at' => $contract->deposit_paid_at ?? now(),
                ]);
            } else {
                $contract->update([
                    'deposit_status'  => 'pending',
                    'deposit_paid_at' => null,
                ]);
            }

            // Update commission status
            if ($request->has('commission_collected') && $request->commission_collected) {
                $contract->update([
                    'commission_status'       => 'collected',
                    'commission_collected_at' => $contract->commission_collected_at ?? now(),
                ]);
            } else {
                $contract->update([
                    'commission_status'       => 'pending',
                    'commission_collected_at' => null,
                ]);
            }

            // Handle Property Details (External)
            if (! $validated['property_id']) {

                if ($contract->propertyDetails) {
                    $contract->propertyDetails->update([
                        'city_id'          => $validated['city_id'],
                        'neighborhood_id'  => $validated['neighborhood_id'] ?? null,
                        'property_type_id' => $validated['property_type_id'],
                        'address'          => $validated['address'] ?? null,
                        'area'             => $validated['area'] ?? null,
                        'bedrooms'         => $validated['bedrooms'] ?? null,
                        'bathrooms'        => $validated['bathrooms'] ?? null,
                        'floor'            => $validated['floor'] ?? null,
                        'description'      => $validated['description'] ?? null,
                    ]);
                } else {
                    RentalPropertyDetail::create([
                        'rental_contract_id' => $contract->id,
                        'city_id'            => $validated['city_id'],
                        'neighborhood_id'    => $validated['neighborhood_id'] ?? null,
                        'property_type_id'   => $validated['property_type_id'],
                        'address'            => $validated['address'] ?? null,
                        'area'               => $validated['area'] ?? null,
                        'bedrooms'           => $validated['bedrooms'] ?? null,
                        'bathrooms'          => $validated['bathrooms'] ?? null,
                        'floor'              => $validated['floor'] ?? null,
                        'description'        => $validated['description'] ?? null,
                    ]);
                }

            } else {
                if ($contract->propertyDetails) {
                    $contract->propertyDetails->delete();
                }
            }

            // ⚠️ إعادة بناء جدول الدفعات بالكامل
            $oldStart = $contract->getOriginal('start_date');
            $oldEnd   = $contract->getOriginal('end_date');
            $oldFreq  = $contract->getOriginal('payment_frequency');
            $oldTotal = $contract->getOriginal('total_rent_amount');

            if (
                $validated['start_date'] != $oldStart ||
                $validated['end_date'] != $oldEnd ||
                $validated['payment_frequency'] != $oldFreq ||
                $validated['total_rent_amount'] != $oldTotal
            ) {

                // احصل على الدفعات المدفوعة (نحتفظ بها)
                $paidSchedules = $contract->paymentSchedules()
                    ->where('status', 'paid')
                    ->orderBy('due_date')
                    ->get();

                $totalPaidAmount = $paidSchedules->sum('amount');
                $remainingAmount = $validated['total_rent_amount'] - $totalPaidAmount;

                // احذف كل الدفعات القديمة (pending)
                $contract->paymentSchedules()->where('status', 'pending')->delete();

                // احسب عدد الدفعات الجديدة
                $numberOfPayments = $this->calculateNumberOfPayments(
                    $validated['start_date'],
                    $validated['end_date'],
                    $validated['payment_frequency']
                );

                // عدد الدفعات المتبقية = إجمالي الدفعات - الدفعات المدفوعة
                $paidCount         = $paidSchedules->count();
                $remainingPayments = max(1, $numberOfPayments - $paidCount);

                $expectedPaymentAmount = ceil($remainingAmount / $remainingPayments);

                // Update expected_payment_amount in contract
                $contract->update([
                    'expected_payment_amount' => $expectedPaymentAmount,
                ]);

                // احسب تاريخ البداية للدفعات الجديدة (بعد آخر دفعة مدفوعة)
                $lastPaidSchedule = $paidSchedules->last();

                if ($lastPaidSchedule) {
                    $startDate = Carbon::parse($lastPaidSchedule->due_date);

                    // انتقل للدفعة التالية
                    switch ($validated['payment_frequency']) {
                        case PaymentFrequency::DAILY->value:
                            $startDate->addDay();
                            break;
                        case PaymentFrequency::MONTHLY->value:
                            $startDate->addMonth();
                            break;
                        case PaymentFrequency::YEARLY->value:
                            $startDate->addYear();
                            break;
                    }
                } else {
                    $startDate = Carbon::parse($validated['start_date']);
                }

                // ولّد الدفعات الجديدة
                $this->generatePaymentSchedulesFromDate(
                    $contract->fresh(),
                    $startDate,
                    $remainingPayments,
                    $expectedPaymentAmount
                );

            }

            DB::commit();

            return Response::success('تم تحديث العقد بنجاح', [
                'style'    => 'toastr',
                'time_out' => 1.5,
                'redirect' => route('rental.contracts.show', $contract->uuid),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return Response::error('حدث خطأ أثناء تحديث العقد: ' . $e->getMessage(), [
                'time_out' => 3,
                'style'    => 'toastr',
            ]);
        }
    }

    /**
     *
     *
     *
     */
    private function generatePaymentSchedulesFromDate(
        RentalContract $contract,
        Carbon $startDate,
        int $numberOfPayments,
        int $amountPerPayment
    ): int {
        $endDate = $contract->end_date;

        $lastPaymentNumber = $contract->paymentSchedules()
            ->max('payment_number') ?? 0;

        $currentDate = $startDate->copy();
        $created     = 0;

        for ($i = 0; $i < $numberOfPayments; $i++) {

            if ($currentDate->greaterThan($endDate)) {
                break;
            }

            $contract->paymentSchedules()->create([
                'payment_number' => ++$lastPaymentNumber,
                'due_date'       => $currentDate->toDateString(),
                'amount'         => $amountPerPayment,
                'status'         => PaymentScheduleStatus::PENDING,
            ]);

            $created++;

            match ($contract->payment_frequency) {
                PaymentFrequency::DAILY   => $currentDate->addDay(),
                PaymentFrequency::MONTHLY => $currentDate->addMonth(),
                PaymentFrequency::YEARLY  => $currentDate->addYear(),
            };
        }

        return $created;
    }

    private function generatePaymentSchedules(RentalContract $contract)
    {
        $currentDate = Carbon::parse($contract->start_date); // ← نبدأ من start_date
        $endDate     = Carbon::parse($contract->end_date);
        $frequency   = $contract->payment_frequency->value;
        $totalAmount = $contract->total_rent_amount;

        // احسب عدد الدفعات
        $numberOfPayments = $this->calculateNumberOfPayments(
            $contract->start_date,
            $contract->end_date,
            $frequency
        );

        // قيمة الدفعة الواحدة
        $paymentAmount = ceil($totalAmount / $numberOfPayments);

        for ($i = 1; $i <= $numberOfPayments; $i++) {

            // آخر دفعة = الباقي
            $amount = ($i == $numberOfPayments)
                ? ($totalAmount - (($numberOfPayments - 1) * $paymentAmount))
                : $paymentAmount;

            RentalPaymentSchedule::create([
                'rental_contract_id' => $contract->id,
                'payment_number'     => $i,
                'due_date'           => $currentDate->toDateString(), // ← السطر ده قبل الـ add
                'amount'             => $amount,
                'status'             => 'pending',
            ]);

            // بعد كده انقل للفترة التالية
            $currentDate = $this->addPeriod($currentDate, $frequency);
        }
    }

    private function addPeriod(Carbon $date, string $frequency): Carbon
    {
        return match ($frequency) {
            'daily'   => $date->addDay(),
            'monthly' => $date->addMonth(),
            'yearly'  => $date->addYear(),
            default   => $date->addMonth(),
        };
    }

    private function calculateNumberOfPayments($startDate, $endDate, $frequency)
    {
        $start = Carbon::parse($startDate);
        $end   = Carbon::parse($endDate);

        return match ($frequency) {
            'daily'   => $start->diffInDays($end) + 1,   // +1 عشان يحسب اليوم الأول
            'monthly' => $start->diffInMonths($end) + 1, // +1 عشان يحسب الشهر الأول
            'yearly'  => $start->diffInYears($end) + 1,  // +1 عشان يحسب السنة الأولى
            default   => $start->diffInMonths($end) + 1,
        };
    }

    //////////////////////////////////////////////////
    //////////////////////////////////////////////////
    //////////////////////////////////////////////////
    //////////////////////////////////////////////////
    //////////////////////////////////////////////////

    public function searchProperties(Request $request)
    {
        $search = $request->get('q');

        $properties = Property::query()
            ->when($search, function ($query, $search) {
                $query->where('id', $search)
                    ->orWhere('title_normalized_ar', 'like', "%" . normalizeArabic($search) . "%");
            })
            ->where('is_archived', false)
            ->select('id', 'uuid', 'title_normalized_ar')
        // ->limit(10)
            ->get()
            ->map(function ($property) {
                return [
                    'id'   => $property->id,
                    'uuid' => $property->uuid,
                    'text' => "#{$property->id} - {$property->title}",
                ];
            });

        return response()->json($properties);
    }

    public function destroy(RentalContract $rentalContract)
    {

        // Update property availability if linked
        if ($rentalContract->property_id) {
            Property::where('id', $rentalContract->property_id)
                ->update(['availability_status' => PropertyAvailabilityStatus::AVAILABLE->value]);
        }

        $rentalContract->delete();

        return Response::success('تم حذف العقد بنجاح', [
            'style' => 'toastr',
            'reset' => true,
        ]);
    }

}
