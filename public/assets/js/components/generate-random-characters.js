// Generate Random Password
function generatePassword(length = 16) {
    $(".generate-random").click(function (e) {
        let chars =
                "abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$@%^&!$*%^&",
            strLength = length,
            password = "",
            i = 0;

        for (i; i <= strLength; i++) {
            let randomNumber = Math.floor(Math.random() * chars.length); // Gen.. Random Number
            password += chars.substring(randomNumber, randomNumber + 1); // Search By This Random Number And Get After It a Letters
        }
        $(".accept-random").val(password); // Set The Values
    });
}
generatePassword();
