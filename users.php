<?php
//CRUD operation => Create Read Update Delete
require_once "config/db.php";
require_once "includes/header.php";
if (!isset($_SESSION["IsLoggedIn"])) {
    header("Location: index.php");
    exit();
}

require_once "includes/navbar.php";

$stmt = $connect->prepare('SELECT * FROM `users` ');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $users = $stmt->fetch();
// echo "<pre>";
// print_r($users);
// echo "</pre>";
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
</div>

<?php
require_once "includes/footer.php";
?>