<!DOCTYPE HTML>
<html>

<head>
  <title>{{$title}}</title>
  <link href="{{asset('css/bootstrap.css')}}" rel='stylesheet' type='text/css' />
  <link href="{{asset('css/style.css')}}" rel='stylesheet' type='text/css' />
  <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel='stylesheet' type='text/css' />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  @yield('meta')
  {{-- <script type="application/x-javascript">
    addEventListener("load", function() {
      setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script> --}}
  <link href='http://fonts.googleapis.com/css?family=Oswald:100,400,300,700' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,300italic,400italic,600italic' rel='stylesheet' type='text/css'>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <!--script-->
  <script type="text/javascript" src="{{asset('js/move-top.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/easing.js')}}"></script>
  <script src="https://use.fontawesome.com/81383da23c.js"></script>
  <!--/script-->
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $(".scroll").click(function(event) {
        event.preventDefault();
        $('html,body').animate({
          scrollTop: $(this.hash).offset().top
        }, 900);
      });
    });
  </script>
  <!---->
  <link href="{{asset('css/theme/color'.$color_theme.'.css')}}" rel='stylesheet' type='text/css' />
  @yield('css')
</head>

<body>
  <!---strat-banner---->
  <div class="banner">
    <div class="header">
      <div class="container">
        <div class="logo">
          <a href="{{route('home')}}"> <img src="{{asset('images/logo.png')}}" title="{{$title}}" /></a>
        </div>
        <!---start-top-nav---->
        <div class="top-menu">
          <span class="menu"> </span>
          <ul>
            <li><a href="{{route('home')}}">HOME</a></li>
            <li><a href="{{route('home')}}">ANNOUNCEMENT</a></li>
            {{-- <li><a href="contact.html">CONTACT</a></li>
            <li><a href="terms.html">TERMS</a></li> --}}
            <div class="clearfix"> </div>
          </ul>
        </div>
        <div class="clearfix"></div>
        <script>
          $("span.menu").click(function() {
            $(".top-menu ul").slideToggle("slow", function() {});
          });
        </script>
        <!---//End-top-nav---->
      </div>
    </div>

    @include('layouts.banner')

  </div>
  <!---//End-banner---->
  <div class="content">
    <div class="container">
      <div class="content-grids">
        <div class="col-md-8 content-main">
          @yield('content')
        </div>

        @include('layouts.sidebar')

        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  {{-- <!--fotter-->
  <div class="fotter">
    <div class="container">
      <div class="col-md-4 fotter-info">
        <h3>INTEGER VITAE LIBERO</h3>
        <p>Raesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. </p>
        <p>Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus. Phasellus ultrices nulla quis nibh. Quisque a lectus. </p>
      </div>
      <div class="col-md-4 fotter-list">
        <h3>VESTIBULUM COMMO</h3>
        <ul>
          <li><a href="#">Ut alliquam solicitudin</a></li>
          <li><a href="#">Neque id cursus faucibus</a></li>
          <li><a href="#">Raesent dapibus neque id cursus</a></li>
        </ul>
      </div>
      <div class="col-md-4 fotter-media">
        <h3>FOLLOW US ON....</h3>
        <div class="social-icons">
          <a href="#"><span class="fb"> </span></a>
          <a href="#"><span class="twt"> </span></a>
          <a href="#"><span class="in"> </span></a>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <!---fotter/--> --}}
  <div class="copywrite">
    <div class="container">
      <p>Copyrights &copy; 2015 Blogging All rights reserved | Template by <a href="http://w3layouts.com/">W3layouts</a></p>
    </div>
  </div>
  <!---->
  <script type="text/javascript">
    $(document).ready(function() {
      /*
      var defaults = {
      containerID: 'toTop', // fading element id
      containerHoverID: 'toTopHover', // fading element hover id
      scrollSpeed: 1200,
      easingType: 'linear'
      };
      */
      $().UItoTop({
        easingType: 'easeOutQuart'
      });
    });
  </script>
  <a href="#to-top" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>

  @yield('js')
</body>

</html>
