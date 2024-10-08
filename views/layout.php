    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Obtener las notificaciones para el usuario actual
    if (isset($_SESSION['user_id'])) {
        $notificaciones = Notification::getByUserId($_SESSION['user_id']);
        $notificaciones_no_leidas = Notification::countUnreadByUser($_SESSION['user_id']);
    } else {
        $notificaciones = [];
        $notificaciones_no_leidas = 0;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800&display=swap"
            rel="stylesheet">

        <link rel="stylesheet" href="views/font-poppins.css">

        <link rel="stylesheet" href="views/styles.css">
<!-- En tu HTML, asegúrate de tener el archivo de sonido -->

        <title>Inventariado</title>
    </head>

    <body>
        <header>
        <audio id="notification-sound" src="assets/sounds/notification-sound.mp3" preload="auto"></audio>

            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-nav">
                    <a class="navbar-brand poppins-semibold" href="#">SISTEMA</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <?php if ($_SESSION['role'] != 3): ?>
                                <li class="nav-item">
                                    <a class="nav-link poppins-medium"
                                        href="index.php?controller=ubicacion&action=index">Ubicación</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link poppins-medium"
                                        href="index.php?controller=salon&action=index">Salones</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link poppins-medium"
                                        href="index.php?controller=categoria&action=index">Categoría</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link poppins-medium"
                                        href="index.php?controller=unidad_didactica&action=index">Unidad Didáctica</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link poppins-medium"
                                    href="index.php?controller=reserva&action=index">Reserva</a>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="notificaciones-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger <?php echo $notificaciones_no_leidas > 0 ? '' : 'd-none'; ?>">
                    <?php echo $notificaciones_no_leidas; ?>
                        </span>
                        </a>


                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificaciones-dropdown">
                                    <?php if (isset($notificaciones) && !empty($notificaciones)): ?>
                                        <?php foreach ($notificaciones as $notificacion): ?>
                                            <li><a class="dropdown-item" href="index.php?controller=notificacion&action=view&id=<?php echo $notificacion['id']; ?>" target="_blank"><?php echo htmlspecialchars($notificacion['message'], ENT_QUOTES, 'UTF-8'); ?></a></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="#">No hay notificaciones</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <?php if ($_SESSION['role'] == 1): ?>
                                <li class="nav-item">
                                    <a class="nav-link poppins-medium"
                                        href="index.php?controller=usuario&action=index">Usuarios</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link poppins-medium" href="index.php?controller=auth&action=logout">Cerrar
                                    sesión</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main class="container-main my-4">
            <?php require_once $view; ?>
        </main>

        <footer class="bg-light text-center py-3">
            <p>&copy; 2024 Inventariado</p>
        </footer>

        <!-- Carga jQuery antes que Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="views/notificaciones/index.php"></script>


<script>

function fetchNotifications() {
    console.log("Verificando nuevas notificaciones...");
    $.ajax({
        url: 'index.php?controller=notificacion&action=fetchUnreadCount',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            const unreadCount = response.unread_count;
            const notificationBell = document.getElementById('notificaciones-dropdown');
            const previousUnreadCount = notificationBell.getAttribute('data-unread-count') || 0;

            // Actualizar el número de notificaciones no leídas directamente en la campana
            if (unreadCount > 0) {
                notificationBell.innerHTML = `<i class="fas fa-bell"></i> <span class="badge bg-danger">${unreadCount}</span>`;
            } else {
                notificationBell.innerHTML = `<i class="fas fa-bell"></i>`;
            }

            // Comprobar si hay nuevas notificaciones
            if (unreadCount > previousUnreadCount) {
                // Reproducir sonido si hay nuevas notificaciones
                document.getElementById('notification-sound').play();
            }

            // Guardar el nuevo conteo en un atributo personalizado
            notificationBell.setAttribute('data-unread-count', unreadCount);
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener las notificaciones:", error);
        }
    });
}

// Verificar cada 10 segundos
setInterval(fetchNotifications, 10000);
// Ejecutar inmediatamente al cargar la página
fetchNotifications();

</script>



    </body>

    </html>