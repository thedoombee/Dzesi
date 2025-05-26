<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_uti = htmlspecialchars($_POST['nom_uti']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Format d'email invalide.");
    }

    $sql = "INSERT INTO utilisateurs_d (nom_uti, email_uti, mot_de_passe) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nom_uti, $email, $mot_de_passe);

    if ($stmt->execute()) {
        header("Location: connexion.php");
        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
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
        <label for="name" class="form-label">Nom complet</label>
        <input type="text" class="form-control" id="name" name="nom_uti" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="motdepasse" required>
      </div>
      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
        <input type="password" class="form-control" id="confirmPassword" required>
      </div>
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

