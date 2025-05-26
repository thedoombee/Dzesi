<?php
// Informations de connexion à la base de données
$servername = "localhost"; // ou "127.0.0.1"
$username = "root";        // nom d'utilisateur par défaut pour WAMP/XAMPP
$password = "";            // mot de passe (vide par défaut sur WAMP)
$dbname = "dzesidb";       // nom de ta base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Si tout va bien, la connexion est prête à être utilisée
?>
