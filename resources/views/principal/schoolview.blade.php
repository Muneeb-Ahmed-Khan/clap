@extends('layouts.dashboardEssentials')
@section('content')
<div id="main" class="main-padding main-dashboard extend">
<div class="container">
  <button type="button" style='margin-top: 5px;' data-target="#addStudents" data-toggle="modal" class="btn btn-primary">Add Bulk Students</button>
  <button type="button" style='margin-top: 5px;' data-target="#addTeachers" data-toggle="modal" class="btn btn-primary">Add Bulk Teachers</button>
  <button type="button" style='margin-top: 5px;' data-target="#addCourse" data-toggle="modal" class="btn btn-primary">Add Course</button>
  <a type="button" style='margin-top: 5px;' href="./{{__($schoolId)}}/viewStudents" class="btn btn-info">View all Students</a>
  <a type="button" style='margin-top: 5px;' href="./{{__($schoolId)}}/viewTeachers" class="btn btn-info">View all Teachers</a>
</div>
<br>
    <div class="main-content">
        <div class="mc-stats-detail">
                <div class="row">
                <?php $i = 0; ?>
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
                            <?php

                            $array = ['#098CFF','#00D509','#FF681F','#EAC435','#345995','#03CEA4','#CA1551','#FB4D3D','#643895'];
                            //$k = array_rand($array);
                            $v = $array[$i];
                            $i = $i+1;
                            if($i>8)
                            {
                                $i = 0;
                            }
                            ?>
                            <div class="mbox-link" >
                                <a style="background:{{__($v)}}" href="/principal/{{ $schoolId }}/courses/{{ $course->id }}" title="School">{{$course->name ?? "NULL"}}<span class="pull-right"><i class="fa fa-arrow-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endforeach

                    <div class="clearfix"></div>
                </div>
            </div>
    </div>
</div>


<!--  addCourse  -->
<div class="modal fade modal-cuz" id="addCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="sp-form" id="login-form-1" method="post" action="{{ route('ManageUpload',$schoolId ?? '') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="cname">Course Name: </label>
                            <input type="text" class="form-control" name="cname">
                        </div>

                        <div class="form-group">
                            <label for="temail">Teacher Email: </label>
                            <input type="text" class="form-control" name="temail">
                        </div>

                        <input type="text" name="schoolId" value="{{ $schoolId }}" hidden/>

                        <button id="login-submit" name="SubmitedForm_AddCourse" type="submit" class="btn btn-success btn-block mt20" style="background: #3b8de3 !important;">Add Course
                        </button>
                    </form>
                </div>
            </div>
        </div>
</div>


<!--  addStudents     -->
<div class="modal fade modal-cuz" id="addStudents" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="sp-form" id="login-form-1" method="post" action="{{ route('ManageUpload',$schoolId ?? '') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input  name="file" type="file" class="form-control" id="name-input">
                        </div>

                        <button id="login-submit" name="SubmitStudent" type="submit" class="btn btn-success btn-block mt20" style="background: #3b8de3 !important;">Add Students
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--   addTeachers   -->
<div class="modal fade modal-cuz" id="addTeachers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="sp-form" id="login-form-1" method="post" action="{{ route('ManageUpload',$schoolId ?? '') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input  name="file" type="file" class="form-control" id="name-input">
                        </div>

                        <button id="login-submit" name="SubmitTeacher" type="submit" class="btn btn-success btn-block mt20" style="background: #3b8de3 !important;">Add Teacher
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


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


@if(!empty($errors))

    @foreach ($errors->all() as $error)
        <script>
            Command: toastr["error"]("{{$error}}");
        </script>
    @endforeach
@endif


@if(session()->has('success'))
    <script>
        Command: toastr["success"]("{{__(session('success'))}}");
    </script>
@endif

@if(session()->has('info'))
    <script>
        Command: toastr["info"]("{{__(session('info'))}}");
    </script>
@endif


@endsection
