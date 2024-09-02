<?php
// Conectar a la base de datos
function connection() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = 'banco';
    $connect = mysqli_connect($host, $user, $pass, $bd);
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $connect;
}

// Acciones
$con = connection();
$action = $_GET['action'] ?? '';

if ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM cliente WHERE id='$id'";
    mysqli_query($con, $sql);
    header("Location: ejercicio229.php"); 
    exit();
}

if ($action == 'update' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre_completo = $_POST['nombre_completo'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sql = "UPDATE cliente SET nombre_completo='$nombre_completo', direccion='$direccion', telefono='$telefono', fecha_nacimiento='$fecha_nacimiento' WHERE id='$id'";
    mysqli_query($con, $sql);
    header("Location: ejercicio229.php"); 
    exit();
}

if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_completo = $_POST['nombre_completo'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sql = "INSERT INTO cliente (nombre_completo, direccion, telefono, fecha_nacimiento) VALUES('$nombre_completo', '$direccion', '$telefono', '$fecha_nacimiento')";
    mysqli_query($con, $sql);
    header("Location: ejercicio229.php"); 
    exit();
}

if ($action == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM cliente WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
}

//  Lista de clientes
$sql = "SELECT * FROM cliente";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 229</title>
</head>
<body>
    <div align="left"> 
        <?php if ($action == 'edit' && isset($row)): ?>
        <form action="?action=update" method="POST">
            <h2>Editar cliente</h2>
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="text" name="nombre_completo" placeholder="nombre completo" value="<?= $row['nombre_completo'] ?>" required oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
            <input type="text" name="direccion" placeholder="direccion" value="<?= $row['direccion'] ?>" required>
            <input type="number" name="telefono" placeholder="telefono" value="<?= $row['telefono'] ?>" required>
            <input type="date" name="fecha_nacimiento" placeholder="fecha nacimiento" value="<?= $row['fecha_nacimiento'] ?>" required>
            <input type="submit" value="Actualizar">
        </form>
        <?php else: ?>
        <form action="?action=add" method="POST">
            <h2>Agregar cliente</h2>
            <input type="text" name="nombre_completo" placeholder="nombre completo" required oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
            <input type="text" name="direccion" placeholder="direccion" required>
            <input type="number" name="telefono" placeholder="telefono" required> 
            <input type="date" name="fecha_nacimiento" placeholder="fecha nacimiento" required>
            <input type="submit" value="Agregar cliente">
        </form>
        <?php endif; ?>
    </div>

    <div align="left"> 
        <h2>Clientes registrados</h2>
        <table border="1" cellpadding="8" cellspacing="0" width="60%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre completo</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Fecha de nacimiento</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($query)): ?>
                <tr>
                    <td align="center"><?= $row['id'] ?></td>
                    <td align="center"><?= $row['nombre_completo'] ?></td>
                    <td align="center"><?= $row['direccion'] ?></td>
                    <td align="center"><?= $row['telefono'] ?></td>
                    <td align="center"><?= $row['fecha_nacimiento'] ?></td>
                    <td align="center"><a href="?action=edit&id=<?= $row['id'] ?>">Editar</a></td>
                    <td align="center"><a href="?action=delete&id=<?= $row['id'] ?>">Eliminar</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php mysqli_close($con); ?>








