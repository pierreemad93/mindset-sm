<?php
//CRUD operation => Create Read Update Delete
require_once "config/db.php";
require_once "includes/header.php";
if (!isset($_SESSION["IsLoggedIn"])) {
    header("Location: index.php");
    exit();
}

require_once "includes/navbar.php";
$page = isset($_GET['action']) ? $_GET['action'] : 'index';
?>
<!-- index page -->
<?php if ($page == 'index'): ?>
    <?php
    $stmt = $connect->prepare('SELECT * FROM `users` ');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="container">
        <h1 class="text-center">Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">fullname</th>
                    <th scope="col">email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= $user['full_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <a href="" class="btn btn-primary">show</a>
                            <a href="" class="btn btn-warning">edit</a>
                            <a href="" class="btn btn-danger">delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <a href="?action=create" class="btn btn-dark">Create user</a>
    </div>
    <!-- Create page -->
<?php elseif ($page == 'create'): ?>
    <div class="container">
        <h1 class="text-center">Create user</h1>
        <form action="?action=store" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username">
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3">
                <label class="form-label">Fullname</label>
                <input type="text" class="form-control" name="fullname">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php elseif ($page == 'store'): ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email =  $_POST['email'];
        $password = sha1($_POST['password']);
        $fullname = $_POST['fullname'];
        $stmt = $connect->prepare('INSERT INTO `users` (`username` , `email` , `password` , `full_name` , `status` , `created_at`) VALUES (? , ? , ? , ? , "active" , now() ) ');
        $stmt->execute([$username, $email, $password, $fullname]);
        header("Location:users.php");
    }
    ?>
<?php endif ?>
<?php
require_once "includes/footer.php";
?>