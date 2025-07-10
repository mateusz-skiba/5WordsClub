$(document).ready(function () {
    // Login
    $('form.loginForm').on('submit', function (e) {
        e.preventDefault();

        var email = $(this).find('input[name="email"]').val();

        $.ajax({
            url: '/api.php?action=send_token',
            type: 'POST',
            data: {
                email: email,
            },
            success: function (response) {
                console.log(response)
                // var data = JSON.parse(response);
                // console.log(data)
                var data = response
                var url = 'https://5words.club/dashboard/login?status=' + encodeURIComponent(data.status);
                if (data.email) {
                    url += '&email=' + encodeURIComponent(data.email);
                }
                window.location.href = url;

            },
            error: function () {
                alert('Error');
            }
        });
    });

    // Billing link
    if ($("#billingLink").length) {
        $.ajax({
            url: '../../dashboard/billing.php',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                console.log(data);

                if (data.status === 'success') {
                    $('#billingLink').attr('href', data.link);
                } else {
                    console.log("Error loading billing link:", data.message || "");
                }
            },
            error: function () {
                console.log("Error loading billing link.");
            }
        });
    }

    // Change level form
    if ($('input[type="radio"][name="level"]:checked').length) {
        $('input[type="radio"][name="level"]:checked').closest('.pill').addClass('active');
    }

    $('input[type="radio"][name="level"]').change(function () {
        $('.pill').removeClass('active');
        $(this).closest('.pill').addClass('active');

        $("form#changeLevel button").removeClass("unactive");
    });

    $('form#changeLevel').on('submit', function (e) {
        e.preventDefault();

        var email = $('#email').text();
        var newLevel = $('input[type="radio"][name="level"]:checked').val();

        $.ajax({
            url: '/api.php?action=change_level',
            type: 'POST',
            data: {
                email: email,
                level: newLevel
            },
            success: function (response) {
                // var data = JSON.parse(response);
                var data = response;
                if (data.status == 'success') {
                    $("form#changeLevel button").addClass("unactive");
                    var formattedLevel = newLevel.slice(0, 2) + '1-2' + newLevel.slice(2);
                    $(".languagePill").text(formattedLevel);

                    alert(data.message);
                } else {
                    alert(data.message);
                }
            },
            error: function () {
                alert('An error occurred while trying to update the level.');
            }
        });
    });
});