@props(['text', 'title' => null, 'limit' => 20])

<span class="show-full-text cursor-pointer" data-text="{{ $text }}" data-title="{{ $title }}">
    {!! Str::limit($text, $limit, ' <span class="text-primary">المزيد...</span>') !!}
</span>
