    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
     
    <script>

    // Agregar la funcionalidad de atajo de teclado CTRL + M
    document.addEventListener('keydown', function(event) {
        // Verificamos si CTRL (o Command en Mac) + M están presionados
        if ((event.ctrlKey || event.metaKey) && event.key === 'm') {
            // Prevenimos el comportamiento predeterminado
            event.preventDefault();
            // Enfocamos el campo de búsqueda
            document.getElementById('autoComplete').focus();
        }
    });

    // Configuración de autoComplete.js
    const autoCompleteJS = new autoComplete({
        selector:    "#autoComplete",
        placeHolder: "Buscar: función..",
        data: {
            // En lugar de proporcionar datos estáticos, usamos una función que hace una solicitud AJAX
            src: async () => {
                try {
                    // Hacemos una solicitud al backend PHP para obtener los datos
                    const response= await fetch('./funciones/_sis_buscar.php?action=search');
                    const data    = await response.json();
                    return data;
                } catch (error) {
                    console.error("Error al cargar datos:", error);
                    return [];
                }
            },
            cache: false, // Desactivamos caché para tener datos actualizados
        }, resultsList: {
        element: (list, data) => {
            if (!data.results.length) {
                // Mensaje cuando no hay resultados
                const message = document.createElement("div");
                message.setAttribute("class", "no_result");
                message.innerHTML = `<span>No se encontraron resultados para "${data.query}"</span>`;
                list.prepend(message);
            }
        },
        noResults: true,
    },
    resultItem: {
        highlight: {
            render: true
        },
        // Agregamos clase para dar estilo de cursor pointer a los elementos
        class: "autoComplete_result cursor-pointer"
    },
    events: {
        input: {
            focus() {
                // Iniciamos la búsqueda cuando el campo recibe el foco y tiene texto
                if (autoCompleteJS.input.value.length) autoCompleteJS.start();
            },
            selection(event) {
                const feedback  = event.detail;
                // Obtenemos el valor seleccionado
                const selection = feedback.selection.value;
                
                // Establecemos el valor seleccionado en el input
                autoCompleteJS.input.value = selection;
                
                // Mostramos detalles y obtenemos la URL para redirección
                obtenerDetallesYRedireccionar(selection);                
            },
            // Añadimos un evento para la búsqueda en tiempo real
            keyup(event) {
                // Podemos enviar consultas de búsqueda al servidor para búsqueda en vivo
                const query = event.target.value;
                if (query.length >= 2) { // Solo buscar si hay al menos 2 caracteres
                    realizarBusquedaEnVivo(query);
                }
            }
        },
    },
});
   function obtenerDetallesYRedireccionar(seleccion) {
    // Extraemos un identificador o realizamos otra acción basada en la selección
    fetch('./funciones/_sis_buscar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'funcion=' + encodeURIComponent(seleccion) + '&action=details'
    })
    .then(response => response.json())
    .then(data => {
        // Redireccionar directamente a la URL
        redirigirAFuncion(data.url);
    })
    .catch(error => {
        console.error('Error al obtener detalles:', error);
        document.getElementById('resultados').innerHTML = '<div class="alert alert-danger">Error al cargar los detalles</div>';
    });
}

// Función para redireccionar a la URL de la función
function redirigirAFuncion(url) {
    if(url && url.trim() !== '') {
        window.location.href = url;
    } else {
        alert("No hay URL disponible para esta función");
    }
}

// Función para realizar búsqueda en vivo
function realizarBusquedaEnVivo(query) {
    fetch('./funciones/_sis_buscar.php?q=' + encodeURIComponent(query) + '&action=search')
        .then(response => response.json())
        .then(data => {
            // Aquí puedes actualizar un contenedor con resultados parciales si lo deseas
            let html = '<h7>Resultados de búsqueda:</h7>';
            if (data.length > 0) {
                html += '<ul class="list-group">';
                data.slice(0, 10).forEach(item => {
                    // Extraer el ID del elemento para obtener la URL directamente
                    let matches = item.match(/\(ID: (\d+)\)$/);
                    if (matches && matches[1]) {
                        html += `<li class="list-group-item resultado-funcion" 
                                    onclick="obtenerURLyRedireccionar('${encodeURIComponent(item)}', ${matches[1]})">${item}</li>`;
                    } else {
                        html += `<li class="list-group-item resultado-funcion">${item}</li>`;
                    }
                });
                html += '</ul>';
            } else {
                html += '<p>No se encontraron resultados</p>';
            }
            // document.getElementById('resultados').innerHTML = html; // quite ya q se muestran 2 veces los resultados.
        })
        .catch(error => console.error('Error en búsqueda:', error));
}

// Función para obtener la URL y redireccionar directamente sin mostrar detalles
function obtenerURLyRedireccionar(itemEncoded, id) {
    // Hacemos una solicitud para obtener solo la URL correspondiente al ID
    fetch('./funciones/_sis_buscar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'funcion=' + itemEncoded + '&action=details'
    })
    .then(response => response.json())
    .then(data => {
        // Redireccionar directamente a la URL
        if (data.url && data.url !== '#') {
            window.location.href = data.url;
        } else {
            alert("No hay URL disponible para esta función");
        }
    })
    .catch(error => {
        console.error('Error al obtener la URL:', error);
        alert("Error al obtener la URL de la función");
    });
}

// Agregamos estilo para los resultados
document.head.insertAdjacentHTML('beforeend', `
<style>
    .resultado-funcion {            cursor: pointer;                }
    .resultado-funcion:hover {      background-color:rgba(214, 11, 11, 0.25);    }
    .cursor-pointer {               cursor: pointer;                }
</style>
`);
    </script>