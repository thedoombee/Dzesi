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
        body {
            background: #F4ECD6;
        }
        .dzesi-title {
            font-size: 2.7rem;
            font-weight: bold;
            letter-spacing: 2px;
            color: #000;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 0.5rem;
        }
        .recu-container {
            max-width: 700px;
            margin: 30px auto 40px auto;
            background: #fff;
            border: 2px solid #F4ECD6;
            padding: 40px 30px 30px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-outline-dark, .btn-outline-dark:focus {
            border-color: #F4ECD6 !important;
            color: #000;
        }
        .btn-outline-dark:hover {
            background: #F4ECD6;
            color: #000;
        }
        hr {
            border-top: 2px solid #F4ECD6;
        }
        @media print {
            .btn, .text-end, .merci-message { display: none !important; }
            .recu-container { box-shadow: none; border: none; }
        }
    </style>
</head>
<body>
    <div class="dzesi-title">Dzesi</div>
    <div class="recu-container">
        <h2 class="mb-4 text-center" style="letter-spacing:1px;">Reçu de commande</h2>
        <div class="mb-3">
            <p><strong>Numéro de reçu :</strong> <?= htmlspecialchars($num_recu ?? '') ?></p>
            <p><strong>ID Commande :</strong> <?= htmlspecialchars($id_com ?? '') ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($date_com ?? '') ?></p>
            <p><strong>ID Client :</strong> <?= htmlspecialchars($id_uti ?? '') ?></p>
            <p><strong>Adresse de livraison :</strong> <?= htmlspecialchars($adresse ?? '') ?></p>
            <p><strong>Mode de paiement :</strong> <?= htmlspecialchars($mode_paiement ?? '') ?></p>
        </div>
        <hr>
        <h5 class="mb-3">Produits achetés</h5>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 40%;">Produit</th>
                    <th style="width: 20%; text-align: right;">Prix unitaire</th>
                    <th style="width: 15%; text-align: center;">Quantité</th>
                    <th style="width: 25%; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($commandes as $cmd): ?>
                <tr>
                    <td><?= htmlspecialchars($cmd['nom_prod']) ?></td>
                    <td style="text-align: right;"><?= number_format($cmd['total'] / $cmd['quantite'], 2, ',', ' ') ?> €</td>
                    <td style="text-align: center;"><?= $cmd['quantite'] ?></td>
                    <td style="text-align: right;"><?= number_format($cmd['total'], 2, ',', ' ') ?> €</td>
                </tr>
                <?php $total_general += $cmd['total']; ?>
            <?php endforeach; ?>
            </tbody>
            <tr style="font-weight: bold;">
    <td colspan="3" style="text-align: right;">Total général</td>
    <td style="text-align: right;"><?= number_format($total_general, 2, ',', ' ') ?> €</td>
</tr>

        </table>
        <div class="text-end mt-4">
            <button onclick="window.print()" class="btn btn-outline-dark">Imprimer / Enregistrer en PDF</button>
        </div>
        <hr>
        <div class="text-center">
            <h2> Merci de votre visite chez nous</h2>
           
        </div>
    </div>
</body>
</html>