<link rel="stylesheet" href="views/usuario/usuario.css">
    <title>Lista de Usuarios</title>
</head>
<body>
    <div class="container">
        <h2 class="poppins-bold">Lista de Usuarios</h2>
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="-5.0 -10.0 110.0 135.0"  width="50px" height="50px">
            <g fill-rule="evenodd">
                <path d="m70.832 39.582c0 1.1523 0.93359 2.0859 2.0859 2.0859h4.1641c1.1523 0 2.0859-0.93359 2.0859-2.0859v-6.25h6.25c1.1484 0 2.082-0.92969 2.082-2.082v-4.168c0-1.1484-0.93359-2.082-2.082-2.082h-6.25v-6.25c0-1.1523-0.93359-2.082-2.0859-2.082h-4.1641c-1.1523 0-2.0859 0.92969-2.0859 2.082v6.25h-6.25c-1.1484 0-2.082 0.93359-2.082 2.082v4.168c0 1.1523 0.93359 2.082 2.082 2.082h6.25z"/>
                <path d="m41.668 41.668c4.6016 0 8.332-3.7305 8.332-8.3359 0-4.6016-3.7305-8.332-8.332-8.332-4.6055 0-8.3359 3.7305-8.3359 8.332 0 4.6055 3.7305 8.3359 8.3359 8.3359zm0 8.332c9.2031 0 16.664-7.4609 16.664-16.668 0-9.2031-7.4609-16.664-16.664-16.664-9.207 0-16.668 7.4609-16.668 16.664 0 9.207 7.4609 16.668 16.668 16.668z"/>
                <path d="m70.797 79.207c-0.039063-1.375-0.16406-2.707-0.41406-4.082-0.46094-2.293-1.375-5.375-3.25-8.5-3.918-6.5-11.543-12.457-25.461-12.457-13.914 0-21.539 5.957-25.414 12.5-1.875 3.125-2.793 6.207-3.25 8.5-0.25 1.1641-0.33594 2.125-0.41797 2.832-0.125 1.375-0.082032 2.75-0.082032 4.168 0 0.70703 0.53906 1.25 1.25 1.25h5.832c0.70703 0 1.25-0.54297 1.25-1.25 0-1.8359 0-3.7109 0.33203-5.543 1.043-5.125 4.25-9.543 9-11.793 3.543-1.707 7.5859-2.25 11.5-2.25 11.086 0 15.961 4.5 18.293 8.375 1.043 1.75 1.793 3.7109 2.207 5.75 0.375 1.793 0.33594 3.625 0.33594 5.4609 0 0.70703 0.53906 1.25 1.25 1.25h5.832c0.70703 0 1.25-0.54297 1.25-1.25v-2.918z"/>
            </g>
        </svg>

        
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
    </div>

    <a href="index.php?controller=usuario&action=create" class="btn btn-custom mb-3 poppins-bold">CREAR USUARIO</a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>