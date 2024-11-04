<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
            <img src="./assets/img/logo.png" width="112" height="28">
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
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Usuarios</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=user_new">Nuevo</a>
                    <a class="navbar-item" href="index.php?vista=user_list">Lista</a>
                    <a class="navbar-item" href="index.php?vista=user_search">Buscar</a>
                </div>
            </div>
            <a class="navbar-item" >
                Home
            </a>
            <a class="navbar-item">
                Inmobiliarias
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Operaciones</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=operation_new">Nueva</a>
                    <a class="navbar-item" href="index.php?vista=operation_list">Lista</a>
                    <a class="navbar-item" href="index.php?vista=operation_search">Buscar</a>
                    <hr class="navbar-divider">
                </div>
            </div>
             <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Tipos</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?vista=type_new">Nueva</a>
                    <a class="navbar-item" href="index.php?vista=type_list">Lista</a>
                    <a class="navbar-item" href="index.php?vista=type_search">Buscar</a>
                    <hr class="navbar-divider">
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Propiedades
                </a>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-primary is-rounded">
                      <strong>Entrar a mi cuenta</strong>
                    </a>
                    <a href="index.php?vista=logout" class="button is-light is-rounded">
                      Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
