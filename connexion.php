<?php
ob_start();
session_start();
include 'db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email_uti'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    // 1. Cherche d'abord dans la table utilisateurs_d
    $stmt = $pdo->prepare('SELECT * FROM utilisateurs_d WHERE email_uti = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // 2. Si pas trouvé, cherche dans la table admin
    if (!$user) {
        $stmt = $pdo->prepare('SELECT * FROM admin WHERE email = ?');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
            $_SESSION['user'] = $admin['email'];
            $_SESSION['role'] = 'admin';
            header('Location: admin.php');
            exit();
        } else {
            $error = "Adresse e-mail ou mot de passe incorrect.";
        }
    } else {
        // Utilisateur classique
        if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['user'] = $user['email_uti'];
            $_SESSION['role'] = 'user';
            $_SESSION['id_uti'] = $user['id_uti']; // Ajout de l'ID utilisateur à la session
            header('Location: index.php');
            exit();
        } else {
            $error = "Adresse e-mail ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
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
    <h2 class="mb-4 text-center">Connexion</h2>
    <form id="loginForm" action="connexion.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email_uti" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="mot_de_passe" required>
      </div>
      <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <div id="loginError" class="error"></div>
      <button type="submit" class="btn btn-black mt-3">Se connecter</button>
      <p class="mt-3 text-center">Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
    </form>
  </div>

  <script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
      const email_uti = document.getElementById("email").value.trim();
      const mot_de_passe = document.getElementById("password").value;
      const error = document.getElementById("loginError");

      if (!email_uti || !mot_de_passe) {
        error.textContent = "Veuillez remplir tous les champs.";
        event.preventDefault();
        return;
      }
      error.textContent = "";
    });
  </script>
</body>
</html>
