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

    <div class="col-lg-custom">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h6 class="card-title">My Test</h6>
                <table class="mb-0 table">
                    <thead>
                        <tr>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <tr>
                            <td>
                                @if(isset($mytests->poster_name))
                                    By : <b>{{ $mytests->poster_name }}</b>
                                @endif
                            </td>
                            <td>
                                @if(isset($mytests->id))
                                    <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($mytests->id)}}/viewTest"  class="btn btn-info">Start</a>
                                    <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($mytests->id)}}/viewTest"  class="btn btn-warning">View</a>
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>

                <br><br><br>



                <h6 class="card-title">Shared Tests</h6>
                <table class="mb-0 table">
                    <thead>
                        <tr>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($alltests as $test)
                        <tr>
                            <td>
                                By : <b>{{ $test->poster_name }}</b>
                            </td>
                            <td>
                                @if(isset($test->id))
                                    <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($test->id)}}/viewTest"  class="btn btn-info">Start</a>
                                    <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($test->id)}}/viewTest"  class="btn btn-warning">View</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


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

@endsection
