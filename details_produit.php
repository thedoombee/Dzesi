<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokpo_1</title>
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
                            <a id="boutique-link" class="nav-link" href="../produits.html" style="color: black;">Boutique</a>
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




    <div class="container">
        <div class="row">
            <!-- Images du produit -->
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12">
                        <img src="/images/vase_trc1.jpeg" alt="Lampe Orb" class="product-main-image" id="mainImage" >
                    </div>
                </div>
                
            </div>
    
            <!-- Détails du produit -->
            <div class="col-md-6 product-details">
                <h1 class="product-title">Vase en terre rouge</h1>
                <p class="product-price">25.000,00 FCFA</p>
                
                <p class="product-description">
                    Élégant et authentique, ce vase en terre rouge apporte une touche artisanale et chaleureuse à votre intérieur. Idéal pour accueillir des fleurs séchées ou simplement comme objet décoratif, il séduit par sa texture brute et son charme naturel.
                </p>
                
                <div class="mb-4">
                    <label for="quantity" class="form-label">Quantité:</label>
                    <input type="number" id="quantity" class="quantity-input" value="1" min="1">
                </div>
                
                <button class="btn add-to-cart-btn">Ajouter au panier</button>
                
                <div class="product-meta">
                    <span><strong>Catégorie:</strong> Vases</span>
                    <span><strong>Matériaux:</strong> Terre cuite</span>
                    <span><strong>Dimensions:</strong> 30 x 30 x 40 cm</span>
                </div>
            </div>
        </div>
        
        <!-- Onglets d'information supplémentaire -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">Spécifications</button>
                    </li>
                </ul>
                <div class="tab-content" id="productTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <h4>La Vase Lokpo: Une touche chaleureuse </h4>
                        <p>Apportez une touche d'authenticité et de chaleur à votre intérieur avec ce magnifique vase en terre cuite. Réalisé à la main selon un savoir-faire artisanal ancestral, il se distingue par sa teinte rouge profonde et sa texture légèrement granuleuse, caractéristiques de la terre cuite naturelle. Sa silhouette épurée s’adapte aussi bien aux décors contemporains qu’aux ambiances plus rustiques ou bohèmes.</p>

                            <p>Ce vase est aussi fonctionnel qu’esthétique. Sa hauteur de 30 cm et son col légèrement resserré permettent d’y accueillir des bouquets de fleurs fraîches, des branchages secs ou même de servir de simple pièce décorative. Sa solidité naturelle et sa cuisson à haute température garantissent une bonne résistance dans le temps, à condition d’éviter une exposition prolongée à l’humidité.</p>
                            
                            <p>Chaque pièce est unique, avec de subtiles variations de teinte et de texture qui témoignent de sa fabrication artisanale. Ce vase en terre cuite est plus qu’un objet décoratif : c’est un hommage aux matériaux bruts et à l’art de la céramique traditionnelle, pensé pour sublimer les espaces de vie avec sobriété et caractère.</p>
                        
                    </div>
                    <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                        <h4>Caractéristiques techniques</h4>
                        <ul>
                            <li>Dimensions: 30 x 30 x 40 cm</li>
                            <li>Matériaux: argile, terre rouge</li>
                            <li>Poids: 6kg</li>
                            <li>Certifications: CE, RoHS</li>
                        </ul>
                    </div>
                    </div>
                </div>
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