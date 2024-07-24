<?php
include('../Configuraciones/conexion.php');

if (isset($_POST['encuesta_id'])) {
    $encuesta_id = mysqli_real_escape_string($conn, $_POST['encuesta_id']);

    // Obtener información de la encuesta para eliminar la imagen
    $query = "SELECT imagen FROM encuestas WHERE id = $encuesta_id";
    $resultado = mysqli_query($conn, $query);
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        $imagen = $row['imagen'];

        // Verificar si la imagen es un archivo y eliminarla del servidor
        $imagen_ruta = "../imagenes/$imagen";
        if (is_file($imagen_ruta)) {
            unlink($imagen_ruta);
        }

        // Eliminar las opciones asociadas a la encuesta
        $query = "DELETE FROM opciones WHERE id_encuesta = $encuesta_id";
        if (mysqli_query($conn, $query)) {
            // Eliminar la encuesta de la base de datos
            $query = "DELETE FROM encuestas WHERE id = $encuesta_id";
            if (mysqli_query($conn, $query)) {
                echo "<p>Encuesta eliminada correctamente.</p>";
            } else {
                echo "<p>Error al eliminar la encuesta: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p>Error al eliminar las opciones: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>No se encontró la encuesta.</p>";
    }
} else {
    echo "<p>ID de encuesta no proporcionado.</p>";
}

mysqli_close($conn);
?>

<a href="buscar_encuestas_eliminar.php">Volver a Buscar Encuestas</a>