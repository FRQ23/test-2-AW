<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/init.php';

require_login('login.php');

$currentUser = current_user();
$quotes = [];

try {
    $pdo = getConnection();
    $stmt = $pdo->prepare(
        'SELECT * FROM quotes 
         WHERE user_id = :user_id 
         ORDER BY created_at DESC'
    );
    $stmt->execute([':user_id' => $currentUser['id']]);
    $quotes = $stmt->fetchAll();
} catch (PDOException $e) {
    $dbError = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cotizaciones | Bons-AI</title>
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
                    <a class="logo" href="catalogo.php">
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
                        <a href="catalogo.php#home" class="navegacion__enlace">Home</a>
                        <a href="catalogo.php#services" class="navegacion__enlace">Colección</a>
                        <a href="catalogo.php#quote" class="navegacion__enlace">Cotizar</a>
                        <a href="mis-cotizaciones.php" class="navegacion__enlace">Mis Cotizaciones</a>
                        <?php if (is_admin()): ?>
                            <a href="admin/index.php" class="navegacion__enlace">Panel Admin</a>
                        <?php endif; ?>
                        <a href="controllers/logout.php" class="navegacion__enlace navegacion__enlace--boton">Cerrar sesión</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <section class="quote-section" style="padding: 6rem 0; min-height: calc(100vh - 200px);">
        <div class="container">
            <div class="quote-section__header">
                <h2 class="quote-section__titulo">Mis Solicitudes de Cotización</h2>
                <p class="quote-section__descripcion">
                    Aquí puedes ver todas tus solicitudes y las respuestas del equipo de Bons-AI.
                </p>
            </div>

            <?php if (empty($quotes)): ?>
                <div class="admin-card" style="text-align: center; padding: 4rem;">
                    <p style="font-size: 1.8rem; color: #6d7f98; margin-bottom: 2rem;">
                        Aún no has realizado ninguna solicitud de cotización.
                    </p>
                    <a href="catalogo.php#quote" class="quote-form__button">Solicitar mi primer bonsái</a>
                </div>
            <?php else: ?>
                <div style="display: grid; gap: 2.5rem;">
                    <?php foreach ($quotes as $quote): ?>
                        <div class="admin-card">
                            <div style="display: grid; gap: 1.5rem;">
                                <!-- Encabezado de la cotización -->
                                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f0f4f8; padding-bottom: 1.5rem;">
                                    <div>
                                        <h3 style="font-size: 2rem; color: #486284; margin: 0 0 0.5rem;">
                                            Solicitud #<?= (int)$quote['id']; ?>
                                        </h3>
                                        <p style="font-size: 1.3rem; color: #6d7f98; margin: 0;">
                                            Enviada el <?= date('d/m/Y H:i', strtotime($quote['created_at'])); ?>
                                        </p>
                                    </div>
                                    <?php if (!empty($quote['response_message'])): ?>
                                        <span style="display: inline-block; padding: 0.6rem 1.2rem; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); color: white; border-radius: 999px; font-size: 1.3rem; font-weight: 600;">
                                            Respondida
                                        </span>
                                    <?php else: ?>
                                        <span style="display: inline-block; padding: 0.6rem 1.2rem; background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border-radius: 999px; font-size: 1.3rem; font-weight: 600;">
                                            Pendiente
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Detalles de la solicitud -->
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                                    <div>
                                        <p style="font-size: 1.3rem; color: #6d7f98; margin: 0 0 0.3rem;">Tipo de Bonsái</p>
                                        <p style="font-size: 1.6rem; color: #2c325e; font-weight: 600; margin: 0;">
                                            <?= sanitize($quote['bonsai_type']); ?>
                                        </p>
                                    </div>
                                    <div>
                                        <p style="font-size: 1.3rem; color: #6d7f98; margin: 0 0 0.3rem;">Tamaño</p>
                                        <p style="font-size: 1.6rem; color: #2c325e; font-weight: 600; margin: 0;">
                                            <?= sanitize($quote['size']); ?>
                                        </p>
                                    </div>
                                    <?php if ($quote['budget']): ?>
                                        <div>
                                            <p style="font-size: 1.3rem; color: #6d7f98; margin: 0 0 0.3rem;">Presupuesto</p>
                                            <p style="font-size: 1.6rem; color: #2c325e; font-weight: 600; margin: 0;">
                                                <?= sanitize($quote['budget']); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($quote['phone']): ?>
                                        <div>
                                            <p style="font-size: 1.3rem; color: #6d7f98; margin: 0 0 0.3rem;">Teléfono</p>
                                            <p style="font-size: 1.6rem; color: #2c325e; font-weight: 600; margin: 0;">
                                                <?= sanitize($quote['phone']); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($quote['message']): ?>
                                    <div>
                                        <p style="font-size: 1.3rem; color: #6d7f98; margin: 0 0 0.8rem;">Tu Mensaje</p>
                                        <p style="font-size: 1.5rem; color: #2c325e; margin: 0; padding: 1.2rem; background: #f8fbff; border-radius: 1rem; line-height: 1.6;">
                                            <?= nl2br(sanitize($quote['message'])); ?>
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <!-- Respuesta del administrador -->
                                <?php if (!empty($quote['response_message'])): ?>
                                    <div style="background: linear-gradient(135deg, #e8f8f5 0%, #d4efdf 100%); padding: 2rem; border-radius: 1.6rem; border-left: 5px solid #2ecc71;">
                                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                            <i class="fa fa-check-circle" style="font-size: 2.4rem; color: #2ecc71;"></i>
                                            <div>
                                                <p style="font-size: 1.5rem; color: #27ae60; font-weight: 700; margin: 0;">
                                                    Respuesta de Bons-AI
                                                </p>
                                                <p style="font-size: 1.3rem; color: #229954; margin: 0;">
                                                    Respondido el <?= date('d/m/Y H:i', strtotime($quote['response_sent_at'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <p style="font-size: 1.6rem; color: #1e8449; margin: 0; line-height: 1.7;">
                                            <?= nl2br(sanitize($quote['response_message'])); ?>
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <div style="background: #fff8e1; padding: 1.5rem; border-radius: 1rem; border-left: 4px solid #f39c12;">
                                        <p style="font-size: 1.4rem; color: #b8860b; margin: 0;">
                                            <i class="fa fa-clock-o"></i>
                                            Tu solicitud está siendo revisada. Recibirás una respuesta pronto.
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer id="contact" class="bonsai-footer">
        <div class="container bonsai-footer__contenedor">
            <div class="bonsai-footer__brand">
                <img src="./img/bonsai-logo.png" alt="Logo Bons-AI" class="bonsai-footer__logo">
                <h2 class="bonsai-footer__nombre">Bons-AI</h2>
                <p class="bonsai-footer__slogan">Cultivamos calma, un árbol a la vez.</p>
                <a href="catalogo.php#quote" class="bonsai-footer__cta">Solicitar un bonsái</a>
            </div>
            <div class="bonsai-footer__column">
                <h3>Servicios</h3>
                <ul>
                    <li><a href="catalogo.php#services">Diseños personalizados</a></li>
                    <li><a href="catalogo.php#services">Talleres y eventos</a></li>
                    <li><a href="mis-cotizaciones.php">Mis cotizaciones</a></li>
                </ul>
            </div>
            <div class="bonsai-footer__column">
                <h3>Aprende</h3>
                <ul>
                    <li><a href="#">Guías para principiantes</a></li>
                    <li><a href="#">Técnicas avanzadas</a></li>
                    <li><a href="catalogo.php#services">Biblioteca de especies</a></li>
                </ul>
            </div>
            <div class="bonsai-footer__column">
                <h3>Contacto</h3>
                <ul>
                    <li><a href="mailto:fernando.rosales59@uabc.edu.mx">fernando.rosales59@uabc.edu.mx</a></li>
                    <li><a href="tel:+526645568800">+52 (664) 556-8800</a></li>
                    <li><a href="catalogo.php#home">Visita nuestro estudio</a></li>
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
    </script>
</body>
</html>

