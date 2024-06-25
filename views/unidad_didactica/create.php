<div class="container">
    <h2>Crear Unidad Didáctica</h2>
    <form action="index.php?controller=unidad_didactica&action=store" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="ciclo">Ciclo:</label>
            <input type="text" class="form-control" id="ciclo" name="ciclo" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
