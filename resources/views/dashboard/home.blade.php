@extends('dashboard.layouts.master')
@section('title', 'لوحة التحكم')
<x-dashboard.css :links="[
    [
        'link' => 'home/home.css',
    ],
]" />
@section('content')

    <main id="home-dashboard">

        {{-- Header Section --}}
        <div class="row mb-4 mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h2 class="mb-2 font-weight-bold fs-clamp-16-26">مرحباً،
                            {{ auth()->guard('admin')->user()->full_name }}</h2>
                        <p class="text-muted mb-0">إليك نظرة عامة على أداء نظام CRM الخاص بك</p>
                    </div>
                    <div class="">
                        <div class="mb-0 mt-1 mt-md-0 font-weight-bold fs-clamp-16-20">
                            {{ now()->translatedFormat('l، d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="card  mb-4">
            <div style="padding-bottom: 30px" class="card-body">
                <h5 class="card-title mb-3 d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bolt ml-2" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <polyline points="13 3 13 10 19 10 11 21 11 14 5 14 13 3"></polyline>
                    </svg>
                    إجراءات سريعة
                </h5>
                <div class="form-row">
                    <div class="col-6 col-md-4 col-lg-3 col-xl mb-3 mb-xl-0">
                        <a href="{{ route('crm.clients.index') }}"
                            class="btn btn-block btn-outline-primary quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users mb-2"
                                width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                            </svg>
                            <div class="small font-weight-bold">العملاء</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 col-xl mb-3 mb-xl-0">
                        <a href="{{ route('crm.deals.index') }}" class="btn btn-block btn-outline-success quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-handshake mb-2"
                                width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 18a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z"></path>
                                <path d="M9.172 15.172l-4.172 4.172"></path>
                                <path d="M14.828 15.172l4.172 4.172"></path>
                                <path d="M12 12v-8"></path>
                            </svg>
                            <div class="small font-weight-bold">الصفقات</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 col-xl mb-3 mb-xl-0">
                        <a href="{{ route('properties.index') }}" class="btn btn-block btn-outline-purple quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building mb-2"
                                width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="3" y1="21" x2="21" y2="21"></line>
                                <line x1="9" y1="8" x2="10" y2="8"></line>
                                <line x1="9" y1="12" x2="10" y2="12"></line>
                                <line x1="9" y1="16" x2="10" y2="16"></line>
                                <line x1="14" y1="8" x2="15" y2="8"></line>
                                <line x1="14" y1="12" x2="15" y2="12"></line>
                                <line x1="14" y1="16" x2="15" y2="16"></line>
                                <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"></path>
                            </svg>
                            <div class="small font-weight-bold">العقارات</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 col-xl mb-3 mb-xl-0">
                        <a href="{{ route('crm.interests.index') }}"
                            class="btn btn-block btn-outline-warning quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star mb-2"
                                width="32" height="32" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z">
                                </path>
                            </svg>
                            <div class="small font-weight-bold">الاهتمامات</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 col-xl mb-3 mb-xl-0">
                        <a href="{{ route('owner-associations.index') }}"
                            class="btn btn-block btn-outline-info quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-buildings mb-2"
                                width="32" height="32" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="4" y1="21" x2="4" y2="12"></line>
                                <line x1="20" y1="21" x2="20" y2="12"></line>
                                <line x1="6" y1="21" x2="18" y2="21"></line>
                                <path d="M4 12h16l-4 -8h-8z"></path>
                            </svg>
                            <div class="small font-weight-bold">اتحادات الملاك</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 col-xl mb-3 mb-xl-0">
                        <a href="{{ route('rental.contracts.index') }}"
                            class="btn btn-block btn-outline-teal quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text mb-2"
                                width="32" height="32" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                <line x1="9" y1="9" x2="10" y2="9"></line>
                                <line x1="9" y1="13" x2="15" y2="13"></line>
                                <line x1="9" y1="17" x2="15" y2="17"></line>
                            </svg>
                            <div class="small font-weight-bold">عقود الإيجار</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 col-xl mb-3 mb-xl-0">
                        <a href="{{ route('crm.deals.follow-ups.index') }}"
                            class="btn btn-block btn-outline-danger quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-calendar-check mb-2" width="32" height="32"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                                <line x1="16" y1="3" x2="16" y2="7"></line>
                                <line x1="8" y1="3" x2="8" y2="7"></line>
                                <line x1="4" y1="11" x2="20" y2="11"></line>
                                <path d="M9 16l2 2l4 -4"></path>
                            </svg>
                            <div class="small font-weight-bold">المتابعات</div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 col-xl mb-3 mb-xl-0">
                        <a href="{{ route('owner-associations.requests.all-requests') }}"
                            class="btn btn-block btn-outline-pink quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-inbox mb-2"
                                width="32" height="32" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                                <path d="M4 13h3l3 3h4l3 -3h3"></path>
                            </svg>
                            <div class="small font-weight-bold">الطلبات</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section id="statistics-section">
            <div class="row mb-3">

                {{-- Clients Stats --}}
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
                    <a href="{{ route('crm.clients.index') }}" class="text-decoration-none">
                        <div class="card stat-card stat-card-primary h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="stat-icon bg-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                        </svg>
                                    </div>
                                    <span class="badge badge-success">+{{ $stats['clients']['new_this_month'] }} هذا
                                        الشهر</span>
                                </div>
                                <h6 class="text-muted mb-2">إجمالي العملاء</h6>
                                <h2 class="mb-3 font-weight-bold" data-stat="clients-total">
                                    {{ number_format($stats['clients']['total']) }}</h2>
                                <div class="d-flex justify-content-between text-muted small border-top pt-2">
                                    <span>نشط: <strong>{{ $stats['clients']['active'] }}</strong></span>
                                    <span>لديهم صفقات: <strong>{{ $stats['clients']['with_deals'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                {{-- Deals Stats --}}
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
                    <a href="{{ route('crm.deals.index') }}" class="text-decoration-none">
                        <div class="card stat-card stat-card-success  h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="stat-icon bg-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-checklist">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8">
                                            </path>
                                            <path d="M14 19l2 2l4 -4"></path>
                                            <path d="M9 8h4"></path>
                                            <path d="M9 12h2"></path>
                                        </svg>
                                    </div>
                                    <span class="badge badge-success">{{ $stats['deals']['won'] }} مكتملة</span>
                                </div>
                                <h6 class="text-muted mb-2">إجمالي الصفقات</h6>
                                <h2 class="mb-3 font-weight-bold">{{ number_format($stats['deals']['total']) }}</h2>
                                <div class="d-flex justify-content-between text-muted small border-top pt-2">
                                    <span>قيد التنفيذ: <strong>{{ $stats['deals']['in_progress'] }}</strong></span>
                                    <span>مفقودة: <strong>{{ $stats['deals']['lost'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                {{-- Properties Stats --}}
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
                    <a href="{{ route('properties.index') }}" class="text-decoration-none">
                        <div class="card stat-card stat-card-purple  h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="stat-icon bg-purple">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-buildings">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15" />
                                            <path d="M16 8h2c1 0 2 1 2 2v11" />
                                            <path d="M3 21h18" />
                                            <path d="M10 12v.01" />
                                            <path d="M10 16v.01" />
                                            <path d="M10 8v.01" />
                                            <path d="M7 12v.01" />
                                            <path d="M7 16v.01" />
                                            <path d="M7 8v.01" />
                                            <path d="M17 12v.01" />
                                            <path d="M17 16v.01" />
                                        </svg>
                                    </div>
                                    <span class="badge badge-success">{{ $stats['properties']['available'] }} متاحة</span>
                                </div>
                                <h6 class="text-muted mb-2">إجمالي العقارات</h6>
                                <h2 class="mb-3 font-weight-bold">{{ number_format($stats['properties']['total']) }}</h2>
                                <div class="d-flex justify-content-between text-muted small border-top pt-2">
                                    <span>للبيع: <strong>{{ $stats['properties']['for_sale'] }}</strong></span>
                                    <span>للإيجار: <strong>{{ $stats['properties']['for_rent'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                {{-- Revenue Stats --}}
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
                    <a href="{{ route('crm.deals.analytics') }}" class="text-decoration-none">
                        <div class="card stat-card stat-card-warning  h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="stat-icon bg-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2">
                                            </path>
                                            <path d="M12 3v3m0 12v3"></path>
                                        </svg>
                                    </div>
                                    <span class="badge badge-info">قيمة الصفقات</span>
                                </div>
                                <h6 class="text-muted mb-2">إجمالي الإيرادات</h6>
                                <h2 class="mb-3 font-weight-bold">{{ number_format($stats['deals']['total_value']) }}
                                    <small>ج.م</small>
                                </h2>
                                <div class="text-muted small border-top pt-2">
                                    <span>صفقات مكتملة: <strong>{{ number_format($stats['deals']['won_value']) }}
                                            ج.م</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                {{-- Interests Stats --}}
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
                    <a href="{{ route('crm.interests.index') }}" class="text-decoration-none">
                        <div class="card stat-card stat-card-info  h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="stat-icon bg-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="badge badge-warning">{{ $stats['interests']['new'] }} جديدة</span>
                                </div>
                                <h6 class="text-muted mb-2">الاهتمامات</h6>
                                <h2 class="mb-3 font-weight-bold">{{ number_format($stats['interests']['total']) }}</h2>
                                <div class="d-flex justify-content-between text-muted small border-top pt-2">
                                    <span>مخصصة: <strong>{{ $stats['interests']['assigned'] }}</strong></span>
                                    <span>محولة: <strong>{{ $stats['interests']['converted'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                {{-- Follow-ups Stats --}}
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
                    <a href="{{ route('crm.deals.follow-ups.index') }}" class="text-decoration-none">
                        <div class="card stat-card stat-card-danger  h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="stat-icon bg-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                                            <line x1="16" y1="3" x2="16" y2="7"></line>
                                            <line x1="8" y1="3" x2="8" y2="7"></line>
                                            <line x1="4" y1="11" x2="20" y2="11"></line>
                                            <path d="M9 16l2 2l4 -4"></path>
                                        </svg>
                                    </div>
                                    <span class="badge badge-danger">{{ $stats['follow_ups']['overdue'] }} متأخرة</span>
                                </div>
                                <h6 class="text-muted mb-2">المتابعات المعلقة</h6>
                                <h2 class="mb-3 font-weight-bold">{{ number_format($stats['follow_ups']['pending']) }}
                                </h2>
                                <div class="d-flex justify-content-between text-muted small border-top pt-2">
                                    <span>اليوم: <strong>{{ $stats['follow_ups']['today'] }}</strong></span>
                                    <span>هذا الأسبوع: <strong>{{ $stats['follow_ups']['this_week'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                {{-- Owner Associations Stats --}}
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
                    <a href="{{ route('owner-associations.index') }}" class="text-decoration-none">
                        <div class="card stat-card stat-card-indigo  h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="stat-icon bg-indigo">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="4" y1="21" x2="4" y2="12"></line>
                                            <line x1="20" y1="21" x2="20" y2="12"></line>
                                            <line x1="6" y1="21" x2="18" y2="21"></line>
                                            <path d="M4 12h16l-4 -8h-8z"></path>
                                        </svg>
                                    </div>
                                    <span class="badge badge-purple">{{ $stats['owner_associations']['total_units'] }}
                                        وحدة</span>
                                </div>
                                <h6 class="text-muted mb-2">اتحادات الملاك</h6>
                                <h2 class="mb-3 font-weight-bold">
                                    {{ number_format($stats['owner_associations']['total']) }}
                                </h2>
                                <div class="text-muted small border-top pt-2">
                                    <span>طلبات معلقة:
                                        <strong>{{ $stats['owner_associations']['requests_pending'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


                {{-- Rental Contracts Stats --}}
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-3">
                    <a href="{{ route('rental.contracts.index') }}" class="text-decoration-none">
                        <div class="card stat-card stat-card-teal  h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="stat-icon bg-teal">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="badge badge-warning">{{ $stats['rental_contracts']['expiring_soon'] }}
                                        تنتهي
                                        قريباً</span>
                                </div>
                                <h6 class="text-muted mb-2">عقود الإيجار</h6>
                                <h2 class="mb-3 font-weight-bold">{{ number_format($stats['rental_contracts']['total']) }}
                                </h2>
                                <div class="text-muted small border-top pt-2">
                                    <span>نشطة: <strong>{{ $stats['rental_contracts']['active'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>


            </div>
        </section>

        {{-- Activity Columns --}}
        <div class="row">

            {{-- Latest Owner Association Requests --}}
            <div class="col-12 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fs-clamp-16-20 d-flex align-items-center font-weight-bold">
                                أحدث طلبات اتحادات الملاك
                            </h5>
                            <a href="{{ route('owner-associations.requests.all-requests') }}"
                                class="font-13 font-weight-500">
                                عرض الكل
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($latestOARequests as $request)
                                <a href="{{ route('owner-associations.requests.show', [$request->ownerAssociation->uuid, $request]) }}"
                                    class="text-decoration-none">
                                    <div class="list-group-item border-0 hover-bg-light transition-all py-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="flex-grow-1 ml-2">
                                                <h6 class="mb-1 font-weight-bold text-dark">
                                                    {{ $request->title }}
                                                </h6>
                                                <p class="text-muted mb-0 small d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ml-1"
                                                        width="14" height="14" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M3 21l18 0" />
                                                        <path d="M9 8l1 0" />
                                                        <path d="M9 12l1 0" />
                                                        <path d="M9 16l1 0" />
                                                        <path d="M14 8l1 0" />
                                                        <path d="M14 12l1 0" />
                                                        <path d="M14 16l1 0" />
                                                        <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" />
                                                    </svg>
                                                    {{ $request->ownerAssociation->name }}
                                                </p>
                                            </div>
                                            <span class="badge badge-pill {{ $request->status->color() }} px-3 py-2">
                                                {{ $request->status->label() }}
                                            </span>
                                        </div>

                                        <div
                                            class="d-flex justify-content-between align-items-center text-muted small mt-3 pt-2 border-top">
                                            <span class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon ml-1" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <circle cx="12" cy="7" r="4" />
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                </svg>
                                                {{ $request->client->name }}
                                            </span>
                                            <span class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon ml-1" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <circle cx="12" cy="12" r="9" />
                                                    <polyline points="12 7 12 12 15 15" />
                                                </svg>
                                                {{ $request->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler mb-3 text-secondary"
                                        width="64" height="64" viewBox="0 0 24 24" stroke-width="1"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="4" y="4" width="16" height="16" rx="2" />
                                        <path d="M4 13h3l3 3h4l3 -3h3" />
                                    </svg>
                                    <p class="mb-0 font-weight-medium">لا توجد طلبات حتى الآن</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Latest Interests --}}
            <div class="col-12 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fs-clamp-16-20 d-flex align-items-center font-weight-bold">
                                أحدث اهتمامات العملاء
                            </h5>
                            <a href="{{ route('crm.interests.index') }}" class="font-13 font-weight-500">
                                عرض الكل
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($latestInterests as $interest)
                                <a href="{{ route('crm.interests.index') }}" class="text-decoration-none">
                                    <div class="list-group-item border-0 hover-bg-light transition-all py-3">
                                        <div class="d-flex align-items-start">
                                            <div class="avatar-circle bg-light rounded-circle d-flex align-items-center justify-content-center ml-3"
                                                style="width: 40px; height: 40px; min-width: 40px; overflow: hidden;">
                                                @if ($interest->client->avatar)
                                                    <img src="{{ asset($interest->client->avatar) }}"
                                                        alt="{{ $interest->client->name }}" class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary"
                                                        width="20" height="20" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="7" r="4" />
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 font-weight-bold text-dark">{{ $interest->client->name }}
                                                </h6>
                                                <p class="text-muted mb-2 small">{{ Str::limit($interest->message, 80) }}
                                                </p>
                                                <div
                                                    class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                                    <span
                                                        class="badge badge-pill {{ $interest->status->badgeClass() }} px-3 py-2">
                                                        {{ $interest->status->label() }}
                                                    </span>
                                                    <span class="text-muted small d-flex align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon ml-1"
                                                            width="16" height="16" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <circle cx="12" cy="12" r="9" />
                                                            <polyline points="12 7 12 12 15 15" />
                                                        </svg>
                                                        {{ $interest->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler mb-3 text-secondary"
                                        width="64" height="64" viewBox="0 0 24 24" stroke-width="1"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                    </svg>
                                    <p class="mb-0 font-weight-medium">لا توجد اهتمامات حتى الآن</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Latest Follow-ups --}}
            <div class="col-12 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 d-flex fs-clamp-16-20 align-items-center font-weight-bold">
                                المتابعات القادمة
                            </h5>
                            <a href="{{ route('crm.deals.follow-ups.index') }}" class="font-13 font-weight-500">
                                عرض الكل
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($latestFollowUps as $followUp)
                                <a href="{{ route('crm.deals.edit', $followUp->deal->uuid) }}?tab=follow-up"
                                    class="text-decoration-none">
                                    <div class="list-group-item border-0 hover-bg-light transition-all py-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="flex-grow-1 ml-2">
                                                <h6 class="mb-1 font-weight-bold text-dark">
                                                    {{ $followUp->follow_up_type }}
                                                </h6>
                                                <p class="text-muted mb-0 small d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ml-1"
                                                        width="14" height="14" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="7" r="4" />
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                    </svg>
                                                    {{ $followUp->deal->client->name }}
                                                </p>
                                            </div>
                                            <span
                                                class="badge badge-pill {{ $followUp->priority->badgeClass() }} px-3 py-2">
                                                {{ $followUp->priority->label() }}
                                            </span>
                                        </div>

                                        <div class="d-flex align-items-center text-muted small mt-3 pt-2 border-top">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon ml-1" width="16"
                                                height="16" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <circle cx="12" cy="12" r="9" />
                                                <polyline points="12 7 12 12 15 15" />
                                            </svg>
                                            {{ $followUp->scheduled_at->format('Y-m-d H:i') }}
                                            <span class="mr-2">({{ $followUp->scheduled_at->diffForHumans() }})</span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler mb-3 text-secondary"
                                        width="64" height="64" viewBox="0 0 24 24" stroke-width="1"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="4" y="5" width="16" height="16" rx="2" />
                                        <line x1="16" y1="3" x2="16" y2="7" />
                                        <line x1="8" y1="3" x2="8" y2="7" />
                                        <line x1="4" y1="11" x2="20" y2="11" />
                                    </svg>
                                    <p class="mb-0 font-weight-medium">لا توجد متابعات قادمة</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Latest Replies --}}
            <div class="col-12 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fs-clamp-16-20 d-flex align-items-center font-weight-bold">
                                أحدث الردود على الطلبات
                            </h5>
                            <a href="{{ route('owner-associations.requests.all-requests') }}"
                                class="font-13 font-weight-500">
                                عرض الكل
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($latestReplies as $reply)
                                <a href="{{ route('owner-associations.requests.show', [$reply->request->ownerAssociation, $reply->request]) }}"
                                    class="text-decoration-none">
                                    <div class="list-group-item border-0 hover-bg-light transition-all py-3">
                                        <div class="d-flex align-items-start mb-2">
                                            <div class="avatar-circle bg-light rounded-circle d-flex align-items-center justify-content-center ml-3"
                                                style="width: 40px; height: 40px; min-width: 40px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary"
                                                    width="20" height="20" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <circle cx="12" cy="7" r="4" />
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                </svg>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 font-weight-bold text-dark">{{ $reply->replier_name }}
                                                </h6>
                                                <p class="text-muted mb-0 small">رد على: {{ $reply->request->title }}</p>
                                            </div>
                                        </div>

                                        <p class="text-muted mb-2 small mr-5">{{ Str::limit($reply->message, 100) }}</p>

                                        <div class="d-flex align-items-center text-muted small mt-3 pt-2 border-top">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon ml-1" width="16"
                                                height="16" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <circle cx="12" cy="12" r="9" />
                                                <polyline points="12 7 12 12 15 15" />
                                            </svg>
                                            {{ $reply->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler mb-3 text-secondary"
                                        width="64" height="64" viewBox="0 0 24 24" stroke-width="1"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                                        <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                                    </svg>
                                    <p class="mb-0 font-weight-medium">لا توجد ردود حتى الآن</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- Charts Section --}}
        <div class="row mb-5">

            {{-- Deals by Status Chart --}}
            <div class="col-12 col-lg-6 mb-3">
                <div class="card  h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">توزيع الصفقات حسب الحالة</h5>
                        <div class="chart-container">
                            <canvas id="dealsStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Monthly Deals Trend --}}
            <div class="col-12 col-lg-6 mb-3">
                <div class="card  h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">اتجاه الصفقات الشهرية (آخر 6 أشهر)</h5>
                        <div class="chart-container">
                            <canvas id="monthlyDealsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main><!-- home-dashboard -->


@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Deals by Status Chart
            const dealsStatusCtx = document.getElementById('dealsStatusChart');
            if (dealsStatusCtx) {
                new Chart(dealsStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['مكتملة', 'مفقودة', 'قيد التنفيذ'],
                        datasets: [{
                            data: [
                                {{ $dealsByStatus['won'] ?? 0 }},
                                {{ $dealsByStatus['lost'] ?? 0 }},
                                {{ $dealsByStatus['in_progress'] ?? 0 }}
                            ],
                            backgroundColor: [
                                '#28a745',
                                '#dc3545',
                                '#007bff'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                rtl: true,
                                labels: {
                                    font: {
                                        family: 'Cairo, sans-serif'
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Monthly Deals Trend Chart
            const monthlyDealsCtx = document.getElementById('monthlyDealsChart');
            if (monthlyDealsCtx) {
                const monthlyData = @json($monthlyDeals);
                new Chart(monthlyDealsCtx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(monthlyData),
                        datasets: [{
                            label: 'عدد الصفقات',
                            data: Object.values(monthlyData),
                            borderColor: '#6f42c1',
                            backgroundColor: 'rgba(111, 66, 193, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    font: {
                                        family: 'Cairo, sans-serif'
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        family: 'Cairo, sans-serif'
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
