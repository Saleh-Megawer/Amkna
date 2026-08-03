import { swalDelete } from "../../modules/delete-functions.js";
$(document).ready(function () {
    // Run
    swalDelete();

    // Append Notification Sound
    function notificationSound() {
        $("body").append(`<audio autoplay>
        <source src="${
            baseUrl + "/dashboard/audios/Notification.mp3"
        }" type="audio/mp3">
        </audio>`);
    }

    /*
    |
    | Inbox Page
    |
    */
    // Check All
    let checkboxInputs = document.querySelectorAll(".checkboxes input");
    let inputCheckedAll = document.getElementById("input-checked-all");

    function isChecked() {
        for (let i = 0; i < checkboxInputs.length; i++) {
            $(checkboxInputs[i]).click(function () {
                // Check IF This Input Cheked
                if (checkboxInputs[i].checked == false) {
                    $(checkboxInputs[i]).removeAttr("checked");
                }
            });
        }
    }
    isChecked();
    function checkedAll() {
        $(inputCheckedAll).click(function (e) {
            if (inputCheckedAll.checked) {
                $(checkboxInputs).attr("checked", "checked");
            } else {
                $(checkboxInputs).removeAttr("checked");
            } // End Else
        });
    }
    checkedAll();

    //Refresh load latest
    $("#refresh").click(function (e) {
        let url = adminUrl + "/mail/load-latest";
        $(".overlay").show(0);
        $("#mails-body").load(
            url,
            { method: "POST" },
            function (response, status, request) {
                $(this).empty();
                $(this).html(response);
                $(".overlay").hide();
            }
        );
    });

    /*
    |
    | Read Page
    |
    */
    $("#btn-reply").click(function (e) {
        $("#reply").show();
    });
});
