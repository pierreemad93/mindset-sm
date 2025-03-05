<?php
require_once "config/db.php";
// print_r($_POST);
// echo $_SERVER['REQUEST_METHOD']  ;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    //bind parameters for data 
    $stmt = $connect->prepare('SELECT * FROM `users` WHERE `username` = ? AND `password` = ? LIMIT 1 ');
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(); //return array;
    $inDb = $stmt->rowCount();
    if ($inDb == 1) {
        header('Location:dashboard.php');
    } else {
        echo "user doesnt exist";
    }
    // echo "<pre>";
    // print_r($user);
    // echo "</pre>";
}

?>
<?php require_once "includes/header.php" ?>
<div class="container">

    <h1 class="text-center">Login form</h1>
    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
        <div class="mb-3">
            <label class="form-label">username</label>
            <input type="text" class="form-control" name="username">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php require_once "includes/footer.php" ?>