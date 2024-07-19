
<div class="container mt-5">
    <h2>Crear Usuario</h2>
    <form action="index.php?controller=usuario&action=store" method="POST">
        <div class="form-group">
            <label for="id_rol">Rol:</label>
            <select class="form-control" id="id_rol" name="id_rol" required>
                <option value="">Seleccione un rol</option>
                <option value="2">Asistente</option>
                <option value="3">Profesor</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Siguiente</button>
    </form>
</div>
</body>
</html>
