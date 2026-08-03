<div class="pagination d-flex justify-content-start">
    <div class="nav-links">
        <!-- زر السابق -->
        @if ($properties->onFirstPage())
            <span class="page-numbers prev disabled">&laquo;</span>
        @else
            <a class="page-numbers prev" title="السابق"
                href="{{ $properties->appends(request()->query())->previousPageUrl() }}">&laquo;</a>
        @endif

        <!-- أول صفحة دائمًا -->
        <a class="page-numbers {{ $properties->currentPage() == 1 ? 'current' : '' }}"
            href="{{ $properties->appends(request()->query())->url(1) }}">1</a>

        <!-- النقاط إذا كانت الصفحة الحالية أكبر من 3 -->
        @if ($properties->currentPage() > 3)
            <span class="page-numbers dots">...</span>
        @endif

        <!-- أرقام الصفحات حول الصفحة الحالية -->
        @for ($i = max(2, $properties->currentPage() - 1); $i <= min($properties->lastPage() - 1, $properties->currentPage() + 1); $i++)
            <a class="page-numbers {{ $i == $properties->currentPage() ? 'current' : '' }}"
                href="{{ $properties->appends(request()->query())->url($i) }}">{{ $i }}</a>
        @endfor

        <!-- النقاط إذا كانت الصفحة الحالية أصغر من آخر صفحتين -->
        @if ($properties->currentPage() < $properties->lastPage() - 2)
            <span class="page-numbers dots">...</span>
        @endif

        <!-- آخر صفحة دائمًا -->
        @if ($properties->lastPage() > 1)
            <a class="page-numbers {{ $properties->currentPage() == $properties->lastPage() ? 'current' : '' }}"
                href="{{ $properties->appends(request()->query())->url($properties->lastPage()) }}">{{ $properties->lastPage() }}</a>
        @endif

        <!-- زر التالي -->
        @if ($properties->hasMorePages())
            <a class="page-numbers next" href="{{ $properties->appends(request()->query())->nextPageUrl() }}"
                title="التالي">&raquo;</a>
        @else
            <span class="page-numbers next disabled">&raquo;</span>
        @endif
    </div>
</div>
