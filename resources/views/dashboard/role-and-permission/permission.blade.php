@extends('dashboard.layouts.master')
@section('title', 'الصلاحيات')
@section('css')
    <style>
        .list-group-item.active {
            color: #000000;
            background-color: var(--second-color);
            border-color: var(--second-color);
        }
    </style>
@endsection
@section('content')

    <x-dashboard.links-bar :links="[
        [
            'name' => 'الأدوار',
            'link' => adminUrl('roles'),
        ],
        [
            'name' => Str::ucfirst($row->name),
        ],
        [
            'name' => 'تعيين صلاحيات',
        ],
    ]" />

    <section id="roles" class="mb-5">
        <form class=" form" action="{{ route('update-permissions') }}" method="POST" autocomplete="off">



            <!-- الصفوف: Tabs جانبي + المحتوى -->
            <div class="row">

                <!-- العمود الجانبي للـ Tabs -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            الأقسام
                        </div>
                        <div class="list-group list-group-flush" id="v-pills-tab" role="tablist">
                            @foreach ($data as $index => $section)
                                <a class="list-group-item list-group-item-action {{ $index === 0 ? 'active' : '' }}"
                                    data-toggle="list" href="#tab-{{ $index }}" role="tab">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>{{ $section['name'] }}</span>
                                        <span class="badge badge-light tab-badge" data-tab="{{ $index }}">0</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- عمود المحتوى -->
                <div class="col-lg-9 col-md-8">

                    <!-- شريط البحث والتحكم -->
                    <div class="card mb-3">
                        <div class="card-body pt-3">
                            <div class="form-row align-items-center">

                                <div class="col-md-8">
                                    <div class=" input-normal-style">
                                        <div class="form-group mb-0">
                                            <input style="height: 42px" type="search" name="" id="searchPermissions"
                                                class="form-control" placeholder="ابحث عن صلاحية...">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 text-right mt-2 mt-md-0 d-flex align-self-stretch">
                                    <button type="button" class="btn btn-sm btn-success" id="selectAll">تحديد الكل</button>
                                    <button type="button" class="btn btn-sm btn-warning mx-1" id="deselectAll">إلغاء
                                        الكل</button>
                                    <div class="d-flex align-items-center ml-2 p-2">
                                        المحدد: ( <strong id="selectedCount">0</strong> )
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                @foreach ($data as $index => $section)
                                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                        id="tab-{{ $index }}" role="tabpanel">

                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0 mt-2 font-weight-bold text-dark">{{ $section['name'] }}</h5>
                                            <button type="button" class="btn btn-sm btn-outline-primary select-tab"
                                                data-tab="{{ $index }}">
                                                تحديد الكل
                                            </button>
                                        </div>

                                        <hr>

                                        <div class="row permission-container" data-tab-group="{{ $index }}">
                                            @foreach ($section['permissions'] as $permission)
                                                <div class=" col-md-6 col-12 my-2 permission-item"
                                                    data-permission-name="{{ $permission->display_name }}">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                            class="custom-control-input sr-only permission-checkbox"
                                                            @checked(in_array($permission->id, $rolePermissions)) name="permission[]"
                                                            id="perm-{{ $permission->id }}" value="{{ $permission->id }}"
                                                            data-tab="{{ $index }}">
                                                        <label class="custom-control-label cursor-pointer font-weight-500 text-dark"
                                                            for="perm-{{ $permission->id }}">
                                                            {{ $permission->display_name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <input type="hidden" value="{{ Request::segment(3) }}" name="id">
            @csrf

            <div id="publish-buttons-bar">
                <button class="btn btn-main px-5" type="submit">حفظ</button>
            </div><!-- Buttons -->

        </form>
    </section>

@endsection
@section('js')
    <script>
        $(document).ready(function() {

            // تحديث العدادات
            function updateCounts() {
                let total = $('.permission-checkbox:checked').length;
                $('#selectedCount').text(total);

                $('.tab-badge').each(function() {
                    let tab = $(this).data('tab');
                    let count = $(`.permission-checkbox[data-tab="${tab}"]:checked`).length;
                    $(this).text(count);
                });
            }

            // البحث
            $('#searchPermissions').on('keyup', function() {
                let value = $(this).val().toLowerCase();
                let visibleCount = 0;

                $('.permission-item').each(function() {
                    let text = $(this).data('permission-name').toLowerCase();
                    let isVisible = text.includes(value);
                    $(this).toggle(isVisible);
                    if (isVisible) visibleCount++;
                });

                // إزالة رسالة قديمة
                $('.no-results-message').remove();

                // إضافة رسالة إذا لا توجد نتائج
                if (visibleCount === 0 && value !== '') {
                    $('.tab-pane.active .permission-container').append(`
                <div class="col-12 no-results-message">
                    <i class="fa fa-search"></i>
                    <p>لا توجد صلاحيات تطابق البحث "<strong>${value}</strong>"</p>
                </div>
            `);
                }
            });

            $('#selectAll').click(function() {
                $('.permission-checkbox').prop('checked', true);
                updateCounts();
            });

            $('#deselectAll').click(function() {
                $('.permission-checkbox').prop('checked', false);
                updateCounts();
            });

            $('.select-tab').click(function() {
                let tab = $(this).data('tab');
                let checkboxes = $(`.permission-checkbox[data-tab="${tab}"]`);
                let allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                checkboxes.prop('checked', !allChecked);
                updateCounts();
            });

            $('.permission-checkbox').change(updateCounts);
            updateCounts();
        });
    </script>
@endsection
