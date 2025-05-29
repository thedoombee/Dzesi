<?php
// filepath: c:\wamp64\www\Dzesi\recu.php
session_start();
require_once 'db.php';

$num_recu = $_GET['num_recu'] ?? '';
if (!$num_recu) {
    die("Numéro de reçu invalide.");
}
$stmt = $pdo->prepare("SELECT * FROM commandes_d WHERE num_recu = ?");
$stmt->execute([$num_recu]);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
//echo '<pre>'; print_r($commandes[0]); echo '</pre>';

if (!$commandes) {
    die("Aucun reçu trouvé.");
}

// Infos générales (on prend la première ligne du reçu)
$id_com = $commandes[0]['id_com'];
$date_com = $commandes[0]['date_com'];
$id_uti = $commandes[0]['id_uti'];
$adresse = $commandes[0]['adresse_livraison'];
$mode_paiement = $commandes[0]['mode_paiement'];

$total_general = 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; }
        .recu-container { max-width: 700px; margin: 40px auto; border:1px solid #ccc; padding:30px; border-radius:8px;}
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
<div class="recu-container">
    <h2 class="mb-4">Reçu de commande</h2>
    <p><strong>Numéro de reçu :</strong> <?= htmlspecialchars($num_recu ?? '') ?></p>
    <p><strong>ID Commande :</strong> <?= htmlspecialchars($id_com ?? '') ?></p>
    <p><strong>Date :</strong> <?= htmlspecialchars($date_com ?? '') ?></p>
    <p><strong>ID Client :</strong> <?= htmlspecialchars($id_uti ?? '') ?></p>
    <p><strong>Adresse de livraison :</strong> <?= htmlspecialchars($adresse ?? '') ?></p>
    <p><strong>Mode de paiement :</strong> <?= htmlspecialchars($mode_paiement ?? '') ?></p>
    <hr>
    <h5>Produits achetés</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($commandes as $cmd): ?>
            <tr>
                <td><?= htmlspecialchars($cmd['nom_prod']) ?></td>
                <td><?= number_format($cmd['total'] / $cmd['quantite'], 2, ',', ' ') ?> €</td>
                <td><?= $cmd['quantite'] ?></td>
                <td><?= number_format($cmd['total'], 2, ',', ' ') ?> €</td>
            </tr>
            <?php $total_general += $cmd['total']; ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total général</th>
                <th><?= number_format($total_general, 2, ',', ' ') ?> €</th>
            </tr>
        </tfoot>
    </table>
    <div class="text-end mt-4">
        <button onclick="window.print()" class="btn btn-outline-dark">Imprimer / Enregistrer en PDF</button>
    </div>
</div>
</body>
</html>