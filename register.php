<?php
//Validación de login
include_once("auth.php");
verificarSesion();
?>

<?php
include_once("header.php");
include_once("conexionbd.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? ''; 
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $email && $password) {
        //Encriptado de contraseñas
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO administradores (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Error al registrar el administrador.";
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<main class="container mt-5">
    <h2>Registrar Administrador</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de Usuario</label> 
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Registrar</button>
    </form>
</main>

<?php include_once("footer.php"); ?>
