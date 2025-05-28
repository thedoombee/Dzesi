
<?php
function getBreadcrumbCategory() {
    $currentPage = basename($_SERVER['PHP_SELF']);
    switch ($currentPage) {
        case 'vases.php':
            return 'Vases';
        case 'pagnes.php':
            return 'Pagnes';
        case 'pots.php':
            return 'Pots';
        case 'tableaux.php':
            return 'Tableaux';
        case 'sculptures.php':
            return 'Sculptures';
        default:
            return 'Tous';
    }
}

function showBreadcrumb() {
    $category = getBreadcrumbCategory();
    echo '<div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="produits.php">Boutique</a></li>
                <li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($category) . '</li>
            </ol>
        </nav>
    </div>';
}
?>