@props(['items' => []])
<nav class="client-breadcrumb-nav mt-2" aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent font-14 p-0 mb-4">
        @foreach ($items as $item)
            @if ($loop->last)
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item['title'] }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>