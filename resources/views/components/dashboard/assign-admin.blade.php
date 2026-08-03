@props(['action', 'row'])

<select class="form-control form-control-sm assign-admin" data-action="{{ $action }}"
    data-client-id="{{ $row->id }}">
    @if ($row->assignedTo)
        <!--  لو ف يه مكلف، حطه selected -->
        <option title="{{ $row->assignedTo->full_name }}" value="{{ $row->assignedTo->id }}" selected>
            {{ Str::limit($row->assignedTo->full_name, 20, '..') }}
        </option>
    @else
        <!--  لو مفيش مكلف -->
        <option value="">تكليف موظف...</option>
    @endif

    @foreach (getActiveAvailableSalesAdmins() as $admin)
        @if (!$row->assignedTo || $row->assignedTo->id != $admin->id)
            <option title="{{ $admin->full_name }}" value="{{ $admin->id }}">
                {{ Str::limit($admin->full_name, 20, '..') }}
            </option>
        @endif
    @endforeach
</select>
