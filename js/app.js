let preguntaActual = null;
let puntuacion = 0;

// Cargamos la pregunta apenas cargue la pagina.
document.addEventListener('DOMContentLoaded', () => {
    cargarNuevaPregunta();

    // Configurar el evento del botón continuar una sola vez
    document.getElementById('btn-continuar').onclick = () => {
        document.getElementById('trivia-feedback').classList.add('hidden');
        cargarNuevaPregunta();
    };

});


async function cargarNuevaPregunta() {
    try {
        // Añadimos Date.now() para que la URL sea siempre distinta
        const response = await fetch('obtener_pregunta.php?t=' + Date.now());
        const data = await response.json();

        if (data.success) {
            preguntaActual = data;
            
            // Limpiamos el panel de alerta
            const feedbackPanel = document.getElementById('trivia-feedback');
            feedbackPanel.classList.add('hidden');
            feedbackPanel.className = "feedback-container hidden"; // Reseteamos colores
            
            mostrarPregunta(data);
        } else {
            console.error("Error en la respuesta:", data.message);
        }
    } catch (error) {
        console.error("Error en la petición fetch:", error);
    }
}

function mostrarPregunta(data) {

    const questionText = document.getElementById('question-text');
    const optionsGrid = document.querySelector('.options-grid');

    questionText.textContent = data.pregunta.enunciado;
    optionsGrid.innerHTML = '';

    data.opciones.forEach(opcion => {
        const button = document.createElement('button');
        button.className = 'option-btn';
        button.innerHTML = `
            <span class="letter">${opcion.letra}:</span>
            <span class="option-text">${opcion.contenido}</span>
        `;
        button.onclick = () => validarRespuesta(opcion, button);
        optionsGrid.appendChild(button);
    });

    transcipcionEcuaciones();
}

function validarRespuesta(opcionSeleccionada, botonElemento) {

    console.log(preguntaActual);
    // Bloquear otros clics
    const todosLosBotones = document.querySelectorAll('.option-btn');
    todosLosBotones.forEach(btn => btn.style.pointerEvents = 'none');

    const feedbackPanel = document.getElementById('trivia-feedback');
    const feedbackMessage = document.getElementById('feedback-message');
    
    // Buscar cuál era la correcta para mostrarla en el mensaje si falla
    const correcta = preguntaActual.opciones.find(o => o.es_correcta);

    if (opcionSeleccionada.es_correcta) {
        // CASO CORRECTO
        botonElemento.classList.add('correct');
        puntuacion += 100;
        document.getElementById('score').textContent = puntuacion;
        
        feedbackMessage.textContent = "Correcto ¡Muy bien!";
        feedbackPanel.className = "feedback-container feedback-success";
    } else {
        // CASO INCORRECTO
        botonElemento.classList.add('incorrect');
        
        // También marcamos la correcta en verde para que el alumno aprenda
        marcarCorrectaEnPantalla();

        feedbackMessage.textContent = `¡Casi lo logras! La respuesta correcta era la ${correcta.letra}: ${correcta.contenido}`;
        feedbackPanel.className = "feedback-container feedback-error";
    }

    // Mostrar la alerta (quitando la clase hidden)
    feedbackPanel.classList.remove('hidden');
    transcipcionEcuaciones();
}

function marcarCorrectaEnPantalla() {
    const botones = document.querySelectorAll('.option-btn');
    botones.forEach(btn => {
        const letraBtn = btn.querySelector('.letter').textContent.replace(':', '');
        const opcionData = preguntaActual.opciones.find(o => o.letra === letraBtn);
        if (opcionData && opcionData.es_correcta) {
            btn.classList.add('correct');
        }
    });
}


function transcipcionEcuaciones() {
    renderMathInElement(document.body, {
        delimiters: [
            {left: '$$', right: '$$', display: true},  
            {left: '$', right: '$', display: false}   
        ],
        throwOnError: false
    });
}