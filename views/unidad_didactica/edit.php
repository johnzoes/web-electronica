<div class="container">
    <h2>Actualizar Unidad Didáctica</h2>
    <form action="index.php?controller=unidad_didactica&action=update&id=<?php echo $unidadDidactica['id_unidad_didactica']; ?>" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $unidadDidactica['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ciclo">Ciclo:</label>
            <input type="text" class="form-control" id="ciclo" name="ciclo" value="<?php echo $unidadDidactica['ciclo']; ?>" required>
        </div>
 
        <button type="submit" class="btn btn-primary">Actualizar Unidad Didáctica</button>
    </form>
</div>
