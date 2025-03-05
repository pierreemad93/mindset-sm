<?php
session_start();
if (!isset($_SESSION["isLoggedIn"])) {
    header("Location: index.php");
    exit();
}

require_once "includes/header.php";
require_once "includes/navbar.php";
?>

<div class="container">
    <h1 class="text-center">Users</h1>
</div> 

<?php
require_once "includes/footer.php";
?>