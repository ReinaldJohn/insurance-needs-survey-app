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

    let observer = new MutationObserver(() => {
        // $(
        //     "#wrapped :checkbox, #wrapped input, #wrapped select, #wrapped textarea"
        // )
        //     // .not("#fax_number, #personal_website, #bond_owners_spouse_ssn")
        //     .prop("required", true);
    });

    // Observe the entire document for changes
    observer.observe(document, {
        childList: true, // Observes direct children
        subtree: true, // Observes all descendants
    });

    var isTermsChecked = false;
    $("#process").css("cursor", "no-drop");
    $("#termsCheckbox").on("change", function () {
        isTermsChecked = $(this).is(":checked");
        $("#process").css("cursor", isTermsChecked ? "pointer" : "no-drop");
    });

    // $("#wrapped").on("submit", function (e) {
    //     e.preventDefault();
    // });

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
                if (state.step.hasClass("submit")) {
                    $("#process").on("click", function (e) {
                        e.preventDefault();
                        if (!isTermsChecked) {
                            // event.preventDefault(); // This prevents the button click from doing anything
                            // alert("Please accept the terms and conditions"); // Optional: Show a message
                            toastr.warning(
                                "Please accept the terms and conditions."
                            );
                            return false;
                        } else {
                            $("#loader_form").css("display", "block");
                            var formData = new FormData(
                                document.querySelector("#wrapped")
                            ); // Access the native HTML form element
                            // Create an object to hold the checkbox values
                            var question1 = {};
                            var question2 = {};
                            // Iterate through the checkboxes and add their values to the object
                            for (var i = 1; i <= 7; i++) {
                                var checkbox1 = $("#question_1_opt_" + i);
                                var checkbox2 = $("#question_2_opt_" + i);
                                question1["q" + i] = checkbox1.is(":checked")
                                    ? 1
                                    : 0;
                                question2["q" + i] = checkbox2.is(":checked")
                                    ? 1
                                    : 0;
                            }

                            // Add the checkbox object to your FormData
                            formData.append(
                                "question_1",
                                JSON.stringify(question1)
                            );
                            formData.append(
                                "question_2",
                                JSON.stringify(question2)
                            );

                            axios
                                .post("/submit-form", formData, {
                                    headers: {
                                        "X-CSRF-TOKEN": $(
                                            'meta[name="csrf-token"]'
                                        ).attr("content"),
                                        // "Content-Type": "application/json",
                                        "Content-Type": "multipart/form-data",
                                    },
                                })
                                .then((response) => {
                                    $("#loader_form").css("display", "none");
                                    if (response.data.status === "success") {
                                        $("#wrapped")[0].reset();
                                        window.open("/thankyou", "_blank");
                                        location.reload();
                                    } else {
                                        // Handle error accordingly
                                        console.error(
                                            "Error in saving form:",
                                            response.data.message
                                        );
                                    }
                                })
                                .catch((error) => {
                                    $("#loader_form").css("display", "none");
                                    console.error(
                                        "Error in sending:",
                                        error.response.data.message
                                    );
                                });
                        }
                    });
                }

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
        });

    var isTermsChecked = false;
    $("#process").css("cursor", "no-drop");
    $("#termsCheckbox").on("change", function () {
        isTermsChecked = $(this).is(":checked");
        $("#process").css("cursor", isTermsChecked ? "pointer" : "no-drop");
    });

    var allowForward = false;
    var declined = false;

    $("#wizard_container").wizard({
        afterForward: function () {
            setInitialCursorState();
        },
        beforeForward: function (event, state) {
            if (state.stepIndex === 2) {
                if (!allowForward && !declined) {
                    if ($("#dialpadTermsCheckbox").is(":checked")) {
                        allowForward = true;
                        $(".forward").css("cursor", "");
                    } else {
                        $(".forward").css("cursor", "no-drop");
                        toastr.info(
                            "You must accept the agreements before proceeding."
                        );
                        return false;
                    }
                } else if (declined) {
                    toastr.info(
                        "You must refresh the page again to agree to the terms and agreements."
                    );
                    return false;
                }
            } else {
                allowForward = false;
                $(".forward").css("cursor", "");
            }
            return true;
        },
    });

    $("#dialpadTermsCheckbox").change(function () {
        if ($(this).is(":checked")) {
            allowForward = true;
            $(".forward").css("cursor", "");
        } else {
            allowForward = false;
            $(".forward").css("cursor", "no-drop");
            toastr.info("You must accept the agreements before proceeding.");
        }
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
