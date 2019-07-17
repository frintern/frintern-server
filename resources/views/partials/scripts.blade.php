<!-- JS Global Compulsory -->
<script type="text/javascript" src="{{url('assets/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/jquery/jquery-migrate.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="{{url('assets/plugins/back-to-top.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/smoothScroll.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/jquery.parallax.js')}}"></script>
<script src="{{url('assets/plugins/master-slider/masterslider/masterslider.min.js')}}"></script>
<script src="{{url('assets/plugins/master-slider/masterslider/jquery.easing.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/counter/waypoints.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/counter/jquery.counterup.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/fancybox/source/jquery.fancybox.pack.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/owl-carousel/owl-carousel/owl.carousel.js')}}"></script>
<!-- JS Customization -->
<script type="text/javascript" src="{{url('assets/js/custom.js')}}"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="{{url('assets/js/app.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/plugins/fancy-box.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/plugins/owl-carousel.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/plugins/master-slider-fw.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/plugins/datepicker.js')}}"></script>

<script type="text/javascript" src="{{url('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<script type="text/javascript" src="{{url('assets/plugins/masonry/jquery.masonry.min.js')}}"></script>
<!-- JS Customization -->
<script type="text/javascript" src="{{url('assets/js/custom.js')}}"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="{{url('assets/js/pages/blog-masonry.js')}}"></script>

<script type="text/javascript" src="{{url('assets/js/plugins/owl-recent-works.js')}}"></script>

<!--[if lt IE 9]>
<script src="{{url('assets/plugins/respond.js')}}"></script>
<script src="{{url('assets/plugins/html5shiv.js')}}"></script>
<script src="{{url('assets/plugins/placeholder-IE-fixes.js')}}"></script>
<![endif]-->

<script src="{{url('bower_components/aws-sdk/dist/aws-sdk.min.js')}}"></script>


{{--Angular JS--}}
<script src="{{url('bower_components/angular/angular.min.js')}}"></script>
<script src="{{url('bower_components/angular-loader/angular-loader.min.js')}}"></script>
<script src="{{url('bower_components/angular-resource/angular-resource.min.js')}}"></script>
<script src="{{url('bower_components/angular-toastr/dist/angular-toastr.tpls.min.js')}}"></script>
<script src="{{url('bower_components/angular-ui-router/release/angular-ui-router.min.js')}}"></script>
<script src="{{url('bower_components/angular-sanitize/angular-sanitize.min.js')}}"></script>
<script src="{{url('bower_components/ui-select/dist/select.min.js')}}"></script>
<script src="{{url('bower_components/checklist-model/checklist-model.js')}}"></script>
<script src="{{url('bower_components/checklist-model/checklist-model.js')}}"></script>
<script src="{{url('bower_components/angular-truncate/src/truncate.js')}}"></script>
<script src="{{url('bower_components/ng-tags-input/ng-tags-input.min.js')}}"></script>
<script>
    $(function() {
        var loc = window.location.pathname;
        if (/(login)|(register)/.test(loc)) {
            $('.footer').css('display', 'none');
        }
    })
</script>


