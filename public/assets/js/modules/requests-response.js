/**
 * This Function Will Be Check If The Request Response Have Message Or Set Default Message !
 * @param {*} responseMessage
 * @param {*} autoSetMessage
 * @returns
 */
export function checkMessage(
    responseMessage = null,
    autoSetMessage = "Message Not Set !"
) {
    // IF Not Have Message Set Default
    if (responseMessage == null) {
        return autoSetMessage;
    } else {
        return responseMessage;
    }
}

/**
 * before send request set attr in target button
 * disabled and ...
 * @param {*} submitButton
 */
export function beforeSendRequest(submitButton) {
    $(submitButton).addClass("progress-bar-striped progress-bar-animated");
    $(submitButton).attr("disabled", "");
}

/**
 * @param {*} data Response Status Return Data From Request
 * @param {*} form Get From Target ID Or Class Name
 * @param {*} resultBox Result Box In DOM For Append Message
 */
export function responseStatus(data, form = null, resultBox = ".result .row") {
    // Remove All Errors Messages
    $(".error").remove();
    // Empty The Result Box Message
    $(resultBox).empty();

    // Response Main Data
    let message = data.message,
        status = data.status,
        resetForm = data.reset,
        style = data.style,
        reload = data.reload,
        redirect = data.redirect,
        timeOut = data.time_out;

    // Set ICON Style
    let icon = "";

    switch (status) {
        case "success":
            icon = `<i class="fa-solid fa-circle-check"></i>`;
            break;
        case "notfound":
            icon = `<i class="fa-solid fa-ban"></i>`;
            break;
        default:
            icon = `<i class="fa-solid fa-triangle-exclamation"></i>`;
            break;
    }

    /**
     * Check The Response Status
     */
    checkResponseStyle(style, resultBox, message, icon, status);

    // Reload
    if (reload == true) {
        setTimeout(function () {
            location.reload();
        }, timeOut * 1000);
    }

    // Redirect
    if (redirect != null) {
        setTimeout(function () {
            window.location.href = redirect;
        }, timeOut * 1000);
    }

    // Reset Form
    if (form != null && resetForm == true) {
        $(form).trigger("reset");
    }
}

/**
 * @param {*} dataErrors Return Data Errors For This Request
 * @param {*} exception Error
 */
export function errorRequest(dataErrors, exception) {
    $(".error").remove();
    if (exception == "error") {
        $.each(dataErrors.responseJSON.errors, function (key, value) {
            if (key.split(".").length >= 2) {
                // Split Name
                let keySplit = key.split("."),
                    keyName = keySplit[0],
                    keyIndex = parseInt(keySplit[1]);

                // Element
                let targetElement = document.querySelectorAll(
                    `[data-name="${keyName}"]`
                )[keyIndex];

                if (targetElement == undefined) {
                    // For laravel-translatable ar[name]
                    let elemName =
                        keyName + "-" + keySplit[1] + "-lara-trans-error";

                    let targetElement = document.querySelectorAll(
                        `[data-laravel-translatable="${elemName}"]`
                    );

                    $(targetElement).after(`<div class='error'>${value}</div>`);

                } else {
                    // For array like this name[]
                    $(targetElement).after(`<div class='error'>${value}</div>`);
                }
            } else {
                $("input[name=" + key + "]").after(
                    `<div class='error'>${value}</div>`
                );
                $("select[name=" + key + "]").after(
                    `<div class='error'>${value}</div>`
                );
                $("textarea[name=" + key + "]").after(
                    `<div class='error'>${value}</div>`
                );
            }
        });

        // Get All ERRORS IN PAGE
        let errors = document.querySelectorAll(".error"),
            minusHeight = $(".main-navbar").height() + 115;
        if (errors.length > 0) {
            $("html").animate(
                {
                    scrollTop: $(errors[0]).offset().top - minusHeight,
                },
                0
            );
        }
    }
}

/**
 * before send request set attr in target button
 * disabled and ...
 * @param {*} submitButton
 */
export function completeRequest(submitButton) {
    $(submitButton).removeAttr("disabled");
    $(submitButton).removeClass("progress-bar-striped progress-bar-animated");
    // console.clear();
}

/**
 * Check Response Style For Set To DOM
 * @param {*} respStyle Response Style If Custom Style Or External Plugins Like (toastr.js)
 * @param {*} resultBox This Param Get Div From DOM To Set Response
 * @param {*} respMessage Response Message
 * @param {*} respIcon Response Icon Like From
 * @param {*} respStatus
 */
function checkResponseStyle(
    respStyle,
    resultBox,
    respMessage,
    respIcon,
    respStatus
) {
    // Check IF Need Style Alert Or Box
    if (respStyle == "toastr") {
        switch (respStatus) {
            case "success":
                toastr.success(respMessage);
                break;

            case "warning":
            case "notfound":
                toastr.warning(respMessage);
                break;

            case "error":
                toastr.error(respMessage);
                break;

            case "info":
                toastr.info(respMessage);
                break;

            default:
                toastr.warning(
                    "This " +
                    respStatus +
                    " Toastr Style Not Exist In Library ! Choose From This ( success , warning , error )"
                );
                break;
        }
    } else {
        $(resultBox).append(box(respMessage, respStatus, respIcon));
    }
}

// Custom Box
function box(boxMessage, boxStyle, boxIcon) {
    // Back To Top
    $(window).scrollTop(0);
    return `<div class="col-12"> <div class="mt-3 alert alert-box-${boxStyle} alert-dismissible fade show" role="alert">${boxIcon + boxMessage
        }<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div></div>`;
}
