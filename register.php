<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$currentUser = current_user();

if ($currentUser) {
    redirect('catalogo.php');
}

$registerMessages = flash_consume('register');
$registerFormShouldBeVisible = !empty($registerMessages)
    || trim((string)old('register', 'regFullName')) !== ''
    || trim((string)old('register', 'regEmail')) !== '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta | Bons-AI</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Exo:400,400italic,500,500italic,600,600italic,700,700italic,300italic,300,100,200" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f8fbff 0%, #f0f4f8 100%);
        }
        .auth-header {
            padding: 1.5rem 0 0.5rem;
            text-align: center;
        }
        .auth-header__logo {
            display: inline-block;
            margin-bottom: 0;
        }
        .auth-header__logo img {
            width: 100px;
            height: auto;
        }
        .auth-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 0 2rem;
        }
        .auth-back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.8rem;
            border: 2px solid #486284;
            border-radius: 999px;
            color: #486284;
            font-size: 1.4rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            text-decoration: none;
        }
        .auth-back-button:hover {
            background-color: #486284;
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="auth-header">
        <a href="index.php" class="auth-header__logo">
            <img src="./img/bonsai-logo.png" alt="Bons-AI">
        </a>
    </div>

    <main class="auth-main">
        <section class="register-section" style="padding: 0; background: transparent;">
        <div class="container register-section__contenedor">
            <div class="register-section__intro">
                <h2 class="register-section__titulo">Crea tu cuenta</h2>
                <p class="register-section__descripcion">
                    Únete a nuestra comunidad. Completa el formulario y comienza a explorar nuestro catálogo de bonsáis.
                </p>
            </div>
            <?php if ($registerMessages): ?>
                <div class="flash-container">
                    <?php foreach ($registerMessages as $message): ?>
                        <div class="flash-message flash-message--<?= sanitize($message['status']); ?>">
                            <?= sanitize($message['message']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form
                id="register-form"
                class="register-form"
                novalidate
                action="controllers/user_store.php"
                method="POST"
            >
                <div class="register-form__group">
                    <label class="register-form__label" for="regFullName">Nombre completo *</label>
                    <input type="text" id="regFullName" name="regFullName" class="register-form__input" minlength="3" required placeholder="Ej. Ana Gómez" value="<?= old('register', 'regFullName'); ?>">
                    <small class="form-error" data-error-for="regFullName"></small>
                </div>
                <div class="register-form__group">
                    <label class="register-form__label" for="regEmail">Correo electrónico *</label>
                    <input type="email" id="regEmail" name="regEmail" class="register-form__input" required placeholder="correo@ejemplo.com" value="<?= old('register', 'regEmail'); ?>">
                    <small class="form-error" data-error-for="regEmail"></small>
                </div>
                <div class="register-form__row">
                    <div class="register-form__group">
                        <label class="register-form__label" for="regPassword">Contraseña *</label>
                        <input type="password" id="regPassword" name="regPassword" class="register-form__input" minlength="8" required placeholder="Ej: MiContra#123">
                        <small class="form-helper">Debe contener: mayúscula, minúscula, número y carácter especial</small>
                        <small class="form-error" data-error-for="regPassword"></small>
                    </div>
                    <div class="register-form__group">
                        <label class="register-form__label" for="regConfirmPassword">Confirmar contraseña *</label>
                        <input type="password" id="regConfirmPassword" name="regConfirmPassword" class="register-form__input" minlength="8" required placeholder="Repite tu contraseña">
                        <small class="form-error" data-error-for="regConfirmPassword"></small>
                    </div>
                </div>
                <div class="register-form__group register-form__group--checkbox">
                    <label class="form-checkbox">
                        <input type="checkbox" id="regTerms" name="regTerms" required <?= old('register', 'regTerms') ? 'checked' : ''; ?>>
                        <span>He leído y acepto los términos y condiciones *</span>
                    </label>
                    <small class="form-error" data-error-for="regTerms"></small>
                </div>
                <div class="register-form__submit-wrapper">
                    <button type="submit" class="register-form__button" disabled>Registrarme</button>
                    <p id="register-form-status" class="register-form__status" aria-live="polite"></p>
                    <p class="register-form__note">
                        ¿Ya tienes cuenta? <a href="login.php" class="login-form__link">Inicia sesión</a>
                    </p>
                </div>
            </form>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="index.php" class="auth-back-button">
                    <i class="fa fa-arrow-left"></i>
                    Volver al inicio
                </a>
            </div>
        </div>
    </section>
    </main>

    <script>
        /**
         * VALIDACIÓN DE FORMULARIO DE REGISTRO - LADO DEL CLIENTE
         * 
         * Este script implementa validación completa en JavaScript para el formulario de registro.
         * Cumple con los requisitos de validación de formularios del lado del cliente.
         * 
         * Funcionalidades:
         * - Validación en tiempo real (evento input)
         * - Validación al perder el foco (evento blur)
         * - Validación antes del envío (evento submit)
         * - Retroalimentación visual inmediata
         * - Desactivación del botón enviar hasta validación completa
         */

        // Obtener referencia al formulario de registro
        const registerForm = document.getElementById('register-form');
        
        if (registerForm) {
            // Referencias a elementos del DOM
            const statusMessage = document.getElementById('register-form-status');
            const submitButton = registerForm.querySelector('button[type="submit"]');
            const inputs = Array.from(registerForm.querySelectorAll('.register-form__input'));
            const termsCheckbox = document.getElementById('regTerms');

            // Expresión regular para validar formato de correo electrónico
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            
            /**
             * Validación de contraseña segura:
             * - Mínimo 8 caracteres
             * - Al menos una letra mayúscula
             * - Al menos una letra minúscula
             * - Al menos un número
             * - Al menos un carácter especial
             * Esta validación previene contraseñas débiles como "12345678"
             */
            const validatePasswordStrength = (password) => {
                if (password.length < 8) {
                    return 'La contraseña debe tener mínimo 8 caracteres.';
                }
                if (!/[A-Z]/.test(password)) {
                    return 'Debe contener al menos una letra MAYÚSCULA.';
                }
                if (!/[a-z]/.test(password)) {
                    return 'Debe contener al menos una letra minúscula.';
                }
                if (!/[0-9]/.test(password)) {
                    return 'Debe contener al menos un número (0-9).';
                }
                // Validar caracteres especiales
                if (!/[!@#$%^&*(),.?":{}|<>_\-]/.test(password)) {
                    return 'Debe contener al menos un carácter especial (!@#$%^&*).';
                }
                return ''; // Contraseña válida y segura
            };
            
            /**
             * Objeto con funciones validadoras para cada campo
             * Cada función retorna un string vacío si es válido, o mensaje de error si no
             */
            const validators = {
                // Validación: Nombre completo (mínimo 3 caracteres, requerido)
                regFullName: value => value.trim().length >= 3 ? '' : 'Escribe al menos 3 caracteres.',
                
                // Validación: Correo electrónico (formato válido)
                regEmail: value => emailPattern.test(value.trim()) ? '' : 'Ingresa un correo válido.',
                
                // Validación: Contraseña segura (con requisitos de seguridad robustos)
                regPassword: value => validatePasswordStrength(value),
                
                // Validación: Confirmación de contraseña (debe coincidir)
                regConfirmPassword: (value, formValues) => {
                    if (value !== formValues.regPassword) {
                        return 'Las contraseñas no coinciden.';
                    }
                    if (value.length < 8) {
                        return 'La contraseña debe tener mínimo 8 caracteres.';
                    }
                    return '';
                },
                
                // Validación: Términos y condiciones (checkbox obligatorio)
                regTerms: (_, __, field) => field.checked ? '' : 'Debes aceptar los términos.'
            };

            /**
             * Obtiene el valor de un campo, aplicando trim excepto en contraseñas
             * @param {HTMLElement} field - Campo del formulario
             * @returns {string} Valor del campo
             */
            const getFieldValue = field => {
                if (!field) return '';
                return field.type === 'password' ? field.value : field.value.trim();
            };

            /**
             * Obtiene todos los valores actuales del formulario
             * @returns {Object} Objeto con id de campo como clave y valor como dato
             */
            const getFormValues = () => inputs.reduce((acc, input) => {
                acc[input.id] = getFieldValue(input);
                return acc;
            }, {});

            /**
             * Muestra mensaje de error y aplica estilos visuales al campo
             * RETROALIMENTACIÓN VISUAL AL USUARIO:
             * - Borde rojo para campos inválidos
             * - Borde verde para campos válidos
             * - Mensaje de error específico debajo del campo
             * @param {string} fieldId - ID del campo a validar
             * @param {string} message - Mensaje de error (vacío si es válido)
             */
            const showError = (fieldId, message) => {
                const field = document.getElementById(fieldId);
                const errorEl = registerForm.querySelector(`[data-error-for="${fieldId}"]`);
                if (!errorEl) return;
                
                // Mostrar mensaje de error
                errorEl.textContent = message;
                
                // Aplicar clases de validación visual
                if (field && field.classList && field.type !== 'checkbox') {
                    if (message) {
                        field.classList.add('is-invalid');    // Rojo para inválido
                        field.classList.remove('is-valid');
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');      // Verde para válido
                    }
                }
            };

            /**
             * Valida un campo específico usando su función validadora
             * @param {string} fieldId - ID del campo a validar
             * @param {Object} options - Opciones de validación (silent: sin mostrar errores)
             * @returns {boolean} true si es válido, false si no
             */
            const validateField = (fieldId, options = {}) => {
                const { silent = false } = options;
                const field = document.getElementById(fieldId);
                if (!field || !validators[fieldId]) return true;
                
                const formValues = getFormValues();
                const message = validators[fieldId](
                    fieldId === 'regTerms' ? field.checked : getFieldValue(field), 
                    formValues, 
                    field
                );
                
                if (!silent) {
                    showError(fieldId, message);
                }
                
                return message === '';
            };

            /**
             * Valida el formulario completo
             * @param {Object} options - Opciones de validación
             * @returns {boolean} true si todo es válido, false si hay errores
             */
            const validateForm = (options = {}) => {
                const fieldIds = ['regFullName', 'regEmail', 'regPassword', 'regConfirmPassword'];
                const results = fieldIds.map(id => validateField(id, options));
                const termsValid = validateField('regTerms', options);
                return [...results, termsValid].every(Boolean);
            };

            /**
             * Actualiza el estado del botón de envío
             * DESACTIVA el botón si hay campos inválidos
             * ACTIVA el botón solo cuando todo está correcto
             */
            const updateSubmitState = () => {
                const isValid = validateForm({ silent: true });
                if (submitButton) {
                    submitButton.disabled = !isValid;
                }
                return isValid;
            };

            /**
             * VALIDACIÓN EN TIEMPO REAL (evento input)
             * Valida mientras el usuario escribe, proporcionando retroalimentación inmediata
             */
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    validateField(input.id);
                    
                    // Si se cambia la contraseña, re-validar confirmación
                    if (input.id === 'regPassword') {
                        validateField('regConfirmPassword');
                    }
                    
                    updateSubmitState();
                });
                
                /**
                 * VALIDACIÓN AL PERDER FOCO (evento blur)
                 * Verifica el campo cuando el usuario sale de él
                 */
                input.addEventListener('blur', () => {
                    validateField(input.id);
                    updateSubmitState();
                });
            });

            /**
             * VALIDACIÓN DEL CHECKBOX DE TÉRMINOS
             */
            if (termsCheckbox) {
                termsCheckbox.addEventListener('change', () => {
                    validateField('regTerms');
                    updateSubmitState();
                });
            }

            /**
             * MANEJO DEL EVENTO SUBMIT
             * Previene el envío si hay errores y muestra retroalimentación
             */
            registerForm.addEventListener('submit', event => {
                const isValid = validateForm();
                
                if (!isValid) {
                    // PREVENIR ENVÍO si hay errores
                    event.preventDefault();
                    updateSubmitState();
                    
                    // Mostrar mensaje de error al usuario
                    if (statusMessage) {
                        statusMessage.textContent = 'Corrige los campos resaltados.';
                        statusMessage.style.color = '#c0392b';
                    }
                    
                    // Log en consola para debugging
                    console.error('Formulario inválido. Corrige los errores antes de enviar.');
                } else {
                    // Mostrar mensaje de éxito
                    if (statusMessage) {
                        statusMessage.textContent = 'Enviando registro...';
                        statusMessage.style.color = '#2c7a37';
                    }
                    
                    // Log de éxito en consola
                    console.log('Formulario válido. Enviando datos...');
                    console.log('Datos a enviar:', getFormValues());
                }
            });

            // Inicializar estado del botón al cargar la página
            updateSubmitState();
        }
    </script>
</body>
</html>

