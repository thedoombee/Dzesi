<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}
include 'db.php';

$email = $_SESSION['user'];
// Récupération des infos actuelles
$stmt = $pdo->prepare('SELECT nom_uti, prenom_uti, telephone, ville FROM utilisateurs_d WHERE email_uti = ?');
$stmt->execute([$email]);
$userData = $stmt->fetch();

$nom = $userData['nom_uti'] ?? '';
$prenom = $userData['prenom_uti'] ?? '';
$telephone = $userData['telephone'] ?? '';
$ville = $userData['ville'] ?? '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_nom = trim($_POST['nom_uti'] ?? '');
    $new_prenom = trim($_POST['prenom_uti'] ?? '');
    $new_telephone = trim($_POST['telephone'] ?? '');
    $new_ville = trim($_POST['ville'] ?? '');

    // Validation simple
    if (!$new_nom || !$new_prenom || !$new_telephone || !$new_ville) {
        $message = '<div class="alert alert-danger">Tous les champs sont obligatoires.</div>';
    } else {
        $stmt = $pdo->prepare("UPDATE utilisateurs_d SET nom_uti = ?, prenom_uti = ?, telephone = ?, ville = ? WHERE email_uti = ?");
        if ($stmt->execute([$new_nom, $new_prenom, $new_telephone, $new_ville, $email])) {
            $message = '<div class="alert alert-success">Profil mis à jour avec succès.</div>';
            // Met à jour les variables pour réafficher les nouvelles valeurs
            $nom = $new_nom;
            $prenom = $new_prenom;
            $telephone = $new_telephone;
            $ville = $new_ville;
        } else {
            $message = '<div class="alert alert-danger">Erreur lors de la mise à jour.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon profil - Dzesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F4ECD6; padding-top: 56px; }
        .modifier-container {
            max-width: 500px;
            margin: 3rem auto;
            background: #fff;
            border: 2px solid black;
            border-radius: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            padding: 2rem 2.5rem;
        }
        .btn-outline-dark {
            border:2px solid black;
            background:transparent;
            color:black;
            font-weight:600;
            border-radius:0;
            padding:8px 24px;
            transition:0.2s;
            white-space:nowrap;
            font-size:1rem;
            min-width:130px;
        }
        .btn-outline-dark:hover {
            background-color: black !important;
            color: white !important;
            border-radius: 0 !important;
        }
    </style>
</head>
<body>
    <div class="modifier-container">
        <h2 class="mb-4 text-center">Modifier mon profil</h2>
        <?= $message ?>
        <form method="post">
            <div class="mb-3">
                <label for="nom_uti" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom_uti" name="nom_uti" value="<?= htmlspecialchars($nom) ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom_uti" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom_uti" name="prenom_uti" value="<?= htmlspecialchars($prenom) ?>" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="<?= htmlspecialchars($telephone) ?>" required>
            </div>
            <div class="mb-3">
                <label for="ville" class="form-label">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" value="<?= htmlspecialchars($ville) ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="moncompte.php" class="btn btn-outline-dark">Annuler</a>
                <button type="submit" class="btn btn-outline-dark">Enregistrer</button>
            </div>
        </form>
    </div>
</body>
</html>