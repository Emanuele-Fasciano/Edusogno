<?php

$idEvent = $_GET['idEvent'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- link css -->
    <link rel="stylesheet" href="../css/form-style.css">

    <!-- link font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <img src="../images/logo.svg" alt="">
        </div>
    </header>
    <div class="back-btn"><a href="admin_dashboard.php">Indietro</a></div>
    <h1>Modifica evento</h1>
    <div class="form-container">
        <form action="update_form_logic.php" method="POST">
            <input type="hidden" name="idEvent" value="<?php echo $idEvent ?>">

            <label for="title">Titolo:</label>
            <input type="text" name="title" id="title" required>

            <label for="attendees">Partecipanti:</label>
            <input type="text" name="attendees" id="attendees" required>

            <label for="description">Descrizione:</label>
            <input type="text" name="description" id="description" required></input>

            <label for="date">Data:</label>
            <input type="datetime-local" name="date" id="date" required>

            <input type="submit" class="btn" value="Modifica">
        </form>
    </div>

</body>

</html>