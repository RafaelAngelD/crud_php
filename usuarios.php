<?php
//Validación de login
include_once("auth.php");
verificarSesion();
?>

<?php 
include_once("header.php");
include_once("conexionbd.php");

// Crear y seleccionar query
$query = "SELECT * FROM usuarios ORDER BY id DESC";


$stmt = $conn->prepare($query);
$stmt->execute();
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

    <main>
        <div class="container mt-5">
            <div class="table-responsive">
                            
                <table class="table table-danger">
                    <caption><a  class="btn btn-success btn-sm" href="agregar.php" >Agregar</a> </caption>
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Email</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        foreach ($registros as $fila): ?>
                            <tr>
                                <td scope="row"><?php echo $i; ?></td>
                                <td><?php echo $fila['nombre']; ?></td>
                                <td><?php echo $fila['apellidos']; ?></td>
                                <td><?php echo $fila['telefono']; ?></td>
                                <td><?php echo $fila['email']; ?></td>
                                <td><a  class="btn btn-info btn-sm" href="editar.php?id=<?php echo $fila['id']; ?>">Editar</a>  
                                <a class="btn btn-danger btn-sm" href="borrar.php?id=<?php echo $fila['id']; ?>">Eliminar</a></td>
                            </tr>
                        <?php 
                            $i++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php include_once("footer.php");  ?>
