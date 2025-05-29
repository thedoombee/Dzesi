<?php 
include 'db.php';
  session_start();







?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dzesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
      html, body {
    overflow-x: hidden;
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



.carousel-item {
  height: 25rem; /* Ajuste à la taille que tu veux */

}

.carousel-item img {
  object-fit: contain;
  height: 100%;
  width: 100%;
  padding: 0;

}
.col-md-6 .btn:hover{
    background-color: black;
    color: white;
    border-radius: 0;
}
.col-md-6 .btn{
    border: 2 solid black;
}
.image-container {
    width: 18rem; /* Taille du carré */
    height: 18rem;
    overflow: hidden;
    position: relative;
  }

  .image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Permet de remplir le carré tout en gardant le ratio */
    position: absolute;
  }

  body {
    padding-top: 56px; /* Ajustez cette valeur selon la hauteur de votre navbar */
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
    height: 2px;
    width: 100%;
    background-color: black;
    transition: all 0.3s ease-in-out;
}

.btn-outline-dark:hover {
    background-color: black !important;
    color: white !important;
    border-radius: 0 !important;
}











    </style>
</head>
<body>
        <nav class="navbar navbar-expand-lg fixed-top " style="background-color:white;box-shadow: 0 2px ;">
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
                        <a id="boutique-link" class="nav-link" href="produits.php" style="color: black;">Boutique</a>
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
                <div class="d-flex align-items-center gap-3 order-lg-2 order-1" style="width: auto;">
    <div><a href="#" class="nav-link px-2" style="color: black;"><i class="bi bi-cart"></i></a></div>
    <div><a href="#" class="nav-link px-2" style="color: black;"><i class="bi bi-facebook"></i></a></div>
    <div><a href="#" class="nav-link px-2" style="color: black;"><i class="bi bi-twitter"></i></a></div>
    <?php include 'includes/bouton_compte.php'; ?>
</div>
            </div>
        </nav>



    <div class="container-fluid ">
        <div class="row " style="background-color:#F4ECD6;">
            <div class="col-md-3 " style="height: 25rem;  display: flex; align-items: center; padding-top: 5rem;">
                <p style="font-size: 3.125rem; font-display: fallback; padding-left:1rem ; font-weight: 700;">
                    Une vision, un art, une réalistion, une affirmation de soit 
                </p>
            </div>
            <div class="col-md-3">
    
            </div>
            <div class="col-md-6 ms-auto" style="object-fit: cover; padding: 2rem; ">
                <img src="./images/penseur.webp" alt="" style="object-fit: cover; max-width: 100%; ">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row" >
            <div class="col-md-6" style=" object-fit: contain; height: 40rem;padding: 2rem 0; ">
                <img src="./images/pot_ceramic.jpg" alt="" style="width: 100%; max-height: 100%; object-fit: contain; ">
            </div>
    
    
            <div class="col-md-6" style="display: flex; align-items: center; justify-content: flex-end;padding-left: 1.5rem;">
                <p style="font-size: 3.125rem;" >
                    Des oeuvres inédites pour orner votre quotidien
                </p>
            </div>
            
        </div>
    </div>

    <div class="container" style="height: 4rem;  display: flex; align-items: center;justify-content: center;">
        <p style="font-size: 2rem;">
            NOUVEAUTES
        </p>
    </div>
    
    <div class="row" style="background-color: beige;">
        <div class="col-md-6" >
            <div id="carouselExampleAutoplaying" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="./images/tableau_afrc1.jpeg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="./images/tableau_afrc2.jpeg" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="./images/tableau_afrc3.jpeg" class="d-block w-100" alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
        </div>

        <div class="col-md-6" style=" display: flex; align-items:center; justify-content:center; ">
            <div>
                <p style="font-size: 2rem; padding: 1rem;padding-left: 0.5rem;">
                    Faites le découverte de fabuleuses pieces avec ces nouveautés
                </p>
                <div style=" justify-content: center; align-items: center; display: flex;">
                    <a href="#" class="btn  " style="border-radius: 0; border: 2px solid black; margin-bottom: 1rem;"> Explorer </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mt-5">
        <div class="row">
          <!-- Première colonne -->
          <div class="col-md-6 d-flex flex-column align-items-center">
            <div class="mb-3 image-container">
              <!-- Emplacement de l'image -->
              <img src="./images/pages_tg.jpg" alt="Image 1" class="img-fluid">
            </div>
            <button class="btn " style="border-radius: 0; border: 2px solid black; margin-bottom: 1rem;">Voir les pagnes</button>
          </div>
          
          <!-- Deuxième colonne -->
          <div class="col-md-6 d-flex flex-column align-items-center">
            <div class="mb-3 image-container">
              <!-- Emplacement de l'image -->
              <img src="./images/pot_ceramic.jpg" alt="Image 2" class="img-fluid">
            </div>
            <button class="btn "style=" border-radius: 0; border: 2px solid black; ">Voir les pots</button>
          </div>
        </div>
    </div>
    <div class="container mt-5">
      <div class="row">
        <!-- Première colonne -->
        <div class="col-md-6 d-flex flex-column align-items-center">
          <div class="mb-3 image-container">
            <!-- Emplacement de l'image -->
            <img src="./images/vase_trc1.jpeg" alt="Image 1" class="img-fluid">
          </div>
          <button class="btn "style="border-radius: 0; border: 2px solid black;margin-bottom:1rem; ">Voir les vases </button>
        </div>
        
        <!-- Deuxième colonne -->
        <div class="col-md-6 d-flex flex-column align-items-center">
          <div class="mb-3 image-container">
            <!-- Emplacement de l'image -->
            <img src="./images/tableau_afrc1.jpeg" alt="Image 2" class="img-fluid">
          </div>
          <button class="btn " style="border-radius: 0; border: 2px solid black;">Voir les tableaux</button>
        </div>
      </div>
    </div>




    <footer class=" text-dark pt-5 pb-3 mt-5 border-top">
        <div class="container">
          <div class="row">
      
            <!-- FAQ -->
            <div class="col-md-4 mb-4">
              <h5 class="mb-3">FAQ</h5>
              <ul class="list-unstyled">
                <li><a href="#" class="text-decoration-none text-muted">Comment soumettre une recette ?</a></li>
                <li><a href="#" class="text-decoration-none text-muted">Comment fonctionne le blog ?</a></li>
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





    <script>
        // Récupère l'URL actuelle
        const currentPage = window.location.pathname;
    
        // Sélectionne tous les liens du menu
        const links = document.querySelectorAll('.nav-link');
    
        // Pour chaque lien, vérifie s'il correspond à la page actuelle
        links.forEach(link => {
            if (currentPage.includes(link.getAttribute('href').split('?')[0])) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    </script>
    
      <script>
        const menuIcon = document.querySelector('.menu-icon i');
        const navbarCollapse = document.getElementById('navbarNav');
      
        navbarCollapse.addEventListener('shown.bs.collapse', () => {
          menuIcon.classList.remove('bi-list');
          menuIcon.classList.add('bi-x');
        });
      
        navbarCollapse.addEventListener('hidden.bs.collapse', () => {
          menuIcon.classList.remove('bi-x');
          menuIcon.classList.add('bi-list');
        });
      </script>
            
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>
