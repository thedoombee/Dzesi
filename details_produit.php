<?php
  session_start();

require_once 'db.php';
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: produits.php'); exit; }
$stmt = $pdo->prepare("SELECT p.*, c.nom_cat FROM produits_d p LEFT JOIN categories_d c ON p.id_cat = c.id_cat WHERE p.id_prod = ?");
$stmt->execute([$id]);
$prod = $stmt->fetch();
if (!$prod) { header('Location: produits.php'); exit; }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($prod['nom_prod']) ?> - Dzesi</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .img-large { max-width: 100%; max-height: 400px; object-fit: contain; }
        .product-title { font-size: 2rem; font-weight: bold; }
        .product-price { font-size: 1.3rem; font-weight: bold; margin-bottom: 1rem; }
        .desc-tabs { margin-top: 2rem; }
        .tab-content { padding-top: 1rem; }
        .product-info { border: 1px solid #ccc; padding: 1.5rem; border-radius: 8px; background: #fafafa; }
        @media (max-width: 767px) {
            .img-large { max-height: 250px; }
        }

        div ul li .nav-link {
            color: black !important; 
        }
                 /* Assurez-vous que le nom du site est centré sur les grands écrans */
@media (min-width: 992px) {
    .navbar-brand {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }
}

/* Ajustez la disposition des éléments sur les petits écrans */
@media (max-width: 991.98px) {
    .navbar-brand {
        margin-right: auto;
    }

    .navbar-collapse {
        flex-grow: 0;
    }

    .navbar-nav {
        flex-direction: column;
    }

    .navbar-toggler {
        order: 3;
    }

    .d-flex.align-items-center {
        order: 2;
        margin-left: auto;
    }
    /* Ajoute un peu d'espace entre les éléments du menu */
    .navbar-nav .nav-item {
        margin: 0.5rem 0;
    }

}

@media (max-width: 767.98px) {
            .menu-vertical {
                flex-direction: row !important;
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .menu-item {
                padding: 0.5rem 0.75rem;
            }
            
            .menu-item:not(:last-child):after {
                content: "";
                display: inline-block;
                height: 15px;
                width: 1px;
                background-color: #d6d6d6;
                margin-left: 0.75rem;
                vertical-align: middle;
            }
        }
.menu-item a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .menu-item a:hover {
            color: #707274;
        }
        
        .menu-item a.active {
            color: black;
            font-weight: 500;
        }


        /* Supprime la bordure et l'effet de contour du bouton hamburger */
.navbar-toggler {
    border: none !important;
    box-shadow: none !important;
    outline: none !important;
}

/* Supprime aussi l'effet de focus quand on clique */
.navbar-toggler:focus {
    box-shadow: none !important;
    outline: none !important;
}

/* Optionnel : enlève aussi tout padding/marge si besoin d’un rendu plus propre */
.navbar-toggler .menu-icon {
    padding: 0;
    margin: 0;
}

    </style>
</head>
<body>
    <div class="container-fluid fixed-top">
        <nav class="navbar navbar-expand-lg  " style="background-color: white; box-shadow: 0 2px ;">
            <div class="container-fluid">
                <!-- Nom du site -->
                <a class="navbar-brand mx-auto order-lg-1 order-0" href="./index.php" ><div class="col-md-4 mb-1 d-flex align-items-center justify-content-center">
  <div style="font-family: 'Segoe Script', 'Brush Script MT', cursive; font-size: 2.7rem; font-weight: bold; letter-spacing: 2px; color: #7a6a3a; text-shadow: 1px 1px 8px #f4ecd6;">
    Dzesi
  </div>
</div></a>
    
                <!-- Bouton du menu hamburger -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-icon">
                      <i class="bi bi-list"></i> <!-- icône hamburger -->
                    </span>                  
                  </button>
    
                <!-- Liens de navigation -->
                <div class="collapse navbar-collapse order-lg-0 order-2" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a id="boutique-link" class="nav-link" href="produits.php" style="color: black;">Boutique</a>
                        </li>
                        <li class="nav-item">
                            <a id="a-propos-link" class="nav-link" href="a-propos.php" style="color: black;">À propos</a>
                        </li>
                        <li class="nav-item">
                            <a id="contact-link" class="nav-link" href="contact.php" style="color: black;">Contact</a>
                        </li>
                    </ul>
                </div>
    
                <!-- Panier et réseaux sociaux + bouton -->
                <div class="d-flex align-items-center gap-3 navbar-actions order-lg-2 order-1">
                    <a href="./panier.php" class="nav-link p-0" style="color: black;"><i class="bi bi-cart fs-5"></i></a>
                    <a href="#" class="nav-link p-0" style="color: black;"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="nav-link p-0" style="color: black;"><i class="bi bi-twitter fs-5"></i></a>
                    <?php include 'includes/bouton_compte.php'; ?>
                </div>
            </div>
        </nav>
    </div>
<div class="container my-5">
    <div class="row g-5">
        <div class="col-md-6 pt-4 text-center">
            <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['nom_prod']) ?>" class="img-large mb-3">
        </div>
        <div class="col-md-6 pt-4">
            <div class="product-title"><?= htmlspecialchars($prod['nom_prod']) ?></div>
            <div class="product-price"><?= number_format($prod['prix'], 2, ',', ' ') ?> FCFA</div>
            <div class="mb-3"><?= nl2br(htmlspecialchars($prod['desc_prod'])) ?></div>
            <form method="post" action="panier.php">
    <input type="hidden" name="id_prod" value="<?= $prod['id_prod'] ?>">
    <input type="hidden" name="quantite" value="1">
    <button type="submit" name="ajouter_panier" class="btn btn-outline-dark w-100 " style="border-radius: 0;">Ajouter au panier</button>
</form>
            <div class="mt-3 product-info">
                <div><strong>Catégorie:</strong> <?= htmlspecialchars($prod['nom_cat']) ?></div>
            </div>
        </div>
    </div>
    <div class="desc-tabs">
        <ul class="nav nav-tabs"  id="descTab" role="tablist">
            <li class=" nav-item" role="presentation">
                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">Description</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="spec-tab" data-bs-toggle="tab" data-bs-target="#spec" type="button" role="tab">Spécifications</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="desc" role="tabpanel">
                <h5><?= htmlspecialchars($prod['nom_prod']) ?> : Une touche chaleureuse</h5>
                <p><?= nl2br(htmlspecialchars($prod['desc_prod'])) ?></p>
            </div>
            <div class="tab-pane fade" id="spec" role="tabpanel">
                <ul>
                    <li>Catégorie : <?= htmlspecialchars($prod['nom_cat']) ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>




<footer class=" text-dark pt-5 pb-3 mt-5 border-top">
    <div class="container-fluid">
      <div class="row">
  
        
  
      <!-- Copyright -->
      <div class="text-center text-muted">
        © 2025 Dzesi. Tous droits réservés.
      </div>
    </div>
  </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>