<div class="tab-pane fa__de {{ $active == true ? 'show active' : '' }} pt-2" id="{{ $langKey }}" role="tabpanel"
    aria-labelledby="{{ $langKey }}-tab">
    {{ $slot }}
</div>
