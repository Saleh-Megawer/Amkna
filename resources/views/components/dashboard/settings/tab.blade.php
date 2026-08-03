<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    @foreach ($tabs as $tabKey => $tabName)
        <button class="nav-link border my-1 @if ($loop->index == 0) {{ 'active' }} @endif"
            id="{{ $tabKey }}-tab" data-toggle="pill" data-target="#v-pills-{{ $tabKey }}" type="button"
            role="tab" aria-controls="v-pills-home"
            aria-selected="@if ($loop->index == 0) {{ 'true' }}@else{{ 'false' }} @endif">
            {{ Str::ucfirst($tabName) }}
        </button><!-- Tab Buttons -->
    @endforeach
</div><!-- End Nav -->
