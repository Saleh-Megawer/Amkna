document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // CONSTANTS
    // ==========================================
    const FILTER_KEYS = ['city_id', 'neighborhood_id', 'property_type_id', 'purpose',
        'price_min', 'price_max', 'area_min', 'area_max', 'bedrooms', 'bathrooms', 'sort'];

    // 5) Lazy load images (lozad)
    if (typeof lozad !== 'undefined') {
        const observer = lozad('.lozad', {
            loaded: function (el) {
                el.classList.add('loaded');
            }
        });
        observer.observe();
    }


    // ==========================================
    // Utility: Re-initialize Lozad
    // ==========================================
    function reinitializeLozad() {
        if (typeof lozad !== 'undefined') {
            const observer = lozad('.lozad', {
                loaded: function (el) {
                    el.classList.add('loaded');
                }
            });
            observer.observe();
        }
    }



    /*
     **********************************
     ******* Mobile Filter Overlay & Open
     **********************************
     */
    // const overlay = document.getElementById('filtersOverlay');
    // const openBtn = document.getElementById('openFiltersBtn');
    // const closeBtn = document.getElementById('closeFiltersBtn');
    // const applyBtn = document.getElementById('applyFiltersBtn');

    // if (overlay && openBtn) {
    //     function openFilters() {
    //         overlay.classList.add('is-open');
    //         document.body.style.overflow = 'hidden';
    //     }

    //     function closeFilters() {
    //         overlay.classList.remove('is-open');
    //         document.body.style.overflow = '';
    //     }

    //     openBtn.addEventListener('click', openFilters);

    //     if (closeBtn) {
    //         closeBtn.addEventListener('click', closeFilters);
    //     }

    //     if (applyBtn) {
    //         applyBtn.addEventListener('click', function () {
    //             closeFilters();
    //         });
    //     }

    //     overlay.addEventListener('click', function (e) {
    //         if (e.target === overlay) {
    //             closeFilters();
    //         }
    //     });
    // }


    /*
    **********************************
    ******* Mobile Filter Overlay & Open
    **********************************
    */
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
                applyFilters('mobile');  // ✅ Apply filters first
                closeFilters();          // ✅ Then close overlay
            });
        }

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                closeFilters();
            }
        });
    }




    /*
     **********************************
     ******* Area Slide ( m2 )
     **********************************
     */
    const areaSliders = document.querySelectorAll('[data-slider="area"]');
    areaSliders.forEach(function (areaSlider) {

        const container = areaSlider.closest('.filter-group') || areaSlider.closest('.property-filters-wrapper');
        const areaMin = container.querySelector('.area-min');
        const areaMax = container.querySelector('.area-max');

        noUiSlider.create(areaSlider, {
            start: [10, 2000],
            connect: true,
            margin: 50,
            step: 10,
            range: { 'min': 10, 'max': 5000 }
        });

        areaSlider.noUiSlider.on('update', function (values) {
            areaMin.textContent = Math.round(values[0]);
            areaMax.textContent = Math.round(values[1]);
        });

    });


    // ==========================================
    // Start Apply Filters Function
    // ==========================================
    function applyFilters(source) {
        // Auto-detect source if not specified
        source = source || ($(window).width() > 768 ? 'desktop' : 'mobile');

        // Get the correct container
        const $container = source === 'desktop' ? $('#filtersSidebar') : $('#filtersOverlay');

        // Collect all filter values
        const filters = collectFilterValues($container);

        // Update browser URL
        updateBrowserURL(filters);

        // Send AJAX request
        sendFilterRequest(filters);
    }

    // Collect Filter Values from Container
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

        // Collect non-empty values only
        Object.entries(filterSelectors).forEach(([key, selector]) => {
            const value = $container.find(selector).val();
            if (value) filters[key] = value;
        });

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

    // Send AJAX Filter Request
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

                    // Re-initialize lazy loading
                    if (typeof reinitializeLozad === 'function') {
                        reinitializeLozad();
                    }

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
        // Initialize for each instance
        $('.location-search-input').each(function () {
            const $locationInput = $(this);
            const $parent = $locationInput.closest('.filter-group, .form-group');
            const $cityIdInput = $parent.find('.selected-city-id');
            const $neighborhoodIdInput = $parent.find('.selected-neighborhood-id');
            const $locationTypeInput = $parent.find('.selected-location-type');

            let typingTimer;
            const typingDelay = 300;

            // Create suggestions dropdown
            const $suggestionsDropdown = $('<ul class="location-suggestions"></ul>');
            $locationInput.parent().css('position', 'relative').append($suggestionsDropdown);

            // On input change
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

            // Display and select handlers
            function displaySuggestions(results, $dropdown) {
                $dropdown.empty();

                if (results.length === 0) {
                    $dropdown.hide();
                    return;
                }

                results.forEach(result => {
                    const $item = $('<li></li>')
                        .text(result.label)
                        .data('location', result)
                        .on('click', function () {
                            selectLocation($(this).data('location'));
                        });

                    $dropdown.append($item);
                });

                $dropdown.show();
            }

            function selectLocation(location) {
                $locationInput.val(location.name);
                $locationTypeInput.val(location.type);

                // Reset both IDs
                $cityIdInput.val('');
                $neighborhoodIdInput.val('');

                // Set the appropriate ID
                if (location.type === 'city') {
                    $cityIdInput.val(location.id);
                } else if (location.type === 'neighborhood') {
                    $neighborhoodIdInput.val(location.id);
                }

                $suggestionsDropdown.hide().empty();

                // Apply filter immediately (Desktop only)
                if ($(window).width() > 768) {
                    applyFilters();
                }
            }

            // Clear selection when input is cleared
            $locationInput.on('keyup', function () {
                if ($(this).val() === '') {
                    $cityIdInput.val('');
                    $neighborhoodIdInput.val('');
                    $locationTypeInput.val('');

                    // Clear filter
                    if ($(window).width() > 768) {
                        applyFilters();
                    }
                }
            });

            // Hide suggestions when clicking outside THIS instance
            $(document).on('click', function (e) {
                if (!$(e.target).closest($locationInput).length &&
                    !$(e.target).closest($suggestionsDropdown).length) {
                    $suggestionsDropdown.hide();
                }
            });
        });

        // Search locations via AJAX (shared function)
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

        function displaySuggestions(results, $dropdown) {
            $dropdown.empty();

            if (results.length === 0) {
                $dropdown.hide();
                return;
            }

            results.forEach(result => {
                const $item = $('<li></li>')
                    .text(result.label)
                    .data('location', result)
                    .on('click', function () {
                        // Find parent to get the correct inputs
                        const $clickedDropdown = $(this).parent();
                        const $parent = $clickedDropdown.closest('.filter-group, .form-group');
                        const $input = $parent.find('.location-search-input');
                        const $cityId = $parent.find('.selected-city-id');
                        const $neighborhoodId = $parent.find('.selected-neighborhood-id');
                        const $locationType = $parent.find('.selected-location-type');

                        const location = $(this).data('location');

                        $input.val(location.name);
                        $locationType.val(location.type);

                        $cityId.val('');
                        $neighborhoodId.val('');

                        if (location.type === 'city') {
                            $cityId.val(location.id);
                        } else if (location.type === 'neighborhood') {
                            $neighborhoodId.val(location.id);
                        }

                        $clickedDropdown.hide().empty();

                        if ($(window).width() > 768) {
                            applyFilters();
                        }
                    });

                $dropdown.append($item);
            });

            $dropdown.show();
        }
    })();



    // ==========================================
    // Property Type Filter
    // ==========================================
    $(document).on('click', '.select-property-type', function () {
        const $btn = $(this);
        const typeId = $btn.data('type-id');

        // Find parent container (Desktop or Mobile)
        const $container = $btn.closest('#filtersSidebar, #filtersOverlay');

        // Remove active from all buttons in this container
        $container.find('.select-property-type').removeClass('active');

        // Add active to clicked button
        $btn.addClass('active');

        // Store the selected type ID
        $container.find('.selected-property-type-id').val(typeId);

        // Apply filter (Desktop only)
        if ($(window).width() > 768 && $container.is('#filtersSidebar')) {
            applyFilters('desktop');
        }
    });


    // ==========================================
    // Purpose Filter (Sale/Rent)
    // ==========================================
    $(document).on('click', '.select-property-purpose', function () {
        const $btn = $(this);
        const purpose = $btn.data('purpose');

        // Find parent container (Desktop or Mobile)
        const $container = $btn.closest('#filtersSidebar, #filtersOverlay');

        // Remove active from all buttons in this container
        $container.find('.select-property-purpose').removeClass('active');

        // Add active to clicked button
        $btn.addClass('active');

        // Store the selected purpose
        $container.find('.selected-purpose').val(purpose);

        // Apply filter (Desktop only)
        if ($(window).width() > 768 && $container.is('#filtersSidebar')) {
            applyFilters('desktop');
        }
    });


    // ==========================================
    // Price Range Slider (noUiSlider)
    // ==========================================
    let filterDebounceTimer = null;

    function initRangeSlider(config) {
        $(config.selector).each(function () {

            const sliderElement = this;
            const $container = $(this).closest('#filtersSidebar, #filtersOverlay');
            const $minDisplay = $container.find(config.minDisplayClass);
            const $maxDisplay = $container.find(config.maxDisplayClass);
            const $minInput = $container.find(config.minInputClass);
            const $maxInput = $container.find(config.maxInputClass);

            const minValue = parseInt($(this).data('min')) || config.defaultMin;
            const maxValue = parseInt($(this).data('max')) || config.defaultMax;
            const rangeDiff = maxValue - minValue;

            let step = config.stepRanges.find(range => rangeDiff > range.threshold)?.step || config.stepRanges[config.stepRanges.length - 1].step;

            // ✅ جيب القيم من الـ hidden inputs لو موجودة
            const initialMin = parseInt($minInput.val()) || minValue;
            const initialMax = parseInt($maxInput.val()) || maxValue;

            noUiSlider.create(sliderElement, {
                start: [initialMin, initialMax],  // ✅ استخدم القيم الأولية
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

            // Update display on slide (instant)
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

            // Apply filter with debounce (delayed)
            sliderElement.noUiSlider.on('change', function () {
                if ($(window).width() > 768 && $container.is('#filtersSidebar')) {
                    clearTimeout(filterDebounceTimer);

                    filterDebounceTimer = setTimeout(function () {
                        applyFilters('desktop');
                    }, 800);
                }
            });
        });
    }

    // Price Slider
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

    // Area Slider
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
    // Bedrooms & Bathrooms Buttons
    // ==========================================
    $(document).on('click', '.select-property-number-room', function () {
        const $container = $(this).closest('#filtersSidebar, #filtersOverlay');

        // Remove active from siblings
        $(this).siblings('.select-property-number-room').removeClass('active');

        // Add active to clicked
        $(this).addClass('active');

        // Get value
        const value = $(this).text().trim();

        // Set hidden input
        if ($(this).index() === 0) {  // أول button = "الكل"
            $container.find('.selected-bedrooms').val('');
        } else {
            // Remove '+' if exists
            const cleanValue = value.replace('+', '');
            $container.find('.selected-bedrooms').val(cleanValue);
        }

        // Apply filters (Desktop only)
        if ($(window).width() > 768 && $container.is('#filtersSidebar')) {
            clearTimeout(filterDebounceTimer);
            filterDebounceTimer = setTimeout(function () {
                applyFilters('desktop');
            }, 300);
        }
    });


    // ==========================================
    // Bathrooms Buttons
    // ==========================================
    $(document).on('click', '.select-property-baths', function () {
        const $button = $(this);
        const $container = $button.closest('#filtersSidebar, #filtersOverlay');
        const $input = $container.find('.selected-bathrooms');

        // Remove active from all buttons in this container
        $container.find('.select-property-baths').removeClass('active');

        // Add active to clicked
        $button.addClass('active');

        // Get value
        const buttonText = $button.text().trim();

        // Check if it's first button (All)
        const isAllButton = $button.index() === 0;

        if (isAllButton) {
            $input.val('');
            console.log('Bathrooms: ALL (empty)');
        } else {
            const cleanValue = buttonText.replace('+', '');
            $input.val(cleanValue);
            console.log('Bathrooms:', cleanValue);
        }

        // Apply filters (Desktop only)
        if ($(window).width() > 768 && $container.is('#filtersSidebar')) {
            clearTimeout(filterDebounceTimer);
            filterDebounceTimer = setTimeout(function () {
                applyFilters('desktop');
            }, 300);
        }
    });



    // ==========================================
    // AJAX Pagination
    // ==========================================
    $(document).on('click', '#properties-pagination a', function (e) {
        e.preventDefault();

        const url = $(this).attr('href');

        if (!url || url === '#' || $(this).hasClass('disabled')) return;

        // Get page number from URL
        const urlObj = new URL(url);
        const page = urlObj.searchParams.get('page');

        if (!page) return;

        // Get current filters from URL
        const currentUrl = new URL(window.location);
        const filters = {};


        FILTER_KEYS.forEach(key => {
            const value = currentUrl.searchParams.get(key);
            if (value) filters[key] = value;
        });

        // Add page number
        filters.page = page;

        // Update URL
        currentUrl.searchParams.set('page', page);
        window.history.pushState({}, '', currentUrl);

        // ✅ Scroll first, then load
        const scrollTarget = $('#properties-list').offset().top - 200;

        $('html, body').animate({
            scrollTop: scrollTarget
        }, 400, function () {
            // ✅ Send request after scroll completes
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

        // ✅ Update button text
        $('.current-options').text(sortText);

        // ✅ Get current filters
        const urlParams = new URLSearchParams(window.location.search);
        const filters = {};

        FILTER_KEYS.forEach(key => {
            const value = urlParams.get(key);
            if (value) filters[key] = value;
        });

        // ✅ Add sort parameter
        filters.sort = sortValue;

        // ✅ Reset to page 1
        delete filters.page;

        // ✅ Update URL
        const url = new URL(window.location);
        url.searchParams.set('sort', sortValue);
        url.searchParams.delete('page');
        window.history.pushState({}, '', url);

        // ✅ Send AJAX request
        sendFilterRequest(filters);

        // Close dropdown
        $('.dropdown-toggle').dropdown('hide');
    });






});



