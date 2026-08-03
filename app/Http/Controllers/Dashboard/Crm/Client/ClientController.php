<?php
namespace App\Http\Controllers\Dashboard\Crm\Client;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Client\ClientStoreRequest;
use App\Http\Requests\Dashboard\Client\ClientUpdateRequest;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Dashboard\Source;
use App\Traits\Client\FindsClientByUuid;
use App\Traits\Client\HandlesClientData;
use App\Traits\Client\HasClientTabs;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    use HasClientTabs, HandlesClientData, FindsClientByUuid;

    public function __construct()
    {
        $this->bootTabs();
        $this->bootSharedData();

        // View & filter clients
        $this->middleware(['permission:clients_view_all_page'], ['only' => ['index']]);
        $this->middleware(['permission:clients_view_details'], ['only' => ['show', 'edit']]);

        // Create client
        $this->middleware(['permission:clients_create'], ['only' => 'store']);

        // Edit & update client
        $this->middleware(['permission:clients_edit'], ['only' => 'update']);

        // Delete client
        $this->middleware(['permission:clients_delete'], ['only' => 'destroy']);

        // Ban / unban client
        $this->middleware(['permission:clients_ban_account'], ['only' => 'changeStatus']);

        // View analytics & statistics
        $this->middleware(['permission:clients_view_statistics'], ['only' => 'analytics']);
    }

    public function index()
    {

        $clients = Client::query()
            ->select(['id', 'uuid', 'name', 'phone', 'country_code', 'email', 'has_account', 'assigned_to', 'created_by', 'last_seen', 'source_id', 'created_at', 'status'])
            ->with(['assignedAdmin:id,full_name', 'creator:id,full_name'])
            ->when(request('search'), function ($query, $search) {
                $cleanedSearch = ltrim($search, '0');
                $query->where(fn($q) =>
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$cleanedSearch}%")
                );
            })
            ->when(request()->filled('has-account'), fn($query) =>
                $query->where('has_account', request('has-account'))
            )
            ->when(request()->filled('assigned-to'), fn($query) =>
                $query->where('assigned_to', request('assigned-to'))
            )
            ->orderBy('created_at', request('sort-order', 'desc'))
            ->paginate(25)
            ->withQueryString();

        $admins = Admin::excludeSystem()->where('status', '1')->select('id', 'full_name')->orderBy('full_name')->get();

        // ✅ احصائيات العملاء
        $stats = [
            'total'   => Client::count(),
            'active'  => Client::where('status', '1')->count(),
            'blocked' => Client::where('status', '0')->count(),
        ];

        return view('dashboard.crm.clients.index', compact('clients', 'admins', 'stats'));
    }
    public function create()
    {
        return view('dashboard.crm.clients.create');
    }

    public function store(ClientStoreRequest $request)
    {
        // Validate Data
        $data = $request->validated();

        // Set Source
        $data['source_id']  = Source::clientManual()->first()?->id;
        $data['created_by'] = adminId();

        // Create New Client
        $row = Client::with(['creator:id,full_name'])->create($data);

        // Return Response
        return Response::success('تم إضافة العميل بنجاح', [
            'style'    => 'toastr',
            'reset'    => true,
            'redirect' => request()->has('noRedirect') ? null : route('crm.clients.edit', $row->uuid),
            'time_out' => 2,
        ]);
    }

    public function searchByNameOrPhone()
    {

        // Get search keyword
        $search = request('q_name_or_phone');

        $name = $search;

        // Remove First Number
        $phone = mb_substr($search, 1);

        $clients = Client::query()
            ->when($search, function ($q) use ($name, $phone) {
                $q->where('name', 'LIKE', "%{$name}%")
                    ->orWhere('phone', 'LIKE', "%{$phone}%");
            })
            ->select('id', 'name', 'country_code', 'phone')
            ->get();

        return response()->json($clients);
    }

    public function show(Client $client)
    {
        // Load all relations
        $client->load([
            'source',
            'assignedAdmin',
            'city',
            'neighborhood',
            'creator',
            'deals.propertyType',
            'deals.assignedTo',
            'interests.property',
            'interests.assignedTo',
            'tags',
        ]);

        // Statistics
        $stats = [
            'total_deals'      => $client->deals()->count(),
            'won_deals'        => $client->deals()->where('is_won', true)->count(),
            'total_interests'  => $client->interests()->count(),
            'unread_interests' => $client->interests()->where('is_read', false)->count(),
        ];

        return view('dashboard.crm.clients.show', compact('client', 'stats'));
    }

    public function edit($uuid)
    {
        $client = Client::with([
            'source:id,key,name',
        ])->where('uuid', $uuid)->firstOrFail();

        // Load deals only if tab = deals
        $deals = [];
        if ($this->currentTab === 'deals') {
            $deals = $client->deals()->with(['assignedTo:id,full_name'])->orderByDesc('id')->get();
        }

        //
        $logs      = [];
        $logsCount = $client->activities()->count();
        if ($this->currentTab === 'logs') {
            $logs = $client->activities()->with('causer:id,full_name')->orderBy('created_at', 'desc')->get();
        }

        //
        $notes      = [];
        $notesCount = $client->notes()->count();
        if ($this->currentTab === 'notes') {
            $notes = $client->notes()->with(['creator:id,full_name'])->orderByDesc('id')->get();
        }

        return view('dashboard.crm.clients.edit',
            array_merge(
                $this->getViewData(),
                [
                    'client'     => $client,
                    'deals'      => $deals,
                    'logs'       => $logs,
                    'logsCount'  => $logsCount,
                    'notes'      => $notes,
                    'notesCount' => $notesCount,
                ]
            )
        );
    }

    public function update(ClientUpdateRequest $request, Client $client)
    {

        // Validate Data
        $data = $request->validated();

        // Update
        $client->update($data);

        // Return success
        return Response::success('تم تحديث العميل بنجاح', [
            'style' => 'toastr',
            'reset' => false,
        ]);
    }

    //
    // public function assign(Request $request, Client $client)
    // {
    //     $request->validate([
    //         'assigned_to' => 'required|exists:admins,id',
    //     ]);

    //     $oldAdminName = $client->assignedAdmin?->full_name ?? 'غير مكلف';
    //     $oldAdminId   = $client->assigned_to ?? '-';

    //     $newAdminName = Admin::find($request->assigned_to)->full_name;
    //     $newAdminId   = $request->assigned_to;

    //     // ✅ أوقف الـ auto-logging مؤقتاً
    //     activity()->disableLogging();

    //     $client->update([
    //         'assigned_to' => $request->assigned_to,
    //     ]);

    //     activity()->enableLogging();

    //     // ✅ سجل يدوي مخصص
    //     $client->activities()->create([
    //         'log_name'     => 'client',
    //         'description'  => 'تم تغيير الموظف المكلّف',
    //         'subject_type' => Client::class,
    //         'subject_id'   => $client->id,
    //         'causer_type'  => Admin::class,
    //         'causer_id'    => adminId(),
    //         'properties'   => [
    //             'message' => "من \"{$oldAdminName} (#{$oldAdminId})\" إلى \"{$newAdminName} (#{$newAdminId})\"",
    //             'old' => $oldAdminName,
    //             'new' => $newAdminName,
    //         ],
    //     ]);

    //     return Response::success('تم تكليف الموظف بنجاح', ['style' => 'toastr']);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {

        try {

            $clientName = $client->name;

            $client->delete();

            return Response::success("تم حذف العميل {$clientName} بنجاح", ['style' => 'toastr']);

        } catch (\Exception $e) {

            return response($e);

            return Response::error('فشل حذف العميل، يرجى المحاولة مرة أخرى', ['style' => 'toastr']);
        }
    }

    public function analytics()
    {
        // ==============================================
        // إحصائيات عامة
        // ==============================================
        $totalClients       = Client::count();
        $activeClients      = Client::where('status', 1)->count();
        $inactiveClients    = Client::where('status', 0)->count();
        $archivedClients    = Client::where('is_archived', true)->count();
        $clientsWithAccount = Client::where('has_account', true)->count();

        // العملاء الجدد هذا الشهر
        $newClientsThisMonth = Client::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // ==============================================
        // العملاء حسب المصدر (Source)
        // ==============================================
        $clientsBySource = Client::with('source')
            ->selectRaw('source_id, count(*) as count')
            ->whereNotNull('source_id')
            ->groupBy('source_id')
            ->get();

        // ==============================================
        // العملاء حسب المدينة
        // ==============================================
        $clientsByCity = Client::with('city')
            ->selectRaw('city_id, count(*) as count')
            ->whereNotNull('city_id')
            ->groupBy('city_id')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // ==============================================
        // العملاء المسندين للموظفين
        // ==============================================
        $clientsByAssignee = Client::with('assignedAdmin')
            ->selectRaw('assigned_to, count(*) as count')
            ->whereNotNull('assigned_to')
            ->groupBy('assigned_to')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // ==============================================
        // اتجاه التسجيل آخر 12 شهر
        // ==============================================
        $clientsLast12Months = Client::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as month,
            count(*) as count
        ')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // ==============================================
        // العملاء الأكثر نشاطاً (لديهم صفقات)
        // ==============================================
        $topActiveClients = Client::withCount('deals')
            ->with(['deals' => function ($query) {
                $query->where('is_won', true);
            }])
            ->having('deals_count', '>', 0)
            ->orderByDesc('deals_count')
            ->limit(10)
            ->get();

        // ==============================================
        // العملاء الأكثر إنفاقاً
        // ==============================================
        $topSpendingClients = Deal::with('client')
            ->selectRaw('client_id, sum(amount) as total_spent, count(*) as deals_count')
            ->where('is_won', true)
            ->groupBy('client_id')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // ==============================================
        // معدل التحويل (العملاء الذين لديهم صفقات ناجحة)
        // ==============================================
        $clientsWithWonDeals = Client::whereHas('deals', function ($query) {
            $query->where('is_won', true);
        })->count();

        $conversionRate = $totalClients > 0
            ? round(($clientsWithWonDeals / $totalClients) * 100, 2)
            : 0;

        // ==============================================
        // العملاء الخاملين (آخر نشاط أكثر من 3 شهور)
        // ==============================================
        $inactiveClientsCount = Client::where(function ($query) {
            $query->where('last_seen', '<', now()->subMonths(3))
                ->orWhereNull('last_seen');
        })->count();

        // ==============================================
        // متوسط الصفقات لكل عميل
        // ==============================================
        $avgDealsPerClient = Deal::count() > 0 && $totalClients > 0
            ? round(Deal::count() / $totalClients, 2)
            : 0;

        // ==============================================
        // العملاء حسب وجود بيانات الاتصال
        // ==============================================
        $clientsWithEmail = Client::whereNotNull('email')->count();
        $clientsWithPhone = Client::whereNotNull('phone')->count();
        $clientsWithBoth  = Client::whereNotNull('email')
            ->whereNotNull('phone')
            ->count();

        // ==============================================
        // العملاء الذين تم التحقق من إيميلهم
        // ==============================================
        $verifiedEmailClients = Client::whereNotNull('email_verified_at')->count();

        // ==============================================
        // العملاء حسب الاهتمامات (Interests)
        // ==============================================
        $clientsWithInterests = Client::has('interests')->count();

        // ==============================================
        // توزيع العملاء حسب تاريخ الإضافة
        // ==============================================
        $clientsThisWeek  = Client::where('created_at', '>=', now()->startOfWeek())->count();
        $clientsThisMonth = Client::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $clientsThisYear = Client::whereYear('created_at', Carbon::now()->year)->count();

        return view('dashboard.crm.clients.analytics', compact(
            'totalClients',
            'activeClients',
            'inactiveClients',
            'archivedClients',
            'clientsWithAccount',
            'newClientsThisMonth',
            'clientsBySource',
            'clientsByCity',
            'clientsByAssignee',
            'clientsLast12Months',
            'topActiveClients',
            'topSpendingClients',
            'conversionRate',
            'inactiveClientsCount',
            'avgDealsPerClient',
            'clientsWithEmail',
            'clientsWithPhone',
            'clientsWithBoth',
            'clientsThisWeek',
            'clientsThisMonth',
            'clientsThisYear',
            'clientsWithWonDeals',
            'verifiedEmailClients',
            'clientsWithInterests'
        ));
    }

    // public function changeStatus(Request $request)
    // {

    //     try {

    //         // Find client by UUID
    //         $client = Client::where('uuid', $request->id)->firstOrFail();

    //         // Toggle status
    //         $client->status = $client->status == '0' ? '1' : '0';
    //         $client->save();

    //         // Response message
    //         $action = $client->status == '1' ? 'فك حظر' : 'حظر';
    //         $style  = $client->status == '1' ? 'warning' : 'success';

    //         return Response::$style("تم {$action} حساب العميل {$client->name}", ['style' => 'toastr']);

    //     } catch (\Exception $e) {
    //         return Response::error('هذه العملية غير مصرح بها، وقد لا تكون البيانات المطلوبة متوفرة في النظام', ['style' => 'alert']);
    //     }
    // }

    public function changeStatus(Request $request)
    {
        try {
            $client = Client::where('uuid', $request->id)->firstOrFail();

            $client->status = $client->status == '0' ? '1' : '0';
            $client->save();

            $action  = $client->status ? 'فك حظر' : 'حظر';
            $message = "تم {$action} حساب العميل {$client->name}";
            $style   = $client->status == '1' ? 'info' : 'success';

            $buttonHtml = view('dashboard.crm.clients.partials.status-button', compact('client'))->render();

            // ✅ استخدام الـ data في options
            return Response::$style($message, [
                'style' => 'toastr',
                'data'  => [
                    'buttonHtml' => $buttonHtml,
                    'clientId'   => $client->uuid,
                    'newStatus'  => $client->status,
                ],
            ]);

        } catch (\Exception $e) {
            return Response::error('العملية غير مصرح بها أو البيانات غير موجودة', [
                'style' => 'toastr',
            ]);
        }
    }

}
