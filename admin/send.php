<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../config/db.php';

$level = $_POST['level']; 
$usersMails = $_POST['usersMails'];
$mailContent = $_POST['mailContent'];

$success = true;

foreach ($usersMails as $email) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'mail.5words.club';
        $mail->SMTPAuth = true;
        $mail->Username = 'daily@5words.club';
        $mail->Password = 'xbY7k$vCj?Uv';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->CharSet = 'UTF-8';
        $mail->setFrom('daily@5words.club', '5WordsClub');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Daily Words';
        $mail->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>5WordsClub</title>
        
                <style>
                    @media only screen and (max-width: 600px) {
                        .word {
                            padding: 28px 22px!important;
                        }

                        .word.story {
                            padding: 38px 22px 28px!important
                        }

                        .separator, .soundBox {
                            display: none!important;
                        }

                        .nameBox p, .definitionBox p, .textBox p, .textBox p strong, .story p {
                            text-align: center!important;
                        }
        
                        .definitionBox {
                            padding-bottom: 16px!important;
                        }
        
                        .definitionBox p {
                            width: 100%!important;
                        }
        
                        .textBox {
                            display: block !important;
                            width: 100% !important;
                            padding-left: 0px!important;
                        }
        
                        .imgBox {
                            display: block !important;
                            height: auto!important;
                            width: 100% !important;
                            padding: 0px 0px 16px!important;
                        }
        
                        .imgBox img {
                            margin: 0 auto!important;
                            width: 80%!important;
                            height: auto!important;
                        }
        
                        .wordFooter {
                            height: 18px!important;
                        }
        
                        .wordFooter td {
                            height: 18px!important;
                        }
        
                        .dot, .br {
                            display: inline-block!important;
                        }
                    }
                </style>
            </head>
            <body style="background-color: #FAFAFB; margin: 0; padding: 0; font-family: Helvetica, Arial, sans-serif;">
                ' . $mailContent . '
            </body>
            </html>
        ';
        $mail->AltBody = 'Your daily 5 new words';

        $mail->send();
    } catch (Exception $e) {
        $success = false;
    }
}

if ($success) {
    echo "Success";
} else {
    echo "Error";
}
?>