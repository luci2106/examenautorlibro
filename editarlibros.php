<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Obtener información del autor
    $sql = "SELECT * FROM autores WHERE idautores=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $autor = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_autor'])) {
    // Recuperar datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    
    // Actualizar información del autor en la base de datos
    $sql = "UPDATE autores SET nombre=?, apellido=? WHERE idautores=?";
    
    $stmt->bind_param("ssi", $nombre, $apellido, $id);
    $stmt->execute();
    
    // Redireccionar a la página principal después de la actualización
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Autor</title>
    <!-- Agregar enlaces a Bootstrap si los estás utilizando -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<h2>Editar Autor</h2>
<form action="" method="post">
    <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $autor['nombre']; ?>" required>
    <input type="text" name="apellido" placeholder="Apellido" value="<?php echo $autor['apellido']; ?>" required>
    <button type="submit" name="actualizar_autor">Actualizar Autor</button>
</form>

</body>
</html>