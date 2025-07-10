<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

    function sendHelloEmail($email, $level, $token) {
        $mail = new PHPMailer(true);

        $link = 'https://5words.club/dashboard/login?email=' . urlencode($email) . '&token=' . urlencode($token);

        try {
            $mail->isSMTP();
            $mail->Host = 'mail.5words.club';
            $mail->SMTPAuth = true;
            $mail->Username = 'hello@5words.club';
            $mail->Password = '$A=sjm0if{Sn';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->setFrom('hello@5words.club', '5words.club');
            // $mail->SMTPDebug = 2;    

            $mail->addAddress($email);
            $mail->addBCC('mateusz.skiba14@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to 5WordsClub';

            $mail->Body    = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>5WordsClub</title>
                <body style="background-color: #FAFAFB; margin: 0; padding: 0; font-family: Helvetica, Arial, sans-serif;">
                <table width="92%" cellspacing="0" cellpadding="0" style="max-width: 700px; margin: 0 auto;">
                    <tr style="padding: 0; margin: 0; height: 38px;">
                        <td style="padding: 0; margin: 0; height: 38px;"></td>
                    </tr>
                    <tr style="padding: 0; margin: 0; width: 100%; height: 35px;">
                        <td align="center" style="margin: 0 auto; padding: 0;">
                            <a href="https://5words.club/" target="_blank"
                                style="padding: 0; margin: 0; display: block; width: 135px; text-align: center; text-decoration: none;">
                                <picture>
                                    <source srcset="https://5words.club/assets/img/mail/logo.svg" type="image/svg+xml">
                                    <img src="https://5words.club/assets/img/mail/logo.png" alt="5WordsClub Logo"
                                        style="display: block; height: 33px; width: 135px;" height="33" width="135" />
                                </picture>
                            </a>
                        </td>
                    </tr>
                    <tr style="padding: 0; margin: 0; height: 38px;">
                        <td style="padding: 0; margin: 0;"></td>
                    </tr>
                    <tr style="padding: 0; margin: 0; height: 18px;">
                        <td style="padding: 0; margin: 0; background-color: #FFF; border-radius: 18px 18px 0px 0px; height: 18px;">
                        </td>
                    </tr>
                    <tr style="padding: 0; margin: 0;">
                        <td style="padding: 28px 40px; margin: 0; background-color: #FFF;" class="word">
                            <p
                                style="padding: 0; margin: 0; text-align: center; font-size: 36px; line-height: 1; font-weight: 700; color: #1B211E; font-family: Helvetica, Arial, sans-serif;">
                                Welcome to <span
                                    style="font-size: 36px; line-height: 1; font-weight: 700; color: #5A7FFA;">5words.club</span>
                            </p>
                            <p
                                style="padding: 0px 0px; margin: 20px 0px 38px; text-align: center; font-size: 17px; line-height: 1.3; font-weight: 400; color: #1B211E; font-family: Helvetica, Arial, sans-serif; width: 100%;">
                                Thanks for joining 5words.club! <br>
                                Your payment was successful and your account is now active. <br><br>

                                Tomorrow you\'ll receive your first daily email with 5 new words! <br><br>

                                You can sign in to your dashboard using the button below
                            </p>
                            <a href="' . htmlspecialchars($link) . '"
                                style="font-family: Helvetica, Arial, sans-serif; font-size: 18px; color: #FFF; text-decoration: none; border-radius: 7px; font-weight: bold; background-color: #5A7FFA; height: 46px; width: 200px; display: block; line-height: 46px; text-align: center; margin: auto;"
                                target="_blank">Sign in</a>
                        </td>
                    </tr>
                    <tr class="wordFooter" style="padding: 0; margin: 0; height: 18px;">
                        <td style="padding: 0; margin: 0; background-color: #FFF; border-radius: 0px 0px 18px 18px; height: 18px;">
                        </td>
                    </tr>
                    <tr style="padding: 0; margin: 0; height: 28px;">
                        <td style="padding: 0; margin: 0; height: 28px;"></td>
                    </tr>
                    <tr style="padding: 0; margin: 0;">
                        <td style="padding: 0; margin: 0;">
                            <p class="footerInfo"
                                style="padding: 0; margin: 0 auto; text-align: center; font-size: 12px; line-height: 1.5; font-weight: 400; color: #888888; font-family: Helvetica, Arial, sans-serif; width: 94%; max-width: 365px;">
                                Level up your English with 5 words daily</p>
                        </td>
                    </tr>
                    <tr style="padding: 0; margin: 0; height: 20px;">
                        <td style="padding: 0; margin: 0; height: 20px;"></td>
                    </tr>
                    <tr style="padding: 0; margin: 0;">
                        <td style="padding: 0; margin: 0;">
                            <p
                                style="padding: 0; margin: 0 auto; text-align: center; font-size: 12px; line-height: 1.5; font-weight: 400; color: #888888; font-family: Helvetica, Arial, sans-serif; max-width: 365px;">
                                © 2025 5WordsClub
                            </p>
                        </td>
                    </tr>
                    <tr style="padding: 0; margin: 0; height: 20px;">
                        <td style="padding: 0; margin: 0; height: 20px;"></td>
                    </tr>
                </table>
                </body>
            </html>
            ';
            $mail->AltBody = 'Welcome to 5WordsClub

                Thanks for joining 5WordsClub!
                Your payment was successful and your account is now active.

                Tomorrow you\'ll receive your first daily email with 5 new words!

                You can sign in to your dashboard using the link below 
                ' . htmlspecialchars($link);

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }