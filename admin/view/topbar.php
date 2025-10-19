<?php
if(!isset($_SESSION['admin'])) {
    header("Location: index.php?controller=admin&action=login");
    exit;
}
?>
<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
    <h5 class="ml-3">Chào, <?= $_SESSION['admin']['fullname'] ?></h5>
</nav>