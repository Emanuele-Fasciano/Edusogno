<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // L'utente non è autenticato, reindirizza alla pagina di login
    header("Location: login_form.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera la nuova password inviata dal modulo
    $new_password = $_POST["new_password"];

    // Esegui l'aggiornamento della password nel database per l'utente autenticato
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "edusogno_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    // Escapare la nuova password per prevenire SQL injection
    $new_password = $conn->real_escape_string($new_password);

    // Recupera l'ID dell'utente autenticato dalla sessione
    $user_id = $_SESSION["user_id"];

    // Esegui l'aggiornamento della password nel database
    $update_password_query = "UPDATE utenti SET password = ? WHERE id = ?";
    $new_query = $conn->prepare($update_password_query);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $new_query->bind_param("si", $hashed_password, $user_id);

    if ($new_query->execute()) {
        // Password aggiornata con successo
        $_SESSION['success_message'] = "Password cambiata con successo!";
        header("Location: dashboard.php");
    } else {
        // Errore nell'aggiornamento della password
        $error_message = "Si è verificato un errore nell'aggiornamento della password.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- link css -->
    <link rel="stylesheet" href="login-style.css">

    <!-- link font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <img src="images/logo.svg" alt="">
        </div>
    </header>
    <div class="action-btn"><a href="dashboard.php">Indietro</a></div>
    <h1>Cambia Password</h1>

    <div class="form-container">
        <form action="change_password_form.php" method="post">
            <label for="password">Nuova Password:</label>
            <input type="password" id="password" name="new_password" placeholder="Inserisci la nuova password" required><br>
            <input type="submit" value="Cambia Password" class="btn">
        </form>
    </div>
</body>

</html>

<style>
    h2 {
        color: green;
        text-align: center;
    }

    .action-btn {
        margin-top: 45px;
    }

    .action-btn a {
        text-align: center;
        background-color: rgb(0, 87, 255);
        padding: 15px;
        color: white;
        border-radius: 15px;
        font-size: 15px;
        cursor: pointer;
        text-decoration: none;
        margin-left: 20px;
    }
</style>