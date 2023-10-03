<?=$this->layout('index');?>

    <div class="breadcrumb-area shadow dark text-center bg-fixed text-light" style="background-image: linear-gradient(to bottom left, blue, yellow);">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Error Page</h1>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#">Page</a></li>
                        <li class="active">404</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Start 404 
    ============================================= -->
    <div class="error-page-area default-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center content">
                    <h1>404</h1>
                    <h2>Sorry Page Was Not Found!</h2>
                    <p>
                        The page you are looking is not available or has been removed. Try going to Home Page by using the button below.
                    </p>
                    <a class="btn btn-dark effect btn-md" href="<?=BASE_URL;?>">Back To Home</a>
                    <a class="btn btn-dark border btn-md" href="<?=BASE_URL;?>/contact/">Contact Us</a>
                    <ul>
                        <li class="facebook">
                            <a href="https://www.facebook.com/UniversitasFajar"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="twitter">
                            <a href="https://twitter.com/UnivFajar?s=20"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li class="youtube">
                            <a href="https://youtube.com/channel/UCjA6LT_z8K9VafY4hCL7LRA"><i class="fab fa-youtube"></i></a>
                        </li>
                        <li class="instagram">
                            <a href="https://instagram.com/univfajar?utm_medium=copy_link"><i class="fab fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End 404 -->

