<div class="container">
    <h2>Actualizar Asistente</h2>
    <form action="index.php?controller=asistente&action=update&id=<?php echo $usuario['id_usuario']; ?>" method="POST">
        <div class="form-group">
            <label for="nombre_usuario">Usuario:</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo $usuario['nombre_usuario']; ?>" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellido:</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $usuario['apellidos']; ?>" required>
        </div>
        <div class="form-group">
            <label for="turno">Turno:</label>
            <select class="form-control" id="id_turno" name="id_turno" required>
                <option value="" disabled>Selecciona un turno</option>
                <?php foreach ($turnos as $turno): ?>
                    <option value="<?php echo $turno['id_turno']; ?>" <?php echo $turno['id_turno'] == $asistente['id_turno'] ? 'selected' : ''; ?>>
                        <?php echo $turno['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>




            
        </div>
        <div class="form-group">
            <label for="salon">Salón:</label>
            <select class="form-control" id="id_salon" name="id_salon" required>
                <option value="" disabled>Selecciona un salón</option>
                <?php foreach ($salones as $salon): ?>
                    <option value="<?php echo $salon['id_salon']; ?>" <?php echo $salon['id_salon'] == $asistente['id_salon'] ? 'selected' : ''; ?>>
                        <?php echo $salon['nombre_salon']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Asistente</button>
    </form>
</div>
