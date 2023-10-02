<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edusogno_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Ricezione dei dati dal modulo
$name = $_POST["name"];
$surname = $_POST["surname"];
$email = $_POST["email"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Controllo l'inicità della mail
$check_email = "SELECT * FROM utenti WHERE email = '$email'";
$result = $conn->query($check_email);


if ($result->num_rows > 0) {
    // L'email è già presente nel database, mostra un messaggio di errore
    echo "Questo indirizzo email è già stato registrato. Si prega di utilizzare un altro indirizzo email.";
} else {

    // Inserimento dei dati nella tabella degli utenti
    $sql = "INSERT INTO utenti (name, surname, email, password) VALUES ('$name', '$surname', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Utente registrato con successo!";
    } else {
        echo "Errore durante la registrazione dell'utente: " . $conn->error;
    }

    // Chiudi la connessione al database
    $conn->close();
}