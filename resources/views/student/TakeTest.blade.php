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

abc = '{!! $test->data !!}';
var res = JSON.parse(abc);
//console.log(res);

jsonObj = new Array();

for(var i = 0; i < res.length; i++)
{
    if(res[i].type == "Descriptive")
    {
        var getRandomNum = new Date().getTime();
        textarea_id = 'txtArea-' + getRandomNum;

        item = new Object();
        item['type'] = 'Descriptive';
        item['id'] = textarea_id;
        jsonObj.push(item);


        var createFormElement = "<br><br>";
        createFormElement +="<div><label>"+(i+1)+" :&nbsp;&nbsp;"+res[i].question+"</label>";
        createFormElement += "<textarea placeholder='Write Anser here...' class='form-control text-area' id='"+ textarea_id +"'></textarea></div>";
        $("#formdrop").append(createFormElement);
    }
    else if(res[i].type == "MCQ")
    {
        var getRandomNum = new Date().getTime();
        checkbox_id = 'checkbox-' + getRandomNum;

        item = new Object();
        item['type'] = 'MCQ';
        item['id'] = checkbox_id;
        jsonObj.push(item);


        var createFormElement = "<br><br>";
        createFormElement +="<div>";
        createFormElement +="<label>"+(i+1)+" :&nbsp;&nbsp;"+res[i].question+"</label>";
        for(var v = 0 ; v < res[i].values.length; v++)
        {
            createFormElement += "<br><input type='checkbox' id='" + checkbox_id + "' name='"+Object.keys(res[i].values[v])+"' value='"+Object.keys(res[i].values[v])+"'/>";
            createFormElement += "<label for='" + checkbox_id + "' style='font-weight: 100;' >&nbsp;"+Object.keys(res[i].values[v])+"</label>";
        }
        createFormElement +="</div>";
        $("#formdrop").append(createFormElement);
    }
    else if(res[i].type == "ImageMCQ")
    {
        var getRandomNum = new Date().getTime();
        img_checkbox_id = 'img-checkbox-' + getRandomNum;
        
        item = new Object();
        item['type'] = 'ImageMCQ';
        item['id'] = img_checkbox_id;
        jsonObj.push(item);

        var createFormElement = "<br><br>";
        createFormElement +="<div>";
        createFormElement +="<label>"+(i+1)+" :&nbsp;&nbsp;"+res[i].question+"</label><div class='grid-container'>";
        for(var v = 0 ; v < res[i].values.length; v++)
        {
            createFormElement += "<div class='grid-item'><input type='checkbox' id='"+ img_checkbox_id +"' name='"+Object.keys(res[i].values[v])+"' value='"+Object.keys(res[i].values[v])+"'/>";
            createFormElement += "<img for='"+ img_checkbox_id +"' src='/content/"+Object.keys(res[i].values[v])+"' style='height:auto; max-width:300px' /></div>";
        //createFormElement += "<label for='checkbox-"+getRandomNum+"-1' style='font-weight: 100;' >&nbsp;"+Object.keys(res[i].values[v])+"</label>";
        }
        createFormElement +="</div></div>";
        $("#formdrop").append(createFormElement);
    }
}
$("#formdrop").append('<button id="TestSubmit" type="submit" class="btn btn-success btn-lg pull-right" style="margin-top:10px;">Submit!</button>');


//Submitting the test.
$("#TestSubmit").on("click", function(event){

    console.log(jsonObj);
    answer = new Array();
    for(var i = 0; i < jsonObj.length; i++)
    {
        if(jsonObj[i].type == "Descriptive")
        {
            var favorite = [];
            val = document.getElementById(jsonObj[i].id).value;
            if(val != "")
            {
                favorite.push(val);
            }
            answer.push(favorite);
        }
        else if(jsonObj[i].type == "MCQ")
        {
            var favorite = [];
            $.each($("input[id='"+ jsonObj[i].id +"']:checked"), function(){
                favorite.push($(this).val());
            });
            answer.push(favorite);
        }
        else if(jsonObj[i].type == "ImageMCQ")
        {
            var favorite = [];
            $.each($("input[id='"+ jsonObj[i].id +"']:checked"), function(){
                favorite.push($(this).val());
            });
            answer.push(favorite);
        }
    }
    console.log(answer);

    const formData = new FormData();
    var myJsonString = JSON.stringify(answer);
    console.log(myJsonString);
    /*  Sending the Answers Form to Server for Marking*/

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    formData.append('_token', CSRF_TOKEN);
    formData.append('data', myJsonString);
    formData.append('test_id', '{!! $test->id !!}');


    $.ajax({
        method: 'POST', // Type of response and matches what we said in the route
        url: '/student/' + {{request()->route('courseId')}} + '/submitTest', // This is the url we gave in the route
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
                        Command: toastr["success"]("Test Submitted Successfully");
                        setTimeout(function(){window.location.href = '/student/';}, 4000);
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




function createTextBox(){
	var getRandomNum = new Date().getTime();
	var createFormElement = "";
	createFormElement +="<label>Question</label>";
	createFormElement += "<input type='text' id='txt-"+getRandomNum+"' class='form-control text-input'/>";
	return createFormElement;
}


function createRadioGroup(){
	var getRandomNum = new Date().getTime();
	var createFormElement="<br><br>";
    var question = prompt("Please enter your Question:");
    var options = [];

    if (question == null || question == "") {
        return;
    }
    else
    {
        var xyz = true;
        while(xyz)
        {
            var o = prompt("Enter Choice : ");
            if (o == null || o == "")
            {
                break;
            }
            else
            {
                options.push(o);
            }
        }
    }
    if(options.length != 0)
    {
        createFormElement += "<div><label>Question</label><input type='text' value='"+question+"' class='form-control text-input'/>";
        for(var i = 0; i < options.length; i++)
        {
            createFormElement += "<br><input type='radio' id='radio-"+getRandomNum+"-1' name='radio-"+getRandomNum+"' value='"+options[i]+"'/>";
            createFormElement += "<label for='radio-"+getRandomNum+"-1'>&nbsp;"+options[i]+"</label>";
        }
        createFormElement += "</div>";
    }
    else
    {
        createFormElement = "";
    }

	return createFormElement;
}

function createTextArea(){
	var getRandomNum = new Date().getTime();
	var createFormElement="<br><br>";
	createFormElement +="<div><label>Question</label>";
	createFormElement += "<textarea class='form-control text-area' id='txtArea-"+getRandomNum+"'></textarea></div>";
	return createFormElement;
}

function createSelectBox(){
	var getRandomNum = new Date().getTime();
	var createFormElement="<br><br><br>";
	createFormElement +="<label>Please Select Option</label>";
	createFormElement +="<select class='form-control select' id='select-"+getRandomNum+"'>"
	var createOption="<option value='1'>option 1</option>";
	for(i=2;i<=4;i++){
		createOption +="<option value='"+i+"'>option "+i+"</option>";
	}
	createFormElement += createOption;
	createFormElement += "</select>";
	return createFormElement;
}



function createCheckBox(){
	var getRandomNum = new Date().getTime();
	var createFormElement="<br><br>";
    var question = prompt("Please enter your Question:");
    var options = [];

    if (question == null || question == "") {
        return;
    }
    else
    {
        var xyz = true;
        while(xyz)
        {
            var o = prompt("Enter Choice : ");
            if (o == null || o == "")
            {
                break;
            }
            else
            {
                options.push(o);
            }
        }
    }
    if(options.length != 0)
    {
        createFormElement += "<div><label>Question</label><input type='text' value='"+question+"' class='form-control text-input'/>";
        for(var i = 0; i < options.length; i++)
        {
            createFormElement += "<br><input type='checkbox' id='checkbox-"+getRandomNum+"-1' name='checkbox-"+getRandomNum+"' value='"+options[i]+"'/>";
            createFormElement += "<label for='checkbox-"+getRandomNum+"-1'>&nbsp;"+options[i]+"</label>";
        }
        createFormElement += "</div>";
    }
    else
    {
        createFormElement = "";
    }

	return createFormElement;
}

























/*
MCQ = document.getElementById('MCQButton');
Descriptive = document.getElementById('DescriptiveButton');
TestSubmit = document.getElementById('TestSubmit');

MCQ.addEventListener("click", ()=>{
    MCQquestion = document.getElementById('MCQquestion');
    ch1 = document.getElementById('ch1');
    ch2 = document.getElementById('ch2');
    ch3 = document.getElementById('ch3');
    ch4 = document.getElementById('ch4');
    MCQcorrect = document.getElementById('MCQcorrect');

    var q = $('<label class="control-label">'+MCQquestion.value+'</label><br>');
    $("#testForm").append(q);

    time = Date.now();

    var ch1 = $('<input type="radio" name="'+time+'" value="'+ch1.value+'"/><label>'+"&nbsp;"+ch1.value+'</label><br>');
    $("#testForm").append(ch1);
    var ch2 = $('<input type="radio" name="'+time+'" value="'+ch2.value+'"/><label>'+"&nbsp;"+ch2.value+'</label><br>');
    $("#testForm").append(ch2);
    var ch3 = $('<input type="radio" name="'+time+'" value="'+ch3.value+'"/><label>'+"&nbsp;"+ch3.value+'</label><br>');
    $("#testForm").append(ch3);
    var ch4 = $('<input type="radio" name="'+time+'" value="'+ch4.value+'"/><label>'+"&nbsp;"+ch4.value+'</label><br>');
    $("#testForm").append(ch4);


    var br = $('<br><br>');
    $("#testForm").append(br);

});


$("#TestSubmit").on("click", function(event){
   $("#testForm").submit();
});

 $("#testForm").on("submit", function(event) {
    event.preventDefault();
    form = document.getElementById('testForm');
 });

TestSubmit
*/
</script>
@endsection
