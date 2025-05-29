<?php
session_start();
require_once 'db.php';

// Debug temporaire
//echo '<pre>'; print_r($_SESSION); echo '</pre>';

// Vérifier que le panier n'est pas vide
$panier = $_SESSION['panier'] ?? [];
if (empty($panier)) {
    header('Location: panier.php');
    exit;
}

// Récupérer les produits du panier
$ids = array_keys($panier);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT * FROM produits_d WHERE id_prod IN ($placeholders)");
$stmt->execute($ids);
$produits_panier = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($produits_panier as &$prod) {
    $prod['quantite'] = $panier[$prod['id_prod']];
    $prod['sous_total'] = $prod['prix'] * $prod['quantite'];
    $total += $prod['sous_total'];
}
unset($prod);

// Traitement du formulaire
$message = '';
$id_uti = isset($_SESSION['id_uti']) ? intval($_SESSION['id_uti']) : null;
$num_recu = strtoupper(uniqid('RC'));


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adresse = trim($_POST['adresse'] ?? '');
    $mode_paiement = $_POST['mode_paiement'] ?? '';
    $date_com = date('Y-m-d H:i:s');
    if ($adresse && $mode_paiement) {
        // Générer un nouvel id_com (auto-incrément)
        // 1. Insérer une ligne "vide" pour obtenir un nouvel id_com
        $stmt = $pdo->prepare("INSERT INTO commandes_d (id_uti, date_com) VALUES (?, ?)");
        $stmt->execute([$id_uti, $date_com]);
        $id_com = $pdo->lastInsertId();

        // 2. Supprimer cette ligne "vide" (optionnel, ou tu peux la remplir avec le premier produit)
        $stmt = $pdo->prepare("DELETE FROM commandes_d WHERE id_ligne = ?");
        $stmt->execute([$id_com]);

        // 3. Insérer tous les produits avec ce même id_com et num_recu
        foreach ($produits_panier as $prod) {
            $stmt = $pdo->prepare("INSERT INTO commandes_d 
                (id_com, id_uti, date_com, total, adresse_livraison, mode_paiement, nom_prod, image, quantite, num_recu) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $id_com,
                $id_uti,
                $date_com,
                $prod['sous_total'],
                $adresse,
                $mode_paiement,
                $prod['nom_prod'],
                $prod['image'],
                $prod['quantite'],
                $num_recu
            ]);

            // Mise à jour du stock
            $stmt = $pdo->prepare("UPDATE produits_d SET quantite_stock = quantite_stock - ? WHERE id_prod = ?");
            $stmt->execute([$prod['quantite'], $prod['id_prod']]);
        }
        $_SESSION['panier'] = [];
        $message = "Commande enregistrée ! (Paiement test Stripe)";
        $dernier_id_com = $id_com;
        $dernier_num_recu = $num_recu;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement - Dzesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; }
        .commande-container { max-width: 600px; margin: 40px auto; }
        .recap-produit img { width: 60px; height: 60px; object-fit: cover; }
    </style>
</head>
<body>
    <div class="container commande-container">
        <h2 class="mb-4">Finaliser ma commande</h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
            <a href="produits.php" class="btn btn-dark">Retour à la boutique</a>
            <?php if (!empty($dernier_num_recu)): ?>
                <a href="recu.php?num_recu=<?= urlencode($dernier_num_recu) ?>&id_com=<?= urlencode($dernier_id_com) ?>" class="btn btn-outline-success ms-2" target="_blank">Télécharger le reçu</a>

            <?php endif; ?>
        <?php else: ?>
        <form method="post">
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse de livraison</label>
                <textarea name="adresse" id="adresse" class="form-control" required rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Mode de paiement</label>
                <select name="mode_paiement" class="form-select" required>
                    <option value="">Choisir...</option>
                    <option value="stripe_test">Stripe (Mode Test)</option>
                </select>
            </div>
            <h5>Récapitulatif du panier</h5>
            <ul class="list-group mb-3">
                <?php foreach ($produits_panier as $prod): ?>
                    <li class="list-group-item d-flex align-items-center recap-produit">
                        <img src="<?= htmlspecialchars($prod['image']) ?>" alt="" class="me-3">
                        <div>
                            <?= htmlspecialchars($prod['nom_prod']) ?> <br>
                            <small>Quantité : <?= $prod['quantite'] ?></small>
                        </div>
                        <span class="ms-auto fw-bold"><?= number_format($prod['sous_total'], 2, ',', ' ') ?> €</span>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total</span>
                    <span class="fw-bold"><?= number_format($total, 2, ',', ' ') ?> €</span>
                </li>
            </ul>
            <button type="submit" class="btn btn-outline-dark w-100">Valider et payer</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>