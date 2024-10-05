<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dysie - Recupera Tu Contraseña</title>
    <link rel="shortcut icon" href="{{ asset('assets/justLogoDysie.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('aos-master/dist/aos.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200..1000&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

    <!-- Logo -->
    <div class="logo">
        <a href="{{ url('/') }}"><img src="{{ asset('assets/logoDysie.png') }}" alt="Logo Dysie"></a>
    </div>
    <main>
        <div class="contenedor__todo">
            <div class="contenedor__login-register">
                <form id="formularioL" method="POST" action="{{ route('password.email') }}" class="formulario__login">
                    @csrf
                    <h2>Recupera Tu Contraseña</h2>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                    <br><br>
                    <button type="submit" class="botonDysie" style="margin-top: 30px;">Recuperar Contraseña</button>
                    <div class="contenedor-linkVolver">
                        <a class="link-Volver" href="{{ url('/') }}">Volver a Inicio</a>
                    </div> 
                </form>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
