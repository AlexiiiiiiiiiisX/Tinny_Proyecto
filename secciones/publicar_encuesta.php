<?php
include('../Configuraciones/conexion.php');

if (isset($_POST['encuesta_id'])) {
    $encuesta_id = mysqli_real_escape_string($conn, $_POST['encuesta_id']);
    
    // Actualizar el campo publicado a 'si'
    $query = "UPDATE encuestas SET publicado = 'si' WHERE id = $encuesta_id";
    
    if (mysqli_query($conn, $query)) {
        echo "<p>Encuesta publicada correctamente.</p>";
    } else {
        echo "<p>Error al publicar la encuesta: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>ID de encuesta no proporcionado.</p>";
}

mysqli_close($conn);
?>

<a href="buscar_encuestas_publicar.php">Volver a Buscar Encuestas</a>