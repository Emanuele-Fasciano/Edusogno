<?php


require 'vendor/autoload.php';

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
        // Preparo la query per l'inserimento dei dati nel database
        $sql = "INSERT INTO eventi (nome_evento, attendees, description, data_evento) VALUES (?, ?, ?, ?)";
        $stmt = $this->database->prepare($sql);


        // Bind dei parametri e imposto i valori
        $stmt->bind_param("ssss", $title, $attendees, $description, $date);

        // Se il bind è andato a buon fine
        if ($stmt->execute()) {

            // Trasformo la stringa $attendees in un array
            $attendeesArray = explode(',', $attendees);

            // Rimuovo gli spazi bianchi iniziali e finali
            $attendeesArray = array_map('trim', $attendeesArray);

            // Verifico se ogni elemento dell'array è un indirizzo email valido
            $validEmails = [];
            foreach ($attendeesArray as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validEmails[] = $email;
                }
            }

            // per ogni email in attendees invio una mail
            foreach ($validEmails as $email) {

                $phpmailer = new PHPMailer\PHPMailer\PHPMailer();
                $phpmailer->isSMTP();
                $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
                $phpmailer->SMTPAuth = true;
                $phpmailer->Port = 2525;
                $phpmailer->Username = '3188c60cf7bfb6';
                $phpmailer->Password = '10b534efe4d64d';

                $phpmailer->setFrom('manu@gmail.com');
                $phpmailer->addAddress($email);
                $phpmailer->Subject = "Nuovo invito per te";
                $phpmailer->Body = "Ciao, sei stato invitato a $title il $date, ecco una breve descrizione dell'evento: $description";

                if ($phpmailer->send()) {
                    echo "Email inviata con successo a $email<br>";
                } else {
                    echo "Errore nell'invio dell'email a $email: " . $phpmailer->ErrorInfo . "<br>";
                }
            }
        } else {
            die("Errore durante l'aggiunta dell'evento: " . $stmt->error);
        }

        // chiudo lo statement
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

            // Trasformo la stringa $attendees in un array
            $attendeesArray = explode(',', $attendees);

            // Rimuov gli spazi bianchi iniziali e finali
            $attendeesArray = array_map('trim', $attendeesArray);

            // Verifica se ogni elemento dell'array è un indirizzo email valido
            $validEmails = [];
            foreach ($attendeesArray as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validEmails[] = $email;
                }
            }

            // per ogni email in attendees invio una mail
            foreach ($validEmails as $email) {

                $phpmailer = new PHPMailer\PHPMailer\PHPMailer();
                $phpmailer->isSMTP();
                $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
                $phpmailer->SMTPAuth = true;
                $phpmailer->Port = 2525;
                $phpmailer->Username = '3188c60cf7bfb6';
                $phpmailer->Password = '10b534efe4d64d';

                $phpmailer->setFrom('manu@gmail.com');
                $phpmailer->addAddress($email);
                $phpmailer->Subject = "Nuovo invito per te";
                $phpmailer->Body = "Ciao, sei stato invitato a $title il $date, ecco una breve descrizione dell'evento: $description";

                if ($phpmailer->send()) {
                    echo "Email inviata con successo a $email<br>";
                } else {
                    echo "Errore nell'invio dell'email a $email: " . $phpmailer->ErrorInfo . "<br>";
                }
            }
        } else {
            // die("Errore durante l'aggiunta dell'evento: " . $stmt->error);
        }

        $stmt->close();
    }

    // funzione per l'eliminazione di un evento
    public function deleteEvent($id)
    {
        // preparo la query ed eseguo il bind
        $sql = "DELETE FROM eventi WHERE id = ?";
        $stmt = $this->database->prepare($sql);

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true; // L'evento è stato eliminato con successo
        } else {
            die("Errore durante l'eliminazione dell'evento: " . $stmt->error);
        }

        $stmt->close();
    }
}
