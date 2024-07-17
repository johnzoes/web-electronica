<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="views/font-poppins.css">
    <link rel="stylesheet" href="views/login.css">

    <title>Iniciar sesión</title>
</head>
<body>
    <div class="background"></div>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-box">
            <h2 class="mb-4">Iniciar Sesión</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="index.php?controller=auth&action=authenticate" method="POST">
                <div class="mb-3">
                    <label for="nombre_usuario" class="form-label">Username</label>
                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary poppins-light">Continuar</button>
            </form>
        </div>
    </div>
</body>
</html>
