<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item<?= url_is('news*') ? ' active' : '' ?>">
                    <a class="nav-link" href="<?= route_to('news_index') ?>">News</a>
                </li>
                <li class="nav-item<?= url_is('users*') ? ' active' : '' ?>">
                    <a class="nav-link" href="<?= route_to('users_index') ?>">User</a>
                </li>
                <li class="nav-item<?= url_is('roles*') ? ' active' : '' ?>">
                    <a class="nav-link" href="<?= route_to('roles_index') ?>">Role Permission</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <?php if(!logged_in()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('login') ?>">Login</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <?= user()->username ?>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= route_to('logout') ?>">Logout</a>
                    </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>