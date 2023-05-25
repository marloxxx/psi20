<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <img src="{{ asset('images/' . getSettings('site_logo')) }}" alt="City tours">
            </div>
            <div class="col-md-2 col-sm-3">
                <a href="#">About us</a>
            </div>
            <div class="col-md-2 col-sm-3">
                <a href="#">About us</a>
            </div>

            <div class="col-md-2 col-sm-3">
                <a href="#">About us</a>
            </div>
            <div class="col-md-2 col-sm-3">
                <div class="d-flex justify-content-end">
                    <ul class="d-flex list-unstyled">
                        <li class="me-3">
                            <a href="#">
                                <i class="icon-facebook"></i>
                            </a>
                        </li>
                        <li class="me-3">
                            <a href="#"><i class="icon-twitter"></i></a>
                        </li>
                        <li class="me-3">
                            <a href="#"><i class="icon-instagram"></i></a>
                        </li>
                        <li><a href="#"><i class="icon-youtube-play"></i></a></li>
                    </ul>
                </div>
            </div>
        </div><!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div id="social_footer">
                    <p>© {{ getSettings('site_name') }} {{ date('Y') }} - All rights reserved</p>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
</footer><!-- End footer -->
