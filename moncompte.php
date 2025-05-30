<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}
include 'db.php'; // pour avoir accès à $pdo

$email = $_SESSION['user'];
$stmt = $pdo->prepare('SELECT nom_uti, prenom_uti, telephone, ville, image_profil, email_uti FROM utilisateurs_d WHERE email_uti = ?');
$stmt->execute([$email]);
$userData = $stmt->fetch();
$nom = $userData['nom_uti'] ?? '';
$prenom = $userData['prenom_uti'] ?? '';
$telephone = $userData['telephone'] ?? '';
$ville = $userData['ville'] ?? '';
$photo_profil = $userData['image_profil'] ?? ''; // Corrigé ici
$email = $userData['email_uti'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['nouvelle_photo']) && $_FILES['nouvelle_photo']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['nouvelle_photo']['tmp_name'];
    $ext = pathinfo($_FILES['nouvelle_photo']['name'], PATHINFO_EXTENSION);
    $filename = 'uploads/profils/' . uniqid('profil_') . '.' . $ext;
    if (!is_dir('uploads/profils')) mkdir('uploads/profils', 0777, true);
    move_uploaded_file($tmp_name, $filename);
    // Mets à jour la BDD
    $stmt = $pdo->prepare("UPDATE utilisateurs_d SET image_profil = ? WHERE email_uti = ?");
    $stmt->execute([$filename, $email]);
    // Recharge la page pour afficher la nouvelle photo
    header("Location: moncompte.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon compte - Dzesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #F4ECD6; padding-top: 56px; }
        .compte-container {
            max-width: 500px;
            margin: 3rem auto;
            background: #fff;
            border: 2px solid black;
            border-radius: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            padding: 2rem 2.5rem;
        }
        .compte-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #222;
            text-align: center;
        }
        .compte-info {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #333;
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
        .compte-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        .compte-photo {
            position: relative;
            display: inline-block;
            text-align: center;
        }
        .compte-photo img {
            margin-bottom: 1rem;
            background: #fff;
        }
        .photo-profil-img {
            display: block;
            margin: 0 auto;
            border-radius: 50%;
            object-fit: cover;
            width: 120px;
            height: 120px;
            background: #fff;
            border: 2px solid #F4ECD6;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color:white;box-shadow: 0 2px;">
        <div class="container-fluid">
            <a class="navbar-brand position-absolute start-50 translate-middle-x" href="index.php" style="color: black;">Dzesi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="menu-icon">
                    <i class="bi bi-list"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse order-lg-0 order-2" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="produits.php" style="color: black;">Boutique</a></li>
                    <li class="nav-item"><a class="nav-link" href="a-propos.php" style="color: black;">À propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php" style="color: black;">Contact</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-3 order-lg-2 order-1" style="width:auto;">
                <a href="./panier.php" class="icon-link text-dark"><i class="bi bi-cart fs-5"></i></a>
                <a href="#" class="icon-link text-dark"><i class="bi bi-facebook fs-5"></i></a>
                <a href="#" class="icon-link text-dark"><i class="bi bi-twitter fs-5"></i></a>
                <?php include 'includes/bouton_compte.php'; ?>
            </div>
        </div>
    </nav>

    <div class="compte-container">
        <div class="compte-title"><i class="bi bi-person-circle"></i> Mon compte</div>
        <div class="compte-photo mb-3 d-flex justify-content-center align-items-center" style="position: relative;">
            <form method="post" enctype="multipart/form-data" id="form-photo-profil" style="display:inline-block;">
                <input type="file" name="nouvelle_photo" id="nouvelle_photo" accept="image/*" style="display:none" onchange="document.getElementById('form-photo-profil').submit();">
                <div style="position: relative; display: inline-block;">
                    <img src="<?= $photo_profil ? htmlspecialchars($photo_profil) : 'images/default_avatar.png' ?>"
                         alt="Photo de profil"
                         class="rounded-circle photo-profil-img"
                         style="width:120px;height:120px;object-fit:cover;border:2px solid #F4ECD6; background:#fff;">
                    <span style="
                        position: absolute;
                        bottom: 8px;
                        right: 8px;
                        background: #fff;
                        border-radius: 50%;
                        border: 1.5px solid #F4ECD6;
                        padding: 6px;
                        cursor: pointer;
                        box-shadow: 0 2px 6px rgba(0,0,0,0.07);
                        z-index:2;
                    " onclick="document.getElementById('nouvelle_photo').click();">
                        <i class="bi bi-pencil-fill" style="font-size: 1.1rem; color: #7a6a3a;"></i>
                    </span>
                </div>
            </form>
        </div>
        <div class="compte-info">
            <strong>Nom :</strong> <?= htmlspecialchars($nom) ?><br>
            <strong>Prénom :</strong> <?= htmlspecialchars($prenom) ?><br>
            <strong>Email :</strong> <?= htmlspecialchars($email) ?><br>
            <strong>Téléphone :</strong> <?= htmlspecialchars($telephone) ?><br>
            <strong>Ville :</strong> <?= htmlspecialchars($ville) ?><br>
        </div>
        <div class="compte-actions">
            <a href="modifier_profil.php" class="btn btn-outline-dark">Modifier le profil</a>
            <a href="deconnexion.php" class="btn btn-outline-dark">Déconnexion</a>
        </div>
    </div>

    <footer class="text-dark pt-5 pb-3 mt-5 border-top">
        <div class="container">
            <div class="text-center text-muted">
                © 2025 Dzesi. Tous droits réservés.
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>