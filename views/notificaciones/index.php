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
