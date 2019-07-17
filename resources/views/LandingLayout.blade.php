 <!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>Meetrabbi |  An online life and career mentoring platform - Find mentors and become one</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Online life and career mentoring platform. Find mentors and become one.">
    <meta name="author" content="MeetRabbi, Babajide Owosakin, Mayowa Egbewunmi, Toluwanimi Ajewole">

    {{--Open Graph Tags for facebook share--}}
    <meta property="fb:app_id"             content="1682670775322787" />
    <meta property="og:url"                content="http://www.meetrabbi.com" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="Hi friends, I'm on Meetrabbi" />
    <meta property="og:description"        content="Meetrabbi offers you the opportunity to grow my knowledge and improve my efficiency through experiential learning. Find mentors and become one." />
    <meta property="og:image"              content="{{url('assets/img/post_mr.jpg')}}" />


    <!-- Favicon -->
    <link rel="shortcut icon" href="{{url('favicon.png')}}">
    @include('partials.LandingStyle')
    @yield('styles')
</head>
<body>
<div class="wrapper">
    @include('partials.LandingHeader')

    @yield('content')

    @include('partials.footer')
</div><!--/wrapper-->

@include('partials.LandingScripts')

@yield('scripts')


{{--Google Analytics--}}
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-75190104-1', 'auto');
    ga('send', 'pageview');

</script>

{{--Crisps Messaging--}}
<script type="text/javascript">CRISP_WEBSITE_ID = "ec35efb7-00fd-4e4e-a074-c4e4e63eaa91";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.im/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>



</body>
</html>
