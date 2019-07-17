
<!--
 * Template Name: Unify - Responsive Bootstrap Template
 * Description: Business, Corporate, Portfolio and Blog Theme.
 * Version: 1.6
 * Author: @htmlstream
        * Website: http://htmlstream.com
        -->
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Welcome to Meetrabbi</title>

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
                                                <a href="#"><img src="{{url('assets/img/meetrabbi.png')}}" style="width: 180px"></a>
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
                    <td valign="top" style="padding: 20px " class="center" width="100%" bgcolor="#f7f7f7">
                        <p style="font-size: 20px"> Hi {{ $questionAuthor->first_name }},</p>
                        <p>{{ $author->first_name . " " . $author->last_name }} posted a reply:</p>
                        <p style="font-size: 12px">
                            {{ $reply->body }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td valign="top" bgcolor="#14A5E0" style="padding: 20px " class="center" align="center">
                        <a href="{{url('/questions/'.$question->id)}}" style="color: #ffffff">View Reply</a>
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
                                    <a href="http://facebook.com/meetrabbi"><img width="32" height="32" src="{{url('assets/img/icons/icon_facebook.png')}}"></a>
                                </td>
                                <td valign="top" style="padding: 20px 10px " class="center">
                                    <a href="http://instagram.com/meetrabbi"><img width="32" height="32" src="{{url('assets/img/icons/icon_instagram.png')}}"></a>
                                </td>
                                <td valign="top" style="padding: 20px 10px " class="center">
                                    <a href="http://twitter.com.com/meetrabbi"><img width="32" height="32" src="{{url('assets/img/icons/icon_twitter.png')}}"></a>
                                </td>

                            </tr>
                        </table>
                        <table  border="0" cellpadding="0" cellspacing="0" align="center">
                            <tr>
                                <td  class="center" style="font-size: 16px; color: #ffffff; font-weight: bold; text-align: center; font-family: Lato, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 0px 10px; ">
                                    Made with love
                                </td>
                            </tr>
                            <tr>
                                <td  class="center" style="font-size: 12px; color: #ffffff; font-weight: bold; text-align: center; font-family: Lato, Helvetica, sans-serif; line-height: 25px; vertical-align: middle; padding: 20px 10px; " >
                                    Please do not reply directly to this mail, if you have any questions or feedback,
                                    please send an email to hello@meetrabbi.com
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
                        Copyright © MeetRabbi 2016
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