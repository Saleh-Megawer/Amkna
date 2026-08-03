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
                                        <th>{{ dbTrans('admin.Full Name') }} :</th>
                                        <td class="text-muted">{{ $row->f_name . ' ' . $row->l_name }}</td>
                                    </tr><!-- name -->

                                    <tr>
                                        <th>{{ dbTrans('admin.Mobile') }} :</th>
                                        <td class="text-muted">
                                            @if ($row->phone == null)
                                                -
                                            @else
                                                {{ $row->phone }}
                                            @endif
                                        </td>
                                    </tr><!-- name -->

                                    <tr>
                                        <th>{{ dbTrans('admin.E-mail') }} :</th>
                                        <td class="text-muted">{{ $row->email }}</td>
                                    </tr><!-- email -->

                                    <tr>
                                        <th>{{ dbTrans('admin.Location') }} :</th>
                                        <td class="text-muted">
                                            @if ($row->country == null && $row->city == null)
                                                -
                                            @else
                                                {{ $row->country . ', ' . $row->city }}
                                            @endif
                                        </td>
                                    </tr><!-- location -->

                                    <tr>
                                        <th>{{ dbTrans('admin.Joining Date') }} :</th>
                                        <td class="text-muted">{{ $row->joining_date }}</td>
                                    </tr><!-- join data -->

                                </tbody><!-- tbody -->
                            </table><!-- table -->
                        </x-panel-with-heading>
                    </div><!-- info -->


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
                    @endif



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



                </div><!-- Grid 2 -->

            </div>
        </div>
    </main>

@endsection
@section('js')
@endsection
