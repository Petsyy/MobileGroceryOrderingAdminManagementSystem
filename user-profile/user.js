$(document).ready(function () {
    $("#userContainer, #dropdownIcon").click(function (e) {
        e.stopPropagation(); // Prevents event bubbling
        $("#userContainer").toggleClass("active");
    });

    // Close dropdown when clicking outside
    $(document).click(function () {
        $("#userContainer").removeClass("active");
    });
});
