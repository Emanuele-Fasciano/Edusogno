<?php
class EventController
{
    private $database;
    // Stabilisco la connessione con il database
    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "edusogno_db";

        $this->database = new mysqli($servername, $username, $password, $dbname);
    }

    // funzione per l'aggiunta di un evento 
    public function addEvent($title, $attendees, $description, $date)
    {
        $sql = "INSERT INTO eventi (nome_evento, attendees, description, data_evento) VALUES (?, ?, ?, ?)";
        $stmt = $this->database->prepare($sql);

        if ($stmt === false) {
            die("Errore nella preparazione dell'istruzione SQL: " . $this->database->error);
        }

        // Bind dei parametri e impostazione dei valori
        $stmt->bind_param("ssss", $title, $attendees, $description, $date);

        if ($stmt->execute()) {
            return true; // L'evento è stato aggiunto con successo
        } else {
            die("Errore durante l'aggiunta dell'evento: " . $stmt->error);
        }

        $stmt->close();
    }


    // funzione per l'update di un evento
    public function updateEvent($title, $attendees, $description, $date, $id)
    {
        $sql = "UPDATE eventi SET nome_evento = ?, attendees = ?, description = ?, data_evento = ? WHERE id = ?";
        $stmt = $this->database->prepare($sql);

        if ($stmt === false) {
            die("Errore nella preparazione dell'istruzione SQL: " . $this->database->error);
        }

        $stmt->bind_param("ssssi", $title, $attendees, $description, $date, $id);

        if ($stmt->execute()) {
            return true; // L'evento è stato modificato con successo
        } else {
            die("Errore durante la modifica dell'evento: " . $stmt->error);
        }

        $stmt->close();
    }

    // DELETE (Eliminazione)
    public function deleteEvent($id)
    {
        $sql = "DELETE FROM eventi WHERE id = ?";
        $stmt = $this->database->prepare($sql);

        if ($stmt === false) {
            die("Errore nella preparazione dell'istruzione SQL: " . $this->database->error);
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true; // L'evento è stato eliminato con successo
        } else {
            die("Errore durante l'eliminazione dell'evento: " . $stmt->error);
        }

        $stmt->close();
    }
}
