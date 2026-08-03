@php
$className = '';
if ($id == 'brief') {
    if ($section == $id || $section == null) {
        $className = 'active';
    } else {
        $className = 'display-none';
    }
} else {
    if ($section == $id) {
        $className = 'active';
    } else {
        $className = 'display-none';
    }
}

@endphp


<section id="{{ $id }}" class="{{ $className }}">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">
                <h5 class="mb-3 text-secondary font-weight-bold text-uppercase">{{ Str::headline($id) }}</h5>
            </div>



            {{ $slot }}

            <!-- Start Important Input -->
            @csrf
            <input type="hidden" class="project_id" name="id" value="{{ $projectId }}">
            <input type="hidden" name="edit" value="EDIT">
            <!-- End Important Input -->
        </div>

        @if (Request::segment(3) == 'edit')
            <button type="submit" class="btn-main">Update</button>
        @else
            @if ($prev != null)
                <button type="button" data-prev="{{ $prev }}" class="btn-prev btn-secondary"><i
                        class="fa-solid fa-arrow-left-long"></i> Prev
                </button>
            @endif

            <button type="submit" class="btn-main">Save & Next <i class="fa-solid fa-arrow-right-long"></i></button>
            <!-- End Button Submit -->
        @endif
    </form>
</section><!-- end brief -->
