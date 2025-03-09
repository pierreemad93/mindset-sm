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
                            <a href="?action=show&id=<?= $user['id'] ?>" class="btn btn-primary">show</a>
                            <a href="?action=edit&id=<?= $user['id'] ?>" class="btn btn-warning">edit</a>
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
<?php elseif ($page == 'show'): ?>

    <?php
    $user_id = intval($_GET['id']) ? $_GET['id'] : header("Location:users.php");
    $stmt = $connect->prepare('SELECT * FROM `users` WHERE `id` =? ');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($user);
    ?>
    <div class="container">
        <h1 class="text-center">Show user</h1>
        <form action="?action=store" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?= $user['username'] ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Fullname</label>
                <input type="text" class="form-control" name="fullname" value="<?= $user['full_name'] ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text" class="form-control" name="fullname" value="<?= $user['status'] ?>" disabled>
            </div>

        </form>
    </div>
<?php elseif ($page == 'edit'): ?>
    <?php
    $user_id = intval($_GET['id']) ? $_GET['id'] : header("Location:users.php");
    $stmt = $connect->prepare('SELECT * FROM `users` WHERE `id` =? ');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="container">
        <h1 class="text-center">Edit user</h1>
        <form action="?action=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?= $user['id'] ?>" name=" user_id" />
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?= $user['username'] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Fullname</label>
                <input type="text" class="form-control" name="fullname" value="<?= $user['full_name'] ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php elseif ($page == 'update'): ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['user_id'];
        $username = $_POST['username'];
        $email =  $_POST['email'];
        $fullname = $_POST['fullname'];
        $stmt = $connect->prepare('UPDATE `users` SET `username`=? ,`email`=?  , `full_name`=? WHERE `id` = ? ');
        $stmt->execute([$username, $email, $fullname, $id]);
        header("Location:users.php");
    }
    ?>
<?php endif ?>
<?php
require_once "includes/footer.php";
?>