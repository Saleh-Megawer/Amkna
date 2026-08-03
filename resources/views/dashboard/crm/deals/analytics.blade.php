@extends('dashboard.layouts.master')
@section('title', 'تحليلات الصفقات')
<x-dashboard.css :links="[
    [
        'link' => 'deals/analytics.css',
    ],
]" />
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'تحليلات الصفقات',
        ],
    ]" :buttons="[
        [
            'name' => 'العودة للصفقات <i class=\'fa-solid fa-arrow-left\'></i>',
            'class' => 'btn-main',
            'link' => route('crm.deals.index'),
        ],
    ]" /><!-- links bar -->




    <!-- KPIs Cards -->
    <section id="kpi-cards">
        <div class="row">

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                    <div class="analytics-card-icon total rounded d-flex align-items-center justify-content-center ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 21l18 0" />
                            <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
                        </svg>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="analytics-card-number mb-1">{{ number_format($totalDeals) }}</h3>
                        <p class="analytics-card-label text-muted mb-0 small">إجمالي الصفقات</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                    <div class="analytics-card-icon won rounded d-flex align-items-center justify-content-center ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 6l4 6l5 -4l-2 10h-14l-2 -10l5 4z" />
                        </svg>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="analytics-card-number mb-1">{{ number_format($wonDeals) }}</h3>
                        <p class="analytics-card-label text-muted mb-0 small">صفقات ناجحة</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                    <div class="analytics-card-icon success rounded d-flex align-items-center justify-content-center ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 11l3 3l8 -8" />
                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                        </svg>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="analytics-card-number mb-1">{{ $successRate }}%</h3>
                        <p class="analytics-card-label text-muted mb-0 small">نسبة النجاح</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                    <div class="analytics-card-icon revenue rounded d-flex align-items-center justify-content-center ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                            <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                        </svg>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="analytics-card-number mb-1">{{ number_format($totalRevenue) }}</h3>
                        <p class="analytics-card-label text-muted mb-0 small">إجمالي الإيرادات</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                    <div
                        class="analytics-card-icon commission rounded d-flex align-items-center justify-content-center ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                            <path d="M12 3v3m0 12v3" />
                        </svg>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="analytics-card-number mb-1">{{ number_format($totalCommission) }}</h3>
                        <p class="analytics-card-label text-muted mb-0 small">إجمالي العمولات</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                    <div class="analytics-card-icon average rounded d-flex align-items-center justify-content-center ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                            <path d="M12 7v5l3 3" />
                        </svg>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="analytics-card-number mb-1">{{ number_format($averageDealValue, 0) }}</h3>
                        <p class="analytics-card-label text-muted mb-0 small">متوسط قيمة الصفقة</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                    <div class="analytics-card-icon month rounded d-flex align-items-center justify-content-center ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                            <path d="M16 3v4" />
                            <path d="M8 3v4" />
                            <path d="M4 11h16" />
                        </svg>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="analytics-card-number mb-1">{{ number_format($currentMonthRevenue) }}</h3>
                        <p class="analytics-card-label text-muted mb-0 small">إيرادات الشهر الحالي</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="analytics-card d-flex align-items-center p-3 bg-white border rounded">
                    <div class="analytics-card-icon time rounded d-flex align-items-center justify-content-center ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 7v5l3 3" />
                        </svg>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="analytics-card-number mb-1">{{ round($avgTimeToClose->avg_days ?? 0) }}</h3>
                        <p class="analytics-card-label text-muted mb-0 small">متوسط أيام الإغلاق</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Charts Row 1 -->
    <div class="row mt-2">

        <!-- Deals Trend -->
        <div class="col-lg-8 mb-3">
            <div class="bg-white border rounded p-3">
                <h6 class="font-weight-600 mb-3">اتجاه الصفقات والإيرادات (آخر 12 شهر)</h6>
                <div id="dealsTrendChart"></div>
            </div>
        </div>

        <!-- Deals by Purpose -->
        <div class="col-lg-4 mb-3">
            <div class="bg-white border rounded p-3">
                <h6 class="font-weight-600 mb-3">الصفقات حسب الغرض</h6>
                <div id="dealsByPurposeChart"></div>
            </div>
        </div>

    </div>

    <!-- Charts Row 2 -->
    <div class="row">

        <!-- Deals by Property Type -->
        <div class="col-lg-6 mb-3">
            <div class="bg-white border rounded p-3">
                <h6 class="font-weight-600 mb-3">الصفقات حسب نوع العقار</h6>
                <div id="dealsByPropertyTypeChart"></div>
            </div>
        </div>

        <!-- Deals by Price Range -->
        <div class="col-lg-6 mb-3">
            <div class="bg-white border rounded p-3">
                <h6 class="font-weight-600 mb-3">توزيع الصفقات حسب السعر</h6>
                <div id="dealsByPriceRangeChart"></div>
            </div>
        </div>

    </div>

    <!-- Charts Row 3 -->
    <div class="row">

        <!-- Deals by Sources -->
        <div class="col-lg-6 mb-3">
            <div class="bg-white border rounded p-3">
                <h6 class="font-weight-600 mb-3">مصادر الصفقات</h6>
                <div id="dealsBySourcesChart"></div>
            </div>
        </div>

        <!-- Rating Distribution -->
        <div class="col-lg-6 mb-3">
            <div class="bg-white border rounded p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="font-weight-600 mb-0">توزيع التقييمات</h6>
                    <span class="badge badge-primary">متوسط: {{ round($averageRating, 1) }} ⭐</span>
                </div>
                <div id="ratingDistributionChart"></div>
            </div>
        </div>

    </div>

    <!-- Tables Row -->
    <div class="row">

        <!-- Top Performers -->
        <div class="col-lg-6 mb-3">
            <div class="bg-white border rounded p-3">
                <h6 class="font-weight-600 mb-3">أفضل الموظفين أداءً</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>الموظف</th>
                                <th class="text-center">الصفقات</th>
                                <th class="text-center">الناجحة</th>
                                <th>الإيرادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topPerformers as $performer)
                                <tr>
                                    <td class="font-weight-500">{{ $performer->assignedUser->name ?? 'غير محدد' }}</td>
                                    <td class="text-center">{{ $performer->deals_count }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-success">{{ $performer->won_count }}</span>
                                    </td>
                                    <td>{{ number_format($performer->total_revenue) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">لا توجد بيانات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Clients -->
        <div class="col-lg-6 mb-3">
            <div class="bg-white border rounded p-3">
                <h6 class="font-weight-600 mb-3">أفضل العملاء</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>العميل</th>
                                <th class="text-center">عدد الصفقات</th>
                                <th>إجمالي الإنفاق</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topClients as $client)
                                <tr>
                                    <td class="font-weight-500">{{ $client->client->name ?? 'غير محدد' }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-primary">{{ $client->deals_count }}</span>
                                    </td>
                                    <td>{{ number_format($client->total_spent) }}</td>
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




@endsection
@section('js')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ============================================
            // 1. Deals Trend (Mixed Chart)
            // ============================================
            var dealsTrendOptions = {
                series: [{
                    name: 'إجمالي الصفقات',
                    type: 'column',
                    data: [
                        @foreach ($dealsLast12Months as $item)
                            {{ $item->total_deals }},
                        @endforeach
                    ]
                }, {
                    name: 'الصفقات الناجحة',
                    type: 'line',
                    data: [
                        @foreach ($dealsLast12Months as $item)
                            {{ $item->won_deals }},
                        @endforeach
                    ]
                }, {
                    name: 'الإيرادات (بالآلاف)',
                    type: 'line',
                    data: [
                        @foreach ($dealsLast12Months as $item)
                            {{ round($item->revenue / 1000, 2) }},
                        @endforeach
                    ]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    fontFamily: 'inherit',
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    width: [0, 3, 3],
                    curve: 'smooth'
                },
                colors: ['#3b82f6', '#10b981', '#f59e0b'],
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '50%'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: [
                        @foreach ($dealsLast12Months as $item)
                            '{{ \Carbon\Carbon::parse($item->month)->locale('ar')->format('M Y') }}',
                        @endforeach
                    ]
                },
                yaxis: [{
                    title: {
                        text: 'عدد الصفقات'
                    }
                }, {
                    opposite: true,
                    title: {
                        text: 'الإيرادات (ألف)'
                    }
                }],
                legend: {
                    position: 'top',
                    horizontalAlign: 'center'
                },
                grid: {
                    borderColor: '#f1f1f1'
                }
            };

            var dealsTrendChart = new ApexCharts(
                document.querySelector("#dealsTrendChart"),
                dealsTrendOptions
            );
            dealsTrendChart.render();

            // ============================================
            // 2. Deals by Purpose (Donut)
            // ============================================
            var dealsByPurposeOptions = {
                series: [
                    @foreach ($dealsByPurpose as $item)
                        {{ $item->count }},
                    @endforeach
                ],
                chart: {
                    type: 'donut',
                    height: 300,
                    fontFamily: 'inherit'
                },
                labels: [
                    @foreach ($dealsByPurpose as $item)
                        '{{ $item->purpose == 'rent' ? 'إيجار' : 'شراء' }}',
                    @endforeach
                ],
                colors: ['#3b82f6', '#8b5cf6'],
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
                                    label: 'الإجمالي',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                }
            };

            var dealsByPurposeChart = new ApexCharts(
                document.querySelector("#dealsByPurposeChart"),
                dealsByPurposeOptions
            );
            dealsByPurposeChart.render();

            // ============================================
            // 3. Deals by Property Type (Bar)
            // ============================================
            var dealsByPropertyTypeOptions = {
                series: [{
                    name: 'عدد الصفقات',
                    data: [
                        @foreach ($dealsByPropertyType as $item)
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
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899'],
                dataLabels: {
                    enabled: true
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: [
                        @foreach ($dealsByPropertyType as $item)
                            '{{ $item->propertyType->name ?? 'غير محدد' }}',
                        @endforeach
                    ]
                }
            };

            var dealsByPropertyTypeChart = new ApexCharts(
                document.querySelector("#dealsByPropertyTypeChart"),
                dealsByPropertyTypeOptions
            );
            dealsByPropertyTypeChart.render();

            // ============================================
            // 4. Deals by Price Range (Column)
            // ============================================
            var dealsByPriceRangeOptions = {
                series: [{
                    name: 'عدد الصفقات',
                    data: [
                        @foreach ($dealsByPriceRange as $item)
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
                        borderRadius: 8,
                        columnWidth: '60%',
                        distributed: true
                    }
                },
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899'],
                dataLabels: {
                    enabled: true
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: [
                        @foreach ($dealsByPriceRange as $item)
                            '{{ $item->price_range }}',
                        @endforeach
                    ],
                    labels: {
                        rotate: -45,
                        style: {
                            fontSize: '11px'
                        }
                    }
                }
            };

            var dealsByPriceRangeChart = new ApexCharts(
                document.querySelector("#dealsByPriceRangeChart"),
                dealsByPriceRangeOptions
            );
            dealsByPriceRangeChart.render();

            // ============================================
            // 5. Deals by Sources (Pie)
            // ============================================
            var dealsBySourcesOptions = {
                series: [
                    @foreach ($dealsBySources as $item)
                        {{ $item->count }},
                    @endforeach
                ],
                chart: {
                    type: 'pie',
                    height: 350,
                    fontFamily: 'inherit'
                },
                labels: [
                    @foreach ($dealsBySources as $item)
                        '{{ $item->source->name ?? 'غير محدد' }}',
                    @endforeach
                ],
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'],
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val, opts) {
                        return opts.w.config.series[opts.seriesIndex];
                    }
                }
            };

            var dealsBySourcesChart = new ApexCharts(
                document.querySelector("#dealsBySourcesChart"),
                dealsBySourcesOptions
            );
            dealsBySourcesChart.render();

            // ============================================
            // 6. Rating Distribution (Bar)
            // ============================================
            var ratingDistributionOptions = {
                series: [{
                    name: 'عدد الصفقات',
                    data: [
                        @foreach ($ratingDistribution as $item)
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
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#dc2626'],
                dataLabels: {
                    enabled: true
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: [
                        @foreach ($ratingDistribution as $item)
                            '{{ $item->rating }} نجوم',
                        @endforeach
                    ]
                }
            };

            var ratingDistributionChart = new ApexCharts(
                document.querySelector("#ratingDistributionChart"),
                ratingDistributionOptions
            );
            ratingDistributionChart.render();
        });
    </script>
@endsection
