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
        <button type="button" style='margin-top: 5px;' data-target="#addTeacher" data-toggle="modal" class="btn btn-primary">Add Teacher</button>
    </div>
<br>
    <center>
    <div class="col-lg-custom">
        <div class="main-card mb-3 card">
            <div class="card-body">
                
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
                        @foreach($teachers as $teacher)
                            <tr>
                                <th scope="row"><?php $i = $i+1; echo $i; ?></th>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->email }}
                                    <a type="button" onclick="deleteTeacher({{ $teacher->id }}, {{ $teacher->school_id }});" style="float:right; padding:5px; margin-left:5px;" class="btn btn-danger">Delete</a>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </center>



<!--  AddTeacher  -->
<div class="modal fade modal-cuz" id="addTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="sp-form" id="login-form-1" method="post" action="{{ route('addTeacher') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="usr">Name:</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="form-group">
                            <label for="usr">Email:</label>
                            <input type="text" class="form-control" name="email">
                        </div>

                        <input type="text" name="schoolId" value="{{ $schoolId }}" hidden/>

                        <button id="login-submit" name="SubmitedForm_AddTeacher" type="submit" class="btn btn-success btn-block mt20" style="background: #3b8de3 !important;">Add Teacher
                        </button>
                    </form>
                </div>
            </div>
        </div>
</div>




<!-- DeleteChapter -->
<form hidden id="DeleteTeacher"  action="{{ route('DeleteTeacher') }}" method="post">
@csrf
    <input type='text' id="del_stud_studentId" name='teacherId'>
    <input type='text' id="del_stud_schoolId" name='schoolId'>
</form>

<script>
    function deleteTeacher(studentId, schoolId) {
        
        var r = confirm("Are you sure you want to Delete this Teacher ?");
        if (r == true) {
            document.getElementById("del_stud_studentId").value = studentId;
            document.getElementById("del_stud_schoolId").value = schoolId;
            document.getElementById("DeleteTeacher").submit();
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
