<?php

$host = "127.0.0.1";
$user = "root";
$password = "";
$dbname = "onlineformabank";

try {
    // Connessione al database usando PDO
    $connessione = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    
    // Impostazione dell'attributo PDO per gestire eccezioni
    $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Messaggio di conferma se la connessione è riuscita
    echo "Connessione al database $dbname effettuata con successo!<br>";
} catch(PDOException $exerror) {
    // Gestione dell'eccezione se si verifica un errore durante la connessione
    echo "Connessione fallita: " . $exerror->getMessage();
    exit(); // Esce dallo script se la connessione fallisce
}

// Verifica se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se i dati POST richiesti esistono
    if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
        // Esegue l'escape dei dati POST (attenzione: questo metodo non è necessario con PDO)
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // on check si l'email existe déjà
        $richiestaUguale = "SELECT Email FROM utenti WHERE Email = '$email';";
        $stmt = $connessione->prepare($richiestaUguale);
        $stmt->execute();

        // si oui on mets un message d'erreur
        if ($stmt->rowCount() > 0) {
            echo "exist";
            $_SESSION['message'] = "Errore: L'email esiste già";
            header("Location: register.php");
            exit; // Assicura che lo script venga terminato dopo il redirect
            
        // si non on créé l'utilisateur
        } else {
            echo "dispo";
            $sql = "INSERT INTO utenti(Email, Username, Password) VALUES (:email, :username, :password)";
            
            $stmt = $connessione->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);


            $_SESSION['message'] = "Registrazione effettuata con successo! Ora effettua il login";


            $stmt->execute();


            header("Location: register.php");
            exit; // Assicura che lo script venga terminato dopo il redirect
        }

}
}

?>
