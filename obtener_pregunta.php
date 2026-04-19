<?php
// Indicar que la respuesta será en formato JSON
header('Content-Type: application/json');

require_once 'conexion.php';

try {
    // 1. Obtener una pregunta aleatoria de la base de datos
    $sqlPregunta = "SELECT id, enunciado FROM preguntas ORDER BY RANDOM() LIMIT 1";
    $stmtPregunta = $pdo->query($sqlPregunta);
    $pregunta = $stmtPregunta->fetch();

    if ($pregunta) {
        // 2. Obtener las opciones correspondientes a esa pregunta
        // Usamos parámetros preparados (:id) para mayor seguridad
        $sqlOpciones = "SELECT id, letra, contenido, es_correcta 
        FROM opciones 
        WHERE pregunta_id = :id 
        ORDER BY letra ASC";
        
        $stmtOpciones = $pdo->prepare($sqlOpciones);
        $stmtOpciones->execute(['id' => $pregunta['id']]);
        $opciones = $stmtOpciones->fetchAll();

        // 3. Estructurar la respuesta
        $respuesta = [
            'success' => true,
            'pregunta' => $pregunta,
            'opciones' => $opciones
        ];
        
        echo json_encode($respuesta);
        
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'No se encontraron preguntas en la base de datos.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Ocurrió un error: ' . $e->getMessage()
    ]);
}
?>