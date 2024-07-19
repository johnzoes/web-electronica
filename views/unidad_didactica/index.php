<div class="container">
    <h2 class="my-4 poppins-bold">Lista de Unidades Didácticas</h2>
    <a href="index.php?controller=unidad_didactica&action=create" class="btn btn-success mb-3">Crear</a>
    <table class="table-modern">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ciclo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($unidadesDidacticas as $unidadDidactica): ?>
            <tr>
                <td><?php echo htmlspecialchars($unidadDidactica['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($unidadDidactica['ciclo'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="index.php?controller=unidad_didactica&action=edit&id=<?php echo htmlspecialchars($unidadDidactica['id_unidad_didactica'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm">
                        <!-- SVG para Editar -->
                    </a>
                    <form action="index.php?controller=unidad_didactica&action=delete&id=<?php echo htmlspecialchars($unidadDidactica['id_unidad_didactica'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" style="display: inline-block;">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <!-- SVG para Eliminar -->
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($unidadesDidacticas)): ?>
                <tr>
                    <td colspan="3">No hay unidades didácticas disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
