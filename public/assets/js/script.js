$(document).ready(function () {
    // Stripe key live
    // const stripe = Stripe("pk_live_51Q72QrGhqpg1U7QzBQfI4ch9cB71XqjtagCj1n6Gv6d0MPzvzAM3jntbMOtn0YcVkoRA1P80jIBDTksuoD60xkvY00DF1uTZZz");

    // Stripe key test
    const stripe = Stripe("pk_test_51RXhBk2fWJgkLZYyRYpxL7ciGaIAnOWajnbTlmLQUSmfEMVP0gUBH5j62KIAhIHwISTPT0miDH7ZNFAEkvvIUhoK00r0mJIueR");

    // Location
    function showPL() {
        if ($("#lang").length) {
            $("#lang").show();
        }
    };

    if (localStorage.getItem("language") !== "en") {
        const userLang = navigator.language || navigator.userLanguage;
        if (userLang.startsWith("pl")) {
            showPL();
        }
    }

    fetch("https://ipinfo.io/json?token=5fc3e1a4d2ea80")
        .then(response => response.json())
        .then(data => {
            if (data.country === "PL") {
                showPL();
            }
        })
        .catch(error => console.error("IP location error:", error));

    // Stripe
    $('#toclub').on('submit', function (event) {
        event.preventDefault();

        var email = $('#toclub input[name="email"]').val();
        var level = $('#toclub input[name="level"]:checked').val();
        var lang = $('html').attr('lang');
        var refer = document.referrer || '';

        let formData = new FormData(this);
        formData.append('email', email);
        formData.append('level', level);
        formData.append('lang', lang);
        formData.append('refer', refer);

        fbq('track', 'AddToCart');

        setTimeout(() => {
            $.ajax({
                url: '/api.php?action=save_leads',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response)
                    console.log("test");

                    if (response == "success") {
                        fetch('/api.php?action=create_checkout_session', {
                            method: "POST",
                            body: formData
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.id) {
                                    stripe.redirectToCheckout({ sessionId: data.id });
                                } else {
                                    console.error("Nie udało się utworzyć sesji Stripe:", data);
                                }
                            })
                            .catch(err => {
                                console.error("Błąd:", err);
                            });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX ERROR", { status, error, response: xhr.responseText });
                    alert('An error: ' + error);
                }

            });
        }, 200);
    });

    // Mobile menu
    $(".burger").click(function () {
        $("header").toggleClass("active");
    });

    $("header a").click(function () {
        $("header").removeClass("active");
    });

    $(window).scroll(function () {
        if ($("header").hasClass("active")) {
            $("header").removeClass("active");
        }
    });

    // FAQ
    $(".faq .panel").click(function () {
        if (!$(this).hasClass("active")) {
            $(this).addClass("active");
            $(this).find(".answer").slideDown();
        } else {
            $(this).removeClass("active");
            $(this).find(".answer").slideUp();
        }
    });

    // Link to form
    $(".join").click(function () {
        setTimeout(function () {
            $("form#toclub input[name='email']").focus();
        }, 0);

        setTimeout(function () {
            $("form#toclub").css({
                'transform': 'scale(1.02)',
                'transition': 'transform 0.2s ease-in'
            });
        }, 100);

        setTimeout(function () {
            $("form#toclub").css('transform', 'scale(1)');
        }, 300);
    });

    // Handle level
    $('.level input[type="radio"][name="level"]').change(function () {
        var selectedValue = $(this).val();
        $(this).closest('.level').find('.pill').attr('data-option', selectedValue);
    });

    $('.level.mailLevel input[type="radio"][name="level"]').change(function () {
        var selectedValue = $(this).val();
        $(".previewMail").hide();
        $(".previewMail[data-level='" + selectedValue + "']").show();
    });

    // Handle mail audio
    let audio = null;

    $(document).on("click", ".soundBox", function () {
        if ($(this).data("disabled")) return;

        let soundUrl = $(this).data("sound");

        if (soundUrl) {
            let audio = new Audio(soundUrl);
            audio.play();

            $(this).data("disabled", true);
            setTimeout(() => $(this).removeData("disabled"), 500);
        }
    });

    // Fixed level in popup
    $('#popupPreview').on('scroll', function () {
        var marginTopValue = parseInt($('#popupPreview .content').css('margin-top'));
        var overlayMailScrollTop = $(this).scrollTop();

        if (overlayMailScrollTop > marginTopValue) {
            $('.mailLevel').addClass('active');
        } else {
            $('.mailLevel').removeClass('active');
        }
    });

    // Open email preview popup
    $(".openPreview").click(function () {
        $("#popupPreview").css("display", "flex").hide().fadeIn();
        $("body").addClass("fixed");
    });

    // Close popup
    $(".overlay, .popupClose").click(function () {
        $(this).closest(".popup").fadeOut(300);

        $('form#formJoin').find('button.cta').addClass("noTransition");
        $('form#formJoin').find('button.cta').removeClass("active");

        setTimeout(() => {
            $('form#formJoin').find('button.cta').removeClass("noTransition");
        }, 320);

        setTimeout(() => {
            $("body").removeClass("fixed");

        }, 300);
    });

    // Form Join
    $('form#formJoin').on('submit', function (e) {
        e.preventDefault();

        var email = $(this).find('input[name="email"]').val();
        var level = $(this).find('input[name="level"]:checked').val();

        $(this).find('button.cta').addClass("active");
        $('form#formWaitlist').find('input[name="email"]').val(email);
        $('form#formWaitlist').find('select[name="level"]').val(level);
        $("#popupWaitlist").css("display", "flex").hide().fadeIn();
    });

    // Form Waitlist
    // $('form#formWaitlist').on('submit', function (e) {
    //     e.preventDefault();

    //     var email = $(this).find('input[name="email"]').val();
    //     var level = $(this).find('select[name="level"]').val();

    //     let formData = new FormData(this);
    //     formData.append('email', email);
    //     formData.append('level', level);

    //     $.ajax({
    //         url: 'https://5words.club/src/database/save_waitlist.php',
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function (response) {
    //             console.log(response)
    //             if (response == "success") {
    //                 $("#popupWaitlist p.title").html('Thanks for signing up!');
    //                 $("#popupWaitlist p.text").html('You’re on the waitlist! We’ll let you know when 5WordsClub will be ready. <br>Stay tuned! 🚀');

    //                 $('form#formJoin').find('button.cta').removeClass("active");
    //                 setTimeout(() => {
    //                     $('form#formJoin').find('button.cta').removeClass("noTransition");
    //                 }, 320);

    //                 $('form#formJoin')[0].reset();
    //                 $('form#formJoin').find('.level').find('.pill').attr('data-option', 'A');

    //                 $('form#formWaitlist').hide();
    //             }
    //         }
    //     });
    // });

    // Scroll animation on mail section
    $(window).scroll(function () {
        if ($("#mainMail").length) {
            var scrollTop = $(window).scrollTop();
            var howOffset = $(".how").offset().top - 160;
            var scrollDistance = scrollTop - howOffset;

            var speed = $(window).width() <= 768 ? 0.5 : 0.3;

            var newTop = -100 - scrollDistance * speed;

            if (newTop < -1150) {
                newTop = -1150;
            }
            if (newTop > 0) {
                newTop = 0;
            }

            $("#mainMail").css("top", newTop + "px");
        }
    });

    // Thankyou
    if ($("section#thankyou").length) {
        let params = new URLSearchParams(window.location.search);
        let email = params.get("email");
        let level = params.get("level");

        if (level == "A") {
            level = "A1-2";
        } else if (level == "B") {
            level = "B1-2";
        } else if (level == "C") {
            level = "C1-2";
        }

        if (!email || !level) {
            window.location.href = '/';
        } else {
            $("#fieldEmail").text(email);
            $("#fieldLevel").text(level.toUpperCase());
        }
    }
});