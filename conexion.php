<?php
        // $host = 'localhost';
        // $dbname = 'trivia_db';
        // $user = 'postgres'; // Reemplaza con tu usuario de PostgreSQL
        // $password = '1234'; // Reemplaza con tu clave

        // try {
        //     // String de conexión (DSN) para PostgreSQL
        //     $dsn = "pgsql:host=$host;dbname=$dbname";

        //     $pdo = new PDO($dsn, $user, $password);

        //     // Configurar PDO para que lance excepciones en caso de error
        //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //     // Configurar para que devuelva arrays asociativos por defecto
        //     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // } catch (PDOException $e) {
        //     die(json_encode([
        //         'success' => false, 
        //         'message' => "Error de conexión a la base de datos: " . $e->getMessage()
        //     ]));
        // }

// Lee las variables de Render, si no existen usa valores locales
$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_NAME') ?: 'trivia_db';
$user = getenv('DB_USER') ?: 'postgres';
$pass = getenv('DB_PASS') ?: '1234';
$port = getenv('DB_PORT') ?: '5432';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}






?>