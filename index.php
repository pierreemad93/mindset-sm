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
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
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

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>