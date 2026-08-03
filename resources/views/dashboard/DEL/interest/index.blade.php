@extends('dashboard.layouts.master')
@section('title', 'رسائل الاهتمام')
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'رسائل الاهتمام',
        ],
    ]" :buttons="[
        [
            'name' => 'تصدير Excel',
            'class' => 'btn-main',
            'options' => [
                'id' => 'exportExcel',
            ],
        ],
    ]" /><!-- links bar -->

    <section id="">

        <div class="box table-responsive">
            <table class="table table-modern table-modern-sm table-inverse">
                <thead class="thead-inverse">
                    <tr>
                        @canany(['interest_delete'])
                            <th class="noExl">التحكم</th>
                        @endcanany
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الهاتف</th>
                        @can('interest_allow_set_marketer')
                            <th>نوع الإهتمام</th>
                        @endcan

                        <th class="noExl">تعيين مسوق</th>
                        <th>تاريخ الإضافة</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $row)
                        <tr class="{{ $row->is_read ? 'table-light' : 'table-warning' }} parents">

                            @canany(['interest_delete'])
                                <td class="noExl">

                                    <button data-id="{{ $row->id }}" type="button"
                                        class="btn-show-details btn btn-sm btn-second" title="عرض التفاصيل" data-toggle="modal"
                                        data-target="#show-interest-details">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    @can('interest_delete')
                                        <!-- زر الحذف -->
                                        <form class="ajax-delete d-inline-block" action="{{ route('interests.destroy') }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" class="id" name="id" value="{{ $row->id }}">
                                            <button type="submit" class="btn-sm btn btn-soft-danger"
                                                data-delete="هل انت متأكد من حذف : {{ $row->name }}">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endcan
                                    {{-- 
                                    @can('interest_read')
                                        @if (!$row->is_read)
                                            <form action="{{ route('interests.read', $row->id) }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i> تم القراءة
                                                </button>
                                            </form>
                                        @endif
                                    @endcan --}}

                                </td>
                            @endcanany

                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email ?? '-' }}</td>
                            <td>{{ $row->phone ?? '-' }}</td>
                            <td>{{ $row->interest_type ?? '-' }}</td>
                            @can('interest_allow_set_marketer')
                                <td class="noExl">
                                    <style>
                                        .h-30 select {
                                            height: 40px !important;
                                        }
                                    </style>
                                    <x-form-group class="mb-0 h-30" :properties="[
                                        'select' => [
                                            'name' => 'marketer_id',
                                            'list' => $marketers,
                                            'text' => 'full_name',
                                            'selected' => $row->marketer_id,
                                            'options' => [
                                                'data-interest' => $row->id,
                                                'class' => 'select-marketer',
                                                'placeholder' => '',
                                            ],
                                        ],
                                    ]" /><!-- city -->
                                </td>
                            @endcan

                            <td class="ltr">{{ $row->created_at->format('Y-m-d • H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center pt-4 text-muted">لا توجد بيانات بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div><!-- end box table -->


    </section><!-- section -->


    <!-- Modal -->
    <div class="modal fade" id="show-interest-details" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تفاصيل رسالة إهتمام</h5>
                    <button type="button" style="margin: 0px;padding:0px" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>الاسم</td>
                                <td class="modal-username font-weight-600"></td>
                            </tr>
                            <tr>
                                <td>رقم الهاتف</td>
                                <td class="modal-phone font-weight-600"></td>
                            </tr>
                            <tr>
                                <td>البريد الإلكتروني</td>
                                <td class="modal-email font-weight-600"></td>
                            </tr>
                            <tr>
                                <td>نوع الإهتمام</td>
                                <td class="modal-interest-type font-weight-600"></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="bg-light border p-3 radius mt-2">
                        <div class=" font-weight-600 ">ملاحظات & تفاصيل</div>
                        <div class="modal-notes"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')

    <script src="https://cdn.jsdelivr.net/npm/jquery-table2excel@1.1.1/dist/jquery.table2excel.min.js"></script>


    <script>
        $(document).ready(function() {

            $("#exportExcel").click(function() {
                $(".table").table2excel({
                    name: "Interest Data",
                    exclude: ".noExl",
                    filename: "interests.xls", // اسم الملف
                    preserveColors: true // يحافظ على الألوان لو ممكن
                });
            });

            $('.select-marketer').change(function(e) {

                let selectMarketer = $(this);
                $.post("{{ route('interests.add_marketer') }}", {
                        marketer_id: selectMarketer.val(),
                        interes_id: selectMarketer.attr('data-interest')
                    },
                    function(res, textStatus, jqXHR) {
                        if (res.status != undefined && res.status == 'success') {
                            toastr.success(res.message);
                            selectMarketer.parents('.parents').removeClass('table-warning');
                        }

                    },
                    "json"
                );
            });

            $('.btn-show-details').click(function(e) {
                $.post("{{ route('notifications.interests.get_row') }}", {
                        id: $(this).data('id')
                    },
                    function(row, textStatus, jqXHR) {
                        let modalBody = $('#show-interest-details .modal-body'),
                            email = row.email == null ? 'لا يوجد' : row.email,
                            interest_type = row.interest_type == null ? 'لم يحدد بعد' : row
                            .interest_type;

                        $('.modal-username').text(': ' + row.name);
                        $('.modal-phone').text(': ' + row.phone);
                        $('.modal-email').text(': ' + email);
                        $('.modal-interest-type').text(': ' + interest_type);
                        //
                        $('.modal-notes').html(row.notes);
                    },
                    "json"
                );

            });

        });
    </script>
@endsection
