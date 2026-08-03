<div class="pagination d-flex justify-content-start">
    <div class="nav-links">
        <!-- زر السابق -->
        @if ($paginator->onFirstPage())
            <span class="page-numbers prev disabled">&laquo;</span>
        @else
            <a class="page-numbers prev" title="السابق"
                href="{{ $paginator->appends(request()->query())->previousPageUrl() }}">&laquo;</a>
        @endif

        <!-- أول صفحة دائمًا -->
        <a class="page-numbers {{ $paginator->currentPage() == 1 ? 'current' : '' }}"
            href="{{ $paginator->appends(request()->query())->url(1) }}">1</a>

        <!-- النقاط إذا كانت الصفحة الحالية أكبر من 3 -->
        @if ($paginator->currentPage() > 3)
            <span class="page-numbers dots">...</span>
        @endif

        <!-- أرقام الصفحات حول الصفحة الحالية -->
        @for ($i = max(2, $paginator->currentPage() - 1); $i <= min($paginator->lastPage() - 1, $paginator->currentPage() + 1); $i++)
            <a class="page-numbers {{ $i == $paginator->currentPage() ? 'current' : '' }}"
                href="{{ $paginator->appends(request()->query())->url($i) }}">{{ $i }}</a>
        @endfor

        <!-- النقاط إذا كانت الصفحة الحالية أصغر من آخر صفحتين -->
        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            <span class="page-numbers dots">...</span>
        @endif

        <!-- آخر صفحة دائمًا -->
        @if ($paginator->lastPage() > 1)
            <a class="page-numbers {{ $paginator->currentPage() == $paginator->lastPage() ? 'current' : '' }}"
                href="{{ $paginator->appends(request()->query())->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
        @endif

        <!-- زر التالي -->
        @if ($paginator->hasMorePages())
            <a class="page-numbers next" href="{{ $paginator->appends(request()->query())->nextPageUrl() }}"
                title="التالي">&raquo;</a>
        @else
            <span class="page-numbers next disabled">&raquo;</span>
        @endif
    </div>
</div>
