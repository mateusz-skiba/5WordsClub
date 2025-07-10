<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily words cron</title>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            let set;

            function startCron() {
                checkSet();
            }

            function checkSet() {
                $.ajax({
                    url: 'check_set.php',
                    type: 'POST',
                    success: function (response) {
                        set = response;

                        fetchUsers();
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error (checkSet): ' + status + ' - ' + error);
                    }
                });
            }

            function fetchUsers() {
                $.ajax({
                    url: 'fetch_users.php',
                    type: 'POST',
                    success: function (response) {
                        let users;

                        response.forEach(user => {
                            generateWords(user.level, user.email);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error (fetchUsers): ' + status + ' - ' + error);
                    }
                });
            }

            function generateWords(level, email) {
                $.ajax({
                    url: '../words.php',
                    type: 'POST',
                    data: {
                        level: level,
                        set: set
                    },
                    success: function (response) {
                        sendMail([email], level, response);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error (generateWords): ' + status + ' - ' + error);
                    }
                });
            }

            function sendMail(usersMails, level, content) {
                $.ajax({
                    url: '../send.php',
                    type: 'POST',
                    data: {
                        usersMails: usersMails,
                        level: level,
                        mailContent: content
                    },
                    success: function (response) {
                        console.log(`Mail sent to ${usersMails.join(', ')}`);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX error (sendMail): ' + status + ' - ' + error);
                    }
                });
            }

            startCron();
        });
    </script>
</body>
</html>
