<div id="links-bar">
    @foreach ($links as $row)
        @php
            // Global Varible
            $link = '';
            $name = '';
            // Check If Isset Link
            if (isset($row['link'])) {
                $link = $row['link'];
            }
            if (isset($row['name'])) {
                $name = $row['name'];
            }
        @endphp
        <!-- End Check Links -->

        <a href="{{ $link }}">
            @if ($loop->index == 0)
                @if (isset($row['name']))
                    {{ $name }}
                @else
                    @yield('title')
                @endif
            @else
                {{ $name }}
            @endif
        </a>
    @endforeach
</div>


@foreach ($buttons as $btn)
    @php
        // Global Varible
        $link = '';
        $name = '';
        $class = '';
        // Check If Isset Link
        if (isset($btn['link'])) {
            $link = $btn['link'];
        }
        if (isset($btn['name'])) {
            $name = $btn['name'];
        }
        if (isset($btn['class'])) {
            $class = $btn['class'];
        }
    @endphp

   


    <!-- End Check Links -->
    <a href="{{ $link }}" class="btn-add-new {{ $class }} "  @if (isset($btn['options'])) @foreach ($btn['options'] as $key => $val) @if (is_numeric($key)) {{ $val }} @else @php echo $key.'="'.$val.'"'; @endphp @endif @endforeach @endif>{{ $name }}</a>
@endforeach


<div class="clearfix"></div>
