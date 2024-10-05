<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kanban Dysie</title>
    <link href="{{ asset('css/estilosdashboard.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo"><img class="" src="{{ asset('assets/logoDysie.png') }}" alt=""></div>
        <nav>
            <ul>
                <li><a href="/">Inicio</a></li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                <li><a href="/profile" class="botonDysie">Mi Perfil</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="board">
            <h1 class="titulo-index">Agrega, Edita y Elimina tableros</h1>
            <h3 class="parrafo-index">¡Agrega etiquetas dentro de tu tablero, edítalas <br> y una vez completadas elimímalas!</h3>

            <div class="cuadrado-contenido">
                <h1 class="agrega-txt">Agrega un Tablero</h1>
                <form action="{{ route('tableros.store') }}" method="POST">
                    @csrf
                    <input type="text" name="nombre_tablero" class="tablero-nombre-i" placeholder="Nombre del tablero" required><br><br>
                    <select class="seleccionar" name="color" required>
                        <option value="#4496ff">Azul</option>
                        <option value="#fe44ff">Rosado</option>
                        <option value="#a832ff">Morado</option>
                        <option value="#28bf2e">Verde</option>
                        <option value="#585858">Gris</option>
                        <option value="linear-gradient(125deg, #ff5f60, #f9d423);">Amarillo / Naranja</option>
                        <option value="linear-gradient(125deg, #197fff, #ff75ed);">Azul / Rosado</option>
                        <option value="linear-gradient(125deg, #4bff00, #4d00ff);">Verde / Morado</option>
                        <option value="linear-gradient(125deg, #006ccf, #00ff95);">Azul / Verde</option>
                        <option value="linear-gradient(125deg, #8b00ff, #a832ff);">Rosa / Morado</option>
                    </select><br><br>
                    <button type="submit" class="btn-tablero">Agregar</button>
                </form>
            </div>
        </div>

        <div class="tableros-container">
            <!-- Iteración sobre los tableros -->
            @foreach ($tableros as $tablero)
            <div class="tablero" style="background: {{ $tablero->color }};">
                <h2>{{ $tablero->nombre_tablero }}</h2>
                <!-- Formulario para agregar tarjetas -->
                <form action="{{ route('tarjetas.store') }}" method="POST">
                    @csrf
                    <input type="text" name="nombre_tarjeta" class="nombre-tarjeta" placeholder="Nombre de la tarjeta" required>
                    <input type="hidden" name="tablero_id" value="{{ $tablero->id }}">
                    <select name="color" required>
                        <option value="#4496ff">Azul</option>
                        <option value="#fe44ff">Rosado</option>
                        <option value="#a832ff">Morado</option>
                        <option value="#28bf2e">Verde</option>
                        <option value="#585858">Gris</option>
                        <option value="linear-gradient(125deg, #ff5f60, #f9d423);">Amarillo / Naranja</option>
                        <option value="linear-gradient(125deg, #197fff, #ff75ed);">Azul / Rosado</option>
                        <option value="linear-gradient(125deg, #4bff00, #4d00ff);">Verde / Morado</option>
                        <option value="linear-gradient(125deg, #006ccf, #00ff95);">Azul / Verde</option>
                        <option value="linear-gradient(125deg, #8b00ff, #a832ff);">Rosa / Morado</option>
                    </select>
                    <button type="submit" class="btn-tarjeta">Agregar Tarjeta</button>
                </form>
                <!-- Formulario para eliminar tablero -->
                <form action="{{ route('tableros.destroy', $tablero->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Eliminar Tablero</button>
                </form>
                <!-- Iteración sobre las tarjetas del tablero -->
                @foreach ($tablero->tarjetas as $tarjeta)
                <div class="tarjeta" style="background: {{ $tarjeta->color }};">
                    <h3>{{ $tarjeta->nombre_tarjeta }}</h3>
                    <!-- Formulario para eliminar tarjeta -->
                    <form action="{{ route('tarjetas.destroy', $tarjeta->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Eliminar Tarjeta</button>
                    </form>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>

    <footer>
        <!-- Aquí puedes colocar tu footer -->
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
