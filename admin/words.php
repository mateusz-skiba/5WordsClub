<?php
require_once __DIR__ . '/../config/db.php';

$level = $_POST['level'];
$set = $_POST['set'];
$table = $level . "_words";
$table_texts = $level . "_texts";

echo '<table width="92%" cellspacing="0" cellpadding="0" style="max-width: 700px; margin: 0 auto;">
    <tr style="padding: 0; margin: 0; height: 38px;">
        <td style="padding: 0; margin: 0; height: 38px;">
            <p style="display: none; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">';

try {
    $sqll = "SELECT word FROM $table WHERE `set` = :set";
    $stmtl = $pdo->prepare($sqll);
    $stmtl->execute(['set' => $set]);

    $wordsl = $stmtl->fetchAll(PDO::FETCH_COLUMN);

    echo implode(", ", $wordsl);

} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}

echo '</p></td>
    </tr>
    <tr style="padding: 0; margin: 0; width: 100%; height: 35px;">
        <td align="center" style="margin: 0 auto; padding: 0;">
          <a href="https://5words.club/" target="_blank" style="padding: 0; margin: 0; display: block; width: 135px; text-align: center; text-decoration: none;">
            <picture>
                <source srcset="https://5words.club/assets/img/mail/logo.svg" type="image/svg+xml">
                <img src="https://5words.club/assets/img/mail/logo.png" alt="5WordsClub Logo" style="display: block; height: 33px; width: 135px;" height="33" width="135" />
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
    </tr>';

try {
    $sql = "SELECT word, definition, forms, example, uses, audio FROM $table WHERE `set` = :set";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['set' => $set]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        ?>
        <tr style="padding: 0; margin: 0;">
            <td style="padding: 28px 40px; margin: 0; background-color: #FFF;" class="word">
                <table style="padding: 0; margin: 0; width: 100%; text-align: left;">
                    <tr style="padding: 0; margin: 0;">
                        <td class="nameBox" style="padding: 0; margin: 0; width: 100%;">
                            <p style="padding: 0; margin: 0; text-align: left; font-size: 36px; line-height: 1; font-weight: 700; color: #1B211E; font-family: Helvetica, Arial, sans-serif; text-transform: capitalize;">
                                <?= htmlspecialchars($row["word"]) ?>
                            </p>
                        </td>
                        <td class="soundBox" style="padding: 0; margin: 0; width: 34px; text-align: right;">
                            <a href="<?= htmlspecialchars($row["audio"]) ?>" target="_blank" style="display: block; width: 34px; height: 34px; text-decoration: none;">
                                <picture>
                                    <source srcset="https://5words.club/assets/img/mail/sound.svg" type="image/svg+xml">
                                    <img src="https://5words.club/assets/img/mail/sound.png" alt="Listen to the word" style="display: block; height: 34px; width: 34px;" height="34" width="34">
                                </picture>
                            </a>
                        </td>
                    </tr>
                </table>
                <table style="padding: 0; margin: 0; width: 100%; text-align: left;">
                    <tr style="padding: 0; margin: 0;">
                        <td class="definitionBox" style="padding: 6px 0px 24px; margin: 0; width: 100%;">
                            <p style="padding: 0; margin: 0; text-align: left; font-size: 18px; line-height: 1.3; font-weight: 400; color: #1B211E; font-family: Helvetica, Arial, sans-serif; width: 90%;">
                                <?= htmlspecialchars($row["definition"]) ?>
                            </p>
                        </td>
                    </tr>
                </table>
                <table style="padding: 0; margin: 0; width: 100%; text-align: left;">
                    <tr style="padding: 0; margin: 0;">
                        <td class="imgBox" style="padding: 0; padding-left: 16px; margin: 0; width: 166px; height: 150px; text-align: right;">
                            <img src="https://5words.club/word/<?= strtolower(str_replace(' ', '_', htmlspecialchars($row["word"]))) ?>.jpg" alt="<?= htmlspecialchars($row["word"]) ?>" style="display: block; height: 150px; width: 150px; border-radius: 16px;" height="150" width="150" />
                        </td>
                        <td class="textBox" style="padding: 0; padding-left: 24px; margin: 0; width: 100%;">
                            <p style="padding: 0; margin: 0; text-align: left; font-size: 16px; line-height: 1.2; font-weight: 400; color: #2E3331; font-family: Helvetica, Arial, sans-serif;">
                                <strong style="padding: 0; padding-bottom: 4px; margin: 0; display: block; text-align: left; font-size: 14px; line-height: 1; font-weight: 700; color: #AEADAD; font-family: Helvetica, Arial, sans-serif;">Example</strong>
                                <?= nl2br(htmlspecialchars($row["example"])) ?><br><br>
                                <?php if (!empty($row["forms"])): ?>
                                    <strong style="padding: 0; padding-bottom: 4px; margin: 0; display: block; text-align: left; font-size: 14px; line-height: 1; font-weight: 700; color: #AEADAD; font-family: Helvetica, Arial, sans-serif;">Forms</strong>
                                    <?= nl2br(htmlspecialchars($row["forms"])) ?><br><br>
                                <?php endif; ?>
                                <strong style="padding: 0; padding-bottom: 4px; margin: 0; display: block; text-align: left; font-size: 14px; line-height: 1; font-weight: 700; color: #AEADAD; font-family: Helvetica, Arial, sans-serif;">Common uses</strong>
                                <?= nl2br(htmlspecialchars($row["uses"])) ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php
    }
} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}

try {
    $sql_text = "SELECT text FROM $table_texts WHERE id = :set";
    $stmt_text = $pdo->prepare($sql_text);
    $stmt_text->execute(['set' => $set]);
    $text = $stmt_text->fetchColumn() ?: "";
} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}
?>

<tr style="padding: 0; margin: 0;">
    <td style="padding: 38px 40px 28px; margin: 0; background-color: #FFF;" class="word story">
        <p style="padding: 0; margin: 0; text-align: left; font-size: 30px; line-height: 1; font-weight: 700; color: #333; font-family: Helvetica, Arial, sans-serif; text-transform: capitalize;">
            Story 
        </p>
        <p style="padding: 0; margin: 0; text-align: left; font-size: 17px; line-height: 1.45; font-weight: 400; color: #555; font-family: Helvetica, Arial, sans-serif; width: 98%; padding-top: 10px;">
            <?= htmlspecialchars($text) ?>
        </p>
    </td>
</tr>

<?php
echo '    <tr class="wordFooter" style="padding: 0; margin: 0; height: 36px;">
        <td style="padding: 0; margin: 0; background-color: #FFF; border-radius: 0px 0px 18px 18px; height: 36px;">
        </td>
    </tr>
    <tr style="padding: 0; margin: 0; height: 28px;">
        <td style="padding: 0; margin: 0; height: 28px;"></td>
    </tr>
    <tr style="padding: 0; margin: 0;">
        <td style="padding: 0; margin: 0;">
          <p class="footerInfo" style="padding: 0; margin: 0 auto; text-align: center; font-size: 12px; line-height: 1.5; font-weight: 400; color: #888888; font-family: Helvetica, Arial, sans-serif; width: 94%; max-width: 365px;">
            You’re receiving this email because you subscribed to 5WordsClub to improve your English skills<span class="dot" style="display: none;">.</span><br class="br" style="display: none;"><span class="separator"> |</span>
            <a href="https://5words.club/dashboard/" style="color: #888888;">Unsubscribe</a>
          </p>
        </td>
    </tr>
    <tr style="padding: 0; margin: 0; height: 20px;">
        <td style="padding: 0; margin: 0; height: 20px;"></td>
    </tr>
    <tr style="padding: 0; margin: 0;">
        <td style="padding: 0; margin: 0;">
          <p style="padding: 0; margin: 0 auto; text-align: center; font-size: 12px; line-height: 1.5; font-weight: 400; color: #888888; font-family: Helvetica, Arial, sans-serif; max-width: 365px;">
            © 2025 5WordsClub
          </p>
        </td>
    </tr>
    <tr style="padding: 0; margin: 0; height: 20px;">
        <td style="padding: 0; margin: 0; height: 20px;"></td>
    </tr>
  </table>';
?>