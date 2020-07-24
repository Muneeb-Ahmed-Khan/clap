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

.container
{
    padding :0px;
    margin : 0px;
}
</style>


<div id="main" class="main-padding main-dashboard extend">
    <div class="container">
    <a type="button" style='margin-top: 5px;' href="/teacher/{{__($course)}}/chapter/new" class="btn btn-primary">Add Chapter</a>
    <a type="button" style='margin-top: 5px;' data-target="#testbrodcast" data-toggle="modal" class="btn btn-danger">Create Test Brodcast</a>
    <a type="button" style='margin-top: 5px;' href="/teacher/{{__($course)}}/progress" data-toggle="modal" class="btn btn-warning">Progress</a>
    <a type="button" style='margin-top: 5px;' href="/teacher/{{__($course)}}/createtest" data-toggle="modal" class="btn btn-success">Create Test</a>
    <a type="button" style='margin-top: 5px;' href="/teacher/{{__($course)}}/viewTest"  class="btn btn-primary">View Test</a>
    <a type="button" style='margin-top: 5px;' data-target="#startTestPopup" data-toggle="modal" class="btn btn-info">Start Test</a>
    <a type="button" onclick="StopTest()" style='margin-top: 5px;' data-toggle="modal" class="btn btn-danger">Stop Test</a>
    <a type="button" style='margin-top: 5px;' href="/teacher/{{__($course)}}/summary" class="btn btn-success">Detailed Summary</a>
    </div>
    <br>

    <div class="col-lg-custom">
        <div class="main-card mb-3 card">
            <div class="card-body">
                {{-- <h6 class="card-title">Student's Table</h6> --}}
                <table class="mb-0 table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Chapter Name</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($chapters as $chapter)
                        <tr>
                            <th scope="row"><?php $i = $i+1; echo $i; ?></th>
                            <td>{{ key(json_decode($chapter->data,true)) }}
                                <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($course)}}/chapter/{{__($chapter->id)}}/ViewAsStudent"  class="btn btn-warning">Attempt</a>
                                <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($course)}}/chapter/{{__($chapter->id)}}/listRR"  class="btn btn-info">Round Robin</a>
                                <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($course)}}/chapter/{{__($chapter->id)}}/summary"  class="btn btn-primary">Summary</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<!--
<table class="mb-0 table">
    <thead>
        <tr>
            <th>#</th>
            <th>Student Name</th>
        </tr>
    </thead>
    <tbody>
    @foreach($students as $student)
        <tr>
            <th scope="row">{{$student->id}}</th>
            <td>{{ $student->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
-->


<!--  BroadCast Popup      -->
<div class="modal fade modal-cuz" id="testbrodcast" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="responseBody">
                    <form class="sp-form" method="post" action="{{ route('ManageBroadcast',$course ?? '') }}">
                    @csrf
                        <div class="form-group">
                                <label class="control-label">Write down Message to Brodcast</label>
                                <input type='text' name='brodcastMsg' class="form-control"/>
                        </div>
                        <button type="submit" class="btn btn-primary  btn-lg">Publish</button>
                    </form>
                </div>
            </div>
        </div>
</div>



<!--  StartTest Popup      -->
<div class="modal fade modal-cuz" id="startTestPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
                </div>
                <div class="modal-body">
                    <h4>Allowed Students</h4>
                </div>
                <div class="modal-body" id="responseBody">
                    <form id="startTestForm" class="sp-form" method="post">
                    @csrf
                        @foreach($students as $student)
                            <div class="form-group">
                                    <input type='checkbox' name='AllowedStudents' value='{{$student->id}}' id='student_id_{{$student->id}}'/>
                                    <label for='student_id_{{$student->id}}'>{{ $student->name }}</label>
                            </div>
                        @endforeach
                        <br><br>
                        <button type="submit" class="btn btn-primary  btn-lg">Publish</button>
                    </form>
                </div>
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





<script>
var form = document.getElementById("startTestForm");
form.addEventListener("submit", function(event){

    event.preventDefault();
    yourArray = new Array();
    $("input:checkbox[name=AllowedStudents]:checked").each(function(){
    yourArray.push($(this).val());
    });
    jsonData = JSON.stringify(yourArray)
    console.log(jsonData);

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        method: 'POST', // Type of response and matches what we said in the route
        url: '/teacher/' + {{request()->route('courseId')}} + '/startTest', // This is the url we gave in the route
        data: {_token: CSRF_TOKEN, data: jsonData}, // a JSON object to send back

        success: function(response){ // What to do if we succeed

                    console.log('Server Response : ', response);
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
                    Command: toastr["success"]("Test Started");
        },

        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            alert("Couldn't Start Test");
        }
    });

});
</script>



<script>
    function StopTest()
    {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: 'POST', // Type of response and matches what we said in the route
            url: '/teacher/' + {{request()->route('courseId')}} + '/stopTest', // This is the url we gave in the route
            data: {_token: CSRF_TOKEN, data: ""}, // a JSON object to send back

            success: function(response){ // What to do if we succeed

                        console.log('Server Response : ', response);
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
                        Command: toastr["success"]("Test Stoped");
            },

            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                alert("Couldn't Stop Test");
            }
        });
        
    }
    </script>
@endsection
