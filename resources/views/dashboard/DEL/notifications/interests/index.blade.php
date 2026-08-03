@extends('dashboard.layouts.master')
@section('title', 'مركز الإشعارات')
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'مركز الإشعارات',
        ],
        [
            'name' => 'عملائي',
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
            <table id="table-data" class="table table-modern table-modern-sm table-inverse">
                <thead class="thead-inverse">
                    <tr>
                        <th class="noExl">التحكم</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الهاتف</th>
                        <th>نوع الإهتمام</th>
                        <th>تاريخ الإضافة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $row)
                        <tr class="{{ $row->action_completed ? 'table-light' : 'table-warning' }} parents">

                            <td class="noExl">
                                <button data-id="{{ $row->id }}" type="button"
                                    class="btn-show-details btn btn-sm btn-second" title="عرض التفاصيل" data-toggle="modal"
                                    data-target="#show-interest-details">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <a class="btn btn-sm btn-main tip" title="تعديل واضافة تفاصيل"
                                    href="{{ route('notifications.interests.edit', $row->id) }}">
                                    <i class=" fa fa-edit"></i>
                                </a>
                            </td>

                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email ?? '-' }}</td>
                            <td>{{ $row->phone ?? '-' }}</td>
                            <td>{{ $row->interest_type ?? '-' }}</td>
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
                $("#table-data").table2excel({
                    name: "Interest Data",
                    exclude: ".noExl",
                    filename: "interests.xls", // اسم الملف
                    preserveColors: true // يحافظ على الألوان لو ممكن
                });
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
