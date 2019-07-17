@extends('layout')

@section('title')
    About MeetRabbi
@stop
@section('content')
    <div class="breadcrumbs-v3 img-v1 text-center">
        <div class="effect-over"></div>
        <div class="container">
            <h1>Our mission is to provide experiential learning by connecting you with the right mentors</h1>
        </div>
    </div>

    <!--=== End Interactive Slider ===-->
    <div class="wrap-bground row">
        <div class="col-md-2">
            <div class="text-contain">
                <h2><a href="#inspiration">The Inspiration</a></h2>
                <h2><a href="#our-job">What we do</a></h2>
                {{--<h2><a href="#the-team">Meet the team</a></h2>--}}
            </div>
        </div>
        <div class="col-md-10">
            <div class="the-content">
                <article id="inspiration">
                    <h1>The Inspiration</h1>
                    <p>Every phase of life and career leaves us with so many choices to make.
                        How easier would it have been if we had mentors to guide us through these phases?
                    </p>

                    <p>Meet 'Meetrabbi': your life and career hoist.</p >
                    <p>The swiftness in achieving your dreams is our major inspiration. </p>
                </article>

                <article id="our-job">
                <h1>What we do</h1>
                    <p>Meetrabbi creates the platform for you to connect with mentors in your areas of
                        interest. We provide tools to help you learn directly from your mentors through
                        one-on-one communication with your mentors as well as having articles from them at your disposal.
                    </p>
                    <p>Leave the job of finding the right mentors for you to us, while you enjoy learning and
                        stay inspired, day in and day out.
                    </p>
                </article>
                {{--<h1>The team</h1>--}}
                {{--<article id="the-team">--}}
                    {{--<p>In this first phase of your professional journey,--}}
                        {{--when there are so many directions to choose from,--}}
                        {{--there is little access to the learning and connections you need to be successful.--}}
                    {{--</p>--}}

                    {{--<p>Enter Levo: your career copilot.</p>--}}

                    {{--<p>Levo arms you with the tools to develop your talent, build connections with peers,--}}
                        {{--mentors, and jobs, and stay inspired day in and day out as you grow and develop.--}}
                        {{--We believe you can create a life you’re passionate about.--}}
                    {{--</p>--}}

                    {{--<p>It’s no coincidence that our name is the Latin root of the word “elevate.”--}}
                        {{--With technology, we can move forward together.--}}
                        {{--You are no longer alone in this marathon we call career. Welcome to the league.--}}
                    {{--</p>--}}
                {{--</article>--}}
            </div>

        </div>
    </div>

@stop