// ================================
// Global helpers
// ================================
const meta = name => $(`meta[name="${name}"]`).attr('content');
const dealUuidMeta = () => meta('deal-uuid');
const csrfToken = () => meta('csrf-token');

$(document).ready(function () {


    // ================================
    // Global helpers
    // ================================
    const post = (url, data, onSuccess, errorMsg = 'Something went wrong', onFail = null) => {
        $.post(adminUrl + url, { ...data, _token: csrfToken() }, onSuccess)
            .fail(xhr => {
                iziToast.error({
                    message: xhr.responseJSON?.message || errorMsg
                });
                if (onFail) onFail();
            });
    };

    const showLoader = (container, height = 200) => {
        container.fadeOut(200, function () {
            $(this)
                .html(`
                    <div style="min-height:${height}px;"
                         class="pb-4 text-center col-12 d-flex align-items-center justify-content-center">
                        جاري التحميل...
                    </div>
                `)
                .fadeIn(200);
        });
    };

    const getDealUuid = () =>
        $("#matched-properties-container").data('deal-uuid') || dealUuidMeta();

    const togglePropertyButtons = (btn, attached) => {
        btn.prop('disabled', false).toggle(!attached);
        btn.siblings('.remove-property-from-deal')
            .prop('disabled', false)
            .toggle(attached);
        btn.siblings('.assign-badge-status')
            .toggle(attached);
    };

    // ================================
    // Collect filters
    // ================================

    const collectFilters = () => ({
        deal_uuid: dealUuidMeta(),
        client_id: $('[name="client_id"]').val(),
        city_id: $('[name="city_id"]').val(),
        neighborhood_id: $('[name="neighborhood_id"]').val(),
        budget_min: $('[name="budget_min"]').val(),
        budget_max: $('[name="budget_max"]').val(),
        area_min: $('[name="area_min"]').val(),
        area_max: $('[name="area_max"]').val(),
        bedrooms: $('[name="bedrooms"]').val(),
        bathrooms: $('[name="bathrooms"]').val(),
        purpose: $('[name="purpose"]').val(),
        neighborhoods: $('[name="neighborhoods[]"]').val(),
    });

    // ================================
    // Match properties
    // ================================

    $('#btn-match-properties').on('click', function () {
        const container = $("#matched-properties-container");
        container.data('deal-uuid', dealUuidMeta());
        showLoader(container);

        post('/crm/deals/match-properties', collectFilters(), response => {
            container.fadeOut(300, function () {
                $(this).html(response).fadeIn(600);
            });
        }, 'فشل تحميل النتائج');
    });

    // ================================
    // Attach property to deal
    // ================================

    $(document).on('click', '.add-property-to-deal', function () {
        const btn = $(this);
        const dealUuid = getDealUuid();

        if (!dealUuid) {
            iziToast.error({ message: 'Deal not selected' });
            return;
        }

        btn.prop('disabled', true);

        post(
            '/crm/deals/add-property',
            {
                property_id: btn.data('property-id'),
                deal_uuid: dealUuid
            },
            () => {
                iziToast.success({ message: 'Property linked successfully' });
                togglePropertyButtons(btn, true);
            },
            'فشل ربط الوحدة مع الصفقة',
            () => btn.prop('disabled', false)
        );
    });

    // ================================
    // Remove property from deal
    // ================================
    $(document).on('click', '.remove-property-from-deal', function () {
        const btn = $(this);
        const dealUuid = getDealUuid();

        if (!dealUuid) {
            iziToast.error({ message: 'Deal not selected' });
            return;
        }

        btn.prop('disabled', true);

        post(
            '/crm/deals/remove-property',
            {
                property_id: btn.data('property-id'),
                deal_uuid: dealUuid
            },
            () => {
                iziToast.success({ message: 'Property removed successfully' });
                togglePropertyButtons(btn, false);
            },
            'فشل إزالة الوحدة من الصفقة',
            () => btn.prop('disabled', false)
        );
    });

    // ================================
    // Show only linked properties
    // ================================

    $('#btn-show-matched-properties-only').on('click', function () {
        const container = $("#matched-properties-container");
        const dealUuid = dealUuidMeta();
        container.data('deal-uuid', dealUuid);
        showLoader(container, 400);

        post(
            '/crm/deals/show-linked-properties',
            { deal_uuid: dealUuid },
            response => {
                container.fadeOut(200, function () {
                    $(this).html(response).fadeIn(400);
                });
            },
            'فشل تحميل الوحدات المرتبطة'
        );
    });

    // ================================
    // AJAX Pagination
    // ================================

    $(document).on('click', '.ajax-pagination .pagination a', function (e) {
        e.preventDefault();

        const url = $(this).attr('href');
        const container = $("#matched-properties-container");
        const page = new URL(url).searchParams.get('page');

        showLoader(container);

        const filters = { ...collectFilters(), page: page };

        post('/crm/deals/match-properties', filters, response => {
            container.fadeOut(200, function () {
                $(this).html(response).fadeIn(400);
            });
        });

        $('html, body').animate({
            scrollTop: container.offset().top - 150
        }, 1000);
    });



    // ================================
    // Chats
    // ================================
    $(document).on('click', '.btn-edit-chat', function () {
        let chatId = $(this).data('chat-id');

        $.ajax({
            url: adminUrl + `/crm/deals/${dealUuidMeta()}/chats/${chatId}/show`,
            type: 'GET',
            success: function (response) {
                if (response.status === 'success') {
                    $('#editChatModal').remove();
                    $('body').append(response.html);
                    $('#editChatModal').modal('show');
                }
            },
            error: function () {
                iziToast.error({ message: 'حدث خطأ أثناء تحميل البيانات' });
            }
        });
    });




    // ================================
    // Change Status
    // ================================
    $(document).on('click', '.btn-change-deal-status', function () {

        const btn = $(this);
        const dealUuid = getDealUuid();

        if (!dealUuid) {
            iziToast.error({ message: 'Deal not selected' });
            return;
        }

        btn.prop('disabled', true);

        post(`/crm/deals/update-status/${dealUuid}`,
            {
                status: btn.data('status')
            },
            () => {
                iziToast.success({ message: 'تم تحديث حالة الصفقة بنجاح' });

                $('.btn-change-deal-status').prop('disabled', false);

                $('.btn-change-deal-status').each(function () {
                    this.className = this.className.replace(/btn-(success|danger|info)/g, 'btn-outline-$1');
                });

                btn[0].className = btn[0].className.replace(/btn-outline-(success|danger|info)/g, 'btn-$1');
            },
            'فشل تحديث حالة الصفقة',
            () => $('.btn-change-deal-status').prop('disabled', false)
        );

    });





});
