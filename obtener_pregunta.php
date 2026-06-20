<?php
// Indicar que la respuesta será en formato JSON
header('Content-Type: application/json');

require_once 'conexion.php';

try {
    // 1. Obtener una pregunta aleatoria de la base de datos (Forzamos FETCH_ASSOC)
    $sqlPregunta = "SELECT id, enunciado FROM preguntas ORDER BY RANDOM() LIMIT 1";
    $stmtPregunta = $pdo->query($sqlPregunta);
    $pregunta = $stmtPregunta->fetch(PDO::FETCH_ASSOC);

    if ($pregunta) {
        // 2. Obtener las opciones correspondientes a esa pregunta
        $sqlOpciones = "SELECT id, letra, contenido, es_correcta 
                        FROM opciones 
                        WHERE pregunta_id = :id 
                        ORDER BY letra ASC";
        
        $stmtOpciones = $pdo->prepare($sqlOpciones);
        $stmtOpciones->execute(['id' => $pregunta['id']]);
        $opciones = $stmtOpciones->fetchAll(PDO::FETCH_ASSOC);

        // CASEO CRÍTICO: Asegurar que 'es_correcta' sea un booleano real en el JSON
        foreach ($opciones as &$opcion) {
            // filter_var convierte "t", "f", 1, 0, "true", "false" a booleanos nativos reales
            $opcion['es_correcta'] = filter_var($opcion['es_correcta'], FILTER_VALIDATE_BOOLEAN);
        }
        unset($opcion); // Rompemos la referencia por seguridad

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