<nav class="navbar navbar-expand-lg letra_menu navbar-light bg-light">

    <button 
        class="navbar-toggler" 
        type="button" 
        data-toggle="collapse" 
        data-target="#navbarNavDropdown" 
        aria-controls="navbarNavDropdown" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" href="<?php echo urlRoot; ?>/pages/index">
                    Inicio
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo urlRoot; ?>/pages/about">
                    Acerca de..
                </a>
            </li>
            <li class="nav-item">
               		<a href="<?php echo urlRoot; ?>/categories/index" class="px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:text-indigo-600 hover:bg-slate-100 transition-colors">Categorías</a>
            </li>
            <li class="nav-item">
                <?php
                if (isLoggedIn()) {
                    echo '<a class="nav-link" href="' . urlRoot . '/users/logout">Salir</a>';
                } else {
                    echo '<a class="nav-link" href="' . urlRoot . '/users/login">Ingresar</a>';
                }
                ?>
            </li>

        </ul>
    </div>

</nav>
