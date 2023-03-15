$(document).ready(function () {
    $('.nav li a').click(function (event) {
        $('.active').removeClass('active');
        $(this).addClass('active');
        let state = $(this).attr('data-id');
        if (state === "home") {
            $('#home').show();
            $('#groups').hide();
            $('#users').hide();
            $('#navbarToggler').removeClass("show");
        } else
            if (state === "users") {
                $('#home').hide();
                $('#groups').hide();
                $('#users').show();
                $('#navbarToggler').removeClass("show");
            } else
                if (state === "groups") {
                    $('#home').hide();
                    $('#groups').show();
                    $('#users').hide();
                    $('#navbarToggler').removeClass("show");
                }
        event.preventDefault();
    });
});