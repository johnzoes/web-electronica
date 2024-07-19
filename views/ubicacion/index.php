<?php
require_once 'models/salon.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>
<link rel="stylesheet" href="styles.css">

<div class="container">
    <h2 class="my-4 poppins-bold">Lista de Ubicaciones</h2>
    <?php if ($rol != 3): // Si no es profesor ?>
        <a href="index.php?controller=ubicacion&action=create" class="btn btn-success mb-3">Crear Ubicación</a>
    <?php endif; ?>
    <table class="table-modern" id="sortableTable">
        <thead>
            <tr>
                <th data-sort="name">Nombre del Armario</th>
                <th data-sort="salon">Salón</th>
                <?php if ($rol != 3): // Si no es profesor ?>
                    <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ubicaciones as $ubicacion): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ubicacion['nombre_armario'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($ubicacion['id_salon'], ENT_QUOTES, 'UTF-8'); ?></td>
<?php if ($rol != 3): // Si no es profesor ?>                    
<td>
                    <a href="index.php?controller=ubicacion&action=edit&id=<?php echo htmlspecialchars($ubicacion['id_ubicacion'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary ">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50 " width="20px" height="20px">
                        <path d="M 36 5.0097656 C 34.205301 5.0097656 32.410791 5.6901377 31.050781 7.0507812 L 8.9160156 29.183594 C 8.4960384 29.603571 8.1884588 30.12585 8.0253906 30.699219 L 5.0585938 41.087891 A 1.50015 1.50015 0 0 0 6.9121094 42.941406 L 17.302734 39.974609 A 1.50015 1.50015 0 0 0 17.304688 39.972656 C 17.874212 39.808939 18.39521 39.50518 18.816406 39.083984 L 40.949219 16.949219 C 43.670344 14.228094 43.670344 9.7719064 40.949219 7.0507812 C 39.589209 5.6901377 37.794699 5.0097656 36 5.0097656 z M 36 7.9921875 C 37.020801 7.9921875 38.040182 8.3855186 38.826172 9.171875 A 1.50015 1.50015 0 0 0 38.828125 9.171875 C 40.403 10.74675 40.403 13.25325 38.828125 14.828125 L 36.888672 16.767578 L 31.232422 11.111328 L 33.171875 9.171875 C 33.957865 8.3855186 34.979199 7.9921875 36 7.9921875 z M 29.111328 13.232422 L 34.767578 18.888672 L 16.693359 36.962891 C 16.634729 37.021121 16.560472 37.065723 16.476562 37.089844 L 8.6835938 39.316406 L 10.910156 31.521484 A 1.50015 1.50015 0 0 0 10.910156 31.519531 C 10.933086 31.438901 10.975086 31.366709 11.037109 31.304688 L 29.111328 13.232422 z"/>
                    </svg>                        
                </a>          
                
                <a href="index.php?controller=ubicacion&action=delete&id=<?php echo htmlspecialchars($ubicacion['id_ubicacion'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-danger">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="20px" height="20px">
                    <path d="M 21 2 C 19.354545 2 18 3.3545455 18 5 L 18 7 L 10.154297 7 A 1.0001 1.0001 0 0 0 9.984375 6.9863281 A 1.0001 1.0001 0 0 0 9.8398438 7 L 8 7 A 1.0001 1.0001 0 1 0 8 9 L 9 9 L 9 45 C 9 46.645455 10.354545 48 12 48 L 38 48 C 39.645455 48 41 46.645455 41 45 L 41 9 L 42 9 A 1.0001 1.0001 0 1 0 42 7 L 40.167969 7 A 1.0001 1.0001 0 0 0 39.841797 7 L 32 7 L 32 5 C 32 3.3545455 30.645455 2 29 2 L 21 2 z M 21 4 L 29 4 C 29.554545 4 30 4.4454545 30 5 L 30 7 L 20 7 L 20 5 C 20 4.4454545 20.445455 4 21 4 z M 11 9 L 18.832031 9 A 1.0001 1.0001 0 0 0 19.158203 9 L 30.832031 9 A 1.0001 1.0001 0 0 0 31.158203 9 L 39 9 L 39 45 C 39 45.554545 38.554545 46 38 46 L 12 46 C 11.445455 46 11 45.554545 11 45 L 11 9 z M 18.984375 13.986328 A 1.0001 1.0001 0 0 0 18 15 L 18 40 A 1.0001 1.0001 0 1 0 20 40 L 20 15 A 1.0001 1.0001 0 0 0 18.984375 13.986328 z M 24.984375 13.986328 A 1.0001 1.0001 0 0 0 24 15 L 24 40 A 1.0001 1.0001 0 1 0 26 40 L 26 15 A 1.0001 1.0001 0 0 0 24.984375 13.986328 z M 30.984375 13.986328 A 1.0001 1.0001 0 0 0 30 15 L 30 40 A 1.0001 1.0001 0 1 0 32 40 L 32 15 A 1.0001 1.0001 0 0 0 30.984375 13.986328 z"/>
            </svg>
                    </svg>                        
                </a>    

                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (isset($_GET['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>'
            });
        });
    </script>
<?php elseif (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Ubicación eliminada correctamente'
            });
        });
    </script>
<?php endif; ?>