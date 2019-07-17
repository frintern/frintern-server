<div class="header-v6 header-classic-white header-sticky">
    <!-- Navbar -->
    <div class=" mr-card navbar mega-menu" role="navigation">
        <div class="container container-space">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="menu-container">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Navbar Brand -->
                <div class="navbar-brand">
                    <a href="{{url('/')}}">
                        <img src="{{url('assets/img/custom/meetrabbi-logo.png')}}" height="30px" alt="Meetrabbi">
                    </a>
                </div>
                <!-- ENd Navbar Brand -->
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-responsive-collapse">
                <div class="menu-container">
                    <ul class="nav navbar-nav">

                        <!-- Misc Pages -->
                        <li class="{{strpos(URL::current(), URL::to('about')) !== false ? 'active':''}}">
                            <a href="{{url('about')}}">
                                About
                            </a>
                        </li>

                    </ul>
                </div>
            </div><!--/navbar-collapse-->
        </div>
    </div>
    <!-- End Navbar -->
</div>
