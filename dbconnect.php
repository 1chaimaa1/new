<?php
// Définir les paramètres de connexion à la base de données
$servername = "localhost";  // Nom du serveur (ou IP)
$username = "root";         // Nom d'utilisateur de la base de données
$password = "";             // Mot de passe de la base de données
$dbname = "project";  // Nom de la base de données

try {
    // Créer une instance PDO pour la connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

    // Configurer PDO pour qu'il lance des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Facultatif : configurer PDO pour qu'il utilise les clés de colonnes associatives par défaut
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Message de succès (facultatif)
    // echo "Connected successfully"; 
} catch(PDOException $e) {
    // Gérer les erreurs de connexion
    echo "Connection failed: " . $e->getMessage();
}
?>