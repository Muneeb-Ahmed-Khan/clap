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

td {
    text-align: center;
}


</style>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!--Since this bootstrap library is forcing white color to body, i have to again difine the color after it is loaded-->
<style>
    body{
        background: #e9eaef;
    }
</style>

<div id="main" class="main-padding main-dashboard extend">



    <div class="col-lg-custom">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h6 class="card-title">Chapter's Summary</h6>
                <table class="mb-0 table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th >Student Name</th>
                            <th style='text-align: center;'>Quiz</th>
                            <th style='text-align: center;'>Round Robbin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($results as $row)
                        <tr>
                            <th><?php $i = $i+1; echo $i; ?></th>
                            
                            <td style='text-align: left;'> {{ $row['name'] }} </td>

                            @if($row['quiz']['submitted'] == 1)
                                <td><span class="glyphicon glyphicon-ok-sign" style="color:green; font-size:25px"></span></td>
                            @else
                                <td><span class="glyphicon glyphicon-remove-sign" style="color:#b52727; font-size:25px"></span></td>
                            @endif

                            
                            

                            @if($row['rr']['submitted'] == 1)
                                <td><span class="glyphicon glyphicon-ok-sign" style="color:green; font-size:25px"></span></td>
                            @else
                                <td><span class="glyphicon glyphicon-remove-sign" style="color:#b52727; font-size:25px"></span></td>
                            @endif


                            <td>
                            @if($row['rr']['submitted'] == 1)
                                <a type="button" style="float:right; padding:5px; margin-left:5px;"  href="/teacher/{{__(request()->route('courseId'))}}/{{__(request()->route('chapterId'))}}/{{__($row['rr']['rr_id'])}}/ViewRR" class="btn btn-info">RR</a>
                            @endif

                            @if($row['quiz']['submitted'] == 1)
                                <a type="button" style="float:right; padding:5px; margin-left:5px;"  href="/teacher/{{__(request()->route('courseId'))}}/progress/{{__($row['id'])}}/viewChapterDetails/{{__($row['quiz']['chap_id'])}}" class="btn btn-primary">Quiz</a>
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

@endsection
