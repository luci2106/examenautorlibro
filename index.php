<?php
include 'conexion.php';

// Añadir Autor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_author'])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];

    $sql = "INSERT INTO autores (nombre, apellido) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $apellido);
    if ($stmt->execute()) {
        $stmt->close();
    } else {
        echo "Error al añadir autor: " . $conn->error;
    }
}

// Añadir Libro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $titulo = $_POST["titulo"];
    $idautor = $_POST["idautores"];

    $sql = "INSERT INTO libro (titulo, idautor) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $titulo, $idautor);
    if ($stmt->execute()) {
        $stmt->close();
    } else {
        echo "Error al añadir libro: " . $conn->error;
    }
}

// Eliminar Autor
if (isset($_GET['delete_author'])) {
    $id = $_GET['delete_author'];

    $sql = "DELETE FROM autores WHERE idautores=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $stmt->close();
    } else {
        echo "Error al eliminar autor: " . $conn->error;
    }
}

// Eliminar Libro
if (isset($_GET['delete_book'])) {
    $id = $_GET['delete_book'];

    $sql = "DELETE FROM libro WHERE idlibro=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $stmt->close();
    } else {
        echo "Error al eliminar libro: " . $conn->error;
    }
}

// Obtener Autores
$sql = "SELECT * FROM autores";

// Obtener Libros
$sql = "SELECT idlibro, libro.titulo, autores.nombre, autores.apellido 
        FROM libro
        LEFT JOIN autores ON libro.idautor = autores.idautores";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Biblioteca</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<h2>Añadir Autor</h2>
<form action="" method="post">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellido" placeholder="Apellido" required>
    <button type="submit" name="add_author">Añadir Autor</button>
</form>

<h2>Añadir Libro</h2>
<form action="" method="post">
    <input type="text" name="titulo" placeholder="Título" required>
    <select name="idautores" required>
        <option value="">Seleccione un autor</option>
        <?php while($row = $result_authors->fetch_assoc()): ?>
            <option value="<?php echo $row['idautores']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit" name="add_book">Añadir Libro</button>
</form>

<h2>Lista de Libros</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result_books->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['idlibro']; ?></td>
        <td><?php echo $row['titulo']; ?></td>
        <td><?php echo $row['nombre'] . " " . $row['apellido']; ?></td>
        <td>
            <a href="index.php?delete_book=<?php echo $row['idlibro']; ?>">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Lista de Autores</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Acciones</th>
    </tr>
    <?php
    // Reiniciar el puntero del resultado para volver a obtener los autores
    $result_authors->data_seek(0);
    while($row = $result_authors->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['idautores']; ?></td>
        <td><?php echo $row['nombre']; ?></td>
        <td><?php echo $row['apellido']; ?></td>
        <td>
            <a href="index.php?delete_author=<?php echo $row['idautores']; ?>">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>