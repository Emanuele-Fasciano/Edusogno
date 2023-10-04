<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Includo la classe EventController
    include "EventController.php";

    // Ottieni l'ID dell'evento da eliminare dalla richiesta POST
    $idEvent = $_POST["idEvent"];

    // Creo un'istanza di EventController
    $eventController = new EventController();

    // Richiamo la funzione addEvent per eliminare il record al database
    if ($eventController->deleteEvent($idEvent)) {
        header("Location: admin_dashboard.php"); // Redirect alla pagina personale dell' admin
    } else {
        echo "Errore durante l'eliminazione del record nel database.";
    }

    // Dopo aver eseguito l'eliminazione, puoi reindirizzare l'utente o fornire un messaggio di successo
    header("Location: admin_dashboard.php"); // Reindirizza alla pagina dell'amministratore
    exit();
}
