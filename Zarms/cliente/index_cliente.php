<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: login.php');
    exit();
}
?>

<?php
$servername = "b9adcso2ssjiqbhrwytf-mysql.services.clever-cloud.com";
$username = "uzd4kdukd76ffseo";
$password = "lXa5hn5RkrINOzg9yDaN";
$dbname = "b9adcso2ssjiqbhrwytf";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zarms</title>
    <script
      src="https://kit.fontawesome.com/7b5fb2de65.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/promocion.css" />
    <link rel="stylesheet" href="css/prueba.css" />
    <link rel="stylesheet" href="css/styleindex_cliente.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  </head>

  <body>
  <header class="header">
  <div class="container">
    <div class="logo__container">
      <div class="logogg">
        <img src="img/logo.png" alt="Logo" class="logo-img">
      </div>
    </div>
    <form class="search-form" action="buscar.php" method="get">
  <div class="search-container">
    <input type="text" id="search-input" name="query" placeholder="Buscar Electrodomésticos y más..." class="search-input" required>
    <button type="button" class="clear-button" onclick="clearSearch()">✖</button>
    <button type="submit" class="search-button">🔍</button>
  </div>
</form>


    <nav class="nav">
      <ul>
      <li>
    <a href="carrito.php" class="profile-btn">
        <i class="fas fa-shopping-cart"></i>
    </a>
</li>

        <li><a href="perfil.php" class="profile-btn">  <i class="fas fa-user"></i></a></li>
        <a href="logout.php" id="cerrar-sesion" class="logout-btn">
    <i class="fas fa-sign-out-alt"></i> <!-- Ícono de cerrar sesión -->
</a>
      </ul>
    </nav>
  </div>
</header> 


<!-- Menú debajo del header -->
<div class="sub-menu">
  <div class="menu">
    <ul>
      <li class="dropdown-container">
        <!-- Botón Comprar con ícono -->
        <a href="#" id="comprar-btn" class="dropdown-button">
          <img src="img/menu.png" alt="Menú" class="menu-icon">
          Comprar
        </a>
        <!-- Contenido desplegable dentro del mismo li -->
        <div class="dropdown" id="categorias">
          <h2>Categorías</h2>
          <ul>
            <li>Cocina</li>
            <li>Carro</li>
            <li>Electrodomésticos</li>
          </ul>
        </div>
      </li>
      <li><a href="Historial.php" class="menu-button">Compras Recientes</a></li>
      <li><a href="#" class="menu-button">Horario de Atención</a></li>
      <li><a href="#" class="menu-button">Contáctanos</a></li>
    </ul>
  </div>
</div>

<!--seccion de productos  -->
<!-- SECTION -->
<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="img/camara.png" alt="">
							</div>
							<div class="shop-body">
								<h3>Laptop<br>Collection</h3>
								<a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="img/camara.png" alt="">
							</div>
							<div class="shop-body">
								<h3>Accessories<br>Collection</h3>
								<a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="img/camara.png"alt="">
							</div>
							<div class="shop-body">
								<h3>Cameras<br>Collection</h3>
								<a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>


<!--prueba -->
<div class="br-button-wrapper">
    <div class="content-block container font-blue" id="brxsaas:featureCategory-Ggymw">
        <h1 class="main-title">Categorías</h1> <!-- Título principal -->
        <div class="featured-categories_container">
            <!-- Categoría 1 -->
            <a href="Alimentos.php" class="sf-link featured-categories_container--category sf-button" aria-label="Alimentos">
                <div class="img-container">
                    <img src="img/alimentos.jpg" alt="Alimentos" loading="lazy">
                </div>
                <span class="category-name">Alimentos</span>
            </a>
            <!-- Categoría 2 -->
            <a href="hogar.php" class="sf-link featured-categories_container--category sf-button" aria-label="Hogar">
                <div class="img-container">
                    <img src="img/hogar.jpg" alt="Hogar" loading="lazy">
                </div>
                <span class="category-name">Hogar</span>
            </a>
            <!-- Categoría 3 -->
            <a href="Alcohol.php" class="sf-link featured-categories_container--category sf-button" aria-label="Licor, Cerveza y Vino">
                <div class="img-container">
                    <img src="img/vino.jpg" alt="Licor, Cerveza y Vino" loading="lazy">
                </div>
                <span class="category-name">Licor, Cerveza y Vino</span>
            </a>
            <!-- Categoría 4 -->
            <a href="belleza.php" class="sf-link featured-categories_container--category sf-button" aria-label="Salud y Belleza">
                <div class="img-container">
                    <img src="img/salud.jpg" alt="Salud y Belleza" loading="lazy">
                </div>
                <span class="category-name">Salud y Belleza</span>
            </a>
            <!-- Categoría 5 -->
            <a href="bebe.php" class="sf-link featured-categories_container--category sf-button" aria-label="Bebé">
                <div class="img-container">
                    <img src="img/bebe.jpg" alt="Bebé" loading="lazy">
                </div>
                <span class="category-name">Bebé</span>
            </a>
            <!-- Categoría 6 -->
            <a href="Mascotas.php" class="sf-link featured-categories_container--category sf-button" aria-label="Mascotas">
                <div class="img-container">
                    <img src="img/mascota.jpg" alt="Mascotas" loading="lazy">
                </div>
                <span class="category-name">Mascotas</span>
            </a>
            <!-- Categoría 7 -->
            <a href="Electronica.php" class="sf-link featured-categories_container--category sf-button" aria-label="Electrónicos">
                <div class="img-container">
                    <img src="img/electronico.jpg" alt="Electrónicos" loading="lazy">
                </div>
                <span class="category-name">Electrónicos</span>
            </a>
            <!-- Categoría 8 -->
            <a href="Ferreteria.php" class="sf-link featured-categories_container--category sf-button" aria-label="Ferretería y Mejoras al Hogar">
                <div class="img-container">
                    <img src="img/mejora.jpg" alt="Ferretería y Mejoras al Hogar" loading="lazy">
                </div>
                <span class="category-name">Ferretería y Mejoras al Hogar</span>
            </a>
            <!-- Categoría 9 -->
            <a href="Exteriores.php" class="sf-link featured-categories_container--category sf-button" aria-label="Exteriores">
                <div class="img-container">
                    <img src="img/exterior.jpg" alt="Exteriores" loading="lazy">
                </div>
                <span class="category-name">Exteriores</span>
            </a>
            <!-- Categoría 10 -->
            <a href="Electrodomesticos.php" class="sf-link featured-categories_container--category sf-button" aria-label="Electrodomésticos">
                <div class="img-container">
                    <img src="img/electrodomestico.jpg" alt="Electrodomésticos" loading="lazy">
                </div>
                <span class="category-name">Electrodomésticos</span>
            </a>
        </div>
    </div>
</div>


<!--ofertas -->
<!-- HOT DEAL SECTION -->
<div id="hot-deal" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hot-deal">
                    <!-- Contenedor del cronómetro y la imagen -->
                    <div class="hot-deal-content">
                        <!-- Cronómetro -->
                        <ul id="countdown" class="hot-deal-countdown">
                            <li>
                                <div>
                                    <h3 id="days">00</h3>
                                    <span>Days</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3 id="hours">00</h3>
                                    <span>Hours</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3 id="minutes">00</h3>
                                    <span>Mins</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3 id="seconds">00</h3>
                                    <span>Secs</span>
                                </div>
                            </li>
                        </ul>

                       
                    </div>

                    <!-- Texto y botón -->
                    <h2 class="text-uppercase">Hot Deal This Week</h2>
                    <p>New Collection Up to 50% OFF</p>
                    <a class="primary-btn cta-btn" href="#">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>



<!--footer -->
<!-- FOOTER -->
<footer id="footer">
			<!-- top footer -->
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">About Us</h3>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
								<ul class="footer-links">
									<li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
									<li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
									<li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Categories</h3>
								<ul class="footer-links">
									<li><a href="#">Hot deals</a></li>
									<li><a href="#">Laptops</a></li>
									<li><a href="#">Smartphones</a></li>
									<li><a href="#">Cameras</a></li>
									<li><a href="#">Accessories</a></li>
								</ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Information</h3>
								<ul class="footer-links">
									<li><a href="#">About Us</a></li>
									<li><a href="#">Contact Us</a></li>
									<li><a href="#">Privacy Policy</a></li>
									<li><a href="#">Orders and Returns</a></li>
									<li><a href="#">Terms & Conditions</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Service</h3>
								<ul class="footer-links">
									<li><a href="#">My Account</a></li>
									<li><a href="#">View Cart</a></li>
									<li><a href="#">Wishlist</a></li>
									<li><a href="#">Track My Order</a></li>
									<li><a href="#">Help</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							<ul class="footer-payments">
								<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
							</ul>
							<span class="copyright">
								<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with Daialan Reyes</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

<script src="script.js"></script>

<script>
  function clearSearch() {
    // Almacena un estado en el localStorage para indicar que el campo debe ser limpiado
    localStorage.setItem('clearSearch', 'true');
    // Redirige a la página anterior en el historial del navegador
    window.history.back();
  }

  // Función para limpiar el campo de búsqueda cuando la página se carga
  function initializeSearch() {
    if (localStorage.getItem('clearSearch') === 'true') {
      // Limpia el campo de búsqueda
      document.getElementById('search-input').value = '';
      // Borra el estado del localStorage
      localStorage.removeItem('clearSearch');
    }
  }

  // Llama a initializeSearch cuando la página se carga
  window.onload = initializeSearch;
</script>




</html>