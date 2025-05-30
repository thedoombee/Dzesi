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
            $_SESSION['id_uti'] = $user['id_uti'];
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
  <title>Connexion - Dzesi</title>
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

  <div class="form-container" >
    <div class="dzesi-title mb-2">Connexion</div>
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
      <p class="mt-3 text-center">Pas encore de compte ? <a href="inscription.php" class="dzesi-link">Inscrivez-vous</a></p>
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