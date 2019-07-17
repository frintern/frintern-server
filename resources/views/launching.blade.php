<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>Launching Soon | Meetrabbi - An online life and career mentoring platform</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{url('favicon.png')}}">

    <!-- Web Fonts -->
    <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin'>

    <!-- CSS Global Compulsory-->
    <link rel="stylesheet" href="{{url('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{url('assets/plugins/animate.css')}}">
    <link rel="stylesheet" href="{{url('assets/plugins/line-icons/line-icons.css')}}">
    <link rel="stylesheet" href="{{url('assets/plugins/font-awesome/css/font-awesome.css')}}">

    <style type="text/css">

        .mr-color-btn {
            color: #fff;
            background: #14A5E0;
            border-color: #14A5E0;
        }

        .mr-color-btn:hover {
            color: #fff;
            background: #14A5E0;
            border-color: #14A5E0;
        }

        .color-meetrabbi {
            color: #00b3ee;
        }


    </style>

    <link rel="stylesheet" href="{{url('assets/css/theme-colors/meetrabbi.css')}}">

    <!-- CSS Page Style -->
    <link rel="stylesheet" href="{{url('assets/css/pages/page_coming_soon_v1.css')}}">

</head>

<body class="coming-soon-page">
<div class="coming-soon-border"></div>

<div class="coming-soon-bg-cover"></div>

<!--=== Content Part ===-->
<div class="container cooming-soon-content">
    <!-- Coming Soon Content -->
    <div class="row">
        <div class="col-md-12 coming-soon">
            <h1>Hi, we're <span class="color-aqua">Meetrabbi</span></h1>
            <h3 class="test-info"> </h3><br>
            <h2 class="test-info">Get mentored and mentor someone</h2><br>
            <h3 class="test-info1">Mentees / Mentors / Mentoring / Life & Career</h3>

            {{--Notify Me--}}
            <form class="form-inline" action="{{url('notify/me')}}">

                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <input type="email" class="form-control col-md-10" placeholder="Email Address">
                          <span class="input-group-btn">
                            <button class="btn btn-default color-aqua" type="button">Notify me</button>
                          </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-1"></div>

                </div>


            </form>
        </div>
    </div>
</div><!--/container-->
<!--=== End Content Part ===-->

<!--=== Sticky Footer ===-->
<div class="sticky-footer">
    <div class="container ">
        <div class="row">
            <div class="col-sm-6 text-left">
                <p class="color-light">
                    2016 &copy; <span class="color-meetrabbi">Meetrabbi</span>
                </p>
            </div>
            <div class="col-sm-6 text-right">
                <ul class="list-inline coming-soon-social">
                    <li><a href="http://twitter.com/meetrabbi" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="http://faacebook.com/meetrabbi" target="_blank"><i class="fa fa-dribbble"></i></a></li>
                    <li><a href="http://instagram.com/meetrabbi" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="http://faacebook.com/meetrabbi" target="_blank"><i class="fa fa-facebook"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--=== End Sticky-Footer ===-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="{{url('assets/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/jquery/jquery-migrate.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="{{url('assets/plugins/back-to-top.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/smoothScroll.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/countdown/jquery.plugin.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/countdown/jquery.countdown.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/backstretch/jquery.backstretch.min.js')}}"></script>
<!-- JS Customization -->
<script type="text/javascript" src="{{'assets/js/custom.js'}}"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="{{url('assets/js/app.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/pages/page_coming_soon.js')}}"></script>


<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
        PageComingSoon.initPageComingSoon();
    });
</script>

<!-- Background Slider (Backstretch) -->
<script>
    $.backstretch([
        "assets/img/bg/7.jpg",
        "assets/img/bg/1.jpg",
        "assets/img/bg/16.jpg",
        "assets/img/bg/25.jpg",
    ], {
        fade: 1000,
        duration: 7000
    });
</script>



<!--[if lt IE 9]>
<script src="{{url('assets/plugins/respond.js')}}"></script>
<script src="{{url('assets/plugins/html5shiv.js')}}"></script>
<script src="{{url('assets/plugins/placeholder-IE-fixes.js')}}"></script>
<![endif]-->

</body>
</html>