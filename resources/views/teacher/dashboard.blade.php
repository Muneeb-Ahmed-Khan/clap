@extends('layouts.dashboardEssentials')
@section('content')
<div id="main" class="main-padding main-dashboard extend">
<br>
<?php //phpinfo(); ?>
    <div class="main-content">
        <div class="mc-stats-detail">
            <div class="row">

            @foreach($courses as $course)
                <div class="col-lg-4 mcs-balance">
                    <div class="mbox">
                        <div class="mbox-title">
                            <div class="s-title">
                                <h5>{{ $course->id }}</h5>
                            </div>
                        </div>
                        <div class="mbox-content mbox-number">
                            <span class="highlight">{{ $course->cname }}</span>
                        </div>
                        <div class="mbox-link">
                            <a href="/teacher/{{ $course->id }}" title="School">Course <span class="pull-right"><i class="fa fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            @endforeach

                <div class="clearfix"></div>
            </div>
        </div>
    </div>


@if(!empty($errors))
<script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>
@foreach ($errors->all() as $error)
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
    Command: toastr["error"]("{{$error}}");
    </script>
@endforeach
@endif


@if(session()->has('success'))
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
    Command: toastr["success"]("{{__(session('success'))}}");
</script>
@endif

@if(session()->has('info'))
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
    Command: toastr["info"]("{{__(session('info'))}}");
</script>
@endif
@endsection
