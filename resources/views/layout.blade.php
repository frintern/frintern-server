
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>Meetrabbi | @yield('title')</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{url('favicon.png')}}">

    <!-- Web Fonts -->
    <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin'>

    @include('partials.styles')

    @yield('styles')
</head>

<body class="header-fixed header-fixed-space">

    <div class="wrapper">
        <!--=== Header v6 ===-->
        @include('partials.header')
        <!--=== End Header v6 ===-->

        @yield('content')

        @include('partials.footer')
        <!--=== Footer v6 ===-->
        <!--=== End Footer v6 ===-->
    </div><!--/wrapper-->

@include('partials.scripts')

@yield('scripts')

    {{-- Google Analytics--}}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-75190104-1', 'auto');
        ga('send', 'pageview');

    </script>

</body>
</html>