<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
include 'db.php';

// Récupérer l'email du propriétaire depuis la table informations_d
$stmt = $pdo->query("SELECT email FROM informations_d LIMIT 1");
$info = $stmt->fetch();
$email_admin = $info['email'] ?? '';

//Récupérer le numéro de l'admin

$stmt = $pdo->query("SELECT numero FROM informations_d LIMIT 1" );
$info = $stmt->fetch();
$num = $info['numero'] ?? '';

//Récupérer l'Adresse de l'Entreprise 

$stmt = $pdo->query("SELECT adresse FROM informations_d LIMIT 1" );
$info = $stmt->fetch();
$add = $info['adresse'] ?? '';


// Initialisation des champs
$message = '';
$nom = '';
$sujet = '';
$contenu = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom'] ?? '');
    $sujet = htmlspecialchars($_POST['sujet'] ?? '');
    $contenu = htmlspecialchars($_POST['message'] ?? '');

    if (!$nom || !$sujet || !$contenu) {
        $message = '<div class="alert alert-danger">Tous les champs sont obligatoires.</div>';
    } elseif (!$email_admin) {
        $message = '<div class="alert alert-danger">Aucune adresse email d\'administrateur n\'est configurée.</div>';
    } else {
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tonemail@gmail.com'; // Ton email Gmail
            $mail->Password = 'mot_de_passe_application'; // Mot de passe d'application Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('tonemail@gmail.com', 'Dzesi');
            $mail->addAddress($email_admin);

            $mail->Subject = "Contact Dzesi - $sujet";
            $mail->Body = "Nom: $nom\n\nMessage:\n$contenu";

            $mail->send();
            $message = '<div class="alert alert-success">Votre message a bien été envoyé. Merci de nous avoir contactés !</div>';
            // Vider les champs après envoi
            $nom = '';
            $sujet = '';
            $contenu = '';
        } catch (Exception $e) {
            $message = '<div class="alert alert-danger">Erreur lors de l\'envoi du message : ' . $mail->ErrorInfo . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact - Dzesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #F4ECD6; }
        .contact-container {
            max-width: 700px;
            margin: 3rem auto;
            background: #fff;
            border: 2px solid #F4ECD6;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            padding: 2.5rem 2rem;
        }
        .contact-title {
            font-size: 2rem;
            font-weight: 700;
            color: #222;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: 2px;
        }
        .form-label { font-weight: 500; }
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
            min-width:130px;
        }
        .btn-outline-dark:hover {
            background-color: black !important;
            color: white !important;
            border-radius: 0 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color:white;box-shadow: 0 2px;">
        <div class="container-fluid">
            <a class="navbar-brand position-absolute start-50 translate-middle-x" href="index.php" style="color: black;">Dzesi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="menu-icon">
                    <i class="bi bi-list"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse order-lg-0 order-2" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="produits.php" style="color: black;">Boutique</a></li>
                    <li class="nav-item"><a class="nav-link" href="a-propos.php" style="color: black;">À propos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contact.php" style="color: black;">Contact</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-3 order-lg-2 order-1" style="width:auto;">
                <a href="./panier.php" class="icon-link text-dark"><i class="bi bi-cart fs-5"></i></a>
                <a href="#" class="icon-link text-dark"><i class="bi bi-facebook fs-5"></i></a>
                <a href="#" class="icon-link text-dark"><i class="bi bi-twitter fs-5"></i></a>
                <?php if (file_exists('includes/bouton_compte.php')) include 'includes/bouton_compte.php'; ?>
            </div>
        </div>
    </nav>

    <div class="contact-container mt-5">
        <div class="contact-title"><i class="bi bi-envelope"></i> Contactez-nous</div>
        <?= $message ?>
        <form method="post" class="mb-4">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required value="<?= htmlspecialchars($nom) ?>">
            </div>
            <div class="mb-3">
                <label for="sujet" class="form-label">Sujet</label>
                <input type="text" class="form-control" id="sujet" name="sujet" required value="<?= htmlspecialchars($sujet) ?>">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required><?= htmlspecialchars($contenu) ?></textarea>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-outline-dark">Envoyer</button>
            </div>
        </form>
        <hr>
        <div>
            <h5 class="mb-3">Nos coordonnées</h5>
            <ul class="list-unstyled">
                <li class="mb-2"><i class="bi bi-envelope"></i> Email : <a href="mailto:<?= htmlspecialchars($email_admin) ?>" class="text-decoration-none"><?= htmlspecialchars($email_admin) ?></a></li>
                <!-- Tu peux aussi afficher numéro et adresse ici si tu veux -->
                 <li class="mb-2"><i class="bi bi-phone"></i> Téléphone : <a href="mailto:<?= htmlspecialchars($num) ?>" class="text-decoration-none"><?= htmlspecialchars($num) ?></a></li>

                 <li class="mb-2"><i class="bi bi-location"></i> Adresse : <a href="mailto:<?= htmlspecialchars($add) ?>" class="text-decoration-none"><?= htmlspecialchars($add) ?></a></li>
            </ul>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>