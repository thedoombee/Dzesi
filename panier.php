<?php
session_start();
require_once 'db.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['id_uti'])) {
    header('Location: inscription.php');
    exit;
}

// Ajouter au panier
if (isset($_POST['ajouter_panier'])) {
    $id_prod = intval($_POST['id_prod']);
    $quantite = max(1, intval($_POST['quantite'] ?? 1));
    if (!isset($_SESSION['panier'])) $_SESSION['panier'] = [];
    if (isset($_SESSION['panier'][$id_prod])) {
        $_SESSION['panier'][$id_prod] += $quantite;
    } else {
        $_SESSION['panier'][$id_prod] = $quantite;
    }
    // Redirection pour éviter le repost
    header('Location: panier.php');
    exit;
}

// Gérer + et -
if (isset($_POST['plus'])) {
    $id_prod = intval($_POST['id_prod']);
    if (isset($_SESSION['panier'][$id_prod])) {
        $_SESSION['panier'][$id_prod]++;
    }
    header('Location: panier.php');
    exit;
}
if (isset($_POST['moins'])) {
    $id_prod = intval($_POST['id_prod']);
    if (isset($_SESSION['panier'][$id_prod]) && $_SESSION['panier'][$id_prod] > 1) {
        $_SESSION['panier'][$id_prod]--;
    }
    header('Location: panier.php');
    exit;
}

// Supprimer un produit
if (isset($_GET['supprimer'])) {
    $id_sup = intval($_GET['supprimer']);
    unset($_SESSION['panier'][$id_sup]);
    header('Location: panier.php');
    exit;
}

// Récupérer les produits du panier
$panier = $_SESSION['panier'] ?? [];
$produits_panier = [];
$total = 0;
if (!empty($panier)) {
    $ids = array_keys($panier);
    // Sécurité : ne faire la requête que si $ids n'est pas vide
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM produits_d WHERE id_prod IN ($placeholders)");
    $stmt->execute($ids);
    $produits_panier = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Associer quantité et sous-total à chaque produit
    foreach ($produits_panier as &$prod) {
        $prod['quantite'] = isset($panier[$prod['id_prod']]) ? $panier[$prod['id_prod']] : 0;
        $prod['sous_total'] = $prod['prix'] * $prod['quantite'];
        $total += $prod['sous_total'];
    }
    unset($prod); // Bonnes pratiques PHP
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /*Ensemble des prérequis */
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
.card .img-container{
    height:25rem;
}
.col-md-4 a{
    text-decoration: none;
}

.navbar-nav .nav-link.active {
    position: relative;
    font-weight: 500;
}

.navbar-nav .nav-link.active::after {
    content: "";
    position: absolute;
    bottom: 0.2rem;
    left: 0;
    height: 1px;
    width: 100%;
    background-color: black;
    transition: all 0.3s ease-in-out;

}





body {
            font-family: 'Arial', sans-serif;
            padding-top: 80px;
            color: #333;
            background-color: #f9f9f9;
        }
        .product-main-image {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 15px;
            cursor: pointer;
        }
        .product-title {
            font-weight: 700;
            margin-bottom: 20px;
            color: #222;
        }

        .product-price {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .product-description {
            margin-bottom: 30px;
            color: #555;
            line-height: 1.6;
        }

        .quantity-input {
            width: 80px;
            height: 40px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .add-to-cart-btn {
            background-color: white;
            color: black;
            border: 1px solid black;
            border-radius: 0;
            padding: 10px 20px;
            width: 100%;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background-color: black;
            color: white;
        }

        .product-meta {
            font-size: 14px;
            color: #777;
            margin-top: 30px;
        }

        .product-meta span {
            display: block;
            margin-bottom: 5px;
        }

        .tab-content {
            padding: 20px 0;
        }
        .nav-tabs .nav-link {
            color: #555;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 10px 15px;
        }

        .nav-tabs .nav-link.active {
            color: #000;
            border-bottom: 2px solid #000;
            background-color: transparent;
        }
        @media (max-width: 768px) {
            .product-details {
                margin-top: 30px;
            }
            
            .product-thumbnail {
                height: 60px;
            }
        }



        /*pour gerer le panier , genre le css du panier quoi*/

        body {
      padding: 2rem;
      background-color: #f9f9f9;
    }
        .cart-item img {
      width: 100px;
      height: auto;
      object-fit: cover;
    }
    .qty-btn {
      border: none;
      background: none;
      font-size: 1.2rem;
      cursor: pointer;
      padding: 0 10px;
    }
    .checkout-btn {
      border: 2px solid black;
      background-color: transparent;
      padding: 10px 30px;
      font-weight: 600;
      transition: all 0.2s;
    }
    .checkout-btn:hover {
      background-color: black;
      color: white;
    }
    /*css du panier fini ici quoi*/














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
    
                <!-- Panier et réseaux sociaux -->
                <div class="d-flex align-items-center gap-3 order-lg-2 order-1">
                    <a href="./panier.php" class="nav-link p-0" style="color: black;"><i class="bi bi-cart"></i></a>
                    <a href="#" class="nav-link p-0" style="color: black;"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="nav-link p-0" style="color: black;"><i class="bi bi-twitter"></i></a>
                    <?php include 'includes/bouton_compte.php'; ?>
                </div>
            </div>
        </nav>
    </div> <!-- Fin du nav-bar -->

    <div class="container-fluid" style="height: 10rem; align-items: center; display: flex; font-size: 2rem;">Panier</div>

    <div class="container bg-white p-4 rounded" style="min-height:200px;">
        <?php if (empty($produits_panier)): ?>
            <div class="text-center text-muted">Votre panier est vide.</div>
        <?php else: ?>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <?php foreach ($produits_panier as $prod): ?>
                    <div class="col-2">
                        <img src="<?= htmlspecialchars($prod['image']) ?>" class="img-fluid" style="max-width:80px;">
                    </div>
                    <div class="col-3"><?= htmlspecialchars($prod['nom_prod']) ?></div>
                    <div class="col-3 text-center">
                        <form method="post" action="panier.php" class="d-inline">
                            <input type="hidden" name="id_prod" value="<?= $prod['id_prod'] ?>">
                            <button type="submit" name="moins" class="qty-btn btn btn-link p-0" style="text-decoration: none; color: black;">-</button>
                        </form>
                        <?= $prod['quantite'] ?>
                        <form method="post" action="panier.php" class="d-inline">
                            <input type="hidden" name="id_prod" value="<?= $prod['id_prod'] ?>">
                            <button type="submit" name="plus" class="qty-btn btn btn-link p-0"style="text-decoration: none;color: black;">+</button>
                        </form>
                    </div>
                    <div class="col-2 fw-bold"><?= number_format($prod['sous_total'], 2, ',', ' ') ?> FCFA</div>
                    <div class="col-2 text-end">
                        <a href="panier.php?supprimer=<?= $prod['id_prod'] ?>" class="text-dark fs-4" title="Supprimer"><i class="bi bi-x"></i></a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row justify-content-end">
                <div class="col-auto text-end">
                    <div class="fw-bold">Sous-total</div>
                    <div class="fs-4"><?= number_format($total, 2, ',', ' ') ?> FCFA</div>
                    <a href="traitement_commande.php" class="btn btn-outline-dark mt-2" style="border-radius:0; font-weight:600;">Paiement</a>
                </div>
            </div>
        <?php endif; ?>
    </div>




    <footer class=" text-dark pt-5 pb-3 mt-5 border-top">
    <div class="container-fluid">
      <div class="row">
  
        <!-- FAQ -->
       <!-- Remplace la section FAQ par ceci -->
<div class="col-md-4 mb-4 d-flex align-items-center justify-content-center">
  <div style="font-family: 'Segoe Script', 'Brush Script MT', cursive; font-size: 2.7rem; font-weight: bold; letter-spacing: 2px; color: #7a6a3a; text-shadow: 1px 1px 8px #f4ecd6;">
    Dzesi
  </div>
</div>
  
        <!-- Contacts -->
        <div class="col-md-4 mb-4">
          <h5 class="mb-3">Contact</h5>
          <ul class="list-unstyled">
            <li class="text-muted">Email : <a href="mailto:contact@Dzesi.com" class="text-decoration-none">contact@Dzesi.com</a></li>
            <li class="text-muted">Téléphone : +228 90 00 00 00</li>
            <li class="text-muted">Adresse : Lomé, Togo</li>
          </ul>
        </div>
  
        <!-- Réseaux sociaux -->
        <div class="col-md-4 mb-4">
          <h5 class="mb-3">Suivez-nous</h5>
          <div class="d-flex gap-3">
            <a href="#" class="text-dark"><i class="bi bi-facebook fs-4"></i></a>
            <a href="#" class="text-dark"><i class="bi bi-instagram fs-4"></i></a>
            <a href="#" class="text-dark"><i class="bi bi-twitter fs-4"></i></a>
            <a href="#" class="text-dark"><i class="bi bi-youtube fs-4"></i></a>
          </div>
        </div>
  
      </div>
  
      <hr>
  
      <!-- Copyright -->
      <div class="text-center text-muted">
        © 2025 Dzesi. Tous droits réservés.
      </div>
    </div>
  </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>