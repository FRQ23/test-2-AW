<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

require_login('index.php#auth');

$quoteMessages = flash_consume('quote');
$authMessages = flash_consume('auth');
$usersCount = 0;
$quotesCount = 0;
$currentUser = current_user();

try {
    $pdo = getConnection();
    $usersCount = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    $quotesCount = (int)$pdo->query('SELECT COUNT(*) FROM quotes')->fetchColumn();
} catch (PDOException $e) {
    // Las estadísticas son informativas; si la conexión falla se ignoran.
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bons-AI | Experiencias de Bonsái</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Exo:400,400italic,500,500italic,600,600italic,700,700italic,300italic,300,100,200" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header id="home">
        <div class="container">
            <div class="barra">
                <div class="barra__logo">
                    <a class="logo" href="#home">
                        <img src="./img/bonsai-logo.png" alt="Bons-AI" class="logo__img">
                    </a>
                </div>
                <nav class="navegacion">
                    <input type="checkbox" id="nav-toggle" class="navegacion__checkbox">
                    <label for="nav-toggle" class="navegacion__toggle" aria-label="Abrir menú">
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>
                    <div class="navegacion__links" id="nav-links">
                        <a href="#home" class="navegacion__enlace">Home</a>
                        <a href="#services" class="navegacion__enlace">Colección</a>
                        <a href="#quote" class="navegacion__enlace">Cotizar</a>
                        <a href="mis-cotizaciones.php" class="navegacion__enlace">Mis Cotizaciones</a>
                        <?php if (is_admin()): ?>
                            <a href="admin/index.php" class="navegacion__enlace">Panel Admin</a>
                        <?php endif; ?>
                        <a href="controllers/logout.php" class="navegacion__enlace navegacion__enlace--boton">Cerrar sesión</a>
                    </div>
                </nav>
            </div>
        </div>
        <div class="hero-feature hero-feature--header">
            <div class="hero-feature__contenedor hero-feature__contenedor--boxed">
                <div class="hero-feature__texto">
                    <span class="hero-feature__etiqueta">Bons-AI</span>
                    <h2 class="hero-feature__titulo">Los mejores bonsáis del mundo</h2>
                    <p class="hero-feature__descripcion">
                        Descubre el arte de cultivar árboles en miniatura que transmiten armonía y equilibrio. Cada ejemplar es moldeado a mano para llenar tus espacios de calma.
                    </p>
                    <a href="#services" class="hero-feature__boton">Descubrir colecciones</a>
                </div>
                <div class="hero-feature__media">
                    <img src="./img/arbol-bonsai.jpg" alt="Árbol bonsái" class="hero-feature__imagen">
                </div>
            </div>
        </div>
    </header>

    <section id="services" class="bonsai-list">
        <div class="container bonsai-list__contenedor">
            <h2 class="bonsai-list__titulo">Colección destacada</h2>
            <div class="bonsai-card">
                <div class="bonsai-card__contenido">
                    <h3 class="bonsai-card__titulo">Bonsái Junípero</h3>
                    <p class="bonsai-card__descripcion">
                        Resistente y escultural, el bonsái de junípero prospera en interior o exterior y ofrece el clásico perfil de la tradición nipona.
                    </p>
                    <a href="#quote" class="bonsai-card__boton">Solicitar estilo</a>
                </div>
                <div class="bonsai-card__media">
                    <img src="./img/juniper-bonsai.jpg" alt="Bonsái Junípero" class="bonsai-card__imagen">
                </div>
            </div>
            <div class="bonsai-card">
                <div class="bonsai-card__contenido">
                    <h3 class="bonsai-card__titulo">Bonsái Ficus</h3>
                    <p class="bonsai-card__descripcion">
                        Ideal para principiantes gracias a su follaje brillante y raíces aéreas que añaden un toque tropical a cualquier espacio.
                    </p>
                    <a href="#quote" class="bonsai-card__boton">Conocer cuidados</a>
                </div>
                <div class="bonsai-card__media">
                    <img src="./img/ficus-bonsai.jpg" alt="Bonsái Ficus" class="bonsai-card__imagen">
                </div>
            </div>
            <div class="bonsai-card">
                <div class="bonsai-card__contenido">
                    <h3 class="bonsai-card__titulo">Bonsái Arce Japonés</h3>
                    <p class="bonsai-card__descripcion">
                        Famoso por su colorido estacional. Cada hoja refleja el paso del tiempo con elegancia y sutileza.
                    </p>
                    <a href="#quote" class="bonsai-card__boton">Ver variedades</a>
                </div>
                <div class="bonsai-card__media">
                    <img src="./img/japanese-maple.jpg" alt="Bonsái arce japonés" class="bonsai-card__imagen">
                </div>
            </div>
        </div>
    </section>

    <section class="bonsai-grid">
        <div class="container bonsai-grid__contenedor">
            <div class="bonsai-grid__intro">
                <h2 class="bonsai-grid__titulo">Galería de inspiración</h2>
                <p class="bonsai-grid__descripcion">
                    Recorre nuestra selección de especies entrenadas durante años. Cada bonsái cuenta una historia de paciencia, diseño y respeto por la naturaleza.
                </p>
            </div>
            <div class="bonsai-grid__imagenes">
                <div class="bonsai-grid__card">
                    <img src="./img/japanese-maple.jpg" alt="Bonsái arce japonés" class="bonsai-grid__imagen">
                </div>
                <div class="bonsai-grid__card">
                    <img src="./img/ficus-bonsai.jpg" alt="Bonsái ficus" class="bonsai-grid__imagen">
                </div>
                <div class="bonsai-grid__card">
                    <img src="./img/juniper-bonsai.jpg" alt="Bonsái junípero" class="bonsai-grid__imagen">
                </div>
            </div>
            <div class="bonsai-stats">
                <div class="bonsai-stat">
                    <span class="bonsai-stat__numero"><?= number_format($usersCount); ?></span>
                    <span class="bonsai-stat__texto">Usuarios registrados en la plataforma</span>
                </div>
                <div class="bonsai-stat">
                    <span class="bonsai-stat__numero"><?= number_format($quotesCount); ?></span>
                    <span class="bonsai-stat__texto">Solicitudes de cotización almacenadas</span>
                </div>
                <div class="bonsai-stat">
                    <span class="bonsai-stat__numero">24h</span>
                    <span class="bonsai-stat__texto">Tiempo de respuesta promedio</span>
                </div>
            </div>
        </div>
    </section>

    <section class="bonsai-testimonials">
        <div class="container bonsai-testimonials__contenedor">
            <div class="bonsai-testimonial">
                <div class="bonsai-testimonial__header">
                    <div class="bonsai-testimonial__avatar">
                        <img src="./img/1.png" alt="Avatar de cliente">
                    </div>
                    <div>
                        <span class="bonsai-testimonial__stars">★★★★★</span>
                    </div>
                </div>
                <p class="bonsai-testimonial__texto">
                    “Mi junípero llegó perfectamente formado. Tenerlo en el escritorio transforma por completo mi jornada.”
                </p>
                <span class="bonsai-testimonial__autor">Avery Chen</span>
            </div>
            <div class="bonsai-testimonial">
                <div class="bonsai-testimonial__header">
                    <div class="bonsai-testimonial__avatar">
                        <img src="./img/1.png" alt="Avatar de cliente">
                    </div>
                    <div>
                        <span class="bonsai-testimonial__stars">★★★★★</span>
                    </div>
                </div>
                <p class="bonsai-testimonial__texto">
                    “El bonsái ficus incluía instrucciones detalladas y luce mejor que en las fotos.”
                </p>
                <span class="bonsai-testimonial__autor">Jordan Blake</span>
            </div>
            <div class="bonsai-testimonial">
                <div class="bonsai-testimonial__header">
                    <div class="bonsai-testimonial__avatar">
                        <img src="./img/1.png" alt="Avatar de cliente">
                    </div>
                    <div>
                        <span class="bonsai-testimonial__stars">★★★★★</span>
                    </div>
                </div>
                <p class="bonsai-testimonial__texto">
                    “El arce japonés se convirtió en el centro de nuestra sala. El proceso fue sencillo y muy profesional.”
                </p>
                <span class="bonsai-testimonial__autor">Morgan Lee</span>
            </div>
        </div>
    </section>

    <section id="quote" class="quote-section">
        <div class="container quote-section__contenedor">
            <div class="quote-section__header">
                <span class="quote-section__etiqueta">Cotiza</span>
                <h2 class="quote-section__titulo">Solicita tu bonsái personalizado</h2>
                <p class="quote-section__descripcion">
                    Compártenos tus preferencias y recibirás una propuesta personalizada en menos de 24 horas.
                </p>
            </div>
            <?php if ($authMessages): ?>
                <div class="flash-container">
                    <?php foreach ($authMessages as $message): ?>
                        <div class="flash-message flash-message--<?= sanitize($message['status']); ?>">
                            <?= sanitize($message['message']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ($quoteMessages): ?>
                <div class="flash-container">
                    <?php foreach ($quoteMessages as $message): ?>
                        <div class="flash-message flash-message--<?= sanitize($message['status']); ?>">
                            <?= sanitize($message['message']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="user-session-banner">
                <div class="user-session-banner__info">
                    <div class="user-session-banner__avatar">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="user-session-banner__details">
                        <span class="user-session-banner__name"><?= sanitize($currentUser['full_name']); ?></span>
                        <span class="user-session-banner__email"><?= sanitize($currentUser['email']); ?></span>
                    </div>
                </div>
                <form action="controllers/logout.php" method="POST" style="margin: 0;">
                    <button type="submit" class="user-session-banner__logout">
                        <i class="fa fa-sign-out"></i>
                        Cerrar sesión
                    </button>
                </form>
            </div>
            <form class="quote-form" id="quote-form" action="controllers/quote_store.php" method="POST" novalidate>
                <div class="quote-form__row">
                    <div class="quote-form__group">
                        <label for="phone" class="quote-form__label">Teléfono (opcional)</label>
                        <input type="tel" id="phone" name="phone" class="quote-form__input" placeholder="+52 664 123 4567" value="<?= old('quote', 'phone'); ?>">
                        <small class="form-error" data-error-for="phone"></small>
                    </div>
                    <div class="quote-form__group">
                        <label for="bonsaiType" class="quote-form__label">Tipo de bonsái *</label>
                        <select id="bonsaiType" name="bonsaiType" class="quote-form__input" required>
                            <option value="">Selecciona una opción</option>
                            <option value="juniper" <?= old('quote', 'bonsaiType') === 'juniper' ? 'selected' : ''; ?>>Junípero</option>
                            <option value="ficus" <?= old('quote', 'bonsaiType') === 'ficus' ? 'selected' : ''; ?>>Ficus</option>
                            <option value="japanese-maple" <?= old('quote', 'bonsaiType') === 'japanese-maple' ? 'selected' : ''; ?>>Arce japonés</option>
                            <option value="pine" <?= old('quote', 'bonsaiType') === 'pine' ? 'selected' : ''; ?>>Pino</option>
                            <option value="elm" <?= old('quote', 'bonsaiType') === 'elm' ? 'selected' : ''; ?>>Olmo chino</option>
                            <option value="custom" <?= old('quote', 'bonsaiType') === 'custom' ? 'selected' : ''; ?>>Diseño a medida</option>
                        </select>
                        <small class="form-error" data-error-for="bonsaiType"></small>
                    </div>
                </div>
                <div class="quote-form__row">
                    <div class="quote-form__group">
                        <label for="size" class="quote-form__label">Tamaño preferido *</label>
                        <select id="size" name="size" class="quote-form__input" required>
                            <option value="">Selecciona el tamaño</option>
                            <option value="small" <?= old('quote', 'size') === 'small' ? 'selected' : ''; ?>>Pequeño (15-25 cm)</option>
                            <option value="medium" <?= old('quote', 'size') === 'medium' ? 'selected' : ''; ?>>Mediano (25-40 cm)</option>
                            <option value="large" <?= old('quote', 'size') === 'large' ? 'selected' : ''; ?>>Grande (40-60 cm)</option>
                            <option value="extra-large" <?= old('quote', 'size') === 'extra-large' ? 'selected' : ''; ?>>Extra grande (60+ cm)</option>
                        </select>
                        <small class="form-error" data-error-for="size"></small>
                    </div>
                    <div class="quote-form__group">
                        <label for="budget" class="quote-form__label">Presupuesto (opcional)</label>
                        <select id="budget" name="budget" class="quote-form__input">
                            <option value="">Selecciona un rango</option>
                            <option value="under-100" <?= old('quote', 'budget') === 'under-100' ? 'selected' : ''; ?>>Menos de $100</option>
                            <option value="100-250" <?= old('quote', 'budget') === '100-250' ? 'selected' : ''; ?>>$100 - $250</option>
                            <option value="250-500" <?= old('quote', 'budget') === '250-500' ? 'selected' : ''; ?>>$250 - $500</option>
                            <option value="500-1000" <?= old('quote', 'budget') === '500-1000' ? 'selected' : ''; ?>>$500 - $1,000</option>
                            <option value="over-1000" <?= old('quote', 'budget') === 'over-1000' ? 'selected' : ''; ?>>Más de $1,000</option>
                        </select>
                        <small class="form-error" data-error-for="budget"></small>
                    </div>
                </div>
                <div class="quote-form__group quote-form__group--full">
                    <label for="message" class="quote-form__label">Detalles adicionales</label>
                    <textarea id="message" name="message" class="quote-form__textarea" rows="5" placeholder="Describe requisitos, estilo deseado o preguntas adicionales..." maxlength="500"><?= old('quote', 'message'); ?></textarea>
                    <small class="form-helper" id="message-counter">0 / 500 caracteres</small>
                    <small class="form-error" data-error-for="message"></small>
                </div>
                <div class="quote-form__submit-wrapper">
                    <button type="submit" class="quote-form__button" id="quote-submit-btn">Enviar solicitud</button>
                    <p class="quote-form__note" id="quote-form-status"></p>
                    <p class="quote-form__note">* Campos obligatorios</p>
                </div>
            </form>
        </div>
    </section>

    <footer id="contact" class="bonsai-footer">
        <div class="container bonsai-footer__contenedor">
            <div class="bonsai-footer__brand">
                <img src="./img/bonsai-logo.png" alt="Logo Bons-AI" class="bonsai-footer__logo">
                <h2 class="bonsai-footer__nombre">Bons-AI</h2>
                <p class="bonsai-footer__slogan">Cultivamos calma, un árbol a la vez.</p>
                <a href="#quote" class="bonsai-footer__cta">Solicitar un bonsái</a>
            </div>
            <div class="bonsai-footer__column">
                <h3>Servicios</h3>
                <ul>
                    <li><a href="#quote">Diseños personalizados</a></li>
                    <li><a href="#services">Talleres y eventos</a></li>
                    <li><a href="#quote">Tarjetas de regalo</a></li>
                </ul>
            </div>
            <div class="bonsai-footer__column">
                <h3>Aprende</h3>
                <ul>
                    <li><a href="admin/index.php">Guías para principiantes</a></li>
                    <li><a href="admin/index.php">Técnicas avanzadas</a></li>
                    <li><a href="#services">Biblioteca de especies</a></li>
                    <li><a href="#quote">Preguntas frecuentes</a></li>
                </ul>
            </div>
            <div class="bonsai-footer__column">
                <h3>Contacto</h3>
                <ul>
                    <li><a href="mailto:fernando.rosales59@uabc.edu.mx">fernando.rosales59@uabc.edu.mx</a></li>
                    <li><a href="tel:+526645568800">+52 (664) 556-8800</a></li>
                    <li><a href="#home">Visita nuestro estudio</a></li>
                </ul>
            </div>
        </div>
        <div class="bonsai-footer__bottom">
            <div class="bonsai-footer__bottom-social">
                <a href="#" aria-label="Facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" aria-label="Instagram"><i class="fa fa-instagram"></i></a>
            </div>
            <span>© <?= date('Y'); ?> Bons-AI. Todos los derechos reservados.</span>
            <span>Diseño de Fernando Rosales.</span>
        </div>
    </footer>

    <script>
        const navToggle = document.getElementById('nav-toggle');
        document.querySelectorAll('.navegacion__enlace').forEach(link => {
            link.addEventListener('click', () => {
                if (navToggle) {
                    navToggle.checked = false;
                }
            });
        });

        /**
         * VALIDACIÓN DE FORMULARIO DE COTIZACIÓN - LADO DEL CLIENTE
         * 
         * Este script implementa validación completa y personalizada para el formulario de cotización.
         * Incluye validaciones interesantes y feedback visual para mejorar la experiencia del usuario.
         * 
         * Funcionalidades:
         * - Validación de formato de teléfono (opcional pero con formato correcto)
         * - Validación de campos requeridos (tipo y tamaño)
         * - Contador de caracteres en tiempo real para el mensaje
         * - Validación en tiempo real (evento input/change)
         * - Retroalimentación visual inmediata
         * - Desactivación del botón hasta que todo esté válido
         * - Resumen de datos antes de enviar
         */

        const quoteForm = document.getElementById('quote-form');
        
        if (quoteForm) {
            // Referencias a elementos del DOM
            const submitButton = document.getElementById('quote-submit-btn');
            const statusMessage = document.getElementById('quote-form-status');
            const phoneInput = document.getElementById('phone');
            const bonsaiTypeSelect = document.getElementById('bonsaiType');
            const sizeSelect = document.getElementById('size');
            const budgetSelect = document.getElementById('budget');
            const messageTextarea = document.getElementById('message');
            const messageCounter = document.getElementById('message-counter');

            /**
             * EXPRESIONES REGULARES PARA VALIDACIÓN
             */
            // Formato de teléfono flexible: acepta +52, (664), espacios, guiones
            const phonePattern = /^(\+?\d{1,3})?[\s.-]?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/;
            
            /**
             * FUNCIONES VALIDADORAS PARA CADA CAMPO
             * Retornan string vacío si es válido, o mensaje de error si no
             */
            const validators = {
                // Validación de teléfono: opcional, pero si se ingresa debe tener formato correcto
                phone: (value) => {
                    if (!value.trim()) return ''; // Opcional, vacío es válido
                    return phonePattern.test(value.trim()) 
                        ? '' 
                        : 'Formato inválido. Ej: +52 664 123 4567';
                },
                
                // Validación de tipo de bonsái: campo requerido
                bonsaiType: (value) => {
                    return value.trim() !== '' ? '' : 'Selecciona el tipo de bonsái que deseas.';
                },
                
                // Validación de tamaño: campo requerido
                size: (value) => {
                    return value.trim() !== '' ? '' : 'Selecciona el tamaño preferido.';
                },
                
                // Validación de mensaje: longitud máxima
                message: (value) => {
                    if (value.length > 500) return 'El mensaje no puede exceder 500 caracteres.';
                    return '';
                }
            };

            /**
             * Muestra mensaje de error y aplica estilos visuales
             * @param {string} fieldId - ID del campo
             * @param {string} message - Mensaje de error (vacío si válido)
             */
            const showError = (fieldId, message) => {
                const field = document.getElementById(fieldId);
                const errorEl = quoteForm.querySelector(`[data-error-for="${fieldId}"]`);
                
                if (errorEl) {
                    errorEl.textContent = message;
                }
                
                // Aplicar clases de validación visual
                if (field && field.classList) {
                    if (message) {
                        field.classList.add('is-invalid');
                        field.classList.remove('is-valid');
                    } else {
                        field.classList.remove('is-invalid');
                        if (field.value.trim() !== '' || fieldId === 'phone') {
                            field.classList.add('is-valid');
                        }
                    }
                }
            };

            /**
             * Valida un campo específico
             * @param {string} fieldId - ID del campo a validar
             * @param {boolean} silent - Si es true, no muestra errores
             * @returns {boolean} true si es válido
             */
            const validateField = (fieldId, silent = false) => {
                const field = document.getElementById(fieldId);
                if (!field || !validators[fieldId]) return true;
                
                const value = field.value;
                const message = validators[fieldId](value);
                
                if (!silent) {
                    showError(fieldId, message);
                }
                
                return message === '';
            };

            /**
             * Valida el formulario completo
             * @param {boolean} silent - Si es true, no muestra errores
             * @returns {boolean} true si todo es válido
             */
            const validateForm = (silent = false) => {
                const phoneValid = validateField('phone', silent);
                const bonsaiTypeValid = validateField('bonsaiType', silent);
                const sizeValid = validateField('size', silent);
                const messageValid = validateField('message', silent);
                
                return phoneValid && bonsaiTypeValid && sizeValid && messageValid;
            };

            /**
             * Actualiza el estado del botón de envío
             * HABILITA el botón solo cuando todo es válido
             */
            const updateSubmitState = () => {
                const isValid = validateForm(true);
                if (submitButton) {
                    submitButton.disabled = !isValid;
                    
                    // Cambiar el estilo visual del botón
                    if (isValid) {
                        submitButton.style.opacity = '1';
                        submitButton.style.cursor = 'pointer';
                    } else {
                        submitButton.style.opacity = '0.5';
                        submitButton.style.cursor = 'not-allowed';
                    }
                }
            };

            /**
             * CONTADOR DE CARACTERES EN TIEMPO REAL
             * Muestra cuántos caracteres ha escrito el usuario en el mensaje
             */
            const updateCharacterCounter = () => {
                const length = messageTextarea.value.length;
                const maxLength = 500;
                messageCounter.textContent = `${length} / ${maxLength} caracteres`;
                
                // Cambiar color si se acerca al límite
                if (length > 450) {
                    messageCounter.style.color = '#c0392b'; // Rojo cuando está cerca del límite
                } else if (length > 350) {
                    messageCounter.style.color = '#f39c12'; // Naranja
                } else {
                    messageCounter.style.color = '#6d7f98'; // Color normal
                }
            };

            /**
             * VALIDACIÓN EN TIEMPO REAL - Teléfono
             */
            if (phoneInput) {
                phoneInput.addEventListener('input', () => {
                    validateField('phone');
                    updateSubmitState();
                });
                
                phoneInput.addEventListener('blur', () => {
                    validateField('phone');
                    updateSubmitState();
                });
            }

            /**
             * VALIDACIÓN EN TIEMPO REAL - Selects (tipo y tamaño)
             */
            if (bonsaiTypeSelect) {
                bonsaiTypeSelect.addEventListener('change', () => {
                    validateField('bonsaiType');
                    updateSubmitState();
                });
            }

            if (sizeSelect) {
                sizeSelect.addEventListener('change', () => {
                    validateField('size');
                    updateSubmitState();
                });
            }

            /**
             * VALIDACIÓN Y CONTADOR - Mensaje
             */
            if (messageTextarea) {
                messageTextarea.addEventListener('input', () => {
                    updateCharacterCounter();
                    validateField('message');
                    updateSubmitState();
                });
                
                // Inicializar contador al cargar
                updateCharacterCounter();
            }

            /**
             * MANEJO DEL EVENTO SUBMIT
             * Valida todo antes de enviar y muestra resumen
             */
            quoteForm.addEventListener('submit', (event) => {
                const isValid = validateForm(false);
                
                if (!isValid) {
                    // PREVENIR ENVÍO si hay errores
                    event.preventDefault();
                    
                    if (statusMessage) {
                        statusMessage.textContent = 'Por favor completa los campos requeridos correctamente.';
                        statusMessage.style.color = '#c0392b';
                        statusMessage.style.fontWeight = '600';
                    }
                    
                    console.error('Formulario de cotización inválido.');
                    return;
                }
                
                // MOSTRAR RESUMEN EN CONSOLA (éxito)
                const formData = {
                    telefono: phoneInput.value.trim() || 'No proporcionado',
                    tipoBonsai: bonsaiTypeSelect.options[bonsaiTypeSelect.selectedIndex].text,
                    tamaño: sizeSelect.options[sizeSelect.selectedIndex].text,
                    presupuesto: budgetSelect.value ? budgetSelect.options[budgetSelect.selectedIndex].text : 'No especificado',
                    mensaje: messageTextarea.value.trim() || 'Sin mensaje adicional',
                };
                
                console.log('Formulario de cotización válido. Enviando solicitud...');
                console.log('RESUMEN DE LA COTIZACIÓN:');
                console.table(formData);
                
                // Mostrar mensaje de éxito
                if (statusMessage) {
                    statusMessage.textContent = 'Enviando solicitud de cotización...';
                    statusMessage.style.color = '#2c7a37';
                    statusMessage.style.fontWeight = '600';
                }
            });

            // Inicializar estado del botón al cargar la página
            updateSubmitState();
        }
    </script>
</body>
</html>
