<?php
require_once __DIR__ . '/../../config/db.php';

try {
    $stmt = $pdo->prepare("SELECT id, word FROM c_words WHERE audio = ''");
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "DB error: " . $e->getMessage();
    $rows = [];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Audio Link Checker</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<script>
$(document).ready(function() {
    const wordsToCheck = <?php echo json_encode($rows); ?>;

    function getOxfordLink(word) {
        const w = word.toLowerCase();
        const base = "https://www.oxfordlearnersdictionaries.com/media/english/us_pron";
        const suffix = w.length === 3 ? "__" : w.length === 4 ? "_" : "";

        const folder1 = w[0];
        const folder2 = w.slice(0, 3);
        const folder3 = w.slice(0, 5) + suffix;

        const versions = ["1", "2"];
        const links = [];

        for (const v of versions) {
            links.push(`${base}/${folder1}/${folder2}/${folder3}/${w}__us_${v}.mp3`);
            links.push(`${base}/x/x${w.slice(0, 2)}/x${w.slice(0, 4)}/x${w}__us_${v}.mp3`);
        }

        return links;
    }

    function tryOxfordAudio(word) {
        const paths = getOxfordLink(word);

        return new Promise(resolve => {
            function tryNext(i = 0) {
                if (i >= paths.length) return resolve(null);
                const audio = new Audio(paths[i]);
                audio.addEventListener("canplaythrough", () => resolve(paths[i]), { once: true });
                audio.addEventListener("error", () => tryNext(i + 1), { once: true });
            }
            tryNext();
        });
    }

    console.log("Total words to check:", wordsToCheck.length);

    async function processWords() {
        for (const row of wordsToCheck) {
            const link = await tryOxfordAudio(row.word);
            if (link) {
                console.log(`${row.word} → ${link}`);
                $.post("save_audio.php", { id: row.id, audio: link }, function (res) {
                    console.log(`Saved to DB: ${res}`);
                });
            } else {
                console.log(`${row.word} → not found`);
            }
        }
    }

    processWords();
});
</script>

</body>
</html>