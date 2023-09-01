(function ($) {
    "use strict";

    // Preload
    $(window).on("load", function () {
        // makes sure the whole site is loaded
        $('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
        $("#preloader").delay(350).fadeOut("slow"); // will fade out the white DIV that covers the website.
        $("body").delay(350).css({
            overflow: "visible",
        });
    });

    $("#wrapped").on("submit", function (e) {
        e.preventDefault();
    });

    // Wizard
    $("#wizard_container")
        .wizard({
            stepsWrapper: "#wrapped",
            submit: ".submit",
            beforeSelect: function (event, state) {
                if ($("input#website").val().length != 0) {
                    return false;
                }
                if (!state.isMovingForward) return true;
                var inputs = $(this).wizard("state").step.find(":input");
                return !inputs.length || !!inputs.valid();
            },
        })
        .validate({
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    error.insertBefore(element.next());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function () {
                var formData = new FormData(document.querySelector("#wrapped")); // Access the native HTML form element
                // Create an object to hold the checkbox values
                var question1 = {};
                var question2 = {};
                // Iterate through the checkboxes and add their values to the object
                for (var i = 1; i <= 7; i++) {
                    var checkbox1 = $("#question_1_opt_" + i);
                    question1["q" + i] = checkbox1.is(":checked") ? 1 : 0;
                }

                for (var i = 1; i <= 6; i++) {
                    var checkbox2 = $("#question_2_opt_" + i);
                    question2["q" + i] = checkbox2.is(":checked") ? 1 : 0;
                }

                // Add the checkbox object to your FormData
                formData.append("question_1", JSON.stringify(question1));
                formData.append("question_2", JSON.stringify(question2));

                axios
                    .post("/submit-form", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then(() => {
                        // console.log("Successfully Sent!");
                        $("#wrapped")[0].reset;
                        location.reload();
                        window.open("/thankyou", "_blank"); // Opens in a new tab
                    })
                    .catch(() => {
                        console.log("Error in sending!");
                    });
            },
        });

    //  progress bar
    $("#progressbar").progressbar();
    $("#wizard_container").wizard({
        afterSelect: function (event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text(
                "(" + state.stepsComplete + "/" + state.stepsPossible + ")"
            );
        },
    });

    // Validate select
    $("#wrapped").validate({
        ignore: [],
        rules: {
            select: {
                required: true,
            },
        },
        errorPlacement: function (error, element) {
            if (element.is("select:hidden")) {
                error.insertAfter(element.next(".nice-select"));
            } else {
                error.insertAfter(element);
            }
        },
    });

    // Submit loader mask
    var form = $("form#wrapped");
    form.on("submit", function () {
        form.validate();
        if (form.valid()) {
            $("#loader_form").fadeIn();
        }
    });

    // Modal Help
    $("#modal_h").magnificPopup({
        type: "inline",
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: "auto",
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300,
        closeMarkup:
            '<button title="%title%" type="button" class="mfp-close"></button>',
        mainClass: "my-mfp-zoom-in",
    });

    $("#trades_performed").select2({
        placeholder: "Select the trade, or trades you perform here..",
    });

    function formatUSPhone() {
        var number = $(this).val().replace(/[^\d]/g, "");
        if (number.length > 10) {
            number = number.slice(0, 10); // Ensures that the phone number is not more than 10 digits
        }
        if (number.length == 7) {
            number = number.replace(/(\d{3})(\d{4})/, "$1-$2");
        } else if (number.length == 10) {
            number = number.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3");
        }
        $(this).val(number);
    }

    $("#phone_no").on("input", formatUSPhone);
})(window.jQuery);
