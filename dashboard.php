<?php
require_once "includes/header.php";
if (!isset($_SESSION["IsLoggedIn"])) {
    header("Location: index.php");
    exit();
}


require_once "includes/navbar.php";
?>

<div class="container">
    <h1 class="text-center">Dashboard</h1>
</div>

<?php
require_once "includes/footer.php";
?>