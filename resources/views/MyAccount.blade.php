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

<br>
    <div class="col-lg-custom">
        <div class="main-card mb-3 card">
            <div class="card-body">
            <h4>Change Password</h4>
                    <form method="POST" action="">
                    @csrf
                        <hr>
                        <div class="form-group">
                            <label>Current Password</label>
                            <input class="form-control" required name="curPass" placeholder="Password" type="password">
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input class="form-control" required name="newPass" placeholder="New Password" type="password">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Save Changes" name="passwordForm" class="btn btn-primary center-block">
                        </div>
                    </form>
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
