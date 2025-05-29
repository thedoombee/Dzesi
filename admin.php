<?php
session_start();
include 'db.php';

// Vérifie si l'utilisateur est connecté et est bien un admin
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

// Vérifie que l'email de session correspond à un admin
$email = $_SESSION['user'];
$stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
$stmt->execute([$email]);
$admin = $stmt->fetch();

if (!$admin) {
    // L'utilisateur n'est pas un admin
    header('Location: connexion.php');
    exit();
}

// Fonctions utilitaires
function getCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories_d");
    return $stmt->fetchAll();
}

// Gestion des produits
if (isset($_POST['add_product'])) {
    $nom = $_POST['nom'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $description = $_POST['description'] ?? '';
    $quantite = $_POST['quantite'] ?? '';

    // Gestion de l'upload d'image
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('prod_', true) . '.' . $ext;
        $uploadFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = $uploadFile;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO produits_d (nom_prod, prix, id_cat, desc_prod, image, quantite_stock) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prix, $categorie, $description, $image, $quantite]);
}
if (isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];
    $description = $_POST['description'];
    $quantite = $_POST['quantite'];
    $image = $_POST['old_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('prod_', true) . '.' . $ext;
        $uploadFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = $uploadFile;
        }
    }
    $stmt = $pdo->prepare("UPDATE produits_d SET nom_prod=?, prix=?, id_cat=?, desc_prod=?, image=?, quantite_stock=? WHERE id_prod=?");
    $stmt->execute([$nom, $prix, $categorie, $description, $image, $quantite, $id]);
}
if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];
    $stmt = $pdo->prepare("DELETE FROM produits_d WHERE id_prod=?");
    $stmt->execute([$id]);
}

// Gestion des catégories
if (isset($_POST['add_category'])) {
    $nom = $_POST['nom'] ?? '';
    $stmt = $pdo->prepare("INSERT INTO categories_d (nom_cat) VALUES (?)");
    $stmt->execute([$nom]);
}
if (isset($_POST['edit_category'])) {
    $id = $_POST['id_cat'];
    $nom = $_POST['nom_cat'];
    $stmt = $pdo->prepare("UPDATE categories_d SET nom_cat=? WHERE id_cat=?");
    $stmt->execute([$nom, $id]);
}
if (isset($_GET['delete_category'])) {
    $id = $_GET['delete_category'];
    $stmt = $pdo->prepare("DELETE FROM categories_d WHERE id_cat=?");
    $stmt->execute([$id]);
}

// Gestion des commandes
if (isset($_GET['delete_order'])) {
    $id = $_GET['delete_order'];
    $stmt = $pdo->prepare("DELETE FROM commandes_d WHERE id_com=?");
    $stmt->execute([$id]);
}

// Statistiques
$chiffreAffaire = $pdo->query("SELECT SUM(total) as ca FROM commandes_d")->fetch()['ca'] ?? 0;
$produitsStats = $pdo->query("
    SELECT nom_prod, SUM(quantite) AS quantite_totale, COUNT(DISTINCT id_com) AS nb_commandes
    FROM commandes_d
    GROUP BY nom_prod
    ORDER BY quantite_totale DESC
")->fetchAll();

// Récupération des données pour affichage
$produits = $pdo->query("SELECT p.*, c.nom_cat as categorie FROM produits_d p LEFT JOIN categories_d c ON p.id_cat = c.id_cat")->fetchAll();
$categories = getCategories($pdo);
$commandes = $pdo->query("
    SELECT c.*, u.nom_uti, u.prenom_uti 
    FROM commandes_d c 
    LEFT JOIN utilisateurs_d u ON c.id_uti = u.id_uti
")->fetchAll();

// Gestion du profil admin
if (isset($_POST['edit_admin'])) {
    $new_nom = $_POST['nom'] ?? '';
    $new_prenom = $_POST['prenom'] ?? '';
    $new_email = $_POST['email'] ?? '';
    $new_mdp = $_POST['mot_de_passe'] ?? '';
    $admin_id = $admin['id'];
    $params = [$new_nom, $new_prenom, $new_email, $admin_id];

    // Si le mot de passe est modifié, on le hash et on l'update
    if (!empty($new_mdp)) {
        $new_mdp_hash = password_hash($new_mdp, PASSWORD_BCRYPT);
        $sql = "UPDATE admin SET nom=?, prenom=?, email=?, mot_de_passe=? WHERE id=?";
        $params = [$new_nom, $new_prenom, $new_email, $new_mdp_hash, $admin_id];
    } else {
        $sql = "UPDATE admin SET nom=?, prenom=?, email=? WHERE id=?";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Mets à jour la session si l'email a changé
    $_SESSION['user'] = $new_email;
    // Recharge les infos admin
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE id = ?");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch();
    $profil_message = "Profil mis à jour avec succès.";
}

// GESTION DE LA SUPPRESSION DE REÇU (doit être AVANT la récupération des reçus)
if (isset($_GET['delete_recu'])) {
    $num_recu = $_GET['delete_recu'];
    $stmt = $pdo->prepare("DELETE FROM commandes_d WHERE num_recu = ?");
    $stmt->execute([$num_recu]);
    // Redirection pour éviter la suppression multiple au rafraîchissement
    header('Location: admin.php#recus');
    exit();
}

// Ensuite seulement, tu fais la récupération des reçus :
$recu_search = $_GET['recu_search'] ?? '';
$where = '';
$params = [];
if ($recu_search) {
    $where = "WHERE num_recu = ?";
    $params[] = $recu_search;
}
$recus = $pdo->prepare("
    SELECT num_recu, id_com, date_com, id_uti, SUM(total) as total
    FROM commandes_d
    $where
    GROUP BY num_recu, id_com, date_com, id_uti
    ORDER BY date_com DESC
");
$recus->execute($params);
$liste_recus = $recus->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Dzesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #F4ECD6; padding-top: 56px; }
        .admin-container {
            max-width: 1200px;
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
            min-width:110px;
        }
        .btn-outline-dark:hover {
            background-color: black !important;
            color: white !important;
            border-radius: 0 !important;
        }
        .table th, .table td { vertical-align: middle; }
        .nav-tabs .nav-link.active {
            background-color: #F4ECD6;
            border-color: #000 #000 #fff;
            color: #000;
            font-weight: bold;
        }
        select, select option {
    color: black !important;
}
.modal-content {
    background: #fff !important;
    border: 2px solid #000 !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.15);
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color:white;box-shadow: 0 2px;">
        <div class="container-fluid">
            <a class="navbar-brand mx-auto" href="index.php" style="color: black;">Dzesi</a>
            <div class="d-flex align-items-center gap-3">
                <a href="deconnexion.php" class="btn btn-outline-dark">Retour au site</a>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <ul class="nav nav-tabs mb-4"  id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" style="color: #000; border-radius: 0;" id="produits-tab" data-bs-toggle="tab" data-bs-target="#produits" type="button" role="tab">Produits</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" style="color: #000; border-radius: 0;" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab">Catégories</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" style="color: #000; border-radius: 0;" id="commandes-tab" data-bs-toggle="tab" data-bs-target="#commandes" type="button" role="tab">Commandes</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" style="color: #000; border-radius: 0;" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button" role="tab">Statistiques</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" style="color: #000; border-radius: 0;" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab">Mon profil</button>
            </li>
            <li class="nav-item" role="presentation">
    <button class="nav-link" style="color: #000; border-radius: 0;" id="recus-tab" data-bs-toggle="tab" data-bs-target="#recus" type="button" role="tab">Reçus</button>
</li>
        </ul>
        <div class="tab-content" id="adminTabsContent">
            <!-- Produits -->
            <div class="tab-pane fade show active" id="produits" role="tabpanel">
                <h4>Liste des produits</h4>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Catégorie</th>
                            <th>Description</th>
                            <th>Quantité</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produits as $prod): ?>
                        <tr>
                            <td><?= htmlspecialchars($prod['nom_prod'] ?? '') ?></td>
                            <td><?= htmlspecialchars($prod['prix'] ?? '') ?> €</td>
                            <td><?= htmlspecialchars($prod['categorie'] ?? '') ?></td>
                            <td><?= htmlspecialchars($prod['desc_prod'] ?? '') ?></td>
                            <td><?= htmlspecialchars($prod['quantite_stock'] ?? '') ?></td>
                            <td>
    <?php if (!empty($prod['image'])): ?>
        <img src="<?= htmlspecialchars($prod['image']) ?>" alt="" style="width:60px;height:60px;object-fit:cover;">
    <?php endif; ?>
</td>
                            <td>
                                <!-- Modifier -->
                                <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal<?= $prod['id_prod'] ?>"><i class="bi bi-pencil"></i></button>
                                <!-- Supprimer -->
                                <a href="?delete_product=<?= $prod['id_prod'] ?>" class="btn btn-outline-dark btn-sm" onclick="return confirm('Supprimer ce produit ?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <!-- Modal édition produit -->
<?php foreach ($produits as $prod): ?>
<div class="modal fade" id="editProductModal<?= $prod['id_prod'] ?>" tabindex="-1"
     aria-labelledby="editProductModalLabel<?= $prod['id_prod'] ?>" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">

    <form method="post" class=" edit-product-form" enctype="multipart/form-data" data-modal="#editProductModal<?= $prod['id_prod'] ?>">
          <div class="modal-dialog">
            <div class="modal-content">
      <div class="modal-header" style="background:#F4ECD6; border-bottom:2px solid #000;">
        <h5 class="modal-title" id="editProductModalLabel<?= $prod['id_prod'] ?>">Modifier le produit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" style="background:#fff;">
        <input type="hidden" name="id" value="<?= $prod['id_prod'] ?>">
        <input type="hidden" name="old_image" value="<?= htmlspecialchars($prod['image']) ?>">
        <div class="mb-2">
          <label>Nom</label>
          <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($prod['nom_prod']) ?>" required>
        </div>
        <div class="mb-2">
          <label>Prix</label>
          <input type="number" name="prix" class="form-control" value="<?= htmlspecialchars($prod['prix']) ?>" required>
        </div>
        <div class="mb-2">
          <label>Catégorie</label>
          <select name="categorie" class="form-control" required>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id_cat'] ?>" <?= $cat['id_cat']==$prod['id_cat']?'selected':'' ?>><?= htmlspecialchars($cat['nom_cat']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-2">
          <label>Quantité</label>
          <input type="number" name="quantite" class="form-control" value="<?= htmlspecialchars($prod['quantite_stock']) ?>" required>
        </div>
        <div class="mb-2">
          <label>Description</label>
          <textarea name="description" class="form-control"><?= htmlspecialchars($prod['desc_prod']) ?></textarea>
        </div>
        <div class="mb-2">
          <label for="edit_image_<?= $prod['id_prod'] ?>" class="form-label">Nouvelle image (laisser vide pour ne pas changer)</label>
          <input type="file" name="image" id="edit_image_<?= $prod['id_prod'] ?>" class="form-control" accept="image/*">
          <?php if (!empty($prod['image'])): ?>
            <div class="mt-2">
              <img src="<?= htmlspecialchars($prod['image']) ?>" alt="" style="width:60px;height:60px;object-fit:cover;">
              <small class="text-muted d-block">Image actuelle</small>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="modal-footer" style="background:#F4ECD6; border-top:2px solid #000;">
        <button type="submit" name="edit_product" class="btn btn-outline-dark">Enregistrer</button>
      </div>
      </div>
      </div>
    </form>
  
</div>
<?php endforeach; ?>
                <?php endforeach; ?>
                    </tbody>
                </table>
                <h5 class="mt-4">Ajouter un produit</h5>
                <form method="post" class="row g-3" enctype="multipart/form-data">
                    <div class="col-md-3">
                        <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="prix" class="form-control" placeholder="Prix" required>
                    </div>
                    <div class="col-md-3">
                        <select name="categorie" class="form-control" required>
                            <option value="">Catégorie</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id_cat'] ?>"><?= htmlspecialchars($cat['nom_cat']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="quantite" class="form-control" placeholder="Quantité" required>
                    </div>
                    <div class="col-md-3 d-flex flex-column">
    <label for="image" class="form-label">Image</label>
    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
</div>
                    <div class="col-md-12">
                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" name="add_product" class="btn btn-outline-dark">Ajouter</button>
                    </div>
                </form>
            </div>
            <!-- Catégories -->
            <div class="tab-pane fade" id="categories" role="tabpanel">
                <h4>Liste des catégories</h4>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= htmlspecialchars($cat['nom_cat']) ?></td>
                            <td>
                                <!-- Modifier -->
                                <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?= $cat['id_cat'] ?>"><i class="bi bi-pencil"></i></button>
                                <!-- Supprimer -->
                                <a href="?delete_category=<?= $cat['id_cat'] ?>" class="btn btn-outline-dark btn-sm" onclick="return confirm('Supprimer cette catégorie ?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Place toutes les modales ici, après la table -->
                <?php foreach ($categories as $cat): ?>
                <div class="modal fade" id="editCategoryModal<?= $cat['id_cat'] ?>" tabindex="-1">
        
                    <form method="post" class="modal-content">
                        <div class="modal-dialog">
                            <div class="modal-header">
                        <h5 class="modal-title">Modifier la catégorie</h5>
                        tton type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $cat['id_cat'] ?>">
                        <div class="mb-2">
                          <label>Nom</label>
                          <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($cat['nom_cat']) ?>" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="edit_category" class="btn btn-outline-dark">Enregistrer</button>
                      </div></tr>
                        </div>
                      
                    </form>
                
                </div>
                <?php endforeach; ?>
            </div>
            <!-- Commandes -->
            <div class="tab-pane fade" id="commandes" role="tabpanel">
                <h4>Liste des commandes</h4>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID commande</th>
                            <th>ID utilisateur</th>
                            <th>Nom produit</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Adresse livraison</th>
                            <th>Mode paiement</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandes as $cmd): ?>
                        <tr>
                            <td><?= $cmd['id_com'] ?></td>
                            <td><?= $cmd['id_uti'] ?></td>
                            <td><?= htmlspecialchars($cmd['nom_prod']) ?></td>
                            <td><?= $cmd['date_com'] ?></td>
                            <td><?= number_format($cmd['total'], 2, ',', ' ') ?> €</td>
                            <td><?= htmlspecialchars($cmd['adresse_livraison']) ?></td>
                            <td><?= htmlspecialchars($cmd['mode_paiement']) ?></td>
                            <td>
                    <?php if (!empty($cmd['image'])): ?>
                        <img src="<?= htmlspecialchars($cmd['image']) ?>" alt="" style="width:60px;height:60px;object-fit:cover;">
                    <?php endif; ?>
                </td>
                            <td>
                                <a href="?delete_order=<?= $cmd['id_com'] ?>" class="btn btn-outline-dark btn-sm" onclick="return confirm('Supprimer cette commande ?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Statistiques -->
            <div class="tab-pane fade" id="stats" role="tabpanel">
                <h4>Statistiques</h4>
                <div class="mb-3">
                    <strong>Chiffre d'affaires général :</strong>
                    <span><?= number_format($chiffreAffaire, 2, ',', ' ') ?> €</span>
                </div>
                <h5>Produits achetés</h5>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité totale achetée</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produitsStats as $stat): ?>
                        <tr>
                            <td><?= htmlspecialchars($stat['nom_prod']) ?></td>
                            <td><?= $stat['quantite_totale'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Profil -->
            <div class="tab-pane fade" id="profil" role="tabpanel">
                <h4>Mon profil</h4>
                <form method="post" class="row g-3">
                    <div class="col-md-6">
                        <label>Nom</label>
                        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($admin['nom']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($admin['prenom']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Mot de passe</label>
                        <input type="password" name="mdp" class="form-control" placeholder="Laissez vide si inchangé">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" name="edit_profil" class="btn btn-outline-dark">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
            <!-- Reçus -->
            <div class="tab-pane fade" id="recus" role="tabpanel">
                <h4>Recherche de reçu</h4>
                <form method="get" class="row g-3 mb-4">
                    <div class="col-md-8">
                        <input type="text" name="recu_search" class="form-control" placeholder="Numéro de reçu" value="<?= htmlspecialchars($recu_search) ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-outline-dark w-100">Rechercher</button>
                    </div>
                </form>

                <?php if ($liste_recus): ?>
                <h5>Résultats de recherche</h5>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Numéro de reçu</th>
                            <th>ID commande</th>
                            <th>Date</th>
                            <th>ID utilisateur</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($liste_recus as $recu): ?>
                        <tr>
                            <td><?= htmlspecialchars($recu['num_recu'] ?? '') ?></td>
                            <td><?= $recu['id_com'] ?? '' ?></td>
                            <td><?= $recu['date_com'] ?? '' ?></td>
                            <td><?= $recu['id_uti'] ?? '' ?></td>
                            <td><?= number_format($recu['total'] ?? 0, 2, ',', ' ') ?> €</td>
                            <td>
                                <a href="recu.php?num_recu=<?= urlencode($recu['num_recu'] ?? '') ?>&id_com=<?= urlencode($recu['id_com'] ?? '') ?>" class="btn btn-outline-dark btn-sm" target="_blank">
    Voir / Télécharger
</a>

                                <a href="?delete_recu=<?= urlencode($recu['num_recu'] ??'') ?>#recus" class="btn btn-outline-danger btn-sm ms-1"
                                   onclick="return confirm('Supprimer ce reçu ? Cette action est irréversible !')">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="alert alert-info">Aucun reçu trouvé pour cette recherche.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.querySelectorAll('.edit-product-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        // On laisse le formulaire se soumettre normalement (POST)
        // Mais on ferme la modal juste après
        setTimeout(() => {
            const modalId = form.getAttribute('data-modal');
            const modal = bootstrap.Modal.getInstance(document.querySelector(modalId));
            if (modal) modal.hide();
        }, 300); // Laisse le temps au serveur de traiter et recharger
    });
});
</script>
</body>
</html>