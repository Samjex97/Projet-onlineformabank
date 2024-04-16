<?php
session_start();
$host = "127.0.0.1";
$user = "root";
$password = "";
$dbname = "onlineformabank";

try {
    // Connexion à la base de données en utilisant PDO
    $connessione = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    
    // Définition de l'attribut PDO pour gérer les exceptions
    $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Message de confirmation si la connexion réussit
    echo "Connexion à la base de données $dbname réussie !<br>";
} catch(PDOException $exerror) {
    // Gestion de l'exception en cas d'erreur de connexion
    echo "Connexion échouée : " . $exerror->getMessage();
    exit(); // Quitte le script si la connexion échoue
}

/// Vérifie si des données ont été envoyées via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les données POST requises existent
    if (isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['password']) && isset($_POST['last_name'])) {
        // Échappe les données POST (attention: cette méthode n'est pas nécessaire avec PDO)
        $email = $_POST['email'];
        $lastName = $_POST['last_name']; // Correction de l'attribut name
        $password = $_POST['password'];
        $firstNames = $_POST['first_name'];

        // Requête SQL pour vérifier si l'email existe déjà
        $richiestaUguale = "SELECT email FROM utilisateurs WHERE email = '$email'";
        $stmt = $connessione->prepare($richiestaUguale);
        $stmt->execute();

        // Vérifie si l'email existe déjà
        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = "Erreur : L'email existe déjà";
            header("Location: register.php");
            exit; // Assure que le script se termine après le redirection
        } else {
            // Requête SQL pour insérer un nouvel utilisateur
            $sql = "INSERT INTO utilisateurs(first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
            
            // Prépare la déclaration préparée
            $stmt = $connessione->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':first_name', $firstNames);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':password', $password);

            // Exécute la requête SQL
            $stmt->execute();

            $_SESSION['message'] = "Inscription réussie ! Veuillez vous connecter maintenant";

            // Redirige l'utilisateur après l'inscription
            header("Location: register.php");
            exit; // Assure que le script se termine après la redirection
        }
    }
}
