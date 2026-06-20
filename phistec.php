<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phistec</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/katex.min.css">
</head>
<body>
    <div class="trivia-container">

        <header class="trivia-header">
            <h2>Phistec</h2>
            <div class="score-board">Puntuación: <span id="score">0</span></div>
        </header>

        <div class="question-wrapper">
            <div class="question-box">
                <p id="question-text"></p>
            </div>
        </div>

        <div class="options-grid">
            <button class="option-btn" id="opcion-a">
                <span class="letter">A:</span>
                <span class="option-text">Primera opción de respuesta</span>
            </button>
            <button class="option-btn" id="opcion-b">
                <span class="letter">B:</span>
                <span class="option-text">Segunda opción de respuesta</span>
            </button>
            <button class="option-btn" id="opcion-c">
                <span class="letter">C:</span>
                <span class="option-text">Tercera opción de respuesta</span>
            </button>
            <button class="option-btn" id="opcion-d">
                <span class="letter">D:</span>
                <span class="option-text">Cuarta opción de respuesta</span>
            </button>
        </div>

        <div id="trivia-feedback" class="feedback-container hidden">
            <p id="feedback-message"></p>
            <button id="btn-continuar" class="btn-next">Continuar</button>
        </div>

    </div>
    <script src="js/katex.min.js" defer></script>
    <script src="js/auto-render.min.js" defer></script>
    <script src="js/app.js"></script>
</body>
</html>


