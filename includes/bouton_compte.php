<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php if (isset($_SESSION['user'])): ?>
    <a href="moncompte.php" class="btn btn-outline-dark ms-2"
       style="border:2px solid black; background:transparent; color:black; font-weight:600; border-radius:0; padding:6px 16px; transition:0.2s; white-space:nowrap; font-size:1rem; min-width:110px;">
        Mon compte
    </a>
<?php else: ?>
    <a href="inscription.php" class="btn btn-outline-dark ms-2"
       style="border:2px solid black; background:transparent; color:black; font-weight:600; border-radius:0; padding:6px 16px; transition:0.2s; white-space:nowrap; font-size:1rem; min-width:110px;">
        S'inscrire
    </a>
<?php endif; ?>