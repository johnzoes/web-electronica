<?php
if ($_SESSION['role'] != 3) {
    header('Location: index.php?controller=reserva&action=index');
    exit;
}

$profesorId = $_SESSION['user_id']; // ID del profesor
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reserva</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Crear Reserva</h2>
    <form action="index.php?controller=reserva&action=store" method="POST">
        <input type="hidden" name="id_profesor" value="<?php echo $profesorId; ?>" />

        <div class="form-group">
            <label for="fecha_prestamo">Fecha de Préstamo:</label>
            <input type="date" class="form-control" id="fecha_prestamo" name="fecha_prestamo" required>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select class="form-control" id="item" name="item[]" required>
                            <option value="" selected disabled>Selecciona un ítem</option>
                            <?php foreach ($items as $item): ?>
                                <option value="<?php echo $item['id_item']; ?>"><?php echo htmlspecialchars($item['descripcion'], ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control" id="cantidad" name="cantidad[]" min="1" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success" id="add-item">Agregar</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <label for="ciclo">Ciclo:</label>
            <select class="form-control" id="ciclo" name="ciclo" required onchange="cargarUnidadesDidacticas()">
                <option value="" disabled selected>Selecciona ciclo</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
                <option value="IV">IV</option>
                <option value="V">V</option>
                <option value="VI">VI</option>
            </select>
        </div>

        <div class="form-group" id="div_unidad_didactica" style="display: none;">
            <label for="unidad_didactica">Unidad Didáctica:</label>
            <select class="form-control" id="unidad_didactica" name="unidad_didactica" required>
                <option value="" disabled selected>Selecciona una Unidad Didáctica</option>
                <!-- Las opciones se llenarán dinámicamente -->
            </select>
        </div>

        <div class="form-group">
            <label for="id_turno">Turno:</label>
            <select class="form-control" id="id_turno" name="id_turno" required>
                <option value="" selected disabled>Para qué turno lo desea</option>
                <?php foreach ($turnos as $turno): ?>
                    <option value="<?php echo htmlspecialchars($turno['id_turno'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($turno['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Crear Reserva</button>
    </form>
</div>

<script>
function cargarUnidadesDidacticas() {
    var ciclo = document.getElementById('ciclo').value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?controller=reserva&action=obtener_unidad_didactica&ciclo=' + encodeURIComponent(ciclo), true);

    xhr.onload = function() {
        console.log("Response Text:", xhr.responseText); // Añadir esto para ver la respuesta

        if (xhr.status >= 200 && xhr.status < 400) {
            try {
                // Verifica que la respuesta no esté vacía antes de intentar analizarla
                if (xhr.responseText.trim().length > 0) {
                    var unidades = JSON.parse(xhr.responseText);
                    var selectUnidades = document.getElementById('unidad_didactica');

                    // Limpiar opciones anteriores
                    selectUnidades.innerHTML = '';
                    // Agregar opción predeterminada
                    var option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Selecciona una unidad didactica';
                    selectUnidades.appendChild(option);

                    // Agregar las opciones de unidades obtenidas
                    unidades.forEach(function(unidad) {
                        var option = document.createElement('option');
                        option.value = unidad.id_unidad_didactica;
                        option.textContent = unidad.nombre;
                        selectUnidades.appendChild(option);
                    });

                    // Mostrar el div de unidades si hay opciones disponibles
                    document.getElementById('div_unidad_didactica').style.display = unidades.length > 0 ? 'block' : 'none';
                } else {
                    console.error('Respuesta vacía del servidor.');
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
            }
        } else {
            console.error('Error al cargar las unidades didacticas. Estado HTTP:', xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Error de red al cargar las unidades didacticas.');
    };

    xhr.send();
}

document.getElementById('add-item').addEventListener('click', function() {
    var newRow = '<tr>' +
        '<td>' +
        '<select class="form-control" name="item[]" required>' +
        '<option value="" selected disabled>Selecciona un ítem</option>' +
        '<?php foreach ($items as $item): ?>' +
        '<option value="<?php echo htmlspecialchars($item['id_item'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($item['descripcion'], ENT_QUOTES, 'UTF-8'); ?></option>' +
        '<?php endforeach; ?>' +
        '</select>' +
        '</td>' +
        '<td>' +
        '<input type="number" class="form-control" name="cantidad[]" min="1" required>' +
        '</td>' +
        '<td>' +
        '<button type="button" class="btn btn-danger remove-item">Eliminar</button>' +
        '</td>' +
        '</tr>';

    document.querySelector('table tbody').insertAdjacentHTML('beforeend', newRow);
});

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-item')) {
        event.target.closest('tr').remove();
    }
});
</script>
</body>
</html>