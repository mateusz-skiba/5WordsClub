$(document).ready(function () {
    // // Show input all levels
    // $('#inputShow').on('change', function () {
    //     if ($(this).prop('checked')) {
    //         $('#level_id').show();
    //     } else {
    //         $('#level_id').hide();
    //     }
    // });

    // // Input all levels handler
    // $('#level_id').on('input', function () {
    //     var firstInputValue = parseInt($(this).val(), 10);

    //     if (!isNaN(firstInputValue)) {
    //         $('#input1').val(firstInputValue);
    //         $('#input2').val(firstInputValue + 1);
    //         $('#input3').val(firstInputValue + 2);
    //         $('#input4').val(firstInputValue + 3);
    //         $('#input5').val(firstInputValue + 4);
    //     } else {
    //         $('#input1, #input2, #input3, #input4, #input5').val('');
    //     }
    // });

    // Form generateMail
    var level;
    var levelIds = [];

    var set;
    $('form#generateMail').submit(function (event) {
        event.preventDefault();

        set = $("#set").val();
        level = $("input[name='level']:checked").val();
        levelIds = [];
        $("input[name='level_id[]']").each(function () {
            levelIds.push($(this).val());
        });

        $.ajax({
            url: 'words.php',
            type: 'POST',
            data: {
                level: level,
                level_ids: levelIds,
                set: set
            },
            success: function (response) {
                $('#generateMail').hide();
                $('#sendMail').show();
                $('#response').html(response);
            },
            error: function (xhr, status, error) {
                console.error('AJAX error: ' + status + ' - ' + error);
            }
        });
    });

    // Add mail
    $('#newMailAdd').click(function (event) {
        event.preventDefault();

        var newMail = $('#newMail').val();
        if (newMail) {
            $('#mailsList').append('<li><span class="mailAddress">' + newMail + '</span>      <button class="remove">X</span></button>'); // Dodajemy do #mailsList
            $('#newMail').val('');
        }

        removeBtn();
    });

    // Remove mail
    function removeBtn() {
        $('button.remove').click(function (event) {
            event.preventDefault();

            $(this).parent().remove();
        });
    }

    // Double check if send
    $('#sentMailFirst').click(function (event) {
        event.preventDefault();
        $('#sentMailFirst').hide();
        $('#sentMailsBox').show();
    });

    // Form sendMail
    $('form#sendMail').submit(function (event) {
        event.preventDefault();

        let usersMails = $(".mailAddress").map(function () {
            return $(this).text();
        }).get();

        let mailContent = $('#response').html();

        $.ajax({
            url: 'send.php',
            type: 'POST',
            data: {
                usersMails: usersMails,
                level: level,
                level_ids: levelIds,
                mailContent: mailContent
            },
            success: function (response) {
                console.log(response)

                $('#newMail').hide();
                $('#newMailAdd').hide();
                $('#sentMailFirst').hide();
                $('#sentMailsBox').hide();
                $('.remove').hide();

                $("#sendMail h1").text("The emails have been sent!")
            },
            error: function (xhr, status, error) {
                console.error('AJAX error: ' + status + ' - ' + error);
            }
        });
    });
});