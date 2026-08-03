document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // CONSTANTS
    // ==========================================
    const FILTER_KEYS = ['city_id', 'neighborhood_id', 'property_type_id', 'purpose',
        'price_min', 'price_max', 'area_min', 'area_max', 'bedrooms', 'bathrooms', 'sort'];

    const DESKTOP_MIN_WIDTH = 768;
    let filterDebounceTimer = null;

    function isDesktop() {
        return $(window).width() > DESKTOP_MIN_WIDTH;
    }

    function applyDesktopIfSidebar($container, delay = 300) {
        if (isDesktop() && $container && $container.is('#filtersSidebar')) {
            clearTimeout(filterDebounceTimer);
            filterDebounceTimer = setTimeout(function () {
                applyFilters('desktop');
            }, delay);
        }
    }

    // ==========================================
    // Lozad (Lazy load)
    // ==========================================
    function initLozad() {
        if (typeof lozad !== 'undefined') {
            const observer = lozad('.lozad', {
                loaded: function (el) {
                    el.classList.add('loaded');
                }
            });
            observer.observe();
        }
    }

    initLozad();

    // ==========================================
    // Mobile Filter Overlay & Open
    // ==========================================
    const overlay = document.getElementById('filtersOverlay');
    const openBtn = document.getElementById('openFiltersBtn');
    const closeBtn = document.getElementById('closeFiltersBtn');
    const applyBtn = document.getElementById('applyFiltersBtn');

    if (overlay && openBtn) {

        function openFilters() {
            overlay.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeFilters() {
            overlay.classList.remove('is-open');
            document.body.style.overflow = '';
        }

        openBtn.addEventListener('click', openFilters);

        if (closeBtn) {
            closeBtn.addEventListener('click', closeFilters);
        }

        if (applyBtn) {
            applyBtn.addEventListener('click', function () {
                applyFilters('mobile');
                closeFilters();
            });
        }

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                closeFilters();
            }
        });
    }


    // ==========================================
    // Start Apply Filters Function
    // ==========================================
    function applyFilters(source) {
        source = source || (isDesktop() ? 'desktop' : 'mobile');

        const $container = source === 'desktop' ? $('#filtersSidebar') : $('#filtersOverlay');

        const filters = collectFilterValues($container);

        updateBrowserURL(filters);

        sendFilterRequest(filters);
    }

    function collectFilterValues($container) {

        const filterSelectors = {
            city_id: '.selected-city-id',
            neighborhood_id: '.selected-neighborhood-id',
            property_type_id: '.selected-property-type-id',
            purpose: '.selected-purpose',
            price_min: '.selected-price-min',
            price_max: '.selected-price-max',
            area_min: '.selected-area-min',
            area_max: '.selected-area-max',
            bedrooms: '.selected-bedrooms',
            bathrooms: '.selected-bathrooms'
        };

        const filters = {};

        Object.entries(filterSelectors).forEach(([key, selector]) => {
            const value = $container.find(selector).val();
            if (value) filters[key] = value;
        });

        // ✅ حافظ على الـ sort من الـ URL
        const currentUrl = new URL(window.location);
        const currentSort = currentUrl.searchParams.get('sort');
        if (currentSort) {
            filters.sort = currentSort;
        }

        return filters;
    }

    function updateBrowserURL(filters) {
        const url = new URL(window.location);

        FILTER_KEYS.forEach(key => url.searchParams.delete(key));
        url.searchParams.delete('page');

        Object.entries(filters).forEach(([key, value]) => {
            url.searchParams.set(key, value);
        });

        window.history.pushState({}, '', url);
    }

    function sendFilterRequest(filters) {
        const $propertiesList = $('#properties-list');
        const $propertiesPagination = $('#properties-pagination');

        $.ajax({
            url: $propertiesList.data('filter-url'),
            method: 'GET',
            data: filters,
            beforeSend() {
                $propertiesList.addClass('loading');
                //  $propertiesPagination.addClass('loading');
            },
            success(response) {
                if (response.success) {
                    $propertiesList.html(response.html);
                    $propertiesPagination.html(response.pagination);

                    initLozad();

                    $('#resultsCount').text(response.count);
                }
            },
            error(xhr, status, error) {
                console.error('Filter error:', error);
                alert('حدث خطأ أثناء الفلترة. الرجاء المحاولة مرة أخرى.');
            },
            complete() {
                $propertiesList.removeClass('loading');
                // $propertiesPagination.removeClass('loading');
            }
        });
    }
    // ==========================================
    // End Apply Filters Function
    // ==========================================

    // ==========================================
    // Location Autocomplete (Desktop & Mobile)
    // ==========================================
    (function () {

        function displaySuggestions(results, $dropdown) {
            $dropdown.empty();

            if (!results || results.length === 0) {
                $dropdown.hide();
                return;
            }

            results.forEach(result => {
                const $item = $('<li></li>')
                    .text(result.label)
                    .data('location', result);

                $dropdown.append($item);
            });

            $dropdown.show();
        }

        function searchLocations(query, $input, $dropdown) {
            $.ajax({
                url: $input.data('search-url'),
                method: 'GET',
                data: { q: query },
                beforeSend: function () {
                    $input.addClass('loading');
                },
                success: function (response) {
                    displaySuggestions(response.results, $dropdown);
                },
                error: function () {
                    console.error('Location search failed');
                },
                complete: function () {
                    $input.removeClass('loading');
                }
            });
        }

        $('.location-search-input').each(function () {
            const $locationInput = $(this);
            const $parent = $locationInput.closest('.filter-group, .form-group');
            const $cityIdInput = $parent.find('.selected-city-id');
            const $neighborhoodIdInput = $parent.find('.selected-neighborhood-id');
            const $locationTypeInput = $parent.find('.selected-location-type');

            let typingTimer;
            const typingDelay = 300;

            const $suggestionsDropdown = $('<ul class="location-suggestions"></ul>');
            $locationInput.parent().css('position', 'relative').append($suggestionsDropdown);

            $locationInput.on('input', function () {
                clearTimeout(typingTimer);
                const query = $(this).val().trim();

                if (query.length < 2) {
                    $suggestionsDropdown.hide().empty();
                    return;
                }

                typingTimer = setTimeout(() => {
                    searchLocations(query, $locationInput, $suggestionsDropdown);
                }, typingDelay);
            });

            $locationInput.on('keyup', function () {
                if ($(this).val() === '') {
                    $cityIdInput.val('');
                    $neighborhoodIdInput.val('');
                    $locationTypeInput.val('');

                    if (isDesktop()) {
                        applyFilters();
                    }
                }
            });

        });

        $(document).on('click', '.location-suggestions li', function () {
            const $li = $(this);
            const location = $li.data('location');

            const $dropdown = $li.closest('.location-suggestions');
            const $parent = $dropdown.closest('.filter-group, .form-group');

            const $input = $parent.find('.location-search-input');
            const $cityId = $parent.find('.selected-city-id');
            const $neighborhoodId = $parent.find('.selected-neighborhood-id');
            const $locationType = $parent.find('.selected-location-type');

            $input.val(location.name);
            $locationType.val(location.type);

            $cityId.val('');
            $neighborhoodId.val('');

            if (location.type === 'city') {
                $cityId.val(location.id);
            } else if (location.type === 'neighborhood') {
                $neighborhoodId.val(location.id);
            }

            $dropdown.hide().empty();

            if (isDesktop()) {
                applyFilters();
            }
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('.location-search-input').length &&
                !$(e.target).closest('.location-suggestions').length) {
                $('.location-suggestions').hide();
            }
        });

    })();

    // ==========================================
    // Unified Toggle Buttons Helper (Type / Purpose / Baths)
    // ==========================================
    function bindToggleButtons(options) {
        const btnSelector = options.btnSelector;
        const groupSelector = options.groupSelector || options.btnSelector;
        const inputSelector = options.inputSelector;
        const valueGetter = options.valueGetter; // function($btn) => value
        const normalize = options.normalize || function (v, $btn) { return v; };
        const applyDelay = typeof options.applyDelay === 'number' ? options.applyDelay : 0;

        $(document).on('click', btnSelector, function () {
            const $btn = $(this);
            const $container = $btn.closest('#filtersSidebar, #filtersOverlay');

            $container.find(groupSelector).removeClass('active');
            $btn.addClass('active');

            let value = valueGetter($btn);
            value = normalize(value, $btn);

            $container.find(inputSelector).val(value);

            if (applyDelay === 0) {
                if (isDesktop() && $container.is('#filtersSidebar')) {
                    applyFilters('desktop');
                }
            } else {
                applyDesktopIfSidebar($container, applyDelay);
            }
        });
    }

    // Property Type
    bindToggleButtons({
        btnSelector: '.select-property-type',
        groupSelector: '.select-property-type',
        inputSelector: '.selected-property-type-id',
        valueGetter: ($btn) => $btn.data('type-id'),
        applyDelay: 0
    });

    // Purpose
    bindToggleButtons({
        btnSelector: '.select-property-purpose',
        groupSelector: '.select-property-purpose',
        inputSelector: '.selected-purpose',
        valueGetter: ($btn) => $btn.data('purpose'),
        applyDelay: 0
    });

    // Bathrooms
    bindToggleButtons({
        btnSelector: '.select-property-baths',
        groupSelector: '.select-property-baths',
        inputSelector: '.selected-bathrooms',
        valueGetter: ($btn) => $btn.text().trim(),
        normalize: (text, $btn) => {
            const isAllButton = $btn.index() === 0;
            return isAllButton ? '' : text.replace('+', '');
        },
        applyDelay: 300
    });

    // ==========================================
    // Bedrooms Buttons (special case)
    // ==========================================
    $(document).on('click', '.select-property-number-room', function () {
        const $btn = $(this);
        const $container = $btn.closest('#filtersSidebar, #filtersOverlay');

        $btn.siblings('.select-property-number-room').removeClass('active');
        $btn.addClass('active');

        const isAll = $btn.index() === 0;
        const value = isAll ? '' : $btn.text().trim().replace('+', '');

        $container.find('.selected-bedrooms').val(value);

        applyDesktopIfSidebar($container, 300);
    });

    // ==========================================
    // Price Range Slider (noUiSlider)
    // ==========================================
    function initRangeSlider(config) {
        $(config.selector).each(function () {

            const sliderElement = this;
            const $container = $(this).closest('#filtersSidebar, #filtersOverlay');
            const $minDisplay = $container.find(config.minDisplayClass);
            const $maxDisplay = $container.find(config.maxDisplayClass);
            const $minInput = $container.find(config.minInputClass);
            const $maxInput = $container.find(config.maxInputClass);

            if (sliderElement.noUiSlider) return;

            const minValue = parseInt($(this).data('min')) || config.defaultMin;
            const maxValue = parseInt($(this).data('max')) || config.defaultMax;
            const rangeDiff = maxValue - minValue;

            let step = config.stepRanges.find(range => rangeDiff > range.threshold)?.step || config.stepRanges[config.stepRanges.length - 1].step;

            const initialMin = parseInt($minInput.val()) || minValue;
            const initialMax = parseInt($maxInput.val()) || maxValue;

            noUiSlider.create(sliderElement, {
                start: [initialMin, initialMax],
                connect: true,
                direction: $('html').attr('dir') === 'rtl' ? 'rtl' : 'ltr',
                range: {
                    'min': minValue,
                    'max': maxValue
                },
                step: step,
                format: {
                    to: value => Math.round(value),
                    from: value => Number(value)
                }
            });

            sliderElement.noUiSlider.on('update', function (values) {
                const min = parseInt(values[0]);
                const max = parseInt(values[1]);

                const locale = $('html').attr('lang');
                const unit = config.getUnit(locale);

                $minDisplay.text(min.toLocaleString('en-US') + unit);
                $maxDisplay.text(max.toLocaleString('en-US') + unit);

                $minInput.val(min);
                $maxInput.val(max);
            });

            sliderElement.noUiSlider.on('change', function () {
                applyDesktopIfSidebar($container, 100);
            });
        });
    }

    initRangeSlider({
        selector: '.price-slider',
        minDisplayClass: '.price-min',
        maxDisplayClass: '.price-max',
        minInputClass: '.selected-price-min',
        maxInputClass: '.selected-price-max',
        defaultMin: 0,
        defaultMax: 10000000,
        stepRanges: [
            { threshold: 5000000, step: 50000 },
            { threshold: 1000000, step: 20000 },
            { threshold: 200000, step: 10000 },
            { threshold: 0, step: 1000 }
        ],
        getUnit: (locale) => locale === 'ar' ? ' ج.م' : ' EGP'
    });

    initRangeSlider({
        selector: '.area-slider',
        minDisplayClass: '.area-min',
        maxDisplayClass: '.area-max',
        minInputClass: '.selected-area-min',
        maxInputClass: '.selected-area-max',
        defaultMin: 10,
        defaultMax: 5000,
        stepRanges: [
            { threshold: 2000, step: 50 },
            { threshold: 1000, step: 25 },
            { threshold: 500, step: 10 },
            { threshold: 0, step: 5 }
        ],
        getUnit: (locale) => locale === 'ar' ? ' م²' : ' sqm'
    });

    // ==========================================
    // Helper: Get filters from current URL
    // ==========================================
    function getFiltersFromUrl() {
        const currentUrl = new URL(window.location);
        const filters = {};

        FILTER_KEYS.forEach(key => {
            const value = currentUrl.searchParams.get(key);
            if (value) filters[key] = value;
        });

        return { currentUrl, filters };
    }

    // ==========================================
    // AJAX Pagination
    // ==========================================
    $(document).on('click', '#properties-pagination a', function (e) {
        e.preventDefault();

        const url = $(this).attr('href');

        if (!url || url === '#' || $(this).hasClass('disabled')) return;

        const urlObj = new URL(url);
        const page = urlObj.searchParams.get('page');

        if (!page) return;

        const { currentUrl, filters } = getFiltersFromUrl();

        filters.page = page;

        currentUrl.searchParams.set('page', page);
        window.history.pushState({}, '', currentUrl);

        const scrollTarget = $('#properties-list').offset().top - 200;

        $('html, body').animate({
            scrollTop: scrollTarget
        }, 400, function () {
            sendFilterRequest(filters);
        });
    });

    // ==========================================
    // Sorting Handler
    // ==========================================
    $(document).on('click', '.dropdown-menu a[data-sort]', function (e) {
        e.preventDefault();

        const sortValue = $(this).data('sort');
        const sortText = $(this).text().trim();

        $('.current-options').text(sortText);

        const { currentUrl, filters } = getFiltersFromUrl();

        filters.sort = sortValue;

        delete filters.page;

        currentUrl.searchParams.set('sort', sortValue);
        currentUrl.searchParams.delete('page');
        window.history.pushState({}, '', currentUrl);

        sendFilterRequest(filters);

        $('.dropdown-toggle').dropdown('hide');
    });

});
