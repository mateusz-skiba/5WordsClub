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
<body style="background-color: #FAFAFB; margin: 0; padding: 0px; font-family: Helvetica, Arial, sans-serif;">
  
    <form method="POST" action="words.php" id="generateMail" style="padding: 20px;">
        <h1>Generate maila</h1><br>
        <label for="level">Level:</label>
        A <input type="radio" id="A" name="level" value="a">
        B <input type="radio" id="B" name="level" value="b">
        C <input type="radio" id="C" name="level" value="c"><br><br><br>

        <label for="set">SET ID:</label>
        <input type="number" id="set" name="set" required><br><br><br><br>

        <!--  <label for="level_id">Level ID:</label><input type="checkbox" name="inputShow" id="inputShow"><br>
        <input type="number" id="level_id" name="level_id" style="display: none;" required><br><br><br>

        <label for="input1">Level ID 1:</label>
        <input type="number" id="input1" name="level_id[]" required><br>
        
        <label for="input2">Level ID 2:</label>
        <input type="number" id="input2" name="level_id[]" required><br>
        
        <label for="input3">Level ID 3:</label>
        <input type="number" id="input3" name="level_id[]" required><br>
        
        <label for="input4">Level ID 4:</label>
        <input type="number" id="input4" name="level_id[]" required><br>
        
        <label for="input5">Level ID 5:</label>
        <input type="number" id="input5" name="level_id[]" required><br><br><br> -->

        <input type="submit" value="Generate">
    </form>

    <form method="POST" action="send.php" id="sendMail" style="padding: 20px; display: none;">
        <h1>Send mail</h1><br>
        <input type="email" id="newMail" name="newMail"><button id="newMailAdd">+</button>
        <ul id="mailsList"></ul>

        <br><br><br>
        <button id="sentMailFirst">Send</button>
        <div id="sentMailsBox" style="display: none">
            <p>Are you sure you want to send these mails?</p>
            <input type="submit" value="Send mails">
        </div>
    </form>

    <hr>

    <div id="response" style="background-color: #FAFAFB; margin: 0; padding: 0; font-family: Helvetica, Arial, sans-serif;">
        
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>