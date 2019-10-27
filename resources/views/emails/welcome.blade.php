
<!--
 * Template Name: Unify - Responsive Bootstrap Template
 * Description: Business, Corporate, Portfolio and Blog Theme.
 * Version: 1.6
 * Author: @htmlstream
        * Website: http://htmlstream.com
        -->
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
https://skillguides.byfrintern.com<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Welcome to Frintern</title>

    <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <style type="text/css">
        .ReadMsgBody {width: 100%; background-color: #ffffff;}
        .ExternalClass {width: 100%; background-color: #ffffff;}
        body     {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Arial, Helvetica, sans-serif}
        table {border-collapse: collapse;}

        @media only screen and (max-width: 640px)  {
            body[yahoo] .deviceWidth {width:440px!important; padding:0;}
            body[yahoo] .center {text-align: center!important;}
        }

        @media only screen and (max-width: 479px) {
            body[yahoo] .deviceWidth {width:280px!important; padding:0;}
            body[yahoo] .center {text-align: center!important;}
        }
    </style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="font-family: Lato, Helvetica, sans-serif">

<!-- Wrapper -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td width="100%" valign="top" bgcolor="#ffffff" style="padding-top:20px">

            <!--Start Header-->
            <table width="700" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                <tr>
                    <td style="padding: 6px 0px 0px">
                        <table width="680" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                            <tr>
                                <td width="100%" >
                                    <!--Start logo-->
                                    <table  border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                                        <tr>
                                            <td class="center" style="padding: 10px 0px 10px 0px">
                                                <a href="https://frintern.com"><img src="{{url('assets/img/Frintern_Full_Logo_Revisited.png')}}" style="width: 150px"></a>
                                            </td>
                                        </tr>
                                    </table><!--End logo-->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--End Header-->

            <!-- Start Headliner-->
            <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                <tr>
                    <td valign="top" style="padding: 20px " class="center" width="100%" bgcolor="#ffffff">
                        <p style="font-size: 20px"> Hi {{$user->name}},</p>
                        We are happy to have you at <span style="color: #14a5e0">Frintern</span>! 
                        <p>
                        <p>
                            Here is your activation code: <h2>{{$verificationCode}}</h2>
                            <a href="https://techcareers.byfrintern.com/dashboard">Click here</a> to activate your account and start tracking your learning.</p>
                        </p>
                        <p>
                            Thank you for signing up for Frintern's learning program, we appreciate you.

                            To get a full understanding of how Frintern works, check out our <a href="https://frintern.com">explainer page</a>.
                        
                        </p>
                        <h3>
                            How you learn with Frintern
                        </h3>
                        <p>
                            <ul>
                                <li>
                                    You can self learn by going through the learning guides <a href="https://techcareers.byfrintern.com">here</a>. Just select the skill you want to learn and follow the prompts. It will guide you through it. <br/>
                                </li>
                                <li>
                                    To join the Community/Learning Lab where you will be guided through the learning experience click <a href="https://goo.gl/forms/OjZvr0A0VuCF3ESu1">here</a> to sign up and get access for our next class which starts in January after the break.
                                </li>
                            </ul>
                        </p>
                        <h3>How we help you get a job</h3>
                        <p>
                            On completion of any of the above, we do not offer certificates because most employers no longer ask for certificates.
                        </p>
                        <p>
                            Instead employers ask for proof of work done or a portfolio and give you an assignment to complete. We help you get this portfolio which you can use to apply for the job you want. You get this portfolio by:
                            <ul>
                                <li>
                                    Doing all the tasks in the guides and saving the documents and files you create, or <br/>
                                </li>
                                <li>
                                    By signing up for our Learning Labs where we guide you through the process of creating your portfolio and help you package it properly.
                                </li>
                            </ul>
                        </p>
                        <p>
                            We also have partner companies who trust us to help them grow. We will be your plug to these companies.
                        </p>
                        <p>Enjoy the journey</p>
                        <p>Team Frintern</p>
                    </td>
                </tr>
                
            </table>
            <!-- Start Headliner-->

            <div style="height:15px">&nbsp;</div><!-- divider -->

            <!--Start Weekly Prize-->
            <table width="700" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
                <tr>
                    <td width="100%" bgcolor="#14a5e0" class="center">
                        <table  border="0" cellpadding="0" cellspacing="0" align="center">
                            <tr>
                                <td valign="top" style="padding: 20px 10px " class="center">
                                    <a href="https://facebook.com/meetfrintern"><img width="32" height="32" src="{{url('assets/img/icons/icon_facebook.png')}}"></a>
                                </td>
                                <td valign="top" style="padding: 20px 10px " class="center">
                                    <a href="https://instagram.com/meetfrintern"><img width="32" height="32" src="{{url('assets/img/icons/icon_instagram.png')}}"></a>
                                </td>
                                <td valign="top" style="padding: 20px 10px " class="center">
                                    <a href="https://twitter.com.com/meetfrintern"><img width="32" height="32" src="{{url('assets/img/icons/icon_twitter.png')}}"></a>
                                </td>

                            </tr>
                        </table>
                        <table  border="0" cellpadding="0" cellspacing="0" align="center">
                            <tr>
                                <td  class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: center; font-family: Lato, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 20px 10px; " >
                                    Please do not reply directly to this mail, if you have any questions or feedback,
                                    please send an email to <span style="font-size: 12px; color: #ffffff;">hello@frintern.com</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--Weekly Prize-->

            <!-- Footer -->
            <table width="700"  border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth"  >
                <tr>
                    <td  bgcolor="#ffffff" class="center" style="font-size: 12px; color: #687074; font-weight: bold; text-align: center; font-family: Arial, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 20px 50px 0px 50px; " >
                        By Frintern with Love
                    </td>

                </tr>
            </table>
            <!--End Footer-->

        </td>
    </tr>
</table>
<!-- End Wrapper -->
</body>
</html>