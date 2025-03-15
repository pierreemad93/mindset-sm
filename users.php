<?php
require_once "config/db.php";
require_once "includes/header.php";

if (!isset($_SESSION["IsLoggedIn"])) {
    header("Location: index.php");
    exit();
}

require_once "includes/navbar.php";
$page = isset($_GET['action']) ? $_GET['action'] : 'index';
?>

<?php if ($page == 'index'): ?>
    <?php
    $stmt = $connect->prepare('SELECT * FROM `users`');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="container">
        <h1 class="text-center">Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <th><?= $index + 1 ?></th>
                        <td><?= $user['full_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <a href="?action=show&id=<?= $user['id'] ?>" class="btn btn-primary">Show</a>
                            <a href="?action=edit&id=<?= $user['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="?action=delete&id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <a href="?action=create" class="btn btn-dark">Create User</a>
    </div>

<?php elseif ($page == 'create'): ?>
    <div class="container">
        <h1 class="text-center">Create User</h1>
        <form name="userForm" action="?action=store" method="POST" onsubmit="return validateForm()">
            <input type="text" class="form-control" name="username" placeholder="Username">
            <input type="email" class="form-control" name="email" placeholder="Email">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <input type="text" class="form-control" name="fullname" placeholder="Fullname">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

<?php elseif ($page == 'store'): ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $fullname = trim($_POST['fullname']);
        if (!empty($username) && !empty($email) && !empty($password) && !empty($fullname)) {
            $hashed_password = sha1($password);
            $stmt = $connect->prepare('INSERT INTO `users` (`username`, `email`, `password`, `full_name`, `status`, `created_at`) VALUES (?, ?, ?, ?, "active", now())');
            $stmt->execute([$username, $email, $hashed_password, $fullname]);
            header("Location:users.php");
        }
    }
    ?>

<?php elseif ($page == 'edit'): ?>
    <?php
    $user_id = intval($_GET['id']);
    $stmt = $connect->prepare('SELECT * FROM `users` WHERE `id` = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="container">
        <h1 class="text-center">Edit User</h1>
        <form name="userForm" action="?action=update" method="POST" onsubmit="return validateForm()">
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
            <input type="text" class="form-control" name="username" value="<?= $user['username'] ?>">
            <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>">
            <input type="text" class="form-control" name="fullname" value="<?= $user['full_name'] ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

<?php elseif ($page == 'update'): ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['user_id'];
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $fullname = trim($_POST['fullname']);
        if (!empty($username) && !empty($email) && !empty($fullname)) {
            $stmt = $connect->prepare('UPDATE `users` SET `username`=?, `email`=?, `full_name`=? WHERE `id` = ?');
            $stmt->execute([$username, $email, $fullname, $id]);
            header("Location:users.php");
        }
    }
    ?>

<?php elseif ($page == 'delete'): ?>
    <?php
    $user_id = intval($_GET['id']);
    $stmt = $connect->prepare('DELETE FROM `users` WHERE `id` = ?');
    $stmt->execute([$user_id]);
    header("Location:users.php");
    ?>

<?php else: ?>
    <?php header("Location:users.php"); ?>
<?php endif ?>

<?php require_once "includes/footer.php"; ?>

<script>
function validateForm() {
    let username = document.forms["userForm"]["username"].value;
    let email = document.forms["userForm"]["email"].value;
    let password = document.forms["userForm"]["password"] ? document.forms["userForm"]["password"].value : "dummy";
    let fullname = document.forms["userForm"]["fullname"].value;
    if (username == "" || email == "" || password == "" || fullname == "") {
        alert("All fields are required!");
        return false;
    }
}
</script>
