<?php
// Incluir los modelos necesarios y obtener los datos necesarios
require_once 'models/salon.php'; 
require_once 'models/ubicacion.php'; 
$salones = Salon::all(); 
$ubicaciones = Ubicacion::all();
?>

<div class="container">
    <h2>Crear Item</h2>
    <form action="index.php?controller=item&action=store" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="codigo_bci">Código BCI:</label>
            <input type="text" class="form-control" id="codigo_bci" name="codigo_bci" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" required>
        </div>
        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca" required>
        </div>
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" class="form-control" id="modelo" name="modelo" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>



        <div class="form-group">
            <label for="id_salon">Salón:</label>
            <select class="form-control" id="id_salon" name="id_salon" required onchange="cargarArmarios()">
                <option value="" selected disabled>Selecciona</option>
                <?php foreach ($salones as $salon): ?>
                    <option value="<?php echo htmlspecialchars($salon['id_salon'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($salon['nombre_salon'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group" id="div_armario" style="display: none;">
            <label for="id_armario">Armario:</label>
            <select class="form-control" id="id_armario" name="id_armario" required>
                <option value="" selected disabled>Selecciona un salón primero</option>
            </select>
        </div>



        <div class="form-group">
            <label for="nro_inventariado">Nro. Inventariado:</label>
            <input type="text" class="form-control" id="nro_inventariado" name="nro_inventariado" required>
        </div>

        <div class="form-group">
            <label for="id_categoria">Categoría:</label>
            <input type="text" class="form-control" id="id_categoria" name="id_categoria" value="<?php echo htmlspecialchars($id_categoria); ?>" readonly>
        </div>
        
        <button type="submit" class="btn btn-primary">Crear Item</button>
    </form>
</div>

<script>
function cargarArmarios() {
    var idSalon = document.getElementById('id_salon').value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?controller=item&action=obtener_armario&id_salon=' + encodeURIComponent(idSalon), true);

    xhr.onload = function() {
        console.log("Response Text:", xhr.responseText); // Añadir esto para ver la respuesta

        if (xhr.status >= 200 && xhr.status < 400) {
            try {
                var armarios = JSON.parse(xhr.responseText);
                var selectArmarios = document.getElementById('id_armario');

                // Limpiar opciones anteriores
                selectArmarios.innerHTML = '';
                // Agregar opción predeterminada
                var option = document.createElement('option');
                option.value = '';
                option.textContent = 'Selecciona un armario';
                selectArmarios.appendChild(option);

                // Agregar las opciones de armarios obtenidas
                armarios.forEach(function(ubicacion) {
                    var option = document.createElement('option');
                    option.value = ubicacion.id_ubicacion;
                    option.textContent = ubicacion.nombre_armario;
                    selectArmarios.appendChild(option);
                });

                // Mostrar el div de armarios si hay opciones disponibles
                document.getElementById('div_armario').style.display = armarios.length > 0 ? 'block' : 'none';
            } catch (e) {
                console.error('Error parsing JSON:', e);
            }
        } else {
            console.error('Error al cargar los armarios. Estado HTTP:', xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Error de red al cargar los armarios.');
    };

    xhr.send();
}
</script>
