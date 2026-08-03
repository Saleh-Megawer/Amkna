@extends('dashboard.layouts.master')
@section('title', 'الأسئلة الشائعة')

<x-dashboard.css :links="[
    [
        'link' => 'services/services.css',
    ],
]" />


@section('content')


    <x-dashboard.links-bar :links="[
        [
            'name' => 'الأسئلة الشائعة',
        ],
    ]" :buttons="[
        [
            'name' => '<i class=\'fa-solid fa-plus\'></i> اضافة جديد',
            'class' => 'btn-success',
            'link' => adminUrl('faqs/create'),
        ],
    ]" /><!-- links bar -->


    <section id="services">
        <div class="row">

            <div class="col-12">
                <div class="box box-table table-responsive p-4">

                    <table width="100%" id="myTable"
                        class="table table-modern-sm table-modern table-inverse mb-0 border-0">
                        <thead class="thead-inverse">
                            <tr>
                                <th>التحكم</th>
                                <th>#</th>
                                <th>العنوان</th>
                                <th>توقيت الإضافة</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($rows as $row)
                                <tr class="parents">

                                    <td style="width: 50px">

                                        <a href="{{ adminUrl('faqs/edit/' . $row->id) }}"
                                            class=" btn btn-xs btn-soft-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>

                                        <form class="ajax-delete d-inline-block" action="{{ route('faqs-destroy') }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" class="id" name="id" value="{{ $row->id }}">
                                            <button type="submit"
                                                data-delete="{{ 'هل امت متأكد من حذف ' . $row->translate('ar')->title }}"
                                                class="btn btn-xs btn-soft-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </form>

                                    </td><!-- actions -->

                                    <td>{{ $loop->index + 1 }}</td>



                                    <td>{{ Str::limit($row->translate()->title, 75, '...') }}</td>

                                    <td>{{ parseTime($row->created_at) }}</td>


                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div><!-- box -->
            </div><!-- col Table Data -->

        </div><!-- row -->

    </section><!-- section -->

@endsection
