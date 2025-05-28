<?php
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_uti = htmlspecialchars($_POST['nom_uti'] ?? '');
    $prenom_uti = htmlspecialchars($_POST['prenom_uti'] ?? '');
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
            $sql = "INSERT INTO utilisateurs_d (nom_uti, prenom_uti, email_uti, mot_de_passe) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nom_uti, $prenom_uti, $email_uti, $mot_de_passe_hash])) {
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
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
      padding: 2rem;
    }
    .form-container {
      max-width: 400px;
      margin: auto;
      background: white;
      padding: 2rem;
      border: 1px solid #ddd;
    }
    .btn-black {
      border: 2px solid black;
      background-color: transparent;
      width: 100%;
      padding: 10px;
      font-weight: 600;
      transition: 0.2s;
    }
    .btn-black:hover {
      background-color: black;
      color: white;
    }
    .error {
      color: red;
      font-size: 0.9rem;
      margin-top: 0.5rem;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2 class="mb-4 text-center">Inscription</h2>
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
      <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <div id="errorMsg" class="error"></div>
      <button type="submit" class="btn btn-black mt-3" name="submit">Créer un compte</button>
      <p class="mt-3 text-center">Déjà inscrit ? <a href="connexion.php">Connectez-vous</a></p>
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

