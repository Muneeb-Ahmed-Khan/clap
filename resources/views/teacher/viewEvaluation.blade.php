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


/*Dragable list CSS*/
.frmb-control {
    width: 100%!important;
}
.frmb-control li:first-child {
    border-radius: 5px 5px 0 0;
}
.frmb-control {
    margin: 0;
    padding: 0;
}
.frmb-control li {
    cursor: move;
    list-style: none;
    margin: -1px 0 0;
    box-shadow: 0 0 1px 0 inset;
    padding: 10px;
    text-align: left;
    background: #fff;
    -webkit-user-select: none;
    user-select: none;
}

.grid-container {
  display: grid;
  grid-template-columns: auto auto auto;
  padding: 10px;
}

.grid-item {
  padding: 20px;
  font-size: 30px;
  text-align: center;
}
.options_for_MCQs
{
    background: #f2f4f6;
    box-shadow: none;
    border: none;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
}
</style>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{asset('/js/toastr.js')}}"></script>



<div id="main" class="main-padding main-dashboard extend">
    <div class="col-lg-custom">
        <div  class="main-card mb-3 card" style="width: 100%; min-height: 400px; background-color:; float:left;">
            <div class="card-body" id="formdrop" data-content="Drag a field from the right to this area">
            </div>
        </div>
    </div>
</div>


<script>


document.getElementById("formdrop").innerHTML = "";

abc = '{!! $test[0]->data !!}';
var res = JSON.parse(abc);
console.log(res);

def = '{!! $answer[0]->marks !!}';
var marks = JSON.parse(def);
console.log(marks);

ghi = '{!! $answer[0]->data !!}';
var answers = JSON.parse(ghi);
console.log(answers);

answer = new Array();

if(marks.length == res.length)
{
    for(var i = 0; i < marks.length; i++)
    {
        if(marks[i][0] == -1)
        {
            if(res[i].type == "Descriptive")
            {
                var getRandomNum = new Date().getTime();
                textarea_id = 'txtArea-' + getRandomNum;
                id = "marks_"+i;
                answer.push(i);

                var createFormElement = "<br><br>";
                createFormElement +="<div><label>"+(i+1)+" :&nbsp;&nbsp;"+res[i].question+"</label>";
                createFormElement += "<textarea readonly placeholder='Write Anser here...' class='form-control text-area' id='"+ textarea_id +"'>" +answers[i]+ "</textarea></div>";
                createFormElement += "<br><input type='number' min='0' id='"+id+"' class='options_for_MCQs' placeholder='Marks..'/><br><br>"
                $("#formdrop").append(createFormElement);
            }
        }
    }
}
$("#formdrop").append('<button id="TestSubmit" type="submit" class="btn btn-success btn-lg pull-right" style="margin-top:10px;">Submit!</button>');


function isNumber(n) {
  return !isNaN(parseInt(n)) && isFinite(n);
}

//Submitting the test.
$("#TestSubmit").on("click", function(event){

    for(var i = 0; i < answer.length; i++)
    {
        val = document.getElementById("marks_" + answer[i]).value;
        if(!isNumber(val))
        {
            alert("Please Enter Marks in Numbers Only");
            return;
        }
        else
        {
            v = parseInt(val);
            if(!isNaN(v))
            {
                marks[answer[i]][1] = v;
            }
            else
            {
                return;
            }
        }
        
    }

    console.log(marks);
    const formData = new FormData();
    var myJsonString = JSON.stringify(marks);

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    formData.append('_token', CSRF_TOKEN);
    formData.append('data', myJsonString);
    formData.append('test_record_id', '{!! $answer[0]->id !!}');


    $.ajax({
        method: 'POST', // Type of response and matches what we said in the route
        url: '/teacher/' + {{request()->route('courseId')}} + '/progress/' + {{request()->route('studentId')}} + '/changemarks', // This is the url we gave in the route
        data: formData, // a JSON object to send back
        cache: false,
        contentType: false,
        processData: false,

        xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        return myXhr;
                    },

        success: function(response){ // What to do if we succeed
           

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
                    console.log(response);
                    if(response == 'success')
                    {
                        Command: toastr["success"]("Marks Updated Successfully");
                    }
                    else
                    {
                        Command: toastr["error"](response);
                    }
        },

        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            alert("Couldn't Submitted Test");
        }
    });
});
</script>
@endsection
