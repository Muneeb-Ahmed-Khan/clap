<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>{{config('app.name')}} - Cross Linguistic Awareness Programm</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="robots" content="index,follow"/>
    <meta http-equiv="content-language" content="en"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Free Videos Uploading and Sharing Service"/>
    <meta name="keywords" content="videos upload, videos sharing, mp4 upload, video cloud storage, free upload videos, PPU sites"/>
    <meta property="og:url" content="/index"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{config('app.name','CLAP - Cross Linguistic Awareness Programm')}} - Cross Linguistic Awareness Programm"/>
    <meta property="og:description" content="{{config('app.name','CLAP - Cross Linguistic Awareness Programm')}} - Cross Linguistic Awareness Programm"/>
    <meta property="og:image" content="{{asset('images/capture.jpg')}}"/>
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/main-homef195.css?v=2.1')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/media-homeffaf.css?v=1.4')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/icons-home8510.css?v=0.2')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/customeef3.css?v=0.3')}}"/>

    <link href="{{asset('css/toastr.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}"/>
    <script type="text/javascript" src="{{asset('js/jquery-1.9.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/mainc619.js?v=1.0')}}"></script>


</head>
<body class="">
    <header @if (Request::is('/','index'))style="background: linear-gradient(#0B61E8, #00C5FA);"@endif>
    <div class="container">
        <div id="header">
            <a href="/" id="logo"><img src="{{asset('images/logo.png')}}" alt="CLAP" title="CLAP"></a>
            <div id="m-menu"><i class="icon-menu"></i></div>
            <div id="menu">
                <a href="/contact" title="Support" class="menu-contact"><i
                                class="fa fa-support mr5"></i> Support</a>

                <a title="Login" class="menu-login" data-target="#pop-login" data-toggle="modal"><i
                                    class="fa fa-sign-in mr5"></i> Login</a>

                <a href="/register" title="Register" class="menu-register"><i
                                    class="fa fa-plus-circle mr5"></i>Maak een account aan</a>

            </div>
            <div class="clearfix"></div>
        </div>
        <main class="py-4">
            @yield('landingpagecontent')
        </main>
    </div>
    </header>

        <main class="py-4">
            @yield('content')
        </main>


    <footer>
        <div class="container">
            <div id="footer">
                <div class="footer-content">
                    <div class="ft-block ft-block1">
                        <span class="ft-heading">CLAP</span>
                        <ul class="nonestyle">
                            <li><a href="/about" title="About us">About us</a></li>
                            <li><a href="/faq" title="FAQ">FAQ</a></li>
                            <li><a href="/contact" title="Contact">Contact</a></li>
                        </ul>
                    </div>
                    <div class="ft-block ft-block2">
                        <span class="ft-heading">Policy</span>
                        <ul class="nonestyle">
                            <li><a href="/terms" title="Terms and Conditions">Terms and Conditions</a></li>
                            <li><a href="/copyright" title="Copyright Policy">Copyright Policy</a></li>
                            <li><a href="/dmca" title="Report Abuse">Report Abuse</a></li>
                        </ul>
                    </div>
                    <div class="ft-block ft-block5 text-right">
                        <div class="block block-social">
                            <a href="https://facebook.com/Mr.Muneebahmedkhan" class="ft-social-link mr5"><i class="fa fa-facebook fa-2x"></i></a>
                            <a href="https://twitter.com/MUNEEB7860" target="_blank" class="ft-social-link"><i class="fa fa-twitter fa-2x"></i></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </footer>

    <div class="modal fade modal-cuz" id="pop-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="block text-center md-logo"><img src="/images/logo-minimize.png" class="logo-bw"></div>
                    <form class="sp-form" id="login-form-1" method="post" action="{{ url('login') }}">
                        @csrf
                        @if($errors)
                        <script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>
                        <script>
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-center",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                            }
                        </script>
                        @foreach ($errors->all() as $error)
                            <script>
                            Command: toastr["error"]("{{$error}}");
                            </script>
                        @endforeach
                        @endif


                        @if ($errors->has('invalid'))
                            <div style="display: block;" id="error-message" class="alert alert-danger">{{ $errors->first('invalid') }}</div>
                        @else
                            <div style="display: none;" id="error-message" class="alert alert-danger"></div>
                        @endif
                        @if ($errors->has('email'))
                            <div class="alert alert-danger error-message" style="display:block" id="error-name">{{ $errors->first('email') }}&nbsp;<a href="email/resend/{{ session()->get('role') }}/{{ old('email') }}" class="pull-right md-forgot" title="Resend Email">Resend Email</a></div>
                        @else
                            <div class="alert alert-danger error-message" id="error-name"></div>
                        @endif
                        @if ($errors->has('success'))
                            <div class="alert alert-danger error-message" style="display:block;background:#51b74f" id="error-name">{{ $errors->first('success') }}</div>
                        @else
                            <div class="alert alert-danger error-message" id="error-name"></div>
                        @endif
                        @if (session()->has('verified'))
                            <div class="alert alert-danger error-message" style="display:block;background:#51b74f" id="error-name">Email verfied Successfully.</div>
                        @else
                            <div class="alert alert-danger error-message" id="error-name"></div>
                        @endif

                        <div class="form-group">
                            <input required name="email" type="email" class="form-control" id="email-input" value="{{ old('email') }}" placeholder="Email address">
                        </div>

                        <div class="form-group">
                            <input required name="password" type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <select required class="form-control" name="role">
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                                <option value="principal">Principal</option>
                            </select>
                        </div>

                        <div class="checkbox">
                            {{-- <label class="pull-left"><input value="1" name="remember" type="checkbox"> Remember me</label> --}}
                            <a href="password/reset" class="pull-right md-forgot" title="Forgot password">Forgot password?</a>
                            <div class="clearfix"></div>
                        </div>
                        <button id="login-submit" type="submit" class="btn btn-success btn-block mt20">Login
                        </button>
                    </form>
                </div>
                <div class="modal-footer text-center">
                    Not a member yet? <a href="/register" title="Join now!">Join now!</a>
                </div>
            </div>
        </div>
    </div>
    <!--modal-->
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>


    <main class="py-4">
            @yield('landingpagecontent_rotateJQurey')
    </main>
</body>
</html>
