@extends('dashboard.layouts.master')
@section('title', $linksMap['create']['title'])
<x-dashboard.css :links="[
    [
        'link' => 'clients/edit.css',
    ],
]" />
@section('content')


    <x-dashboard.links-bar :links="[
        [
            'name' => $linksMap['index']['title'],
            'link' => $linksMap['index']['url'],
        ],
        [
            'name' => $linksMap['create']['title'],
        ],
    ]" /><!-- links bar -->




    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-12">
            @include('dashboard.crm.clients.tabs.main', [
                'route' => route('crm.clients.store'),
                'currentTabName' => 'بيانات العميل',
                'noRedirect' => true,
            ])
        </div>
    </div>



@endsection
@section('js')
@endsection
