<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dysie - Inicio</title>
    <link rel="icon" href="{{ asset('assets/justLogoDysie.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}"> <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('aos-master/dist/aos.css') }}"> <!-- AOS ANIMATE -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- OUTFIT GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- OUTFIT GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap" rel="stylesheet"> <!-- OUTFIT GOOGLE FONT -->
  </head>

<body>
  <style>
    .contenedor-bienvenida {
      background: linear-gradient(-334deg, #016595, #016595, #01e185);
    }

    .contenedor-bienvenida h1, .contenedor-bienvenida p {
      color: white;
    } 

    .gradiente-bg1 {
      background: linear-gradient(156deg, #016595, #016595, #01e185);
      }
      
    .Planes{
      background: linear-gradient(25deg,#016595, #016595, #01e185);
    }
    .contenedor-cartas{
      background: none;
    }

    .contenedor-cartas h1, .contenedor-cartas p{
      color: white;
    }
    .carta{ 
      background: linear-gradient(154deg, #6baff3, #7affa3);
    }

    .gradiente-bg2{
      background: linear-gradient(154deg,#016595,#016595,#01e185 );
      height: 100vh;
      padding: 0px 0px 50px 0px;
    }
  </style>

  <!-- HEADER -->

  <header class="pagina_principal">
    <a href="" class="logo"><img class="" src="assets/logoDysie.png" alt=""></a>
    <nav>
      <ul>
        <li><a href="#inicio" id="inicio">Inicio</a></li>
        <li><a href="#Sobre Nosotros" id="Sobre Nosotros">Sobre Nosotros</a></li>
        <li><a href="#Planes" id="Planes">Planes</a></li>
        <div class="menu-container">
          <!--  -->
          <a class="botonDysie accordion-btn" style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5); padding: 10px 30px; margin: 0px 10px;"
          onclick="toggleMenu(event)">
          Iniciar Sesión
      </a>
      <ul class="accordion-panel" style="display: none; padding: 0; margin-top: 10px;flex-direction: row;">
          <li style="font-size: 10px;"><a href="/admin" class="botonDysie">Administrador</a></li>
          <li style="font-size: 10px;"><a href="/login" class="botonDysie">Estudiante</a></li>
      </ul>
    </nav>
  </header>
  <!-- SCRIPT CANIMACIÓN HEADER -->
  <script type="text/javascript">
    window.addEventListener("scroll", function () {
      var header = document.querySelector("header");
      header.classList.toggle("abajo", window.scrollY > 0);
    })
  </script>
  <script>
      function toggleMenu(event) {
        event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

        var panel = event.target.nextElementSibling; // Obtener el panel siguiente al botón
        var isOpen = panel.style.display === 'block'; // Verificar si el panel está abierto

        // Cerrar todos los paneles antes de abrir el actual
        var allPanels = document.querySelectorAll('.accordion-panel');
        allPanels.forEach(function (item) {
            item.style.display = 'none';
        });

        if (!isOpen) {
            panel.style.display = 'flex'; // Mostrar el panel si está oculto
        } else {
            panel.style.display = 'none'; // Ocultar el panel si está visible
        }

        // Verificar si ambos paneles están ocultos
        var allHidden = true;
        allPanels.forEach(function (item) {
            if (item.style.display !== 'none') {
                allHidden = false;
            }
        });

        // Mostrar o ocultar el enlace "Iniciar Sesión" según el estado de los otros paneles
        var iniciarSesionLink = document.querySelector('.accordion-btn');
        if (allHidden) {
            iniciarSesionLink.style.display = 'block';
        } else {
            iniciarSesionLink.style.display = 'none';
        }
    }
  </script>

  <!-- CABECERA DE PÁGINA -->

  <div class="contenedor-principal">
    <div class="texto-p">
      <h2 class="h2-p">Organízate, Mantente al día y
        Prográmate <br> con <span class="Dysie-txt-animacion">Dysie</span>
      </h2>
      <p class="p-p">Crea, edita y elimina tableros. Anota tus tareas y completalas. ¡Únete a nosotros!</p>

      <div class="botones-p" style="display: flex; gap: 12px; margin: 30px 0px 0px 60px;">
        <a href="#contentido-bienvenida" id="masinformacion" class="botonDysie"
          style="font-size: 25px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5);">
          Más Información
        </a>

        <a href="./registro/login.php" class="botonDysie"
          style="font-size: 25px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5);">
          Crear Cuenta
        </a>
      </div>
    </div>
    <div class="imagen-p">
      <img src="assets/img.svg" alt="" class="imagen-group">
    </div>
  </div>

  <!-- BIENVENIDA DYSIE -->

  <div class="contenedor-bienvenida">
    <div class="contentido-bienvenida">
      <h1 class="h1-c" style="font-size: 75px;">¡Bienvenido a Dysie!</h1>
      <p data-aos="fade-left" data-aos-duration="700" class="p-c">Con la To-Do List que empleamos en nuestros tableros,
        <br>
        estamos seguros de que te será más facil organizar tu día a día! <br>
        Marca tareas cumplidas y enfócate en lo que falta por hacer... <br>
        ¿Qué esperas? ¡Nunca fue tan fácil!
      </p>
    </div>
    <img data-aos="fade-up" data-aos-duration="700" class="img-Bienvenida" src="assets/board-img.png" alt="Imagen">
  </div>

  <!-- CARTAS INFORMACION SOBRE NOSOTROS -->

  <div class="gradiente-bg1">
    <section class="contenedor">
      <h1 data-aos="fade-right" data-aos-duration="700" class="h1-b">Un poco sobre Nosotros...</h1>
    </section>

    <section class="contenedor">
      <p data-aos="fade-left" data-aos-duration="700" class="p-b">Conoce más sobre Dysie y nuestro equipo </p>
    </section>

    <section class="contenedor">
      <div data-aos="fade-up" data-aos-duration="700" class="columna">
        <img src="assets/somos.png" alt="Icono Quiénes Somos">
        <h2>Quiénes Somos</h2>
        <p>Somos un grupo de desarrolladores de software enfocados en crear una aplicación web para el sector académico
          utilizando la metodología Kanban para facilitar el trabajo individual y en equipo.</p>
      </div>

      <div data-aos="fade-up" data-aos-duration="700" class="columna">
        <img src="assets/mision.png" alt="Icono Misión">
        <h2>Nuestra Misión</h2>
        <p>Facilitar la colaboración y la organización, ayudando a individuos y equipos a gestionar sus proyectos y
          tareas
          de manera eficiente y efectiva.</p>
      </div>

      <div data-aos="fade-up" data-aos-duration="700" class="columna">
        <img src="assets/equipo.png" alt="Icono Equipo de Desarrollo">
        <h2>Equipo de Desarrollo</h2>
        <p>En su proceso de creación, se contó con un equipo conformado por Sebastián Pareja, Sebastián Morales,
        Isabela Rubio y Carlos Restrepo; todos formados en la misma institución, enfocando nuestro desarrollo en 
        torno a la experiencia y la aplicación del conocimiento..</p>
      </div>
    </section>
  </div>

  <!-- PLANES -->
  <Section id="Planes" class="Planes">
    <div id="Planes" class="contenedor-cartas">
      <h1 data-aos="fade-right" data-aos-duration="700" class="h1-c">Planes Dysie</h1>
    </div>

    <div class="contenedor-cartas">
      <p data-aos="fade-left" data-aos-duration="700" class="p-c">Disfruta de nuestros diferentes planes para trabajar
        con
        <br> más comodidad en tu grupo de trabajo
      </p>
    </div>

    <div class="contenedor-cartas">
      <div data-aos="fade-up" data-aos-duration="700" class="carta">
        <div class="contenido-carta">
          <div class="titulo-carta">FREE</div>
          <div class="precio-carta">$0</div>
          <div class="descripcion-carta">Descripción</div>
        </div>
        <a class="botonDysie">
          Comprar Ahora
        </a>
      </div>

      <div data-aos="fade-up" data-aos-duration="700" class="carta">
        <div class="contenido-carta">
          <div class="titulo-carta">Premium</div>
          <div class="precio-carta">$10.000 COP</div>
          <div class="descripcion-carta">Descripción</div>
        </div>
        <a class="botonDysie">
          Comprar Ahora
        </a>
      </div>
    </div>
  </Section>
  <!-- FORMULARIO DE SUGERENCIAS -->

  <div class="gradiente-bg2">
    <div class="contenedorprincipal-formulario">
      <h1 data-aos="fade-right" data-aos-duration="700" class="h1-b">¿Tienes alguna sugerencia?</h1>
    </div>
    <div class="contenedorprincipal-formulario">
      <p data-aos="fade-left" data-aos-duration="700" class="p-b">¡Contáctanos por medio de este formulario!</p>
    </div>

    <div class="contenedorprincipal-formulario"></div>
    <div data-aos="fade-up" data-aos-duration="700" class="contenedor-formulario">
      <form class="formulario">
        <div class="grupo-formulario">
          <label for="email">Nombre Completo</label>
          <input placeholder="Ingresa tu Nombre y Apellidos" type="text" id="nombre" name="nombre" required="">
        </div>
        <div class="grupo-formulario">
          <label for="email">Correo Electrónico</label>
          <input placeholder="Ingresa tu Correo Eléctronico" type="text" id="email" name="email" required="">
        </div>
        <div class="grupo-formulario">
          <label for="textarea">¿Qué nos sugieres?</label>
          <textarea placeholder="Como sugerencia, quisiera decirles que..." name="textarea" id="textarea" rows="10"
            cols="50" required=""></textarea>
        </div>
        <a class="botonDysie">
          Enviar
        </a>
      </form>
    </div>
  </div>

  <!-- FOOTER - PIE DE PÁGINA -->

  <footer>
    <div class="contenedor-footer">
      <div class="footer-contentido">
        <div class="nombre-p">
          <h2>Dysie - </h2>
        </div>
        <div class="redes-sociales">
          <a href="https://www.facebook.com/profile.php?id=61559924572406&_rdc=1&_rdr" target="_blank"><img src="assets/redes-sociales/fb-logo.png" alt="Facebook"></a>
          <a href="https://twitter.com/Dysie791" target="_blank"><img src="assets/redes-sociales/x-logo2.png" alt="Twitter"></a>
          <a href="https://www.instagram.com/dysie01/" target="_blank"><img src="assets/redes-sociales/ig-logo.png" alt="Instagram"></a>
        </div>
      </div>
      <div class="derechos-reservados">
        <p>Derechos Reservados - Dysie &copy; 2024</p>
      </div>
    </div>
  </footer>

  <!-- SCRIPT ANIMACIONES AOS ANIMATE -->

  <script src="aos-master/dist/aos.js"></script>
  <script>
    document.getElementById('Planes').addEventListener('click', function () {
      // Obtenemos la posición de la clase destino
      const destino = document.querySelector('.contenedor-cartas');
      const posicion = destino.offsetTop - 100; // Restamos 100 píxeles para que se detenga un poco más arriba

      // Hacemos scroll suave hasta la posición de la clase destino
      window.scrollTo({
        top: posicion,
        behavior: 'smooth'
      });
    });
    document.getElementById('Sobre Nosotros').addEventListener('click', function () {
      // Obtenemos la posición de la clase destino
      const destino = document.querySelector('.contenedor');
      const posicion = destino.offsetTop - 100; // Restamos 100 píxeles para que se detenga un poco más arriba

      // Hacemos scroll suave hasta la posición de la clase destino
      window.scrollTo({
        top: posicion,
        behavior: 'smooth'
      });
    });
    document.getElementById('inicio').addEventListener('click', function () {
      // Obtenemos la posición de la clase destino
      const destino = document.querySelector('.pagina_principal');
      const posicion = destino.offsetTop - 100; // Restamos 100 píxeles para que se detenga un poco más arriba

      // Hacemos scroll suave hasta la posición de la clase destino
      window.scrollTo({
        top: posicion,
        behavior: 'smooth'
      });
    });
    document.getElementById('masinformacion').addEventListener('click', function () {
      // Obtenemos la posición de la clase destino
      const destino = document.querySelector('.contentido-bienvenida');
      const posicion = destino.offsetTop - 100; // Restamos 100 píxeles para que se detenga un poco más arriba

      // Hacemos scroll suave hasta la posición de la clase destino
      window.scrollTo({
        top: posicion,
        behavior: 'smooth'
      });
    });
  </script>
   <script src="{{ asset('js/index.js') }}"></script>


  <script>
    AOS.init({
      easing: 'ease-in-out-sine'
    });
  </script>

</body>

</html>