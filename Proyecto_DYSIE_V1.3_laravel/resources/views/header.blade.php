<!-- header.blade.php -->

<header>
    <div class="logo">
        <img src="{{ asset('assets/logoDysie.png') }}" alt="">
    </div>
    <nav>
        <ul>
            <li><a href="/">Inicio</a></li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            <li><a href="/profile" class="botonDysie">Mi Perfil</a></li>
        </ul>
    </nav>
</header>
