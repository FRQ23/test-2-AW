<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$currentUser = current_user();

if ($currentUser) {
    redirect('catalogo.php');
}

$usersCount = 0;
$quotesCount = 0;

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
                        <a href="#services" class="navegacion__enlace">Show Case</a>
                        <a href="#contact" class="navegacion__enlace">Contact</a>
                        <a href="login.php" class="navegacion__enlace navegacion__enlace--boton">Iniciar sesión</a>
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
                    <a href="login.php" class="hero-feature__boton">Acceder al catálogo</a>
                </div>
                <div class="hero-feature__media">
                    <video src="./video/japanese-maple.mp4" autoplay muted loop playsinline controls class="hero-feature__imagen"></video>
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
                    <a href="#auth" class="bonsai-card__boton">Solicitar estilo</a>
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
                    <a href="#auth" class="bonsai-card__boton">Conocer cuidados</a>
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
                    <a href="#auth" class="bonsai-card__boton">Ver variedades</a>
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


    <footer id="contact" class="bonsai-footer">
        <div class="container bonsai-footer__contenedor">
            <div class="bonsai-footer__brand">
                <img src="./img/bonsai-logo.png" alt="Logo Bons-AI" class="bonsai-footer__logo">
                <h2 class="bonsai-footer__nombre">Bons-AI</h2>
                <p class="bonsai-footer__slogan">Cultivamos calma, un árbol a la vez.</p>
                <a href="login.php" class="bonsai-footer__cta">Solicitar un bonsái</a>
            </div>
            <div class="bonsai-footer__column">
                <h3>Servicios</h3>
                <ul>
                    <li><a href="#services">Diseños personalizados</a></li>
                    <li><a href="#services">Talleres y eventos</a></li>
                    <li><a href="#auth">Tarjetas de regalo</a></li>
                </ul>
            </div>
            <div class="bonsai-footer__column">
                <h3>Aprende</h3>
                <ul>
                    <li><a href="admin/index.php">Guías para principiantes</a></li>
                    <li><a href="admin/index.php">Técnicas avanzadas</a></li>
                    <li><a href="#services">Biblioteca de especies</a></li>
                    <li><a href="#auth">Preguntas frecuentes</a></li>
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

        const registerForm = document.getElementById('register-form');
        if (registerForm) {
            const statusMessage = document.getElementById('register-form-status');
            const submitButton = registerForm.querySelector('button[type="submit"]');
            const inputs = Array.from(registerForm.querySelectorAll('.register-form__input'));
            const termsCheckbox = document.getElementById('regTerms');

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            const validators = {
                regFullName: value => value.trim().length >= 3 ? '' : 'Escribe al menos 3 caracteres.',
                regEmail: value => emailPattern.test(value.trim()) ? '' : 'Ingresa un correo válido.',
                regPassword: value => value.length >= 8 ? '' : 'La contraseña debe tener mínimo 8 caracteres.',
                regConfirmPassword: (value, formValues) => value === formValues.regPassword && value.length >= 8 ? '' : 'Las contraseñas deben coincidir.',
                regTerms: (_, __, field) => field.checked ? '' : 'Debes aceptar los términos.'
            };

            const getFieldValue = field => {
                if (!field) return '';
                return field.type === 'password' ? field.value : field.value.trim();
            };

            const getFormValues = () => inputs.reduce((acc, input) => {
                acc[input.id] = getFieldValue(input);
                return acc;
            }, {});

            const showError = (fieldId, message) => {
                const field = document.getElementById(fieldId);
                const errorEl = registerForm.querySelector(`[data-error-for="${fieldId}"]`);
                if (!errorEl) return;
                errorEl.textContent = message;
                if (field && field.classList && field.type !== 'checkbox') {
                    if (message) {
                        field.classList.add('is-invalid');
                        field.classList.remove('is-valid');
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                }
            };

            const validateField = (fieldId, options = {}) => {
                const { silent = false } = options;
                const field = document.getElementById(fieldId);
                if (!field || !validators[fieldId]) return true;
                const formValues = getFormValues();
                const message = validators[fieldId](fieldId === 'regTerms' ? field.checked : getFieldValue(field), formValues, field);
                if (!silent) {
                    showError(fieldId, message);
                }
                return message === '';
            };

            const validateForm = (options = {}) => {
                const fieldIds = ['regFullName', 'regEmail', 'regPassword', 'regConfirmPassword'];
                const results = fieldIds.map(id => validateField(id, options));
                const termsValid = validateField('regTerms', options);
                return [...results, termsValid].every(Boolean);
            };

            const updateSubmitState = () => {
                const isValid = validateForm({ silent: true });
                if (submitButton) {
                    submitButton.disabled = !isValid;
                }
                return isValid;
            };

            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    validateField(input.id);
                    if (input.id === 'regPassword') {
                        validateField('regConfirmPassword');
                    }
                    updateSubmitState();
                });
                input.addEventListener('blur', () => {
                    validateField(input.id);
                    updateSubmitState();
                });
            });

            if (termsCheckbox) {
                termsCheckbox.addEventListener('change', () => {
                    validateField('regTerms');
                    updateSubmitState();
                });
            }

            registerForm.addEventListener('submit', event => {
                const isValid = validateForm();
                if (!isValid) {
                    event.preventDefault();
                    updateSubmitState();
                    if (statusMessage) {
                        statusMessage.textContent = 'Corrige los campos resaltados.';
                        statusMessage.style.color = '#c0392b';
                    }
                } else if (statusMessage) {
                    statusMessage.textContent = 'Enviando registro...';
                    statusMessage.style.color = '#2c7a37';
                }
            });

            updateSubmitState();
        }
    </script>
</body>
</html>
