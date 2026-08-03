@extends('dashboard.layouts.master')
@section('title', 'تحليلات العملاء')
<x-dashboard.css :links="[
    [
        'link' => 'clients/analytics.css',
    ],
]" />
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'تحليلات العملاء',
        ],
    ]" :buttons="[
        [
            'name' => 'العودة للعملاء <i class=\'fa-solid fa-arrow-left\'></i>',
            'class' => 'btn-main',
            'link' => route('crm.clients.index'),
        ],
    ]" /><!-- links bar -->

    <main class="mb-5">
        <!-- KPIs Row 1 -->
        <section id="kpi-cards">
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div class="analytics-card-icon total rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($totalClients) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">إجمالي العملاء</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div
                            class="analytics-card-icon active rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($activeClients) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">حسابات مفعلة</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div
                            class="analytics-card-icon conversion rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ $conversionRate }}%</h3>
                            <p class="analytics-card-label text-muted mb-0 small">معدل التحويل</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div class="analytics-card-icon new rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($newClientsThisMonth) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">عملاء جدد هذا الشهر</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- KPIs Row 2 -->
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div
                            class="analytics-card-icon account rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($clientsWithAccount) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">لديهم حسابات</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div
                            class="analytics-card-icon verified rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 12l2 2l4 -4" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($verifiedEmailClients) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">إيميلات متحققة</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div
                            class="analytics-card-icon inactive rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M9 10h.01" />
                                <path d="M15 10h.01" />
                                <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($inactiveClientsCount) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">عملاء خاملين</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div
                            class="analytics-card-icon interests rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($clientsWithInterests) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">لديهم اهتمامات</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- KPIs Row 3 -->
            <div class="row">

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div class="analytics-card-icon avg rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21l18 0" />
                                <path
                                    d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ $avgDealsPerClient }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">متوسط الصفقات/عميل</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div
                            class="analytics-card-icon archived rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" />
                                <path d="M10 12l4 0" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($archivedClients) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">عملاء مؤرشفين</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div
                            class="analytics-card-icon won-deals rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 6l4 6l5 -4l-2 10h-14l-2 -10l5 4z" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($clientsWithWonDeals) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">لديهم صفقات ناجحة</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                        <div
                            class="analytics-card-icon disabled rounded d-flex align-items-center justify-content-center ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="analytics-card-number mb-1">{{ number_format($inactiveClients) }}</h3>
                            <p class="analytics-card-label text-muted mb-0 small">حسابات موقوفة</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Charts Row 1 -->
        <div class="row mt-2">

            <!-- Clients Trend -->
            <div class="col-lg-8 mb-3">
                <div class="bg-white border rounded p-3">
                    <h6 class="font-weight-600 mb-3">اتجاه تسجيل العملاء (آخر 12 شهر)</h6>
                    <div id="clientsTrendChart"></div>
                </div>
            </div>

            <!-- Clients by Source -->
            <div class="col-lg-4 mb-3">
                <div class="bg-white border rounded p-3">
                    <h6 class="font-weight-600 mb-3">مصادر العملاء</h6>
                    <div id="clientsBySourceChart"></div>
                </div>
            </div>

        </div>

        <!-- Charts Row 2 -->
        <div class="row">

            <!-- Clients by City -->
            <div class="col-lg-6 mb-3">
                <div class="bg-white border rounded p-3">
                    <h6 class="font-weight-600 mb-3">أكثر المدن (أعلى 10)</h6>
                    <div id="clientsByCityChart"></div>
                </div>
            </div>

            <!-- Contact Info Stats -->
            <div class="col-lg-6 mb-3">
                <div class="bg-white border rounded p-3">
                    <h6 class="font-weight-600 mb-3">بيانات الاتصال</h6>
                    <div id="contactInfoChart"></div>
                </div>
            </div>

        </div>

        <!-- Time-based Stats -->
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="bg-white border rounded p-3">
                    <h6 class="font-weight-600 mb-3">إحصائيات زمنية</h6>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="p-3">
                                <h3 class="text-primary font-weight-700 mb-2">{{ number_format($clientsThisWeek) }}</h3>
                                <p class="text-muted mb-0 small">هذا الأسبوع</p>
                            </div>
                        </div>
                        <div class="col-4 border-right border-left">
                            <div class="p-3">
                                <h3 class="text-success font-weight-700 mb-2">{{ number_format($clientsThisMonth) }}</h3>
                                <p class="text-muted mb-0 small">هذا الشهر</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3">
                                <h3 class="text-warning font-weight-700 mb-2">{{ number_format($clientsThisYear) }}</h3>
                                <p class="text-muted mb-0 small">هذا العام</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Row -->
        <div class="row">

            <!-- Top Active Clients -->
            <div class="col-lg-6 mb-3">
                <div class="bg-white border rounded p-3">
                    <h6 class="font-weight-600 mb-3">العملاء الأكثر نشاطاً</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>العميل</th>
                                    <th class="text-center">عدد الصفقات</th>
                                    <th>الهاتف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topActiveClients as $client)
                                    <tr>
                                        <td class="font-weight-500">{{ $client->name }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $client->deals_count }}</span>
                                        </td>
                                        <td class="text-ltr">{{ $client->phone ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">لا توجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top Spending Clients -->
            <div class="col-lg-6 mb-3">
                <div class="bg-white border rounded p-3">
                    <h6 class="font-weight-600 mb-3">العملاء الأكثر إنفاقاً</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>العميل</th>
                                    <th class="text-center">الصفقات</th>
                                    <th>إجمالي الإنفاق</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topSpendingClients as $item)
                                    <tr>
                                        <td class="font-weight-500">{{ $item->client->name ?? 'غير محدد' }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-success">{{ $item->deals_count }}</span>
                                        </td>
                                        <td>{{ number_format($item->total_spent) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">لا توجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Assignees Table -->
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="bg-white border rounded p-3">
                    <h6 class="font-weight-600 mb-3">توزيع العملاء على الموظفين</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>الموظف</th>
                                    <th class="text-center">عدد العملاء</th>
                                    <th class="text-center">النسبة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clientsByAssignee as $item)
                                    <tr>
                                        <td class="font-weight-500">{{ $item->assignedAdmin->full_name ?? 'غير محدد' }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $item->count }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ round(($item->count / $totalClients) * 100, 1) }}%
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">لا توجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main> <!-- end main -->

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ============================================
            // 1. Clients Trend (Area Chart)
            // ============================================
            var clientsTrendOptions = {
                series: [{
                    name: 'عدد العملاء',
                    data: [
                        @foreach ($clientsLast12Months as $item)
                            {{ $item->count }},
                        @endforeach
                    ]
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    fontFamily: 'inherit',
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3
                    }
                },
                colors: ['#3b82f6'],
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: [
                        @foreach ($clientsLast12Months as $item)
                            '{{ \Carbon\Carbon::parse($item->month)->locale('ar')->format('M Y') }}',
                        @endforeach
                    ]
                },
                grid: {
                    borderColor: '#f1f1f1'
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + ' عميل';
                        }
                    }
                }
            };

            var clientsTrendChart = new ApexCharts(
                document.querySelector("#clientsTrendChart"),
                clientsTrendOptions
            );
            clientsTrendChart.render();

            // ============================================
            // 2. Clients by Source (Donut)
            // ============================================
            var clientsBySourceOptions = {
                series: [
                    @foreach ($clientsBySource as $item)
                        {{ $item->count }},
                    @endforeach
                ],
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'inherit'
                },
                labels: [
                    @foreach ($clientsBySource as $item)
                        '{{ $item->source->name ?? 'غير محدد' }}',
                    @endforeach
                ],
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'],
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'الإجمالي'
                                }
                            }
                        }
                    }
                }
            };

            var clientsBySourceChart = new ApexCharts(
                document.querySelector("#clientsBySourceChart"),
                clientsBySourceOptions
            );
            clientsBySourceChart.render();

            // ============================================
            // 3. Clients by City (Bar)
            // ============================================
            var clientsByCityOptions = {
                series: [{
                    name: 'عدد العملاء',
                    data: [
                        @foreach ($clientsByCity as $item)
                            {{ $item->count }},
                        @endforeach
                    ]
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    fontFamily: 'inherit',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        horizontal: true,
                        distributed: true
                    }
                },
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#f43f5e', '#14b8a6',
                    '#a855f7', '#f97316'
                ],
                dataLabels: {
                    enabled: true
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: [
                        @foreach ($clientsByCity as $item)
                            '{{ $item->city->name ?? 'غير محدد' }}',
                        @endforeach
                    ]
                }
            };

            var clientsByCityChart = new ApexCharts(
                document.querySelector("#clientsByCityChart"),
                clientsByCityOptions
            );
            clientsByCityChart.render();

            // ============================================
            // 4. Contact Info (Donut)
            // ============================================
            var contactInfoOptions = {
                series: [
                    {{ $clientsWithBoth }},
                    {{ $clientsWithEmail - $clientsWithBoth }},
                    {{ $clientsWithPhone - $clientsWithBoth }},
                    {{ $totalClients - $clientsWithEmail - $clientsWithPhone + $clientsWithBoth }}
                ],
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'inherit'
                },
                labels: ['إيميل + جوال', 'إيميل فقط', 'جوال فقط', 'بدون بيانات'],
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%'
                        }
                    }
                }
            };

            var contactInfoChart = new ApexCharts(
                document.querySelector("#contactInfoChart"),
                contactInfoOptions
            );
            contactInfoChart.render();

        });
    </script>
@endsection
