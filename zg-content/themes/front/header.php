<nav class="navbar navbar-expand-lg bg-white py-3 fixed-top">
    <div class="container">
        <a class="navbar-brand logo" href="./"><img src="<?= BASE_URL . '/' . DIR_INC; ?>/images/logo.png" alt="#"
                class="me-3" width="45">Uchu Cappoe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <?php
            echo $this->menu()->getFrontMenu(WEB_LANG, 'class="navbar-nav ms-auto"', 'class="dropdown"', 'class="dropdown-menu"');
            ?>
            <div class="navbar-nav ms-auto">
                <!-- <a class="nav-link btn btn-light mb-3 mb-lg-0 me-lg-3 " href="https://democaleg35.nyaleg.id/pendukung/pemberitahuan"><i class="far fa-bullhorn"></i></a> -->
                <a class="nav-link btn btn-danger" href="app/pendukung/login">Area Pendukung<i
                        class="far fa-user ms-2"></i></a>
            </div>
        </div>
    </div>
</nav>