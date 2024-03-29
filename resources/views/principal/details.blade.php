@extends('layouts.dashboardEssentials')
@section('content')

<style>
.col-lg-custom {
    min-width : 300px;
    width: 100%;
}
.card {
    box-shadow: 0 0.46875rem 2.1875rem rgba(4,9,20,0.03), 0 0.9375rem 1.40625rem rgba(4,9,20,0.03), 0 0.25rem 0.53125rem rgba(4,9,20,0.05), 0 0.125rem 0.1875rem rgba(4,9,20,0.03);
    border-width: 0;
    transition: all .2s;
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(26,54,126,0.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    padding: 1.25rem;
}



.card-title {
    text-transform: uppercase;
    color: rgba(13,27,62,0.7);
    font-weight: bold;
    font-size: 20px;
}
.mb-0, .my-0 {
    margin-bottom: 0 !important;
}
.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: rgba(0,0,0,0);
}
</style>
<div id="main" class="main-padding main-dashboard extend">
    <div class="container">
        <button type="button" style='margin-top: 5px;' data-target="#changeTeacher" data-toggle="modal" class="btn btn-primary">Change Teacher</button>
        <button type="button"  style='margin-top: 5px;' onclick="deleteCourse({{ $courseId }});" class="btn btn-danger">Delete Course</button>
    </div>
<br>
    <center>
    <div class="col-lg-custom">
        <div class="main-card mb-3 card">
            <div class="card-body">
                {{-- <h6 class="card-title">Student's Table</h6> --}}
                <table class="mb-0 table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach($students as $student)
                            <tr>
                                <th scope="row"><?php $i = $i+1; echo $i; ?></th>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}
                                    <a type="button" onclick="RemoveStudentFromCourse({{ $student->id }}, {{ $courseId }});" style="float:right; padding:5px; margin-left:5px;" class="btn btn-primary">Remove</a>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </center>


<!--  Register Popup      -->
<div class="modal fade modal-cuz" id="changeTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="sp-form" id="login-form-1" method="post" action="{{ route('changeTeacher') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <select class="form-control" name="teacherId">
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="courseId" value="{{ $courseId }}" hidden/>

                        <button id="login-submit" name="SubmitedForm_ChangeTeacher" type="submit" class="btn btn-success btn-block mt20" style="background: #3b8de3 !important;">Change Teacher
                        </button>
                    </form>
                </div>
            </div>
        </div>
</div>



<!-- Remove student from course -->
<form hidden id="RemoveStudent"  action="{{ route('removeStudentFromCourse') }}" method="post">
@csrf
    <input type='text' id="rem_stud_studentId" name='studentId'>
    <input type='text' id="rem_stud_courseId" name='courseId'>
</form>

<!-- DeleteCourse -->
<form hidden id="DeleteCourse"  action="{{ route('DeleteCourse') }}" method="post">
@csrf
    <input type='text' id="del_course_courseId" name='courseId'>
</form>

<script>
    function RemoveStudentFromCourse(studentId, courseId) {
        
        var r = confirm("Are you sure you want to remove this student from this course ?");
        if (r == true) {
            document.getElementById("rem_stud_studentId").value = studentId;
            document.getElementById("rem_stud_courseId").value = courseId;
            document.getElementById("RemoveStudent").submit();
        }
    }

    function deleteCourse(courseId) {
        
        var r = confirm("Are you sure you want to Delete this Course ?");
        if (r == true) {
            document.getElementById("del_course_courseId").value = courseId;
            document.getElementById("DeleteCourse").submit();
        }
    }
</script>



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
