$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// المتغيرات العامة
let lang = $("html").attr("lang"),
    baseUrl = $('meta[name="url"]').attr("content"),
    adminUrl = $('meta[name="admin-url"]').attr("content");

// إعدادات المشروع
const AppConfig = {
    // المتغيرات الأساسية
    lang: lang,
    baseUrl: baseUrl,
    adminUrl: adminUrl,

    // الأصوات
    sounds: {
        notification: baseUrl + '/assets/sounds/notification.mp3',
        //     success: baseUrl + '/assets/sounds/success.mp3',
        //    error: baseUrl + '/assets/sounds/error.mp3',
    },

    // تشغيل الصوت
    playSound: function (soundKey) {
        const audio = new Audio(this.sounds[soundKey]);
        audio.play().catch(err => console.log('Cannot play sound:', err));
    }
};

window.AppConfig = AppConfig;


////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////




// 
$("#city_id").change(function (e) {
    let target = $(this),
        targetSelectBox = target.attr('data-target'),
        neighborhoodSelect = document.querySelector("#neighborhood_id");

    if (targetSelectBox != undefined && targetSelectBox != '') {
        neighborhoodSelect = document.querySelector(`.${targetSelectBox}`);
    }

    $.post(
        target.attr("data-url-get-neighborhoods"),
        { city_id: target.val() },
        function (data) {

            const choicesInstance = neighborhoodSelect.choicesInstance;

            // تحقق هل العنصر مرتبط بـ Choices.js
            if (choicesInstance) {


                // مسح الخيارات القديمة
                choicesInstance.removeActiveItems();
                choicesInstance.clearChoices();

                // إضافة خيار فارغ (placeholder)
                choicesInstance.setChoices([{
                    value: '',
                    label: 'اختر المنطقة',
                    disabled: true,
                }], 'value', 'label', true);


                if (data.status === "empty") {
                    return iziToast.warning({ message: data.message });
                }

                const newOptions = data.map(item => ({
                    value: item.id,     // الvalue = id
                    label: item.name    // اللي بيتعرض = الاسم
                }));


                choicesInstance.setChoices(newOptions, 'value', 'label', false);

            } else {
                // Select عادي بدون المكتبة
                const $neighborhoodSelect = $('#neighborhood_id');
                $neighborhoodSelect.empty();
                $neighborhoodSelect.append('<option value="">اختر المنطقة</option>');

                if (data.status === "empty") {
                    return iziToast.warning({ message: data.message });
                }

                $.each(data, function (name, id) {
                    let newOption = new Option(name, id, false, false);
                    $neighborhoodSelect.append(newOption);
                });
                $neighborhoodSelect.trigger('change');
            }



        },
        "json"
    );
});


// show-full-text
$(document).ready(function () {

    // Create modal once
    if ($('#dynamicTextModal').length === 0) {
        $('body').append(`
            <div class="modal fade" id="dynamicTextModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header d-none">
                            <h5 id="dynamicModalTextHeader" class="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div style="white-space: pre-line" class="modal-body pb-3" id="dynamicTextContent"></div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-main" data-dismiss="modal">إغلاق</button>
                        </div>

                    </div>
                </div>
            </div>
        `);
    }

    // Click handler
    $(document).on('click', '.show-full-text', function () {

        const fullText = $(this).data('text');
        const fullHeaderTitle = $(this).data('title');

        // Handle header visibility
        if (fullHeaderTitle) {
            $('#dynamicModalTextHeader').text(fullHeaderTitle);
            $('#dynamicTextModal .modal-header').removeClass('d-none');
        } else {
            $('#dynamicTextModal .modal-header').addClass('d-none');
        }

        $('#dynamicTextContent').text(fullText);
        $('#dynamicTextModal').modal('show');
    });

});




////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
function clientSearch() {
    const DELAY = 800;
    let timer = null;

    $(document).on('input', '.client-search-input', function () {
        const input = $(this);
        const wrapper = input.closest('.client-search');
        const results = wrapper.find('.client-search-results');
        const keyword = input.val().trim();

        if (keyword.length < 2) {
            results.empty().hide();
            return;
        }

        clearTimeout(timer);

        timer = setTimeout(() => {
            $.get(adminUrl + '/crm/clients/search-by-name-or-phone', {
                q_name_or_phone: keyword
            }, function (data) {
                results.empty();

                if (!data.length) {
                    results.append(`
                        <div class="client-search-no-results">
                            لا توجد نتائج
                        </div>
                    `);
                    results.show();
                    return;
                }

                data.forEach(client => {
                    results.append(`
                        <div class="client-search-item" data-id="${client.id}">
                            ${client.name} — ${client.phone}
                        </div>
                    `);
                });

                results.show();
            });
        }, DELAY);
    });

    // اختيار عميل من النتائج
    $(document).on('click', '.client-search-item', function () {
        const item = $(this);
        const wrapper = item.closest('.client-search');

        wrapper.find('.client-search-input').val(item.text().trim());
        wrapper.find('.client-search-value').val(item.data('id'));
        wrapper.find('.client-search-results').hide();
    });

    // مسح الاختيار
    $(document).on('click', '.client-search-clear', function () {
        const wrapper = $(this).closest('.client-search');

        wrapper.find('.client-search-input').val('');
        wrapper.find('.client-search-value').val('');
        wrapper.find('.client-search-results').hide();

        wrapper.find('.client-search-input').focus();
    });

    // إخفاء النتائج عند النقر خارجها
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.client-search').length) {
            $('.client-search-results').hide();
        }
    });

}

clientSearch();












////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
// function initOwnerAssociationClientSearch() {

//     // Namespace selector
//     const OA_WRAPPER = '.owner-association-client-search';

//     // Inner selectors (local)
//     const BOX = '.client-search-box';
//     const INPUT = '.search-client';
//     const RESULTS = '.client-results';
//     const ITEM = '.client-item';

//     const CLIENT_SEARCH_DELAY = 1000;

//     let timer = null;

//     $(document).on('keyup', `${OA_WRAPPER} ${INPUT}`, function () {


//         const box = $(this).closest(BOX);
//         const results = box.find(RESULTS);
//         const keyword = $(this).val().trim();

//         if (keyword.length < 2) {
//             results.hide().empty();
//             return;
//         }

//         clearTimeout(timer);

//         timer = setTimeout(() => {
//             $.get(adminUrl + '/crm/clients/search-by-name-or-phone', {
//                 q_name_or_phone: keyword
//             }, function (data) {

//                 results.empty();

//                 if (!data.length) {
//                     results.hide();
//                     return;
//                 }

//                 data.forEach(client => {
//                     results.append(`
//                         <div class="${ITEM.replace('.', '')}" data-id="${client.id}">
//                             ${client.name} — ${client.phone}
//                         </div>
//                     `);
//                 });

//                 results.show();
//             });
//         }, CLIENT_SEARCH_DELAY);
//     });

//     // Click on result
//     $(document).on('click', `${OA_WRAPPER} ${ITEM}`, function () {

//         const box = $(this).closest(BOX);
//         const clientId = $(this).data('id');

//         box.find(INPUT).val($(this).text().trim());
//         box.closest(OA_WRAPPER).find('#hidden-manager-client-id-input').val(clientId);


//         box.find(RESULTS).hide();

//         console.log(clientId);

//     });
// }