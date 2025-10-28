/**
 * ============================================
 * CHOJIN BEATS - JavaScript Principal
 * ============================================
 */

// ============================================
// NAVBAR MODERNO - USER DROPDOWN
// ============================================
function toggleUserDropdown() {
    const dropdown = document.getElementById('userDropdown');
    const notificationsDropdown = document.getElementById('notificationsDropdown');
    
    if (dropdown) {
        dropdown.classList.toggle('show');
        // Cerrar notificaciones si están abiertas
        if (notificationsDropdown) {
            notificationsDropdown.classList.remove('show');
        }
    }
}

// ============================================
// NAVBAR MODERNO - NOTIFICACIONES
// ============================================
function toggleNotifications() {
    const dropdown = document.getElementById('notificationsDropdown');
    const userDropdown = document.getElementById('userDropdown');
    
    if (dropdown) {
        dropdown.classList.toggle('show');
        // Cerrar user dropdown si está abierto
        if (userDropdown) {
            userDropdown.classList.remove('show');
        }
    }
}

// ============================================
// BARRA DE BÚSQUEDA
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('navbarSearch');
    const clearBtn = document.getElementById('clearSearch');
    
    if (searchInput && clearBtn) {
        // Mostrar/ocultar botón de limpiar
        searchInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                clearBtn.style.display = 'flex';
            } else {
                clearBtn.style.display = 'none';
            }
        });
        
        // Limpiar búsqueda
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearBtn.style.display = 'none';
            searchInput.focus();
        });
        
        // Búsqueda al presionar Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && this.value.trim()) {
                window.location.href = `${baseUrl}/catalogo?search=${encodeURIComponent(this.value.trim())}`;
            }
        });
    }
});

// Cerrar dropdowns al hacer clic fuera
document.addEventListener('click', function(event) {
    const userDropdown = document.getElementById('userDropdown');
    const notificationsDropdown = document.getElementById('notificationsDropdown');
    const userBtn = event.target.closest('.user-btn');
    const notificationBtn = event.target.closest('.icon-btn');
    
    // Cerrar user dropdown si se hace clic fuera
    if (userDropdown && !userBtn && !event.target.closest('.user-dropdown')) {
        userDropdown.classList.remove('show');
    }
    
    // Cerrar notificaciones si se hace clic fuera
    if (notificationsDropdown && !notificationBtn && !event.target.closest('.notifications-dropdown')) {
        notificationsDropdown.classList.remove('show');
    }
});

// ============================================
// DROPDOWN MENU (Retrocompatibilidad)
// ============================================
function toggleDropdown() {
    toggleUserDropdown();
}

// ============================================
// MOBILE MENU
// ============================================
function toggleMobileMenu() {
    const navLinks = document.getElementById('navLinks');
    const mobileBtn = document.querySelector('.mobile-menu-btn');
    
    if (navLinks) {
        navLinks.classList.toggle('show');
    }
    
    if (mobileBtn) {
        mobileBtn.classList.toggle('active');
    }
}

// ============================================
// CONFIRMACIONES
// ============================================
function confirmarEliminacion(mensaje = '¿Estás seguro de eliminar este elemento?') {
    return confirm(mensaje);
}

function confirmarAccion(mensaje) {
    return confirm(mensaje);
}

// ============================================
// ALERTAS PERSONALIZADAS
// ============================================
function mostrarAlerta(tipo, mensaje, duracion = 5000) {
    const alertContainer = document.getElementById('alertContainer') || crearContenedorAlertas();
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${tipo}`;
    alert.innerHTML = `
        <i class="bi bi-${getIconoAlerta(tipo)}"></i>
        <span>${mensaje}</span>
        <button onclick="this.parentElement.remove()" class="btn btn-ghost btn-sm" style="margin-left: auto;">
            <i class="bi bi-x"></i>
        </button>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remover después de la duración especificada
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateX(100%)';
        setTimeout(() => alert.remove(), 300);
    }, duracion);
}

function crearContenedorAlertas() {
    const container = document.createElement('div');
    container.id = 'alertContainer';
    container.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        max-width: 400px;
    `;
    document.body.appendChild(container);
    return container;
}

function getIconoAlerta(tipo) {
    const iconos = {
        'success': 'check-circle-fill',
        'danger': 'exclamation-circle-fill',
        'warning': 'exclamation-triangle-fill',
        'info': 'info-circle-fill'
    };
    return iconos[tipo] || 'info-circle-fill';
}

// ============================================
// VALIDACIÓN DE FORMULARIOS
// ============================================
function validarFormulario(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const inputs = form.querySelectorAll('[required]');
    let valido = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            marcarError(input, 'Este campo es obligatorio');
            valido = false;
        } else {
            limpiarError(input);
        }
    });
    
    return valido;
}

function marcarError(input, mensaje) {
    limpiarError(input);
    
    input.style.borderColor = 'var(--danger)';
    
    const errorMsg = document.createElement('span');
    errorMsg.className = 'error-message';
    errorMsg.style.cssText = 'color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem; display: block;';
    errorMsg.textContent = mensaje;
    
    input.parentElement.appendChild(errorMsg);
}

function limpiarError(input) {
    input.style.borderColor = '';
    const errorMsg = input.parentElement.querySelector('.error-message');
    if (errorMsg) {
        errorMsg.remove();
    }
}

// ============================================
// VALIDACIÓN DE ARCHIVOS
// ============================================
function validarArchivo(input, tiposPermitidos, tamanoMaxMB = 10) {
    const archivo = input.files[0];
    if (!archivo) return true;
    
    // Validar tipo
    const extension = archivo.name.split('.').pop().toLowerCase();
    if (!tiposPermitidos.includes(extension)) {
        mostrarAlerta('danger', `Tipo de archivo no permitido. Tipos aceptados: ${tiposPermitidos.join(', ')}`);
        input.value = '';
        return false;
    }
    
    // Validar tamaño
    const tamanoMB = archivo.size / (1024 * 1024);
    if (tamanoMB > tamanoMaxMB) {
        mostrarAlerta('danger', `El archivo es demasiado grande. Tamaño máximo: ${tamanoMaxMB}MB`);
        input.value = '';
        return false;
    }
    
    return true;
}

// ============================================
// PREVIEW DE ARCHIVOS
// ============================================
function previsualizarImagen(input, previewId) {
    const preview = document.getElementById(previewId);
    if (!preview) return;
    
    const archivo = input.files[0];
    if (archivo) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(archivo);
    }
}

function mostrarNombreArchivo(input, displayId) {
    const display = document.getElementById(displayId);
    if (!display) return;
    
    const archivo = input.files[0];
    if (archivo) {
        display.textContent = archivo.name;
        display.style.display = 'block';
    }
}

// ============================================
// REPRODUCTOR DE AUDIO
// ============================================
class ReproductorAudio {
    constructor() {
        this.audioActual = null;
        this.botonActual = null;
    }
    
    reproducir(url, botonId) {
        const boton = document.getElementById(botonId);
        
        // Si hay audio reproduciéndose
        if (this.audioActual) {
            this.audioActual.pause();
            if (this.botonActual) {
                this.botonActual.innerHTML = '<i class="bi bi-play-fill"></i>';
            }
        }
        
        // Si es el mismo botón, solo pausar
        if (this.botonActual === boton && !this.audioActual.paused) {
            this.audioActual.pause();
            boton.innerHTML = '<i class="bi bi-play-fill"></i>';
            return;
        }
        
        // Reproducir nuevo audio
        this.audioActual = new Audio(url);
        this.botonActual = boton;
        
        this.audioActual.play();
        boton.innerHTML = '<i class="bi bi-pause-fill"></i>';
        
        this.audioActual.addEventListener('ended', () => {
            boton.innerHTML = '<i class="bi bi-play-fill"></i>';
        });
    }
    
    detener() {
        if (this.audioActual) {
            this.audioActual.pause();
            this.audioActual.currentTime = 0;
            if (this.botonActual) {
                this.botonActual.innerHTML = '<i class="bi bi-play-fill"></i>';
            }
        }
    }
}

const reproductor = new ReproductorAudio();

// ============================================
// BÚSQUEDA EN TIEMPO REAL
// ============================================
function busquedaEnTiempoReal(inputId, contenedorId, url) {
    const input = document.getElementById(inputId);
    const contenedor = document.getElementById(contenedorId);
    
    if (!input || !contenedor) return;
    
    let timeout;
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        
        const termino = this.value.trim();
        
        if (termino.length < 2) {
            contenedor.innerHTML = '';
            return;
        }
        
        timeout = setTimeout(() => {
            fetch(`${url}?q=${encodeURIComponent(termino)}`)
                .then(response => response.json())
                .then(data => {
                    mostrarResultados(data, contenedor);
                })
                .catch(error => {
                    console.error('Error en búsqueda:', error);
                });
        }, 300);
    });
}

function mostrarResultados(resultados, contenedor) {
    if (resultados.length === 0) {
        contenedor.innerHTML = '<p class="text-center" style="color: var(--gray-500); padding: 1rem;">No se encontraron resultados</p>';
        return;
    }
    
    // Implementar según el tipo de resultados
    contenedor.innerHTML = resultados.map(item => `
        <div class="resultado-item">
            ${item.html || item.nombre}
        </div>
    `).join('');
}

// ============================================
// COPIAR AL PORTAPAPELES
// ============================================
function copiarAlPortapapeles(texto) {
    navigator.clipboard.writeText(texto).then(() => {
        mostrarAlerta('success', 'Copiado al portapapeles');
    }).catch(err => {
        console.error('Error al copiar:', err);
        mostrarAlerta('danger', 'Error al copiar al portapapeles');
    });
}

// ============================================
// LOADING SPINNER
// ============================================
function mostrarCargando(mensaje = 'Cargando...') {
    const loading = document.createElement('div');
    loading.id = 'loadingOverlay';
    loading.innerHTML = `
        <div style="
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        ">
            <div style="text-align: center;">
                <div class="pulse" style="
                    width: 60px;
                    height: 60px;
                    border: 4px solid var(--primary);
                    border-top-color: transparent;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                    margin: 0 auto 1rem;
                "></div>
                <p style="color: white; font-size: 1.125rem;">${mensaje}</p>
            </div>
        </div>
    `;
    document.body.appendChild(loading);
}

function ocultarCargando() {
    const loading = document.getElementById('loadingOverlay');
    if (loading) {
        loading.remove();
    }
}

// ============================================
// ANIMACIÓN DE SCROLL
// ============================================
function scrollSuave(elementoId) {
    const elemento = document.getElementById(elementoId);
    if (elemento) {
        elemento.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// ============================================
// CONTADOR DE CARACTERES
// ============================================
function contadorCaracteres(textareaId, contadorId, maximo) {
    const textarea = document.getElementById(textareaId);
    const contador = document.getElementById(contadorId);
    
    if (!textarea || !contador) return;
    
    textarea.addEventListener('input', function() {
        const actual = this.value.length;
        contador.textContent = `${actual}/${maximo}`;
        
        if (actual > maximo) {
            contador.style.color = 'var(--danger)';
        } else if (actual > maximo * 0.9) {
            contador.style.color = 'var(--warning)';
        } else {
            contador.style.color = 'var(--gray-400)';
        }
    });
}

// ============================================
// ANIMACIÓN DE ENTRADA
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Animar elementos al scroll
    const observador = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    });
    
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observador.observe(el);
    });
});

// ============================================
// ESTILOS ADICIONALES DINÁMICOS
// ============================================
const estilosAdicionales = document.createElement('style');
estilosAdicionales.textContent = `
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .alert {
        transition: all 0.3s ease-out;
    }
`;
document.head.appendChild(estilosAdicionales);

console.log('🎵 CHOJIN BEATS - Sistema cargado correctamente');
