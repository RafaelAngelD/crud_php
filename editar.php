<?php
include_once('conexionbd.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener el id enviado de index
$idRegistro = $_GET['id'];

// Preparar la consulta para evitar inyecciones SQL
$query = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $idRegistro, PDO::PARAM_INT);

// Ejecutar la consulta
$stmt->execute();
$registro = $stmt->fetch(PDO::FETCH_ASSOC); // Usamos fetch para un solo registro

if(isset($_POST['editarRegistro']))
{
    // Si se somete el cambio, procedemos a capturar los valores
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $id = $_POST['id'];
    // Validar si no están vacíos cualquiera de los campos
    if (!isset($nombre) || $nombre == '' || !isset($apellidos) || $apellidos == '' || !isset($telefono) || $telefono == '' || !isset($email) || $email == '') {
        $error = "Alerta!!! No debes poner valores en blanco, todos deben tener información";
    } else {
        // Usar una consulta preparada para prevenir inyecciones SQL
        $query = "UPDATE usuarios set nombre=:nombre, apellidos=:apellidos, telefono=:telefono, email=:email where id=:id";
        $stmt = $conn->prepare($query);

        // Vincular los parámetros a la consulta
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = "Registro creado correctamente";
            header('Location: usuarios.php?mensaje=' . urlencode($mensaje));
            exit();
        } else {
            $error = "Error, no se pudo crear el registro";
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
    <title>CRUD PHP Y MYSQL</title>
</head>
<body>
    <header>
        <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container">
                <a class="navbar-brand" href="#">
                <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24">
                </a>
            </div>
        </nav>
    </header>
    <h1 class="text-center mt-3">EDITAR REGISTRO</h1>

    <div class="container mt-2">
        <div class="row caja">
            <?php if (isset($error)) : ?>
                <h4 class="bg-danger text-white"><?php echo $error; ?></h4>
            <?php endif; ?>

            <div class="col-sm-6 offset-3">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($registro['nombre']); ?>">
                    <input type="hidden" name = "id" value="<?php echo $registro['id']; ?>">
                </div>
                
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos:</label>
                    <input type="text" class="form-control" name="apellidos" value="<?php echo htmlspecialchars($registro['apellidos']); ?>">
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Telefono:</label>
                    <input type="number" class="form-control" name="telefono" value="<?php echo htmlspecialchars($registro['telefono']); ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($registro['email']); ?>">
                </div>
              
                <button type="submit" class="btn btn-warning w-100" name="editarRegistro">Editar Registro</button>
            </form>
            </div>
        </div>
    </div>
</body>
</html>