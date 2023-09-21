$(document).ready(function() {
    generateCaptcha();

    $("#malipoform").on("submit", function(e) {
        if (!validateCaptcha()) {
            e.preventDefault();
        }
    });
    // Remove the 'failed' class when the user starts typing in the captcha input
    $("#captcha-input").on("input", function() {
        $("#captcha-text").removeClass("failed");
        $(this).removeClass("is-invalid");
    });
});

function generateCaptcha() {
    let captchaLength = 6;
    let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let captcha = '';

    for (let i = 0; i < captchaLength; i++) {
        let randomIndex = Math.floor(Math.random() * characters.length);
        captcha += characters[randomIndex];
    }

    $("#captcha-text").text(captcha);
}

// ... (rest of the code)
function validateCaptcha() {
    let captchaText = $("#captcha-text").text();
    let captchaInput = $("#captcha-input");

    if (captchaText === captchaInput.val()) {
        captchaInput.removeClass("is-invalid");
        return true;
    } else {
        $("#captcha-text").addClass("failed"); // Make the captcha text red
        captchaInput.addClass("is-invalid");
        $("#captcha-text").addClass("shake");
        setTimeout(function() {
            $("#captcha-text").removeClass("shake");
        }, 500);    // Apply Bootstrap's invalid styling to the input
        generateCaptcha();
        return false;
    }
}










