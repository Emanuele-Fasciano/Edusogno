<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // stabilisco la connesione con il database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "edusogno_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    // Salvo l'email e la password inviate dal modulo e setto una variabile booleana per l'errore
    $email = $_POST["email"];
    $password = $_POST["password"];
    $error = $error_message ?? null;

    // Query per selezionare l'utente tramite l'email
    $emailQuery = "SELECT id, email, password FROM utenti WHERE email = ?";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Controllo se l'email è presente nel database
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $storedPassword = $row["password"];

        // Verifico la password
        if (password_verify($password, $storedPassword)) {
            // Se la password è corretta, esegui l'accesso e salvo in session id e mail dello user
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["email"] = $email;

            header("Location: dashboard.php"); // Redirect alla pagina personale dell'utente
            exit();
        } else {
            // Se la password è errata, imposta il messaggio di errore
            $error_message = "mail o password non corretti, riprovare";
        }
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
    <h1>Hai già un account?</h1>
    <div class="error-message">

    </div>
    <div class="form-container">
        <form action="login_form.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="name@example.com" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Scrivila qui" required><br>
            <input type="submit" value="Accedi" class="btn">
        </form>

        <div class="link-button">
            <a href="registration_form.php">Non hai ancora un profilo? <strong>Registrati</strong>.</a>
        </div>
    </div>
</body>

</html>
<html>