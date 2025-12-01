<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

$currentUser = current_user();

if ($currentUser) {
    redirect('catalogo.php');
}

$authMessages = flash_consume('auth');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Bons-AI</title>
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
                <h2 class="register-section__titulo">Inicia sesión</h2>
                <p class="register-section__descripcion">
                    Accede a tu cuenta para explorar el catálogo completo y solicitar tu bonsái personalizado.
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
            <form
                id="login-form"
                class="register-form"
                action="controllers/login.php"
                method="POST"
            >
                <div class="register-form__group">
                    <label class="register-form__label" for="loginEmail">Correo electrónico *</label>
                    <input type="email" id="loginEmail" name="loginEmail" class="register-form__input" required placeholder="correo@ejemplo.com">
                </div>
                <div class="register-form__group">
                    <label class="register-form__label" for="loginPassword">Contraseña *</label>
                    <input type="password" id="loginPassword" name="loginPassword" class="register-form__input" required placeholder="Tu contraseña">
                </div>
                <div class="register-form__submit-wrapper">
                    <button type="submit" class="register-form__button">Iniciar sesión</button>
                    <p class="register-form__note">
                        ¿Sin cuenta? <a href="register.php" class="login-form__link">Regístrate</a>
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
</body>
</html>

