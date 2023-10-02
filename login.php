<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dati per la connessione al database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "edusogno_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    // Salvo l'email e la password inviate dal modulo
    $email = $_POST["email"];
    $password = $_POST["password"];


    // Query per selezionare l'utente tramite l'email
    $emailQuery = "SELECT id, email, password FROM utenti WHERE email = '$email'";
    $result = $conn->query($emailQuery);


    // Controllo se l'email è presente nel database
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $stored_password = $row["password"];

        // Verifico la password
        if (password_verify($password, $stored_password)) {

            // Se la password è corretta
            $_SESSION["user_id"] = $row["id"];
            header("Location: dashboard.php"); // Redirect alla pagina personale dell'utente
            exit();
        } else {
            // Se la password è errata
            echo "Credenziali errate, riprovare.";
        }
    } else {
        // Se l'utente non è registrato
        echo "Utente non trovato.";
    }

    $conn->close();
}
