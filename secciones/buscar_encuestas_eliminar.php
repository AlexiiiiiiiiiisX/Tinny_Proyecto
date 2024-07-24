<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tinny</title>
    <link rel="stylesheet" href="/Tinny/Styles/Plantilla_inter.css">
    <link rel="stylesheet" href="/Tinny/Styles/accionar_encuesta.css">
    <style>
        .encuesta-cuadro {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            width: 300px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
            display: inline-block;
            vertical-align: top;
        }
        .encuesta-cuadro img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="grid-container">
<nav class="navar">
    <div class="nav-links">
        <div class="nav-item">
            <img class="logo" src="../src/Tinny_logo.png" alt="Logo">
        </div>
        <div class="nav-item">
            <a href="index.html">
                <img class="imagen" src="../src/home.png" alt="Inicio"> Inicio
            </a>
        </div>
        <div class="nav-item">
            <a href="gestionar_encuestas.html">
                <img class="imagen" src="../src/note.png" alt="Mis encuestas"> Mis encuestas
            </a>
        </div>
        <div class="nav-item">
            <a href="mostrar_graficos.html">
                <img class="imagen" src="../src/grafic.png" alt="Graficar"> Graficar
            </a>
        </div>
    </div>
</nav>

<article class="main">
    <h2>Buscar Encuestas</h2>
    <div class="cajabuscar">
        <form method="GET" action="buscar_encuestas_eliminar.php" id="buscarform">
            <fieldset>
                <input type="text" id="termino" name="termino" placeholder="Buscar" />
                <button class="button-search" type="submit">
                    <i class="search"></i>
                </button>
            </fieldset>
        </form>
    </div>

    <h2>Mis Encuestas</h2>
    <div id="encuestasContainer">
        <?php
        include('../Configuraciones/conexion.php');

        $usuario_id = 1;  //id del usuario -- No tiene sesion   

        if (isset($_GET['termino'])) {
            $termino = mysqli_real_escape_string($conn, $_GET['termino']);
            // Consulta a la base de datos buscando las encuestas del usuario
            $query = "SELECT * FROM encuestas WHERE (nombre LIKE '%$termino%' OR categoria LIKE '%$termino%') AND id_usuario = $usuario_id";
        } else {
            // Consultar todas las encuestas que coincidan con las del usuario
            $query = "SELECT * FROM encuestas WHERE id_usuario = $usuario_id";
        }
        
        $resultado = mysqli_query($conn, $query);

        if (mysqli_num_rows($resultado) > 0) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                echo "<div class='encuesta-cuadro'>";
                echo "<h3>" . $row['nombre'] . "</h3>";
                echo "<p>" . $row['pregunta'] . "</p>";
                echo "<p><strong>Tema:</strong> " . $row['categoria'] . "</p>";
                echo "<form method='POST' action='eliminar_encuesta.php'>";
                echo "<input type='hidden' name='encuesta_id' value='" . $row['id'] . "'>";
                echo "<button type='submit'>Eliminar</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No se encontraron encuestas.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
</article>
</body>
</html>