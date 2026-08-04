(function () {
    "use strict";

    var url = window.dashboardHeartbeatUrl;

    if (!url) {
        return;
    }

    var INTERVAL = 60000;
    var lastSent = 0;
    var stopped = false;
    var timer = null;

    function csrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');

        return meta ? meta.content : "";
    }

    function ping() {
        if (stopped || document.hidden || Date.now() - lastSent < INTERVAL) {
            return;
        }

        lastSent = Date.now();

        fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken(),
                "Accept": "application/json",
            },
            credentials: "same-origin",
        }).then(function (response) {
            if (response.status === 401) {
                stopped = true;

                if (timer) {
                    clearInterval(timer);
                }
            }
        }).catch(function () {});
    }

    window.addEventListener("load", ping);
    window.addEventListener("pageshow", ping);

    document.addEventListener("visibilitychange", function () {
        if (document.visibilityState === "visible") {
            ping();
        }
    });

    document.addEventListener("submit", ping);
    document.addEventListener("click", ping);
    document.addEventListener("keydown", ping);

    timer = setInterval(function () {
        if (!document.hidden) {
            ping();
        }
    }, INTERVAL);
})();
