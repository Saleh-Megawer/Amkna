@extends('dashboard.layouts.master')
@section('title', 'مراحل رحلتنا')

@section('content')

<x-dashboard.links-bar :links="[
    ['name' => 'من نحن'],
    ['name' => 'مراحل رحلتنا'],
]" />

<main class="mb-5">
    
    <form action="{{ route('pages.about.update') }}" method="POST" id="journey-form">
        @csrf
        <input type="hidden" name="about_id" value="{{ $about->id }}">

        <div class="row">
            <div class="col-lg-8">
                
                {{-- Language Tabs --}}
                <div class="box mb-3">
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $index => $locale)
                            <li class="nav-item">
                                <a class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                   data-toggle="tab" 
                                   href="#tab-{{ $locale }}" 
                                   role="tab">
                                    {{ $locale === 'ar' ? '🇸🇦 العربية' : '🇬🇧 English' }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Tab Content --}}
                <div class="tab-content">
                    @foreach($locales as $index => $locale)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                             id="tab-{{ $locale }}" 
                             role="tabpanel">
                            
                            <input type="hidden" name="locales[]" value="{{ $locale }}">
                            
                            <div id="journey-items-container-{{ $locale }}" class="mb-3">
                                @php
                                    $journeyItems = $translations[$locale]->our_journey ?? [];
                                @endphp
                                
                                @if (count($journeyItems) > 0)
                                    @foreach ($journeyItems as $itemIndex => $item)
                                        <div class="journey-item mb-4 box" data-item-id="{{ $item['id'] ?? uniqid() }}" data-locale="{{ $locale }}">
                                            
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-2 font-weight-600">عنصر ( {{ $loop->iteration }} )</h6>
                                                <button type="button" class="btn btn-soft-danger btn-sm remove-journey-item">
                                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                        <rect width="256" height="256" fill="none"/>
                                                        <line x1="216" y1="56" x2="40" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                                                        <line x1="104" y1="104" x2="104" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                                                        <line x1="152" y1="104" x2="152" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                                                        <path d="M200,56V208a8,8,0,0,1-8,8H64a8,8,0,0,1-8-8V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                                                        <path d="M168,56V40a16,16,0,0,0-16-16H104A16,16,0,0,0,88,40V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                                                    </svg>
                                                    حذف
                                                </button>
                                            </div>

                                            <input type="hidden" class="journey-item-id" name="our_journey[{{ $locale }}][{{ $itemIndex }}][id]" value="{{ $item['id'] ?? '' }}">

                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <x-form-group :properties="[
                                                        'input' => [
                                                            'name' => 'our_journey[' . $locale . '][' . $itemIndex . '][title]',
                                                            'value' => $item['title'] ?? '',
                                                            'type' => 'text',
                                                            'options' => ['class' => 'journey-title ' . ($locale === 'en' ? 'ltr text-left' : '')],
                                                        ],
                                                        'label' => [
                                                            'text' => 'العنوان',
                                                        ],
                                                    ]" />
                                                </div>

                                                <div class="col-md-12">
                                                    <x-form-group :properties="[
                                                        'textarea' => [
                                                            'name' => 'our_journey[' . $locale . '][' . $itemIndex . '][desc]',
                                                            'value' => $item['desc'] ?? '',
                                                            'options' => ['rows' => 3, 'class' => 'journey-desc ' . ($locale === 'en' ? 'ltr text-left' : '')],
                                                        ],
                                                        'label' => [
                                                            'text' => 'الوصف',
                                                        ],
                                                    ]" />
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>كود الأيقونة SVG <small class="text-muted">(مشترك بين اللغات)</small></label>
                                                        <textarea name="our_journey[{{ $locale }}][{{ $itemIndex }}][icon]" class="form-control journey-icon ltr text-left" rows="4" style="font-family: monospace; font-size: 12px;">{{ $item['icon'] ?? '' }}</textarea>
                                                        <small class="form-text text-muted">الصق كود SVG هنا</small>
                                                    </div>

                                                    @if (!empty($item['icon']))
                                                        <div class="icon-preview p-2 border rounded bg-white text-center">
                                                            <div class="d-inline-block" style="width: 48px; max-height: 48px;">
                                                                {!! $item['icon'] !!}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info text-center">
                                        {{ $locale === 'ar' ? 'لا توجد عناصر. اضغط "إضافة عنصر جديد" للبدء' : 'No items. Click "Add New Item" to start' }}
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                    @endforeach
                </div>

            </div><!-- col-lg-8 -->

            <div class="col-lg-4">
                <div class="box sticky-top" style="top: 90px;">
                    <h5 class="mb-3 font-weight-600">إجراءات</h5>
                    <div class="d-flex">
                        <button style="white-space: nowrap" type="button" class="btn-add-journey-item btn btn-success btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 5l0 14"/>
                                <path d="M5 12l14 0"/>
                            </svg>
                            عنصر جديد
                        </button>

                        <span class="mx-1"></span>

                        <button type="submit" class="btn btn-main btn-block">
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </div>

        </div><!-- row -->
    </form>

</main>

{{-- Template للعنصر الجديد --}}
<template id="journey-item-template">
    <div class="journey-item mb-4 box" data-item-id="" data-locale="">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0 font-weight-600">عنصر جديد</h6>
            <button type="button" class="btn btn-soft-danger btn-sm remove-journey-item">
                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                    <rect width="256" height="256" fill="none"/>
                    <line x1="216" y1="56" x2="40" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                    <line x1="104" y1="104" x2="104" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                    <line x1="152" y1="104" x2="152" y2="168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                    <path d="M200,56V208a8,8,0,0,1-8,8H64a8,8,0,0,1-8-8V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                    <path d="M168,56V40a16,16,0,0,0-16-16H104A16,16,0,0,0,88,40V56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/>
                </svg>
                حذف
            </button>
        </div>

        <input type="hidden" class="journey-item-id" name="" value="">

        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>العنوان</label>
                    <input type="text" class="form-control journey-title" name="" value="">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>الوصف</label>
                    <textarea class="form-control journey-desc" name="" rows="3"></textarea>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label>كود الأيقونة SVG</label>
                    <textarea class="form-control journey-icon ltr text-left" name="" rows="4" style="font-family: monospace; font-size: 12px;"></textarea>
                    <small class="form-text text-muted">الصق كود SVG هنا</small>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@section('js')
<script>
$(document).ready(function() {
    
    let itemCounters = {
        @foreach($locales as $locale)
            '{{ $locale }}': {{ count($translations[$locale]->our_journey ?? []) }},
        @endforeach
    };

    // الحصول على الـ locale النشط حالياً
    function getActiveLocale() {
        return $('.tab-pane.active').attr('id').replace('tab-', '');
    }

    // ========================================
    // إضافة عنصر جديد
    // ========================================
    $('.btn-add-journey-item').on('click', function() {
        const locale = getActiveLocale();
        const itemId = generateUUID();
        const itemCounter = itemCounters[locale];

        const template = $('#journey-item-template').html();
        const $newItem = $(template);

        $newItem.attr('data-item-id', itemId);
        $newItem.attr('data-locale', locale);

        // تحديث الـ name attributes
        $newItem.find('.journey-item-id').attr('name', `our_journey[${locale}][${itemCounter}][id]`).val(itemId);
        $newItem.find('.journey-title').attr('name', `our_journey[${locale}][${itemCounter}][title]`);
        $newItem.find('.journey-desc').attr('name', `our_journey[${locale}][${itemCounter}][desc]`);
        $newItem.find('.journey-icon').attr('name', `our_journey[${locale}][${itemCounter}][icon]`);

        // إضافة class للـ English
        if (locale === 'en') {
            $newItem.find('.journey-title, .journey-desc').addClass('ltr text-left');
        }

        $(`#journey-items-container-${locale}`).append($newItem);
        $(`#journey-items-container-${locale} .alert-info`).remove();

        itemCounters[locale]++;

        $('html, body').animate({
            scrollTop: $newItem.offset().top - 100
        }, 500);

        $newItem.find('.journey-title').focus();
    });

    // ========================================
    // حذف عنصر
    // ========================================
    $(document).on('click', '.remove-journey-item', function() {
        const $item = $(this).closest('.journey-item');
        const locale = $item.data('locale');

        if (confirm('هل أنت متأكد من حذف هذا العنصر؟')) {
            $item.fadeOut(300, function() {
                $(this).remove();

                if ($(`#journey-items-container-${locale} .journey-item`).length === 0) {
                    $(`#journey-items-container-${locale}`).html(`
                        <div class="alert alert-info text-center">
                            ${locale === 'ar' ? 'لا توجد عناصر. اضغط "إضافة عنصر جديد" للبدء' : 'No items. Click "Add New Item" to start'}
                        </div>
                    `);
                }

                updateItemNumbers(locale);
            });
        }
    });

    // ========================================
    // Preview للـ SVG Icon
    // ========================================
    $(document).on('input', '.journey-icon', function() {
        const $textarea = $(this);
        const svgCode = $textarea.val();
        const $item = $textarea.closest('.journey-item');

        $item.find('.icon-preview').remove();

        if (svgCode.trim().length > 0) {
            const $preview = $(`
                <div class="icon-preview p-2 border rounded bg-white text-center mt-2">
                    <div class="d-inline-block">
                        ${svgCode}
                    </div>
                </div>
            `);
            $textarea.parent().append($preview);
        }
    });

    // ========================================
    // Form Validation
    // ========================================
    $('#journey-form').on('submit', function(e) {
        let isValid = true;
        let errorMessages = [];

        $('.tab-pane').each(function() {
            const locale = $(this).attr('id').replace('tab-', '');
            const localeName = locale === 'ar' ? 'العربية' : 'English';

            $(this).find('.journey-item').each(function(index) {
                const $item = $(this);
                const title = $item.find('.journey-title').val().trim();
                const desc = $item.find('.journey-desc').val().trim();

                $item.find('.is-invalid').removeClass('is-invalid');

                if (title === '') {
                    $item.find('.journey-title').addClass('is-invalid');
                    errorMessages.push(`[${localeName}] العنصر ${index + 1}: العنوان مطلوب`);
                    isValid = false;
                }

                if (desc === '') {
                    $item.find('.journey-desc').addClass('is-invalid');
                    errorMessages.push(`[${localeName}] العنصر ${index + 1}: الوصف مطلوب`);
                    isValid = false;
                }
            });
        });

        if (!isValid) {
            e.preventDefault();
            alert('يرجى تصحيح الأخطاء التالية:\n\n' + errorMessages.join('\n'));

            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });

    // ========================================
    // Helper Functions
    // ========================================
    function generateUUID() {
        if (typeof crypto !== 'undefined' && crypto.randomUUID) {
            return crypto.randomUUID();
        }
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }

    function updateItemNumbers(locale) {
        $(`#journey-items-container-${locale} .journey-item`).each(function(index) {
            $(this).find('h6').first().text(`عنصر ${index + 1}`);
        });
    }

});
</script>
@endsection
