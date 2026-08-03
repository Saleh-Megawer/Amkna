// // public/assets/js/notifications.js

// (function () {
//     'use strict';


//     let lastCount = 0;

//     // دالة جلب عدد الإشعارات
//     let lastInterestsCount = 0;
//     let lastOwnerRequestsCount = 0;
//     let lastDealFollowUpCount = 0;

//     function checkNotifications() {
//         $.ajax({
//             url: adminUrl + '/notifications/count',
//             method: 'GET',
//             dataType: 'json',
//             success: function (response) {

//                 let playSound = false;


//                 // إشعارات الاهتمامات
//                 if (response.deals_follow_ups !== undefined) {
//                     updateNotificationBadge(response.deals_follow_ups);
//                     // if (response.deals_follow_ups > lastDealFollowUpCount && lastDealFollowUpCount !== 0) {
//                     //     playSound = true;
//                     // }
//                     lastDealFollowUpCount = response.deals_follow_ups;
//                 }

//                 // إشعارات الاهتمامات
//                 if (response.interests !== undefined) {
//                     updateNotificationBadge(response.interests);

//                     if (response.interests > lastInterestsCount && lastInterestsCount !== 0) {
//                         playSound = true;
//                     }
//                     lastInterestsCount = response.interests;
//                 }

//                 // إشعارات طلبات الملاك
//                 if (response.owner_requests !== undefined) {
//                     if (response.owner_requests > 0) {
//                         $('.aside-owner-associations-requests-count')
//                             .text(response.owner_requests)
//                             .removeClass('display-none');
//                     } else {
//                         $('.aside-owner-associations-requests-count')
//                             .addClass('display-none');
//                     }

//                     if (response.owner_requests > lastOwnerRequestsCount && lastOwnerRequestsCount !== 0) {
//                         playSound = true;
//                     }
//                     lastOwnerRequestsCount = response.owner_requests;
//                 }

//                 // شغّل الصوت لو في أي إشعار جديد
//                 if (playSound) {
//                     AppConfig.playSound('notification');
//                 }
//             },
//             error: function (xhr) {
//                 console.error('فشل جلب الإشعارات:', xhr);
//             }
//         });
//     }



//     // تحديث الـ Badge
//     function updateNotificationBadge(count) {
//         const $badge = $('#navbar #notifications .count'),
//             $badgeAsideInterests = $('.aside-interests-count'),
//             $badgeAsideDealsFollowUps = $('.aside-deals-follow-ups-count');


//         if (count > 0) {
//             $badge.text(count).show();
//             $badgeAsideInterests.text(count).show();
//             $badgeAsideDealsFollowUps.text(count).show();
//         } else {
//             $badge.hide();
//             $badgeAsideInterests.hide();
//             $badgeAsideDealsFollowUps.hide();
//         }
//     }

//     checkNotifications();
//     setInterval(checkNotifications, 30000);

// })();

(function () {
    'use strict';

    const lastCounts = {};

    const notificationMap = {
        interests: {
            selectors: [
                '#navbar #notifications .count',
                '.aside-interests-count'
            ]
        },
        owner_requests: {
            selectors: [
                '.aside-owner-associations-requests-count'
            ]
        },
        deals_follow_ups: {
            selectors: [
                '.aside-deals-follow-ups-count'
            ]
        }
    };

    function checkNotifications() {
        $.getJSON(adminUrl + '/notifications/count', function (response) {

            let playSound = false;

            Object.entries(response).forEach(([key, data]) => {

                const count = data.count;
                const last = lastCounts[key] || 0;

                updateBadges(notificationMap[key]?.selectors, count);

                if (count > last && last !== 0) {
                  //  playSound = true;
                }

                lastCounts[key] = count;
            });

            // if (playSound) {
            //     AppConfig.playSound('notification');
            // }

        });
    }

    function updateBadges(selectors = [], count) {
        selectors.forEach(selector => {
            const $el = $(selector);

            if (!$el.length) return;

            if (count > 0) {
                $el.text(count).removeClass('display-none').show();
            } else {
                $el.addClass('display-none').hide();
            }
        });
    }

    checkNotifications();
    setInterval(checkNotifications, 30000);

})();
