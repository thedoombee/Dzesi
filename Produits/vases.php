<?php
session_start();
require_once './includes/breadcrumb.php';
include 'db.php';

// Récupération des catégories
$categories = $pdo->query("SELECT * FROM categories_d")->fetchAll();

$cat_id = $_GET['cat'] ?? null;
if ($cat_id) {
    $stmt = $pdo->prepare("SELECT * FROM produits_d WHERE id_cat = ?");
    $stmt->execute([$cat_id]);
    $produits = $stmt->fetchAll();
} else {
    $produits = $pdo->query("SELECT * FROM produits_d")->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>produits</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">



    <style>
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








.breadcrumb-container {
    font-size: 1.1rem;
    color: #6c757d;
    margin-top: 20px;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
    margin-bottom: 0;
}

.breadcrumb-item {
    display: inline-block;
    font-weight: 500;
}

.breadcrumb-item a {
    text-decoration: none;
    color: #6c757d;
}

.breadcrumb-item.active {
    font-weight: bold;
    color: #343a40;
}










































    </style>
</head>
<body>
    <div class="container-fluid fixed-top">
        <nav class="navbar navbar-expand-lg  " style="background-color: white; box-shadow: 0 2px ;">
            <div class="container-fluid">
                <!-- Nom du site -->
                <a class="navbar-brand mx-auto order-lg-1 order-0" href="#" style="color: black;">Dzesi</a>
    
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
                            <a id="boutique-link" class="nav-link" href="produits.html" style="color: black;">Boutique</a>
                        </li>
                        <li class="nav-item">
                            <a id="a-propos-link" class="nav-link" href="a-propos.html" style="color: black;">À propos</a>
                        </li>
                        <li class="nav-item">
                            <a id="contact-link" class="nav-link" href="contact.html" style="color: black;">Contact</a>
                        </li>
                    </ul>
                </div>
    
                <!-- Panier et réseaux sociaux -->
                <div class="d-flex align-items-center gap-4 order-lg-2 order-1">
                    <a href="#" class="nav-link p-0" style="color: black;"><i class="bi bi-cart"></i></a>
                    <a href="#" class="nav-link p-0" style="color: black;"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="nav-link p-0" style="color: black;"><i class="bi bi-twitter"></i></a>
                    <?php include 'includes/bouton_compte.php'; ?>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-fluid">
        <div class="container-fluid" style="height: 10rem; align-items: center; display: flex; font-size: 2rem;">Boutique</div>
        <!-- Cette section affichera les breadcrumbs -->
<?php showBreadcrumb(); ?>; ?>

        <hr>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <!-- Menu vertical sur grand écran, horizontal sur mobile -->
                <nav>
                    <ul class="list-unstyled d-flex flex-column menu-vertical">
    <li class="menu-item"><a href="produits.php" class="active">Tous</a></li>
    <?php foreach ($categories as $cat): ?>
        <li class="menu-item">
            <a href="produits.php?cat=<?= $cat['id_cat'] ?>">
                <?= htmlspecialchars($cat['nom_cat']) ?>
            </a>
        </li>
    <?php endforeach; ?>?>
</ul>
                </nav></nav>
                
                    
            </div>
            
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-4  align-items-center">
                    <a href="">
                        <div class="card border-0" >
                            <div class="mb-3 image-container">
                                <!-- Emplacement de l'image -->
                                <img src="./images/vase_trc1.jpeg" alt="Image 1" class="img-fluid">
                            </div>
                            <div class="card border-0">
                            <p class="card-text">Lokpo_1</p>
                            <p class="card-text">25.000,00 FCFA</p>
                            </div>
                        </div>
                    </a>  
                 </div>
                    <div class="col-md-4  align-items-center">
                        <a href="">
                            <div class="card border-0" >
                                <div class="mb-3 image-container">
                                    <!-- Emplacement de l'image -->
                                    <img src="./images/vase_trc3.jpeg" alt="Image 1" class="img-fluid">
                                </div>
                                <div class="card border-0">
                                <p class="card-text">Lokpo</p>
                                <p class="card-text">25.000,00 FCFA</p>
                                </div>
                            </div>
                        </a>  
                     </div>/h5>
                 <div class="col-md-4  align-items-center">
                    <a href="">uted">Comment soumettre une recette ?</a></li>
                        <div class="card border-0" >ted">Comment fonctionne le blog ?</a></li>
                            <div class="mb-3 image-container">aux ?</a></li>
                                <!-- Emplacement de l'image -->
                                <img src="./images/vase_trc.png" alt="Image 1" class="img-fluid">
                            </div>
                            <div class="card border-0">
                            <p class="card-text">Lokpo</p>>
                            <p class="card-text">25.000,00 FCFA</p>tact</h5>
                            </div>unstyled">
                        </div>text-muted">Email : <a href="mailto:contact@Dzesi.com" class="text-decoration-none">contact@Dzesi.com</a></li>
                    </a>  "text-muted">Téléphone : +228 90 00 00 00</li>
                 </div>s="text-muted">Adresse : Lomé, Togo</li>
                </div>          </ul>
                    

            </div>-- Réseaux sociaux -->
        </div>  <div class="col-md-4 mb-4">
    </div>          <h5 class="mb-3">Suivez-nous</h5>
</div>          <div class="d-flex gap-3">
            <a href="#" class="text-dark"><i class="bi bi-facebook fs-4"></i></a>
            <a href="#" class="text-dark"><i class="bi bi-instagram fs-4"></i></a>
            <a href="#" class="text-dark"><i class="bi bi-twitter fs-4"></i></a>
i bi-youtube fs-4"></i></a>

<footer class=" text-dark pt-5 pb-3 mt-5 border-top">
    <div class="container">
      <div class="row">
  
        <!-- FAQ -->
        <div class="col-md-4 mb-4">
          <h5 class="mb-3">FAQ</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-decoration-none text-muted">Comment soumettre une recette ?</a></li>
            <li><a href="#" class="text-decoration-none text-muted">Comment fonctionne le blog ?</a></li>/footer>
            <li><a href="#" class="text-decoration-none text-muted">Puis-je partager sur les réseaux ?</a></li>
          </ul>  
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
            <a href="#" class="text-dark"><i class="bi bi-twitter fs-4"></i></a>llapse.addEventListener('shown.bs.collapse', () => {.getElementById('navbarNav');
            <a href="#" class="text-dark"><i class="bi bi-youtube fs-4"></i></a>on.classList.remove('bi-list');
          </div>      menuIcon.classList.add('bi-x');    navbarCollapse.addEventListener('shown.bs.collapse', () => {
        </div>
    
      </div>vbarCollapse.addEventListener('hidden.bs.collapse', () => {
        menuIcon.classList.remove('bi-x');
      <hr>st.add('bi-list');rCollapse.addEventListener('hidden.bs.collapse', () => {
  
      <!-- Copyright -->st');
      <div class="text-center text-muted">src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script> });
        © 2025 Dzesi. Tous droits réservés.
      </div>
    </div>/html></body>    </script>
  </footer><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
 </body>
    </html></script>    <script>        const menuIcon = document.querySelector('.menu-icon i');        const navbarCollapse = document.getElementById('navbarNav');            navbarCollapse.addEventListener('shown.bs.collapse', () => {        menuIcon.classList.remove('bi-list');        menuIcon.classList.add('bi-x');        });            navbarCollapse.addEventListener('hidden.bs.collapse', () => {        menuIcon.classList.remove('bi-x');        menuIcon.classList.add('bi-list');        });    </script>    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>