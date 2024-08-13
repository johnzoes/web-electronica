<h2>Notificaciones</h2>
<ul class="list-group">
    <?php if (!empty($notificaciones)): ?>
        <?php foreach ($notificaciones as $notificacion): ?>
            <li class="list-group-item">
                <a href="index.php?controller=notificacion&action=view&id=<?php echo $notificacion['id']; ?>" target="_blank">
                    <?php echo htmlspecialchars($notificacion['message'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="list-group-item">No hay notificaciones</li>
    <?php endif; ?>
</ul>


<script>
    // Función para actualizar las notificaciones
    function fetchNotifications() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?controller=notificacion&action=fetch', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const notifications = JSON.parse(xhr.responseText);
                const notificationList = document.getElementById('notification-list');
                notificationList.innerHTML = '';

                if (notifications.length > 0) {
                    notifications.forEach(notification => {
                        const listItem = document.createElement('li');
                        listItem.className = 'list-group-item';
                        listItem.innerHTML = `<a href="index.php?controller=notificacion&action=view&id=${notification.id}" target="_blank">${notification.message}</a>`;
                        notificationList.appendChild(listItem);
                    });
                } else {
                    notificationList.innerHTML = '<li class="list-group-item">No hay notificaciones</li>';
                }
            }
        };
        xhr.send();
    }

    // Actualizar notificaciones cada 10 segundos
    setInterval(fetchNotifications, 10000);

    // Inicializar la actualización de notificaciones
    fetchNotifications();
</script>