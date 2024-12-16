<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php?vista=home_public">
            <img src="./assets/img/logo.jpg" width="50" height="50">
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="index.php?vista=home_public" >Home</a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Venta</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=">Casas</a>
                    <a class="navbar-item" href="index.php?vista=">Departamentos</a>
                    <a class="navbar-item" href="index.php?vista=">Duplex</a>
                    <a class="navbar-item" href="index.php?vista=catalogo">Todos</a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Alquiler</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=">Casas</a>
                    <a class="navbar-item" href="index.php?vista=">Departamentos</a>
                    <a class="navbar-item" href="index.php?vista=">Duplex</a>
                    <a class="navbar-item" href="index.php?vista=catalogo">Todos</a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Alquiler temporal</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=">Casas</a>
                    <a class="navbar-item" href="index.php?vista=">Departamentos</a>
                    <a class="navbar-item" href="index.php?vista=">Cabañas</a>
                    <a class="navbar-item" href="index.php?vista=catalogo">Todos</a>
                </div>
            </div>
            <a class="navbar-item" href="index.php?vista=about_us" >Sobre nosotros</a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Contacto</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=inmobiliarias">Inmobiliarias</a>
                    <a class="navbar-item" href="index.php?vista=contacto">Mensaje</a>
                    <hr class="navbar-divider">
                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="index.php?vista=logout" class="button is-danger is-rounded">
                      Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>