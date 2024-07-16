<div class="container">
    <h2>Lista de Unidades Didácticas</h2>
    <a href="index.php?controller=unidad_didactica&action=create" class="btn btn-success mb-3">Crear</a>
    <table class="table">
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
                <td><?php echo $unidadDidactica['nombre']; ?></td>
                <td><?php echo $unidadDidactica['ciclo']; ?></td>
                <td>
                    <a href="index.php?controller=unidad_didactica&action=edit&id=<?php echo $unidadDidactica['id_unidad_didactica']; ?>" class="btn btn-primary">Editar</a>
                    <form action="index.php?controller=unidad_didactica&action=delete&id=<?php echo $unidadDidactica['id_unidad_didactica']; ?>" method="POST" style="display: inline-block;">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
