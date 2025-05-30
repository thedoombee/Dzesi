<?php
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_uti = htmlspecialchars($_POST['nom_uti'] ?? '');
    $prenom_uti = htmlspecialchars($_POST['prenom_uti'] ?? '');
    $telephone = htmlspecialchars($_POST['telephone'] ?? '');
    $ville = htmlspecialchars($_POST['ville'] ?? '');
    $email_uti = filter_var($_POST['email_uti'] ?? '', FILTER_SANITIZE_EMAIL);
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    if (!filter_var($email_uti, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide.";
    } elseif (empty($mot_de_passe) || strlen($mot_de_passe) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // Vérifie si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id_uti FROM utilisateurs_d WHERE email_uti = ?");
        $stmt->execute([$email_uti]);
        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);
            $sql = "INSERT INTO utilisateurs_d (nom_uti, prenom_uti, telephone, ville, email_uti, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nom_uti, $prenom_uti, $telephone, $ville, $email_uti, $mot_de_passe_hash])) {
                header("Location: connexion.php");
                exit();
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - Dzesi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      background-color: #F4ECD6;
      min-height: 100vh;
      font-family: 'Segoe UI', Arial, sans-serif;
    }
    .dzesi-navbar {
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .dzesi-brand {
      font-family: 'Segoe Script', 'Brush Script MT', cursive;
      font-size: 2.1rem;
      font-weight: bold;
      color: #7a6a3a !important;
      letter-spacing: 2px;
      text-shadow: 1px 1px 8px #f4ecd6;
    }
    .form-container {
      max-width: 410px;
      margin: 5rem auto 2rem auto;
      background: #fff;
      padding: 2.5rem 2rem 2rem 2rem;
      border-radius: 0;
      border: 2px solid black;
      box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    }
    .form-container input{
      border-radius: 0;
    }
    .btn-black {
      border: 2px solid black;
      background-color: transparent;
      width: 100%;
      padding: 10px;
      font-weight: 600;
      border-radius: 0;
      transition: 0.2s;
      letter-spacing: 1px;
    }
    .btn-black:hover {
      background-color: black;
      color: white;
      border-radius: 0;
    }
    .error {
      color: #b02a37;
      font-size: 0.97rem;
      margin-top: 0.5rem;
      text-align: center;
    }
    .dzesi-link {
      color: #7a6a3a;
      text-decoration: underline;
      font-weight: 500;
    }
    .dzesi-link:hover {
      color: #222;
      text-decoration: none;
    }
    .dzesi-title {
      font-family: 'Segoe Script', 'Brush Script MT', cursive;
      color: #7a6a3a;
      font-size: 2rem;
      text-align: center;
      margin-bottom: 0.5rem;
      font-weight: bold;
      letter-spacing: 2px;
    }
    .form-container input:focus, 
.form-container input:active, 
.form-container textarea:focus, 
.form-container textarea:active {
  border-color: #F4ECD6 !important;
  box-shadow: 0 0 0 0.2rem rgba(244,236,214,0.5) !important;
  outline: none !important;
}
  </style>
</head>
<body>
  <nav class="navbar dzesi-navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="dzesi-brand mx-auto" style="text-decoration: none;" href="index.php">Dzesi</a>
    </div>
  </nav>

  <div class="form-container">
    <div class="dzesi-title mb-2">Inscription</div>
    <form id="signupForm" method="POST" action="">
      <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" class="form-control" id="name" name="nom_uti" required>
      </div>
      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom_uti" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email_uti" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="mot_de_passe" required>
      </div>
      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
        <input type="password" class="form-control" id="confirmPassword" required>
      </div>
      <div class="mb-3">
        <label for="telephone" class="form-label">Numéro de téléphone</label>
        <input type="text" class="form-control" id="telephone" name="telephone" required>
      </div>
      <div class="mb-3">
        <label for="ville" class="form-label">Ville</label>
        <input type="text" class="form-control" id="ville" name="ville" required>
      </div>
      <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <div id="errorMsg" class="error"></div>
      <button type="submit" class="btn btn-black mt-3" name="submit">Créer un compte</button>
      <p class="mt-3 text-center">Déjà inscrit ? <a href="connexion.php" class="dzesi-link">Connectez-vous</a></p>
    </form>
  </div>

  <script>
    const form = document.getElementById("signupForm");
    const errorMsg = document.getElementById("errorMsg");

    form.addEventListener("submit", function(e) {
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirmPassword").value;

      if (password !== confirmPassword) {
        e.preventDefault();
        errorMsg.textContent = "Les mots de passe ne correspondent pas.";
      }
    });
  </script>
</body>
</html>