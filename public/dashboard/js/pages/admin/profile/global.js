export function sendVerifyEmail(btnClick) {
    $(btnClick).click(function () {
        $.post(
            adminUrl + "profile/verify-email",
            function (data, textStatus, jqXHR) {
                console.log(data);
                console.log(textStatus);
                console.log(jqXHR);
            },
            "json"
        );
    });
}
