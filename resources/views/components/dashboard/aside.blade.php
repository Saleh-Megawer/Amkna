@if (isset($details['sub_menu']))
    <li class="side-item">
        <a>
            <span class="side-icon">{!! $details['icon'] !!}</span>
            <span class="side-name-lable">{{ $details['name'] }}</span>
            <span
                class="arrow-icon @foreach ($details['sub_menu'] as $item) {{ adminActiveLink($item['link'], 'rotate-icon') }} @endforeach">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 384 512">
                    <path
                        d="M169.4 374.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 306.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" />
                </svg>
            </span>
        </a>
        <ul
            class="sub-menu @foreach ($details['sub_menu'] as $item) {{ adminActiveLink($item['link'], 'show') }} @endforeach">
            @foreach ($details['sub_menu'] as $item)
                @if (isset($item['can']) && $item['can'] != null)
                    @can($item['can'])
                        <li class="sub-item">
                            <a class="{{ adminActiveLink($item['link']) }}" href="{{ adminUrl($item['link']) }}">
                                <span class="side-icon">{!! isset($item['icon']) ? $item['icon'] : '' !!}</span>
                                <span class="side-name-lable">{!! $item['name'] !!}</span>
                            </a>
                        </li>
                    @endcan
                @else
                    <li class="sub-item">
                        <a class="{{ adminActiveLink($item['link']) }}" href="{{ adminUrl($item['link']) }}">
                            <span class="side-icon">{!! isset($item['icon']) ? $item['icon'] : '' !!}</span>
                            <span class="side-name-lable">{!! $item['name'] !!}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </li>
@else
    @if (isset($details['can']) && $details['can'] != null)
        @can($details['can'])
            <li class="side-item">
                <a class="{{ adminActiveLink($details['link']) }}" href="{{ adminUrl($details['link']) }}">
                    <span class="side-icon">{!! $details['icon'] !!}</span>
                    <span class="side-name-lable">{!! $details['name'] !!}</span>
                </a>
            </li>
        @endcan
    @else
        <li class="side-item">
            <a class="{{ adminActiveLink($details['link']) }}" href="{{ adminUrl($details['link']) }}">
                <span class="side-icon">{!! $details['icon'] !!}</span>
                <span class="side-name-lable">{!! $details['name'] !!}</span>
            </a>
        </li>
    @endif

@endif
