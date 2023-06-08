function togglePasswordVisibility(inputId, eyeIcon) {
    var passwordInput = document.getElementById(inputId);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}

function toggleExtraFields(show) {
    var extraFields = document.getElementById("extra-fields");
    var inputs = extraFields.querySelectorAll("option");
    if (show) {
        extraFields.style.display = "block";
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].required = true;
        }
    } else {
        extraFields.style.display = "none";
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].required = false;
        }
    }
}

// function toggleExtraFields(show) {
//     var extraFields = document.getElementById("extra-fields");
//     if (show) {
//         extraFields.style.display = "block";
//     } else {
//         extraFields.style.display = "none";
//     }
//
