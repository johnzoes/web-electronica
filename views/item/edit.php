<?php
// Incluir los modelos necesarios y obtener los datos necesarios
require_once 'models/item.php';
require_once 'models/salon.php'; 
require_once 'models/ubicacion.php'; 
require_once 'models/categoria.php';

$item = Item::find($_GET['id']);

$ubicacion = Ubicacion::find($item['id_ubicacion']);

$salones = Salon::all(); 

$ubicaciones = Ubicacion::all();
$categorias = Categoria::all();
?>

<div class="container">
    <h2>Editar Item</h2>
    <form action="index.php?controller=item&action=update&id=<?php echo $item['id_item']; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="codigo_bci">Código BCI:</label>
            <input type="text" class="form-control" id="codigo_bci" name="codigo_bci" value="<?php echo htmlspecialchars($item['codigo_bci'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($item['descripcion'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($item['cantidad'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" value="<?php echo htmlspecialchars($item['estado'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca" value="<?php echo htmlspecialchars($item['marca'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo htmlspecialchars($item['modelo'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
            <?php if (!empty($item['imagen'])): ?>
                <img src="<?php echo htmlspecialchars($item['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen del item" style="max-width: 100px;">
            <?php endif; ?>
        </div>

        <div class="form-group">
    <label for="id_salon">Salón:</label>
    <select class="form-control" id="id_salon" name="id_salon" required onchange="cargarArmarios()">
        <option value="" selected disabled>Selecciona</option>
        <?php foreach ($salones as $salon): ?>
 
            <option value="<?php echo htmlspecialchars($salon['id_salon'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($salon['id_salon'] == $ubicacion['id_salon']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($salon['nombre_salon'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


        <div class="form-group" id="div_armario">
            <label for="id_armario">Armario:</label>
            <select class="form-control" id="id_armario" name="id_armario" required>
                <?php foreach ($ubicaciones as $ubicacion): ?>
                    <option value="<?php echo htmlspecialchars($ubicacion['id_ubicacion'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $ubicacion['id_ubicacion'] == $item['id_ubicacion'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($ubicacion['nombre_armario'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nro_inventariado">Nro. Inventariado:</label>
            <input type="text" class="form-control" id="nro_inventariado" name="nro_inventariado" value="<?php echo htmlspecialchars($item['nro_inventariado'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="id_categoria">Categoría:</label>
            <select class="form-control" id="id_categoria" name="id_categoria" required>
                <option value="" selected disabled>Selecciona</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo htmlspecialchars($categoria['id_categoria'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $categoria['id_categoria'] == $item['id_categoria'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($categoria['nombre_categoria'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar Item</button>
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
