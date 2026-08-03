<ul class="nav nav-tabs mb-1" id="myTab" role="tablist">
    @foreach (languages() as $key => $val)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->index == 0 ? 'active' : '' }}" id="{{ $key }}-tab" data-toggle="tab"
                data-target="#{{ $key }}" type="button" role="tab" aria-controls="{{ $key }}"
                aria-selected="true">{{ $val['name'] }}</button>
        </li>
    @endforeach
</ul>
