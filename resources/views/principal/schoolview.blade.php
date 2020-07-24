@extends('layouts.dashboardEssentials')
@section('content')
<div id="main" class="main-padding main-dashboard extend">
<div class="container">
  <button type="button" style='margin-top: 5px;' data-target="#addStudents" data-toggle="modal" class="btn btn-primary">Add Students</button>
  <button type="button" style='margin-top: 5px;' data-target="#addTeachers" data-toggle="modal" class="btn btn-danger">Add Teachers</button>
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
                                <a style="background:{{__($v)}}" href="/principal/{{ $schoolId }}/courses/{{ $course->id }}" title="School">{{$course->name}}<span class="pull-right"><i class="fa fa-arrow-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                @endforeach

                    <div class="clearfix"></div>
                </div>
            </div>
    </div>
</div>

<!--  Register Popup      -->
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

<!--    Delete Popup    -->
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

@endsection
