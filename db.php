<?php
// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dzesidb";

// Connexion PDO
$pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
// Optionnel : pour afficher les erreurs PDO
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
