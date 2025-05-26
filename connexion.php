<?php
ob_start(); // Active la mise en mémoire tampon
session_start();

// Debug : affiche les données POST (à supprimer après test)

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
        <input type="email" class="form-control" id="email" name="email" required>
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
      const email = document.getElementById("email").value.trim();
      const mot_de_passe = document.getElementById("password").value;
      const error = document.getElementById("loginError");

      if (!email || !mot_de_passe) {
        error.textContent = "Veuillez remplir tous les champs.";
        event.preventDefault(); // Empêche la soumission seulement si validation échoue
        return;
      }

      // Si validation réussie, le formulaire se soumet normalement
      error.textContent = "";
    });
  </script>

</body>
</html>
