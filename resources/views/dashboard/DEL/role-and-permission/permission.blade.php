@extends('dashboard.layouts.master')
@section('title', 'الأدوار')
@section('content')


    <x-dashboard.links-bar :links="[
        [
            'name' => 'الأدوار',
            'link' => adminUrl('roles'),
        ],
        [
            'name' => Str::ucfirst($row->name),
        ],
    ]" /> <!-- links bar --->


    <section id="roles" class="mb-5">

        <form action="{{ route('update-permissions') }}" method="POST" autocomplete="off">

            <div class="accordion" id="permissionsAccordion">
                @foreach ($data as $index => $section)
                    <div class="card">
                        <div class="card-header p-0" id="heading-{{ $index }}">
                            <h5 class="mb-0">
                                <div class="btn text-right btn-block text-primary font-16 font-weight-500 collapsed"
                                    data-toggle="collapse" data-target="#collapse-{{ $index }}" aria-expanded="false"
                                    aria-controls="collapse-{{ $index }}">
                                    {{ $section['name'] }}
                                </div>
                            </h5>
                        </div>

                        <div id="collapse-{{ $index }}" class="collapse "
                            aria-labelledby="heading-{{ $index }}" data-parent="#permissionsAccordion">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($section['permissions'] as $permission)
                                        <div class="col-lg-4 col-md-6 col-12 py-1">
                                            <input type="checkbox" @checked(in_array($permission->id, $rolePermissions)) name="permission[]"
                                                id="perm-{{ $permission->id }}" value="{{ $permission->id }}">
                                            <label class="cursor-pointer" for="perm-{{ $permission->id }}">
                                                {{  $permission->display_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <input type="hidden" value="{{ Request::segment(3) }}" name="id">
            @csrf
            <button type="submit" class="btn btn-main px-4 mt-3">حفظ التغيرات</button>
        </form>







    </section><!-- Section -->

@endsection
