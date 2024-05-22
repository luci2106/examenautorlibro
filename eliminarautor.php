<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eliminar el autor de la base de datos
    $sql = "DELETE FROM autores WHERE idautores=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Redireccionar a la página principal después de la eliminación
    header("Location: index.php");
    exit();
}
?>


