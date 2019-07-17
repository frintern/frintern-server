@extends('LandingLayout')

@section('title')
    An online life and career mentoring platform
@stop

@section('content')
    <div class="inner-wrapper">
        <div class="effect-over"></div>
        <div class="container">
            <div class="col-md-12 center-div landing-message">
                <h1>Find mentors and become one</h1>
                <p>At Meetrabbi, we are committed to making your dream come alive and help you stand
                    on the shoulder of giants.
                </p>
                <br/>

                {{--pre registration form--}}
                <div class="panel" style="zoom:1.5">
                    <form class="form-horizontal" method="post" action="{{url('notify/me')}}">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="form-group col-md-6{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" name="email" class="form-control" placeholder="Please enter your email address" aria-describedby="basic-addon2" style="border-radius: 6px; border: 1px solid #dde5ed; background: #fafbfc; font-size: 12px" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        @if(isset($code))
                            <input type="text" name="code" value="{{$code}}" hidden>
                        @endif

                        <div class="form-group">
                            <button href="{{url('notify/me')}}" class="btn btn-primary btn-main-signup">Notify me</button>
                        </div>
                    </form>
                </div>
                <br/>
            </div>

        </div><!--/container-->
    </div>
    <!--=== Call To Action ===-->
    <!--=== End Call To Action ===-->
    <div class="bg-white" id="featured-courses">
        <div class="container content-sm">
            <div class="headline-center margin-bottom-60">
                <h2>Why join Meetrabbi?</h2>
                <p>Share <strong> Knowledge </strong>
                    and <strong>Experience</strong></p>
            </div>
            <!-- Rounded Large Boxes -->
            <div class="row content-boxes-v1 margin-bottom-40">
                <div class="col-sm-4 md-margin-bottom-40">
                    <h2 class="heading-md">
                        <i class="icon-custom rounded-x icon-md icon-bg-aqua icon-line icon-directions"></i>
                        <span>You as a Mentee and a Mentor</span>
                    </h2>
                    <p>Everyone can be both. We all have something to learn as well as something to share</p>
                </div>
                <div class="col-sm-4 md-margin-bottom-40">
                    <h2 class="heading-md">
                        <i class="icon-custom rounded-x icon-md icon-bg-aqua fa fa-users"></i>
                        <span>Join a Community</span>
                    </h2>
                    <p>Join a community of ambitious professionals spanning a wide range of industries & backgrounds, and yet, all with similar mindset, curious to learn, connect & grow</p>
                </div>
                <div class="col-sm-4 md-margin-bottom-40">
                    <h2 class="heading-md">
                        <i class="icon-custom rounded-x icon-md icon-bg-aqua icon-line icon-magic-wand"></i>
                        <span>Match Smartly</span>
                    </h2>
                    <p>Thanks to an intuitive algorithm and based on your experience and goals, Meetrabbi will match you with the most relevant mentors and mentees</p>
                </div>
            </div>
            <!-- Rounded Large Boxes -->

            <!-- Cirlce Large Boxes -->
            <div class="row content-boxes-v1 margin-bottom-40">
                <div class="col-sm-4 md-margin-bottom-40">
                    <h2 class="heading-md">
                        <i class="icon-custom rounded-x icon-md icon-color-aqua fa fa-connectdevelop"></i>
                        <span>Help Others Achieve Their Dreams</span>
                    </h2>
                    <p>Our greatest joys in life are rarely found in the relentless pursuit of selfish ambition. Besides that teaching others is enormously satisfying, by investing in others, you’re also investing in yourself</p>
                </div>
                <div class="col-sm-4 md-margin-bottom-40">
                    <h2 class="heading-md">
                        <i class="icon-custom rounded-x icon-md icon-color-aqua fa fa-graduation-cap"></i>
                        <span>A Pool of Talent</span>
                    </h2>
                    <p>Mentors get a highly efficient platform to connect with talented entrepreneurs & professionals, learn from them in the meantime and make meaningful connections</p>
                </div>
                <div class="col-sm-4 md-margin-bottom-40">
                    <h2 class="heading-md">
                        <i class="icon-custom rounded-x icon-md icon-color-aqua fa fa-rocket"></i>
                        <span>Soar High</span>
                    </h2>
                    <p>Entrepreneurs & professionals get access to global resources to scale up their business & enhance their skills</p>
                </div>
            </div>
        </div>
    </div>
    <!--=== Parallax Quote ===-->
    <div class="parallax-quote parallaxBg" style="background-position: 50% 22px;">
        <div class="container">
            <div class="parallax-quote-in">
                <p>We're persistently working to personalize your growth experience.</p>
                <small>- MEETRABBI -</small>
            </div>
        </div>
    </div>
    <!--=== End Parallax Quote ===-->

    <!--=== End Team v4 ===-->
@stop

