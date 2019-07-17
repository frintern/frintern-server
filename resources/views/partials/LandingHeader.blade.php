<nav class="home navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#meetrabbi-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">
                <img id="logo-home-header" src="{{url('assets/img/custom/home-meetrabbi-logo.png')}}" width="135px"/></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        {{--<div class="collapse navbar-collapse" id="meetrabbi-navbar">--}}
            {{--<ul class="nav navbar-nav navbar-right">--}}

                {{--@if(!Auth::user())--}}
                    {{--@endif--}}
                            {{--<!--Become a mentor-->--}}
                    {{--<li class="{{strpos(URL::current(), URL::to('mentor')) !== false ? 'active':''}}">--}}
                        {{--<a href="{{url('mentor/apply')}}" class="mentors-link btn">--}}
                            {{--<span class=""></span>--}}
                            {{--Become a Mentor--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<!-- End Become a mentor -->--}}
            {{--</ul>--}}
        {{--</div><!-- /.navbar-collapse -->--}}
    </div><!-- /.container-fluid -->
</nav>