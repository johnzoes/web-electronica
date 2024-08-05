<link rel="stylesheet" href="views/usuario/usuario.css">
    <title>Lista de Usuarios</title>
</head>
<body>
    <div class="container">
        <h2 class="poppins-bold mb-5">TIPO DE USUARIO</h2>


        
        <div class="row justify-content-center">
            <!-- Tarjeta para Asistentes -->
            <div class="col-md-4 mb-4">
                <div class="card card-gradient text-center d-flex align-items-center justify-content-center">
                    <a href="index.php?controller=asistente&action=index" class="text-decoration-none text-dark w-100 h-100 d-flex align-items-center justify-content-center">
                        <div class="card-body">
                            <h5 class="card-title poppins-bold">Asistentes</h5>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Tarjeta para Profesores -->
            <div class="col-md-4 mb-4">
                <div class="card card-gradient text-center d-flex align-items-center justify-content-center">
                    <a href="index.php?controller=profesor&action=index" class="text-decoration-none text-dark w-100 h-100 d-flex align-items-center justify-content-center">
                        <div class="card-body">
                            <h5 class="card-title poppins-bold">Profesores</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <a href="index.php?controller=usuario&action=create" class="btn btn-custom mb-3 poppins-bold d-flex justify-content-end">CREAR USUARIO</a>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>