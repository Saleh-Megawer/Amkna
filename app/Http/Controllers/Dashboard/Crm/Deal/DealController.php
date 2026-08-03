<?php
namespace App\Http\Controllers\Dashboard\Crm\Deal;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Dashboard\Crm\Deal\DealAttachment;
use App\Models\Dashboard\Status;
use App\Models\Property\Property;
use App\Models\Property\PropertyType;
use App\Traits\Deal\HandlesDealData;
use App\Traits\Deal\HasDealTabs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealController extends Controller
{

    use HasDealTabs, HandlesDealData;

    public function __construct()
    {
        $this->bootTabs();
        $this->bootSharedData();

        // View & filter deals page
        //  $this->middleware(['permission:deals_view_all_page'], ['only' => 'index']);

        // View deal details ( in method edit )

        // Edit deal data
        $this->middleware(['permission:deals_edit'], ['only' => 'update']);

        // Change deal status (win / lost / pending)
        $this->middleware(['permission:deals_change_status'], ['only' => 'updateStatus']);

        // Assign deal to admin
        $this->middleware(['permission:deals_assign_admin'], ['only' => 'assign']);

        // View analytics & reports
        $this->middleware(['permission:deals_view_statistics'], ['only' => 'analytics']);

        // Delete deal (future ready)
        $this->middleware(['permission:deals_delete'], ['only' => 'destroy']);
    }

    public function index(Request $request)
    {

        /**
         * Permission
         */
        if (! isSalesAdmin()) {
            if (! canPermission('deals_view_all_page')) {
                return abort(403);
            }
        }

        $query = Deal::with(['client', 'propertyType', 'assignedTo', 'tags'])
            ->orderByDesc('id');

        if (isSalesAdmin()) {
            $query->where('assigned_to', adminId());
        }

        // Filter: Search (Client name or phone)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Filter: Purpose (buy/rent)
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        // Filter: Property Type
        if ($request->filled('property_type')) {
            $query->where('property_type_id', $request->property_type);
        }

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('status_id', $request->status);
        }

        // Filter: Assigned To
        if ($request->filled('assigned-to')) {
            $query->where('assigned_to', $request->input('assigned-to'));
        }

        // Filter: Date Range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortOrder = $request->input('sort-order', 'desc');
        $query->orderBy('created_at', $sortOrder);

        // Pagination
        $deals = $query->paginate(40);

        // Statistics
        $statsQuery = Deal::selectRaw("
        COUNT(*) as total,
        SUM(CASE WHEN is_won = 1 THEN 1 ELSE 0 END) as won,
        SUM(CASE WHEN is_lost = 1 THEN 1 ELSE 0 END) as lost,
        SUM(CASE WHEN is_won = 0 AND is_lost = 0 THEN 1 ELSE 0 END) as in_progress");

        if (isSalesAdmin()) {
            $statsQuery->where('assigned_to', adminId());
        }
        $stats = $statsQuery->first()->toArray();

        // Get filter options
        $admins        = getActiveAvailableSalesAdmins();
        $propertyTypes = PropertyType::get();

        return view('dashboard.crm.deals.index', compact('deals', 'stats', 'admins', 'propertyTypes'));
    }

    /**
     * Create a deal from interest.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'        => 'required|exists:clients,id',
            'purpose'          => 'required|in:rent,buy',
            'property_type_id' => 'required|exists:property_types,id',
        ]);

        $deal = Deal::create([
            'purpose'          => $data['purpose'],
            'property_type_id' => $data['property_type_id'],
            'client_id'        => $data['client_id'],
            'created_by'       => adminId(),
            'assigned_to'      => isSalesAdmin() ? adminId() : null,
        ]);

        return Response::success('تم الإضافة بنجاح، جاري التحويل...', [
            'style'    => 'toastr',
            'reset'    => true,
            'redirect' => route('crm.deals.edit', $deal->uuid),
            'time_out' => 2,
        ]);

    }

    public function edit($uuid)
    {

        $currentTab = $this->currentTab;
        $tabs       = $this->tabs;
        $tabName    = collect($tabs)->firstWhere('link', $currentTab)['name'];

        // ========================================
        // Base Relationships (Always Load)
        // ========================================
        $baseWith = [
            'client:id,name,country_code,phone,email',
            'propertyType:id',
        ];

        // ========================================
        // Tab-Specific Relationships Map
        // ========================================
        $tabRelations = [
            'main'        => [
                'neighborhoods',
                'city.neighborhoods',
                'properties' => function ($q) {
                    $q->select(['properties.id', 'main_image', 'city_id', 'neighborhood_id', 'area', 'bedrooms', 'bathrooms', 'purpose', 'sale_price', 'rent_price_monthly'])
                        ->with(['city:id', 'neighborhood:id']);
                },
            ],
            'chats'       => [
                'chats.creator:id,full_name',
            ],
            'attachments' => [
                'attachments.uploader:id,full_name',
            ],
            'follow-up'   => [
                'followUps.assignedAdmin:id,full_name',
                'followUps.creator:id,full_name',
            ],
        ];

        // Merge base with tab-specific relationships
        $baseWith = array_merge(
            $baseWith,
            $tabRelations[$currentTab] ?? []
        );

        // Load Deal with relationships
        $row = Deal::with($baseWith)->where('uuid', $uuid)->firstOrFail();

        // ========================================
        // Permission Open This Page !
        // ========================================
        if (isSalesAdmin()) {

            if ($row->assigned_to !== adminId()) {
                abort(403);
            }

        } else {

            if (! canPermission('deals_view_details')) {
                abort(403);
            }

        }

        // ========================================
        // Stat Counts
        // ========================================
        $stat = [
            'total_chats'       => $row->chats->count(),
            'total_follow_ups'  => $row->followUps->count(),
            'total_attachments' => $row->attachments->count(),
        ];

        // ========================================
        // Base View Data
        // ========================================
        $viewData = [
            'row'           => $row,
            'tabs'          => $this->tabs,
            'currentTab'    => $currentTab,
            'tabName'       => $tabName,
            'stat'          => $stat,
            'deal_statuses' => [
                [
                    'id'           => 'is_win',
                    'name'         => 'ناجحة',
                    'button_class' => 'success',
                ],
                [
                    'id'           => 'is_lost',
                    'name'         => 'خاسرة',
                    'button_class' => 'danger',
                ],
                [
                    'id'           => 'is_pending',
                    'name'         => 'قيد المتابعة',
                    'button_class' => 'info',
                ],
            ],
        ];

        // ========================================
        // Tab-Specific View Data
        // ========================================
        if ($currentTab === 'main') {
            $viewData['cityNeighborhoods']     = $row->city?->neighborhoods;
            $viewData['selectedNeighborhoods'] = $row->neighborhoods->pluck('id')->toArray();
            $viewData['dealPropertiesHtml']    = $this->showLinkedProperties($uuid);
        }

        //
        if ($currentTab === 'attachments') {
            $stats = DealAttachment::where('deal_id', $row->id)
                ->selectRaw('attachment_type, COUNT(*) as count')
                ->groupBy('attachment_type')
                ->pluck('count', 'attachment_type');

            $viewData['attachmentStats'] = [
                'total'    => $stats->sum(),
                'contract' => $stats['contract'] ?? 0,
                'invoice'  => $stats['invoice'] ?? 0,
                'image'    => $stats['image'] ?? 0,
                'document' => $stats['document'] ?? 0,
                'id_card'  => $stats['id_card'] ?? 0,
                'other'    => $stats['other'] ?? 0,
            ];

        }

        //
        if ($currentTab === 'follow-up') {
            // Get admins (للـ assigned_to) - للـ admin فقط
            $admins = [];
            if (adminAuth('type') !== 'sales') {
                $admins = Admin::typeSales('type', 'sales')->isActive()->get();
            }
            $viewData['admins'] = $admins;
        }

        return view('dashboard.crm.deals.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {

        // $request->merge([
        //     'budget_min' => trim($request->budget_min) === '' ? null : $request->budget_min,
        //     'budget_max' => trim($request->budget_max) === '' ? null : $request->budget_max,
        // ]);

        $data = $request->validate([

            'amount'              => ['nullable', 'numeric', 'min:0'],
            'commission'          => ['nullable', 'numeric', 'min:0'],
            'marketer_commission' => ['nullable', 'numeric', 'min:0'],

            'facade_id'           => ['nullable', 'exists:property_facades,id'],

            'budget_min'          => ['nullable', 'numeric', 'min:0'],
            'budget_max'          => ['nullable', 'numeric', 'min:0', 'exclude_if:budget_min,null', 'gte:budget_min'],

            'area_min'            => ['nullable', 'integer', 'min:0'],
            'area_max'            => ['nullable', 'integer', 'exclude_if:area_min,null', 'gte:area_min'],

            'bedrooms'            => ['nullable', 'integer', 'min:0'],
            'bathrooms'           => ['nullable', 'integer', 'min:0'],

            'city_id'             => ['nullable', 'exists:cities,id'],
            'neighborhoods'       => ['nullable', 'array'],
            'neighborhoods.*'     => ['exists:neighborhoods,id'],

            'notes'               => 'nullable|max:5000',

        ], [

            'amount.numeric'              => 'قيمة الصفقة يجب أن تكون رقمًا صحيحًا',
            'amount.min'                  => 'قيمة الصفقة لا يمكن أن تكون أقل من صفر',

            'commission.numeric'          => 'العمولة يجب أن تكون رقمًا صحيحًا',
            'commission.min'              => 'العمولة لا يمكن أن تكون أقل من صفر',

            'marketer_commission.numeric' => 'العمولة يجب أن تكون رقمًا صحيحًا',
            'marketer_commission.min'     => 'العمولة لا يمكن أن تكون أقل من صفر',

            'facade_id.exists'            => 'الواجهة المختارة غير موجودة',

            'budget_min.numeric'          => 'الحد الأدنى للميزانية يجب أن يكون رقمًا',
            'budget_min.min'              => 'الحد الأدنى للميزانية لا يمكن أن يكون أقل من صفر',

            'budget_max.numeric'          => 'الحد الأقصى للميزانية يجب أن يكون رقمًا',
            'budget_max.min'              => 'الحد الأقصى للميزانية لا يمكن أن يكون أقل من صفر',
            'budget_max.gte'              => 'الحد الأقصى للميزانية يجب أن يكون أكبر من أو يساوي الحد الأدنى',

            'area_min.integer'            => 'أقل مساحة يجب أن تكون رقمًا صحيحًا',
            'area_min.min'                => 'أقل مساحة لا يمكن أن تكون أقل من صفر',

            'area_max.integer'            => 'أكبر مساحة يجب أن تكون رقمًا صحيحًا',
            'area_max.gte'                => 'أكبر مساحة يجب أن تكون أكبر من أو تساوي أقل مساحة',

            'bedrooms.integer'            => 'عدد الغرف يجب أن يكون رقمًا صحيحًا',
            'bedrooms.min'                => 'عدد الغرف لا يمكن أن يكون أقل من صفر',

            'bathrooms.integer'           => 'عدد الحمامات يجب أن يكون رقمًا صحيحًا',
            'bathrooms.min'               => 'عدد الحمامات لا يمكن أن يكون أقل من صفر',

            'city_id.exists'              => 'المدينة المختارة غير صحيحة',

            'neighborhoods.array'         => 'صيغة المناطق المختارة غير صحيحة',
            'neighborhoods.*.exists'      => 'إحدى المناطق المختارة غير موجودة',

        ]);

        // تحديث بيانات الصفقة نفسها
        $deal->update($data);

        // ربط المناطق (لو موجودة في الريكوست)
        if ($request->filled('neighborhoods')) {
            $deal->neighborhoods()->sync($request->neighborhoods);
        }

        return Response::success('تم تحديث بيانات الصفقة بنجاح', ['style' => 'toastr']);
    }

    /**
     * Assign deals to another admin.
     */
    public function assign(Request $request, Deal $deal)
    {
        $request->validate([
            'assigned_to' => 'required|exists:admins,id',
        ]);

        $deal->update([
            'assigned_to' => $request->assigned_to,
        ]);

        return Response::success('تم تكليف الموظف ليعمل علي الصفقة بنجاح', ['style' => 'toastr']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $client)
    {

    }

    public function updateStatus(Request $request, Deal $deal)
    {

        if (! in_array($request->status, ['is_win', 'is_lost', 'is_pending'])) {
            abort(422);
        }

        $deal->is_won  = 0;
        $deal->is_lost = 0;

        match ($request->status) {
            'is_win'  => $deal->is_won   = 1,
            'is_lost' => $deal->is_lost = 1,
            default   => null,
        };

        $deal->save();

        return response()->json(['success' => true]);
    }

    /**
     * Get Match Properties
     */
    public function showLinkedProperties($deal_uuid = null)
    {
        // Get the deal
        $deal = Deal::whereUuid(request('deal_uuid', $deal_uuid))->firstOrFail();

        // Get property IDs linked to this deal
        $propertyIds = DB::table('deal_property')->where('deal_id', $deal->id)->pluck('property_id');

        // Get properties
        $properties = Property::query()
            ->whereIn('id', $propertyIds)
            ->select([
                'id',
                'uuid',
                'main_image',
                'city_id',
                'neighborhood_id',
                'area',
                'bedrooms',
                'bathrooms',
                'purpose',
                'sale_price',
                'rent_price_monthly',
                'created_at',
            ])
            ->with([
                'city:id',
                'neighborhood:id',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $addedPropertyIds = $propertyIds->toArray();

        return view('dashboard.crm.deals.load.match-properties', [
            'properties'       => $properties,
            'addedPropertyIds' => $addedPropertyIds,
            'result_message'   => "يوجد ( {$properties->count()} ) وحدة مرتبطة بالصفقة",
        ])->render();
    }

    public function getMatchProperties(Request $request)
    {
        // Get the deal
        $deal = Deal::whereUuid($request->deal_uuid)->firstOrFail();

        // Get property IDs already added to this deal
        $addedPropertyIds = $deal->properties()->pluck('properties.id')->toArray();

        // Build properties query with filters
        $properties = Property::query()
            ->select([
                'id',
                'uuid',
                'main_image',
                'city_id',
                'neighborhood_id',
                'area',
                'bedrooms',
                'bathrooms',
                'purpose',
                'sale_price',
                'rent_price_monthly',
                'created_at',
            ])
            ->with([
                'city:id',
                'neighborhood:id',
            ])
            ->where('is_archived', false)
            ->when($request->purpose, fn($q) => $q->where('purpose', $request->purpose))
            ->when($request->city_id, fn($q) => $q->where('city_id', $request->city_id))
            ->when($request->neighborhoods, fn($q) => $q->whereIn('neighborhood_id', $request->neighborhoods))
            ->when($request->filled('budget_min') || $request->filled('budget_max'), function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    // For sale properties
                    $query->when($request->purpose !== 'rent', function ($q) use ($request) {
                        $q->where(function ($subQuery) use ($request) {
                            $subQuery->where('purpose', 'sale')
                                ->when($request->budget_min, fn($q) => $q->where('sale_price', '>=', $request->budget_min))
                                ->when($request->budget_max, fn($q) => $q->where('sale_price', '<=', $request->budget_max));
                        });
                    });
                    // For rent properties
                    $query->when($request->purpose !== 'sale', function ($q) use ($request) {
                        $q->orWhere(function ($subQuery) use ($request) {
                            $subQuery->where('purpose', 'rent')
                                ->when($request->budget_min, fn($q) => $q->where('rent_price_monthly', '>=', $request->budget_min))
                                ->when($request->budget_max, fn($q) => $q->where('rent_price_monthly', '<=', $request->budget_max));
                        });
                    });
                });
            })
            ->when($request->area_min, fn($q) => $q->where('area', '>=', $request->area_min))
            ->when($request->area_max, fn($q) => $q->where('area', '<=', $request->area_max))
            ->when($request->bedrooms, fn($q) => $q->where('bedrooms', $request->bedrooms))
            ->when($request->bathrooms, fn($q) => $q->where('bathrooms', $request->bathrooms))
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Return rendered view with properties and added IDs
        return view('dashboard.crm.deals.load.match-properties', [
            'properties'       => $properties,
            'addedPropertyIds' => $addedPropertyIds,
            'result_message'   => "تم العثور علي ( {$properties->total()} ) نتيجة ذات صلة باهتمام العميل",
        ])->render();
    }

    public function addProperty(Request $request)
    {
        $data = $request->validate([
            'deal_uuid'   => ['required', 'uuid', 'exists:deals,uuid'],
            'property_id' => ['required', 'exists:properties,id'],
        ]);

        $deal = Deal::whereUuid($data['deal_uuid'])->firstOrFail();

        $deal->properties()->syncWithoutDetaching($data['property_id']);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة العقار للصفقة بنجاح',
        ]);
    }

    public function removeProperty(Request $request)
    {
        $data = $request->validate([
            'deal_uuid'   => ['required', 'uuid', 'exists:deals,uuid'],
            'property_id' => ['required', 'exists:properties,id'],
        ]);

        $deal = Deal::whereUuid($data['deal_uuid'])->firstOrFail();

        $deal->properties()->detach($data['property_id']);

        return response()->json([
            'success' => true,
            'message' => 'تم إلغاء ربط العقار من الصفقة بنجاح',
        ]);
    }

    // =====================================================
    // Analytics & Reports
    // =====================================================
    public function analytics()
    {
        // ==============================================
        // إحصائيات عامة
        // ==============================================
        $totalDeals = Deal::count();
        // الصفقات الناجحة
        $wonDeals = Deal::where('is_won', true)->count();
        // الصفقات الخاسرة
        $lostDeals = Deal::where('is_lost', true)->count();

        // الصفقات المفتوحة (لا ناجحة ولا خاسرة)
        $openDeals = Deal::where('is_won', false)
            ->where('is_lost', false)
            ->count();

        // نسبة النجاح
        $successRate = $totalDeals > 0 ? round(($wonDeals / $totalDeals) * 100, 2) : 0;

        // ==============================================
        // الإيرادات والعمولات
        // ==============================================
        $totalRevenue     = Deal::where('is_won', true)->sum('amount');
        $totalCommission  = Deal::where('is_won', true)->sum('commission');
        $averageDealValue = Deal::where('is_won', true)->avg('amount');

        // الإيرادات الشهر الحالي
        $currentMonthRevenue = Deal::where('is_won', true)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        // ==============================================
        // الصفقات حسب النوع (إيجار/شراء)
        // ==============================================
        $dealsByPurpose = Deal::selectRaw('
        purpose,
        count(*) as count,
        sum(amount) as total_amount
        ')
            ->where('is_won', true)
            ->groupBy('purpose')
            ->get();

        // ==============================================
        // الصفقات حسب نوع العقار
        // ==============================================
        $dealsByPropertyType = Deal::with('propertyType')
            ->selectRaw('
        property_type_id,
        count(*) as count,
        sum(amount) as total_amount
        ')
            ->where('is_won', true)
            ->whereNotNull('property_type_id')
            ->groupBy('property_type_id')
            ->get();

        // ==============================================
        // أداء الموظفين
        // ==============================================
        $topPerformers = Deal::with('assignedTo')
            ->selectRaw('
        assigned_to,
        count(*) as deals_count,
        sum(CASE WHEN is_won = 1 THEN 1 ELSE 0 END) as won_count,
        sum(amount) as total_revenue,
        sum(commission) as total_commission
        ')
            ->whereNotNull('assigned_to')
            ->groupBy('assigned_to')
            ->orderByDesc('won_count')
            ->limit(10)
            ->get();

        // ==============================================
        // الصفقات آخر 12 شهر (الناجحة والمفتوحة)
        // ==============================================
        $dealsLast12Months = Deal::selectRaw('
        DATE_FORMAT(created_at, "%Y-%m") as month,
        count(*) as total_deals,
        sum(CASE WHEN is_won = 1 THEN 1 ELSE 0 END) as won_deals,
        sum(amount) as revenue
        ')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // ==============================================
        // الصفقات حسب نطاق السعر
        // ==============================================
        $dealsByPriceRange = Deal::selectRaw("
        CASE
        WHEN amount < 100000 THEN 'أقل من 100 ألف' WHEN amount>= 100000 AND amount < 500000 THEN '100-500 ألف' WHEN amount>=
                500000 AND amount < 1000000 THEN '500 ألف - 1 مليون' WHEN amount>= 1000000 AND amount < 5000000 THEN '1-5 مليون'
                        ELSE 'أكثر من 5 مليون' END as price_range, count(*) as count ")
            ->where('is_won', true)
            ->whereNotNull('amount')
            ->groupBy('price_range')
            ->get();

        // ==============================================
        // مصادر الصفقات
        // ==============================================
        $dealsBySources = Deal::with('source')
            ->selectRaw('
                source_id,
                count(*) as count,
                sum(CASE WHEN is_won = 1 THEN 1 ELSE 0 END) as won_count
            ')
            ->whereNotNull('source_id')
            ->groupBy('source_id')
            ->get();

        // ==============================================
        // متوسط الوقت لإغلاق الصفقة
        // ==============================================
        $avgTimeToClose = Deal::where('is_won', true)
            ->whereNotNull('updated_at')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->first();

        // ==============================================
        // التقييمات
        // ==============================================
        $averageRating = Deal::where('is_won', true)
            ->whereNotNull('rating')
            ->avg('rating');

        $ratingDistribution = Deal::selectRaw('
                rating,
                count(*) as count
            ')
            ->whereNotNull('rating')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        // ==============================================
        // أفضل العملاء (الأكثر صفقات)
        // ==============================================
        $topClients = Deal::with('client')
            ->selectRaw('
                client_id,
                count(*) as deals_count,
                sum(amount) as total_spent
            ')
            ->where('is_won', true)
            ->groupBy('client_id')
            ->orderByDesc('deals_count')
            ->limit(10)
            ->get();

        return view('dashboard.crm.deals.analytics', compact(
            'totalDeals',
            'wonDeals',
            'lostDeals',
            'openDeals',
            'successRate',
            'totalRevenue',
            'totalCommission',
            'averageDealValue',
            'currentMonthRevenue',
            'dealsByPurpose',
            'dealsByPropertyType',
            'topPerformers',
            'dealsLast12Months',
            'dealsByPriceRange',
            'dealsBySources',
            'avgTimeToClose',
            'averageRating',
            'ratingDistribution',
            'topClients'
        ));
    }

}
