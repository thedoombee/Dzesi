<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
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
                <div class="d-flex align-items-center justify-content-between order-lg-2 order-1" style="width: 8rem;">
                    <div><a href="#" class="nav-link" style="color: black ;"><i class="bi bi-cart"></i> </a></div>
                    <div><a href="#" class="nav-link" style="color: black;"><i class="bi bi-facebook"></i></a></div>
                    <div><a href="#" class="nav-link" style="color: black;"><i class="bi bi-twitter"></i></a></div>
                    
                </div>
            </div>
        </nav>
    </div>

    <div class="container-fluid" style="height: 10rem; align-items: center; display: flex; font-size: 2rem;">Panier</div>

    <div class="row align-items-center cart-item border-bottom pb-3 mb-3">
        <div class="col-md-2">
          <img src="images/vase_trc1.jpeg" alt="Lampe Orb" class="img-fluid">
        </div>
        <div class="col-md-4">
          <h5>Lokpo_1</h5>
        </div>
        <div class="col-md-3 d-flex align-items-center">
          <button class="qty-btn">−</button>
          <span>1</span>
          <button class="qty-btn">+</button>
        </div>
        <div class="col-md-2 text-end">
          <strong>80,00 €</strong>
        </div>
        <div class="col-md-1 text-end">
          <button class="btn-close" aria-label="Supprimer"></button>
        </div>
      </div>
  
      <div class="row justify-content-end align-items-center">
        <div class="col-md-3 text-end">
          <p class="mb-1">Sous-total</p>
          <h5>80,00 €</h5>
          <a href="paiement.html" class="btn checkout-btn w-100 mt-2">Paiement</a>
        </div>
      </div>
    </div>


































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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>