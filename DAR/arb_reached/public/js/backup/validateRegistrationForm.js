$(document).ready(function () {
    $flag = 1;
    $("#first_name").focusout(function () {
        if ($(this).val() == '') {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_first_name").text("* You have to a your first name!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_first_name").text("");

        }
    });
    $("#middle_name").focusout(function () {
        if ($(this).val() == '') {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_middle_name").text("* You have to a your middle name!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_middle_name").text("");
        }
    });
    $("#last_name").focusout(function () {
        if ($(this).val() == '') {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_last_name").text("* You have to enter a last name!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_last_name").text("");
        }
    });

    function validateEmail(sEmail) {
        var filter = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/;
        if (filter.test(sEmail)) {
            return true;
        } else {
            return false;
        }
    }
    $("#email").focusout(function () {
        var sEmail = $('#email').val();
        if ($.trim(sEmail).length == 0) {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_email").text("Please enter valid email address");

            e.preventDefault();
        }
        if (validateEmail(sEmail)) {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_email").text("");;
        } else {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_email").text("Invalid email address");
            e.preventDefault();
        }
    });
    $("#phone").focusout(function () {
        var phone = $(this).val();
        var stripped = phone.replace(/[\(\)\.\-\ ]/g, '');
        if(isNaN(parseInt(stripped))){
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_phone").text("* Please provide a correct phone number!");
        }
        else if($(this).val().length == 0){
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_phone").text("* You have to enter a phone number!");
        }
        else if($(this).val().length != 11){
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_phone").text("* Please provide a correct phone number!");
        }else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_phone").text("");
        }
    });
    $("#province").focusout(function () {
        var addd = ($("#province").prop('selectedIndex'));
        if (addd == 'Province') {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_province").text("* You have to select a Province!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_province").text("");
        }
    });
    $("#city").focusout(function () {
        if ($(this).val() == 'City') {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_city").text("* You have to select a City!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_city").text("");
        }
    });
    $("#barangay").focusout(function () {
        if ($(this).val() == 'Barangay') {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_barangay").text("* You have to select a Barangay!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_barangay").text("");
        }
    });
    $("#position").focusout(function () {
        if ($(this).val() == 'Position') {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_position").text("* You have to enter a Position!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_position").text("");
        }
    });

    $("#username").focusout(function () {
        if ($(this).val() == '') {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_username").text("* You have to enter a Username!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_username").text("");
        }
    });
    $("#password").focusout(function () {
        if ($(this).val() == '') {
            $(this).css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_password").text("* You have to enter a Password!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_password").text("");
        }
    });
    $("#confirm").focusout(function () {
        if ($("#confirm").val() !== $("#password").val()) {
            $("#confirm").css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_confirm").text("Passwords Do not match!");
        } else {
            $(this).css("border-color", "#2eb82e");
            $('#register').attr('disabled', false);
            $("#error_confirm").text("");
        }
    });

    $("#register").click(function () {
        if ($("#first_name").val() == '') {
            $("#first_name").css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_first_name").text("* You have to enter a first name!");
        }
        if ($("#middle_name").val() == '') {
            $("#middle_name").css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_middle_name").text("* You have to enter a Middle name!");
        }
        if ($("#last_name").val() == '') {
            $("#last_name").css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_last_name").text("* You have to enter a Last name!");
        }
        
        if ($("#email").val() == '') {
            $("#email").css("border-color", "#FF0000");
            $('#register').attr('disabled', true);
            $("#error_email").text("* You have to enter an Email  !");
        }
        if ($("#phone").val() == '') {
            $("#phone").css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_phone").text("* You have to enter a Phone number!");
        }
        if (addd == 'Province') {
            $("#province").css("border-color", "#FF0000");
            $('#register').attr('disabled', true);
            $("#error_province").text("* You have to select a Province!");
        }
        if ($("#city").val() == '') {
            $("#city").css("border-color", "#FF0000");
            $('#register').attr('disabled', true);
            $("#error_city").text("* You have to select a City!");
        }
        if ($("#barangay").val() == '') {
            $("#barangay").css("border-color", "#FF0000");
            $('#register').attr('disabled', true);
            $("#error_barangay").text("* You have to select a Barangay!");
        }
        if ($("#position").val() == '') {
            $("#position").css("border-color", "#FF0000");
            $('#register').attr('disabled', true);
            $("#error_position").text("* You have to select a Position!");
        }
        if ($("#username").val() == '') {
            $("#username").css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_username").text("* You have to enter a Username!");
        }
        if ($("#password").val() == '') {
            $("#password").css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_password").text("Enter a Password");
        }
        if ($("#confirm").val() == '') {
            $("#confirm").css("border-color", "#cd2d00");
            $('#register').attr('disabled', true);
            $("#error_confirm").text("Confirm Password");
        }

    });


});