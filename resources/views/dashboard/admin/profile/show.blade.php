@extends('dashboard.layouts.master')
@section('title', dbTrans('admin.Profile page title'))

<x-dashboard.css link='admin/profile/show' />

@section('body')

    <header style="background-image: url({{ $coverPath }})">
        <div class="overlay overlay-black"></div>

        <section id="avatar">
            <img class=" d-inline-block mb-3" src="{{ $avatarPath }}" alt="">
            <h5 class="d-inline-block mx-3 mb-0 first-info">
                <span class="name d-block text-white">{{ $row->f_name . ' ' . $row->l_name }}</span>
                <span class="job font-12">{{ $row->job }}</span>
            </h5>
        </section>

        <section id="banner" class="">

            <div class="float-left font-13 bg-soft-light text-white py-2 px-3 radius">{{ dbTrans('admin.Overview') }}</div>

            <div class=" float-right">
                @if ($isMyProfile == true)
                    <a href="{{ adminUrl('profile/edit') }}" class="btn btn-success font-13">
                        <i class="fa-regular fa-pen-to-square mx-1"></i>
                        {{ dbTrans('admin.Edit Profile') }}
                    </a>
                @elseif(canRole(owner()))
                    <a href="{{ adminUrl('admins/edit/' . $row->id) }}" class="btn btn-success font-13">
                        <i class="fa-regular fa-pen-to-square mx-1"></i>
                        {{ dbTrans('admin.Edit Profile') }}
                    </a>
                @endif <!-- edit link -->
            </div>

        </section><!-- section banner -->
    </header><!-- header -->


    <main id="profile">
        <div class="container-fluid">
            <div class="row">

                <div class=" col-xl-4 col-lg-6 col-md-6 col-sm-12">

                    <div id="info">
                        <x-panel-with-heading title="{{ dbTrans('admin.Info') }}" class="shadow-none">
                            <table class="table">
                                <tbody>

                                    <tr>
                                        <th>الاسم :</th>
                                        <td class="text-muted">{{ $row->f_name . ' ' . $row->l_name }}</td>
                                    </tr><!-- name -->

                                    <tr>
                                        <th>{{ dbTrans('admin.Mobile') }} :</th>
                                        <td class="text-muted ltr">
                                            @if ($row->phone == null)
                                                -
                                            @else
                                                {{ $row->phone }}
                                            @endif
                                        </td>
                                    </tr><!-- name -->

                                    @if ($row->type == 'sales')
                                        <tr>
                                            <th>رخصة التسويق :</th>
                                            <td class="text-muted">{{ $row->marketing_license }}</td>
                                        </tr><!-- marketing_license -->

                                        <tr>
                                            <th>متاح للعمل :</th>
                                            <td>
                                                @if ($row->is_available)
                                                    <span class="badge badge-soft-success badge-md">متاح للعمل</span>
                                                @else
                                                    <span class="badge badge-soft-secondary badge-md">غير متاح حالياً</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif


                                    <tr>
                                        <th>حالة الحساب :</th>
                                        <td>
                                            @if ($row->status == 0)
                                                <small class="badge badge-soft-danger badge-md font-11 status-badge">
                                                    الحساب محظور
                                                </small>
                                            @else
                                                <small class="badge badge-soft-success badge-md font-11 status-badge">
                                                    الحساب نشط
                                                </small>
                                            @endif
                                        </td>
                                    </tr><!--  -->



                                    <tr>
                                        <th>{{ dbTrans('admin.E-mail') }} :</th>
                                        <td class="text-muted">{{ $row->email }}</td>
                                    </tr><!-- email -->

                                    <tr>
                                        <th>{{ dbTrans('admin.Joining Date') }} :</th>
                                        <td class="text-muted">{{ $row->joining_date }}</td>
                                    </tr><!-- join data -->

                                </tbody><!-- tbody -->
                            </table><!-- table -->
                        </x-panel-with-heading>
                    </div><!-- info -->

                    {{-- 
                    @if ($portfolio != null)
                        <div id="portfolio">
                            <x-panel-with-heading title="{{ dbTrans('admin.Portfolio') }}" class="social-media">
                                @foreach (socialMedia() as $val)
                                    @if ($portfolio[$val['name_en']] != null)
                                        <a href="{{ $portfolio[$val['name_en']] }}"
                                            title="{{ Str::headline($val['name_en']) }}"
                                            style="background-color: {{ $val['color'] }}"
                                            class="text-white d-inline-block tip"
                                            target="__blank">{!! $val['icon'] !!}</a>
                                    @endif
                                @endforeach
                            </x-panel-with-heading>
                        </div><!-- portfolio -->
                    @endif --}}



                </div><!-- Grid 1 -->

                <div class="col-xl-8 col-lg-6 col-md-6 col-sm-12">

                    <div id="about">
                        <x-panel-with-heading title="{{ dbTrans('admin.About') }}" class="shadow-none">
                            <p class="mb-0 text-second font-14">
                                @if ($row->about == null)
                                    {{ dbTrans('admin.Not available') }}
                                @else
                                    {{ $row->about }}
                                @endif
                            </p>
                        </x-panel-with-heading>
                    </div><!-- about -->


                    @if ($row->is_marketer_request)
                        <div class="box">

                            <div class="alert alert-warning d-flex align-items-center mb-3">

                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="{{ lang() == 'ar' ? 'ml-2' : 'mr-2' }} text-warning">

                                    <path d="M12 9v4"></path>
                                    <path d="M12 17h.01"></path>
                                    <path
                                        d="M10.29 3.86l-7.3 12.63A2 2 0 0 0 4.7 20h14.6a2 2 0 0 0 1.73-3.01L13.73 3.86a2 2 0 0 0-3.46 0z">
                                    </path>

                                </svg>

                                <div>

                                    <strong>تنبيه</strong>

                                    <p class="mb-0">
                                        هذا الحساب مسوق جديد قام بالتسجيل في المنصة.
                                        يرجى مراجعة بياناته ثم قبول طلبه للعمل على المنصة أو رفض الطلب.
                                    </p>

                                </div>

                            </div>

                            <div class="d-flex mt-3">

                                <form class="ajax-post ml-2" action="{{ route('marketer.approve') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $row->id }}">

                                    <button type="submit" class="btn btn-success btn-sm">
                                        قبول المسوق
                                    </button>
                                </form>

                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectMarketerModal"
                                    data-id="{{ $row->id }}">
                                    رفض
                                </button>

                            </div>
                        </div>
                    @endif

                </div><!-- Grid 2 -->

            </div>
        </div>
    </main>



    <div class="modal fade" id="rejectMarketerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        رفض طلب المسوق
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>


                <form class="form" action="{{ route('marketer.reject') }}" method="POST">

                    @csrf

                    <input type="hidden" name="id" id="rejectMarketerId" value="{{$row->id}}">


                    <div class="modal-body">

                        <div class="alert alert-warning mb-3">
                            سيتم إرسال رسالة إلى المسوق تفيد برفض الطلب.
                        </div>


                        <div class="form-group">

                            <label>
                                سبب الرفض (اختياري)
                            </label>

                            <textarea name="message" rows="4" class="form-control" placeholder="يمكنك كتابة سبب الرفض هنا"></textarea>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            إلغاء
                        </button>

                        <button type="submit" class="btn btn-danger">
                            تأكيد الرفض
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
