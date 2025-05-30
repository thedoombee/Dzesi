<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>À propos - Dzesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #F4ECD6; }
        .apropos-container {
            max-width: 900px;
            margin: 3rem auto;
            background: #fff;
            border: 2px solid #F4ECD6;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            padding: 2.5rem 2rem;
        }
        .apropos-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #222;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: 2px;
        }
        .apropos-img {
            max-width: 220px;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .apropos-text {
            font-size: 1.15rem;
            color: #333;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }
        .apropos-values {
            background: #F4ECD6;
            border-radius: 8px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        .apropos-values h5 {
            font-weight: bold;
            margin-bottom: 0.7rem;
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
                    <li class="nav-item"><a class="nav-link active" href="a-propos.php" style="color: black;">À propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php" style="color: black;">Contact</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-3 order-lg-2 order-1" style="width:auto;">
                <a href="./panier.php" class="icon-link text-dark"><i class="bi bi-cart fs-5"></i></a>
                <a href="#" class="icon-link text-dark"><i class="bi bi-facebook fs-5"></i></a>
                <a href="#" class="icon-link text-dark"><i class="bi bi-twitter fs-5"></i></a>
                <?php if (file_exists('includes/bouton_compte.php')) include 'includes/bouton_compte.php'; ?>
            </div>
        </div>
    </nav>

    <div class="apropos-container mt-5">
        <div class="text-center">
            <img src="images/penseur.webp" alt="Dzesi - Art africain" class="apropos-img">
        </div>
        <div class="apropos-title">À propos de Dzesi</div>
        <div class="apropos-text">
            <strong>Dzesi</strong> est une plateforme dédiée à la valorisation de l’art, de l’artisanat et de la créativité africaine. Notre mission est de vous faire découvrir des œuvres uniques, réalisées avec passion par des artistes et artisans locaux, pour embellir votre quotidien et affirmer votre identité.
        </div>
        <div class="apropos-values">
            <h5>Nos valeurs</h5>
            <ul>
                <li><strong>Authenticité :</strong> Chaque pièce est sélectionnée pour sa qualité et son histoire.</li>
                <li><strong>Créativité :</strong> Nous encourageons l’innovation et l’expression artistique.</li>
                <li><strong>Respect :</strong> Nous valorisons le travail des créateurs et le patrimoine culturel africain.</li>
                <li><strong>Proximité :</strong> Nous favorisons les circuits courts et la relation directe avec les artistes.</li>
            </ul>
        </div>
        <div class="apropos-text">
            Que vous soyez passionné d’art, à la recherche d’un cadeau original ou simplement curieux, Dzesi vous ouvre les portes d’un univers riche en couleurs, en formes et en émotions.<br>
            <br>
            <strong>Merci de faire partie de notre aventure !</strong>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>