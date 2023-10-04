<?php

// stabilisco la connesione con il database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edusogno_db";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

session_start();

// recupero email e id dell admin autenticato
if (isset($_SESSION["admin_id"])) {
    $admin_id = $_SESSION["admin_id"];
}

// Eseguo la query per recuperare le informazioni dell' admin e le salvo
$sql = "SELECT name, surname FROM admins WHERE id = $admin_id";
$resultUser = $conn->query($sql);
$row = $resultUser->fetch_assoc();
$adminName = $row["name"];
$adminSurname = $row["surname"];


// Eseguo la query per recuperare le righe in cui l'email è contenuta nella colonna 'attendees'
$sql = "SELECT * FROM eventi";


$resultAllEvents = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- link css -->
    <link rel="stylesheet" href="style-dashboard.css">

    <!-- link font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

    <!-- link fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <div class="logo">
            <img src="images/logo.svg" alt="">
        </div>
    </header>
    <div class="actions">
        <div class="action-btn"><a href="login_form.php">Logout</a></div>
        <div class="action-btn" class="btn btn-primary"><a href="add_event_form.php">Aggiungi evento</a></div>
    </div>
    <h1>Benvenuto admin <?php echo $adminName . " " . $adminSurname ?>, ecco la lista di tutti gli eventi</h1>
    <div class='cards-container'>
        <?php
        if ($resultAllEvents->num_rows > 0) {
            // Scorro  i risultati della query e salvo il nome e la data dell' evento
            while ($row = $resultAllEvents->fetch_assoc()) {
                $nameEvent = $row["nome_evento"];
                $dateEvent = $row["data_evento"];
                $idEvent = $row["id"];

                // Formatto la data e l'orario
                $formattedDate = date("d/m/Y H:i", strtotime($dateEvent));

                // stampo le card con i dettagli
                echo "     
                    <div class='card'>
                        <h2 class='title'>$nameEvent</h2>
                        <h3 class='date'>$formattedDate</h3>
                        <div class='options'>
                            <form method='POST' action='delete_event.php'>
                                <input type='hidden' name='idEvent' value='$idEvent'>
                                <button type='submit' class='delete-btn'><i class='fa-solid fa-trash'></i></button>
                            </form>
                            <div  class='update-btn'><a href='update_form.php?idEvent=$idEvent'><i class='fa-solid fa-pen'></i></a></div>
                        </div>
    </div>
    ";
            }
        } else {
            // stampo un messaggio se non ci sono eventi
            echo "<h1>Nessun evento in programma
        <h1 />";
        }
        ?>
    </div>
</body>

</html>