
<?php
include('../Configuraciones/conexion.php');

if(isset($_POST['Guardar'])){
    // Datos de la encuesta
    $imagen = mysqli_real_escape_string($conn, $_FILES['imagen']['name']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre_encuesta']);
    $pregunta = mysqli_real_escape_string($conn, $_POST['pregunta']);
    $tema = mysqli_real_escape_string($conn, $_POST['tema']);

    if(isset($imagen) && $imagen != ""){
        $tipo = $_FILES['imagen']['type'];
        $temp = $_FILES['imagen']['tmp_name'];

        if(!((strpos($tipo,'jpeg') || strpos($tipo,'jpg') || strpos($tipo,'png')))){
            $_SESSION['mensaje'] = 'solo se permite archivos jpeg, jpg, png';
            header('location:../secciones/crear_encuestas.html');
        } else {
            // Insertar datos en la tabla encuestas...................................................................................................................
            $query = "INSERT INTO encuestas (nombre, pregunta, imagen, id_usuario, categoria) VALUES ('$nombre', '$pregunta', '$imagen', 1, '$tema')";
            $resultado = mysqli_query($conn, $query);

            if($resultado){
                // Obtener el id de la última encuesta insertada ........................................................................................
                $id_encuesta = mysqli_insert_id($conn);

                // Insertar opciones en la tabla opciones
                foreach($_POST['respuestas'] as $respuesta){
                    $respuesta = mysqli_real_escape_string($conn, $respuesta);
                    $query_opcion = "INSERT INTO opciones (opcion, id_encuesta) VALUES ('$respuesta', '$id_encuesta')";
                    mysqli_query($conn, $query_opcion);
                }

                // Haber si existe la carpeta imagenes.........................................................................................................
                if (!is_dir('../imagenes')) {
                    mkdir('../imagenes', 0777, true);
                }

                // Ruta de destino .........................................................................................................................
                $destino = '../imagenes/'.$imagen;

                // Este de aqui mueve el archivo .............................................................................................................
                if(move_uploaded_file($temp, $destino)){
                    $_SESSION['mensaje'] = 'se ha subido correctamente';
                    header('location:../secciones/crear_encuestas.html');
                } else {
                    $_SESSION['mensaje'] = 'error al mover la imagen al directorio';
                    header('location:../secciones/crear_encuestas.html');
                }
            } else {
                $_SESSION['mensaje'] = 'ocurrio un error en el servidor';
                header('location:../secciones/crear_encuestas.html');
            }
        }    
    }
}
?>
 