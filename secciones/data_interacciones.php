<?php
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

$usuario_id = $_GET['usuario_id'] ?? 1;

$query = "
    SELECT 
        e.nombre AS encuesta,
        COUNT(r.id) AS interacciones
    FROM respuestas r
    INNER JOIN encuestas e ON r.id_encuesta = e.id
    WHERE e.id_usuario = :usuario_id
    GROUP BY e.id
    ORDER BY interacciones DESC
";

$stmt = $pdo->prepare($query);
$stmt->execute(['usuario_id' => $usuario_id]);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($resultados);
?>