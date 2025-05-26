<?php
session_start();

// Vérification des données reçues
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    // Ici vous devriez vérifier les identifiants dans votre base de données
    // Exemple simplifié :
    if ($email === 'utilisateur@test.com' && $mot_de_passe === 'mot_de_passe') {
        $_SESSION['user'] = $email;
        
        
        header('Location: index.php'); // Redirection vers la page d'accueil
        exit();
    } else {
        // Redirection vers la page de connexion avec un message d'erreur
        header('Location: connexion.php?error=1');
        exit();
    }
} else {
    // Si accès direct au fichier
    header('Location: connexion.php');
    exit();
}
?>
