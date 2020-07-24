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



/* Style the tab */
.tab {
  overflow: hidden;
  background-color: #ffffff;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding-top: 6px;
  border-top: none;
}

</style>


<div id="main" class="main-padding main-dashboard extend">
    <div class="container">
    </div>
    <br>

    <div class="tab">
        <button id="defaultOpen" class="tablinks" onclick="openCity(event, 'tests')">Tests</button>
        <button class="tablinks" onclick="openCity(event, 'chapters')">Chapters</button>
        <button class="tablinks" onclick="openCity(event, 'roundRobins')">Round Robins</button>
    </div>

    <div id="tests" class="col-lg-custom tabcontent" >
        <div class="main-card mb-3 card">
            <div class="card-body">
                {{-- <h6 class="card-title">Student's Table</h6> --}}
                <table class="mb-0 table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Test</th>
                            <th>Distribution </th>
                            <th>Total Marks </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($tests as $test)
                        <tr>
                            <th scope="row"><?php $i = $i+1; echo $i; ?></th>
                            <td>{{ $test->created_at}}</td>

                            <td>
                            <?php
                                $totalMarks = 0;
                                $myMarks = json_decode($test->marks);
                                for( $i = 0; $i < count($myMarks); $i++ ) // [[1,10],[1,2],[-1,5],[-1,4]]                -1 is MCQS and 1 is Descriptive, the values at 1th index are the marks he got for type of question
                                {
                                    $totalMarks += $myMarks[$i][1];
                                    echo '<li> Q'.($i + 1).' : '.$myMarks[$i][1].'</li>';
                                }
                            ?>
                            </td>


                            <td> {{ $totalMarks }} </td>

                            <td>
                                <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($courseid)}}/progress/{{__($studentid)}}/evaluate/{{__($test->id)}}"  class="btn btn-warning">Evaluate</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div id="chapters" class="col-lg-custom tabcontent" >
        <div class="main-card mb-3 card">
            <div class="card-body">
                {{-- <h6 class="card-title">Student's Table</h6> --}}
                <table class="mb-0 table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Chapters</th>
                            <th>Total Score </th>
                            <th>Date Submitted </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($chapters as $chap)
                        <tr>
                            <th scope="row"><?php $i = $i+1; echo $i; ?></th>
                            <td>{{ $chap->chapterName}}</td>
                            <td> {{ json_decode($chap->data, true)['score'][0] }} </td>
                            <td> {{ $chap->created_at}} </td>
                            <td>
                                <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($courseid)}}/progress/{{__($studentid)}}/viewChapterDetails/{{__($chap->id)}}" class="btn btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div id="roundRobins" class="col-lg-custom tabcontent" >
        <div class="main-card mb-3 card">
            <div class="card-body">
                {{-- <h6 class="card-title">Student's Table</h6> --}}
                <table class="mb-0 table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Chapter Name</th>
                            <th>Participants</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach($roundRobins as $rr)
                        <tr>
                            <th scope="row"><?php $i = $i+1; echo $i; ?></th>
                            <td>{{ $rr->chapterName}}</td>

                            <td>
                            @foreach(json_decode($rr->participants,true) as $item)
                                    <li>{{__($item[0])}}</li>
                            @endforeach
                            </td>


                            <td>{{ $rr->created_at}}</td>

                            <td>
                                <a type="button" style="float:right; padding:5px; margin-left:5px;" href="/teacher/{{__($rr->course_id)}}/{{__($rr->chapter_id)}}/{{__($rr->id)}}/ViewRR" class="btn btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

//When the page is loaded first time, i wwant to show the Test's tab, by default, all are display none :)
document.getElementById("defaultOpen").click();

</script>

@endsection
