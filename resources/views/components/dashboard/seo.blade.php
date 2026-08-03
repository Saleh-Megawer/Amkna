{{-- @if ($browserPreview == true)
    <x-panel-with-heading title="Browser Preview">

        <div id="browser-preview" class=" border p-2 rounded">

            <div class="base-url mb-1">
                <i class="fa-solid fa-globe"></i>
                <span>{{ env('APP_URL') }}/</span>
                <span class="slug">
                    @if (old('slug'))
                        {{ old('slug') }}
                    @else
                        @if (isset($values['slug']))
                            {{ $values['slug'] }}
                        @else
                            {{ dbTransComponent('seo.slug', false) }}
                        @endif
                    @endif
                </span>
            </div><!-- base url & link -->

            <div class="page-title">
                <span>{{ env('APP_NAME') }}</span>
                <span class="mx-1">{{ env('PAGE_TITLE_SEPARATOR') }}</span>
                <span class="title">
                    @if (old('meta_title'))
                        {{ old('meta_title') }}
                    @else
                        @if (isset($values['meta_title']))
                            {{ $values['meta_title'] }}
                        @else
                            {{ 'The page title is displayed prominently, often in large blue text, on search engineresults pages' }}
                        @endif
                    @endif
                </span>

            </div><!-- page title -->

            <div class="meta-desc">
                @if (old('meta_description'))
                    {{ old('meta_description') }}
                @else
                    @if (isset($values['meta_description']))
                        {{ $values['meta_description'] }}
                    @else
                        {{ dbTransComponent('seo.Meta desc') }}
                    @endif
                @endif
            </div><!-- meta desc -->

        </div><!-- browser-preview parnet -->

    </x-panel-with-heading>
@endif --}}

<x-panel-with-heading title="{{ dbTransComponent('seo.SEO', false) }}">

    @php
        $slug = isset($values['slug']) ? $values['slug'] : null;
        $meta_title = isset($values['meta_title']) ? $values['meta_title'] : null;
        $meta_description = isset($values['meta_description']) ? $values['meta_description'] : null;
    @endphp

    <x-form-group :properties="[
        'input' => [
            'name' => 'slug',
            'value' => $slug,
            'type' => 'text',
            'options' => ['required'],
        ],
        'label' => [
            'text' => dbTransComponent('seo.URL Slug', false),
            'options' => [
                'class' => 'required',
            ],
        ],
    ]" /><!-- slug -->


    <x-form-group :properties="[
        'input' => [
            'name' => 'meta_title',
            'value' => $meta_title,
            'type' => 'text',
            'options' => ['required', 'class' => 'input-meta-title'],
        ],
        'label' => [
            'text' =>
                dbTransComponent('seo.Meta Title') .
                ' <small id=\'page-title-max-length\'>( Characters left: <span></span> )</small>',
            'options' => [
                'class' => 'required',
            ],
        ],
    ]" /><!-- page_title -->


    <x-form-group class="mb-1" :properties="[
        'textarea' => [
            'name' => 'meta_description',
            'value' => $meta_description,
            'options' => ['required', 'rows' => 5, 'class' => 'input-meta-description'],
        ],
        'label' => [
            'text' =>
                dbTransComponent('seo.Meta Description') .
                ' <small id=\'description-max-length\'>( Characters left: <span></span> )</small>',
            'options' => [
                'class' => 'required',
            ],
        ],
    ]" /><!-- meta_description -->

    <div class="">
        <div class="progress" style="height: 10px">
            <div class="progress-bar bg-warning " role="progressbar" style="width: 0%" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <!-- Good Bar -->


</x-panel-with-heading>
