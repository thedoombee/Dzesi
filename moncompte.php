<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}
include 'db.php'; // pour avoir accès à $pdo

$email = $_SESSION['user'];
$stmt = $pdo->prepare('SELECT nom_uti FROM utilisateurs_d WHERE email_uti = ?');
$stmt->execute([$email]);
$userData = $stmt->fetch();
$nom = $userData ? $userData['nom_uti'] : '';
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
                    <li class="nav-item"><a class="nav-link" href="a-propos.html" style="color: black;">À propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html" style="color: black;">Contact</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-3 order-lg-2 order-1" style="width:auto;">
                <a href="#" class="icon-link text-dark"><i class="bi bi-cart fs-5"></i></a>
                <a href="#" class="icon-link text-dark"><i class="bi bi-facebook fs-5"></i></a>
                <a href="#" class="icon-link text-dark"><i class="bi bi-twitter fs-5"></i></a>
                <?php include 'includes/bouton_compte.php'; ?>
            </div>
        </div>
    </nav>

    <div class="compte-container">
        <div class="compte-title"><i class="bi bi-person-circle"></i> Mon compte</div>
        <div class="compte-info">
            <strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?><br>
            <strong>Email :</strong> <?php echo htmlspecialchars($email); ?><br>
            <!-- Ajoute ici d'autres infos utilisateur si besoin -->
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