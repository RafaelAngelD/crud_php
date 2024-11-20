<?php
include_once("header.php");
session_start();

// Verificar si el administrador está logueado
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<main class="container mt-5">
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['admin_name']); ?>!</h1>
    <p>Este es tu panel de inicio como administrador.</p>

    <div class="mt-4">
        <h3>Opciones disponibles:</h3>
        <ul>
            <li><a href="usuarios.php" class="btn btn-primary">Gestionar Usuarios</a></li>
            <li><a href="register.php" class="btn btn-success">Registrar Nuevo Administrador</a></li>
            <li><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></li>
        </ul>
    </div>
</main>

<?php include_once("footer.php"); ?>
