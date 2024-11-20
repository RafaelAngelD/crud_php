    <?php
    include_once("header.php");
    include_once("conexionbd.php");

    session_start();
    // Verifica si se ha enviado el formulario a través de POST (cuando el usuario hace clic en "Iniciar sesión")
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Verifica si ambos campos (email y contraseña) tienen valor.
        if ($email && $password) {
            $query = "SELECT * FROM administradores WHERE email = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifica si se encontró un administrador y si la contraseña ingresada coincide con la almacenada en la base de datos.
            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['nombre'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Email o contraseña incorrectos.";
            }
        } else {
            $error = "Por favor, completa todos los campos.";
        }
    }
    ?>

    <main class="container mt-5">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </main>

    <?php include_once("footer.php"); ?>
