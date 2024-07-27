<?php
include('../Configuraciones/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['encuesta_id'])) {
    $encuesta_id = mysqli_real_escape_string($conn, $_POST['encuesta_id']);
    
    // Actualizar el campo `publicado` a 'si' y el campo `fecha` con la fecha actual
    $query = "UPDATE encuestas SET publicado = 'si', fecha = CURRENT_TIMESTAMP WHERE id = $encuesta_id";
    
    if (mysqli_query($conn, $query)) {
        echo "Encuesta publicada exitosamente.";
    } else {
        echo "Error al publicar la encuesta: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
    
    // Redirigir de vuelta a la página de búsqueda de encuestas
    header("Location: buscar_encuestas_publicar.php");
    exit();
}
?>
