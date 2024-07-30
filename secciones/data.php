<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$db = 'tinny';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("No se pudo conectar a la base de datos: " . $e->getMessage());
}

$usuario_id = 1; // ID del usuario

$query = $pdo->prepare("
    SELECT encuestas.nombre AS encuesta, 
           SUM(respuestas.voto = 'si') AS me_gusta
    FROM respuestas 
    JOIN encuestas ON respuestas.id_encuesta = encuestas.id
    WHERE encuestas.id_usuario = ? 
    GROUP BY encuestas.id
");
$query->execute([$usuario_id]);

$resultados = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($resultados);


?>