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
                <h6 class="card-title">Course's Summary</h6>
                <table class="mb-0 table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th >Student Name</th>
                            @foreach($results[0]['chapter'] as $row)
                                <th colspan="2" style='text-align: center;'> {{ $row['name'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            @endforeach
                            
                            <th></th>
                        </tr>

                        <tr>
                            <th></th>
                            <th></th>
                            @foreach($results[0]['chapter'] as $row)
                                <th scope="col" style='text-align: center;'>&nbsp;&nbsp;Quiz&nbsp;&nbsp;&nbsp;</th>
                                <th scope="col" style='text-align: center;'>Round Robin</th>
                            @endforeach
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($results as $row)
                        <tr>
                            <th><?php $i = $i+1; echo $i; ?></th>
                            <td style='text-align: left;'> {{ $row['name'] }} </td>

                            <?php

                                    foreach ($row['chapter'] as $index => $record)
                                    {
                                        /*
                                            Each record contains these three things. count return 3, so in the loops.
                                            but, when i apply for loop (0 to count(record)), this will start discarding the 'name', becasuse
                                            it will conider the pure array indexes not keys like 'name'.
                                            Since the original count return 3 but it starts from 1, so i will have to deduct 1 from count to make it 2
                                            once it is 2 (0,1) indexis, first iteration gets 0th index array:3 [▶], and 1th index gets array:2 [▶]

                                                "name" => "Greetings"
                                                0 => array:3 [▶]
                                                1 => array:2 [▶]
                                        */

                                        for ($i = 0; $i < count($record) - 1  ; $i++)
                                        {
                                            if($i == 0)  //0th index contain array that has chapters_record
                                            {
                                                if($record[$i]['submitted'] == 1)
                                                {
                                                    echo '<td><a href="/teacher/'. request()->route('courseId') . '/progress/'.  $record['chapterId'] . '/viewChapterDetails/'. $record[$i]['chap_id']. '"><span class="glyphicon glyphicon-ok-sign" style="color:green; font-size:25px"></span></a></td>';
                                                }
                                                else
                                                {
                                                    echo '<td><span class="glyphicon glyphicon-remove-sign" style="color:#b52727; font-size:25px"></span></td>';
                                                }
                                            }
                                            else if($i == 1)   //0th index contain array that has chapters_record
                                            {
                                                if($record[$i]['submitted'] == 1)
                                                {
                                                    echo '<td><a href="/teacher/' . request()->route('courseId') . '/' .$record['chapterId']. '/'. $record[$i]['rr_id'] .'/ViewRR"><span class="glyphicon glyphicon-ok-sign" style="color:green; font-size:25px"></span></a></td>';
                                                }
                                                else
                                                {
                                                    echo '<td><span class="glyphicon glyphicon-remove-sign" style="color:#b52727; font-size:25px"></span></td>';
                                                }
                                            }
                                            
                                        }
                                    }
                            ?>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

@endsection
