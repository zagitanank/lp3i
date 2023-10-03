<!-- Header 
    ============================================= -->
    <header id="home">

        <!-- Start Navigation -->
        <nav class="navbar navbar-default navbar-fixed navbar-transparent white pad-top bootsnav">

            <div class="container">

                 <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="<?=BASE_URL;?>">
                        <img src="<?=BASE_URL.'/'.DIR_INC;?>/images/logo.png" class="logo logo-display" alt="Logo">
                        <img src="<?=BASE_URL.'/'.DIR_INC;?>/images/logo.png" class="logo logo-scrolled" alt="Logo">
                    </a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    
                    <?php
						echo $this->menu()->getFrontMenu(WEB_LANG, 'class="nav navbar-nav navbar-right" data-in="#" data-out="#"', 'class="dropdown"', 'class="dropdown-menu"');
					?>
                        
                   
                </div><!-- /.navbar-collapse -->
            </div>

            

        </nav>
        <!-- End Navigation -->

    </header>
    <!-- End Header -->















