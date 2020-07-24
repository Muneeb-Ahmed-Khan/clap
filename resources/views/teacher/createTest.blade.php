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

.inputOption, .addOption
{
    margin-top:20px;
}
.deleteOption
{
    margin-left:20px;
}

.dynamicEntry
{
    margin-top:5px;
    margin-bottom:35px;
}

.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
.dynamicEntry:hover{
    cursor : grab;
}

.dynamicEntry:active{
    cursor : grabbing;
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



<script>
  $( function() {
    $( "#formdrop" ).sortable();
    $( "#formdrop" ).disableSelection();
  } );
  </script>


<div id="main" class="main-padding main-dashboard extend">
    <div class="col-lg-custom">
        <div  class="main-card mb-3 card" style="width: 70%; min-height: 400px;border: dashed 2px gray; background-color:; float:left;">
            <div class="card-body" id="formdrop" data-content="Drag a field from the right to this area">


            </div>
        </div>
    </div>
    <div class="col-lg-custom">
        <div class="main-card mb-3 card" style="width: 30%;  background-color:; float:right;">
            <div class="card-body">
                <ul id="frmb-control-box" class="frmb-control ui-sortable connectedSortable">
                <!--
                    <li class="ui-sortable-handle btn-block" label="Text Field" data-field-type="1">
                        <span>Text Field</span>
                    </li>
                -->
                    <li class="ui-sortable-handle btn-block" label="Text Area" data-field-type="2">
                    <span>Text Area</span>
                    </li>

                    <li class="ui-sortable-handle btn-block" label="Checkbox" data-field-type="3">
                        <span>Checkbox</span>
                    </li>
                    <li class="ui-sortable-handle btn-block" label="Select" data-field-type="4">
                        <span>Image Checkbox <!-- Originally for select like : principla,student,teacher --></span>
                    </li>
                <!--
                    <li class="ui-sortable-handle btn-block"  label="Radio Group" data-field-type="5">
                        <span>Radio Group</span>
                    </li>
                -->
                </ul>
                <br>
                <button type="button" id="TestSubmit" class="btn btn-success btn-block">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).siblings('img')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(150);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }


$("#main").on("click", '.deleteOption',function(event){ //to work for dynamic content
    $(this).parent().remove();
});

$("#main").on("click", ".addOption", function(event){

    var a = $(this).siblings('.inputOption:last').clone();
    if(a.length == 0)
    {
        var getRandomNum = new Date().getTime();
        a = "<div class='inputOption'><input type='checkbox' name='checkbox-"+getRandomNum+"'/> <input type='text' class='options_for_MCQs'/><button class='btn btn-warning btn-xsm deleteOption'>-</button></div></div>";
    }
    x = $(a).insertBefore(this);
    x = x[0];   //[0] because when we do insertBefore it refurns an event, in that event we have the HTML refrence at 0th index
    x = x.getElementsByTagName("input")[1];
    x.value = null;
    $(x).focus();
});

var fieldType={};
fieldType[1]="textbox";
fieldType[2]="textarea";
fieldType[3]="checkbox";
fieldType[4]="select";
fieldType[5]="radio";


$(".ui-sortable-handle").draggable({
		helper: "clone",
	    cursor: "move",
	    cancel: null
});

$("#formdrop").droppable({
    drop: function(event, ui) {

        var getFieldType= ui.draggable.attr('data-field-type');
        var createFormElement=null;

        switch (fieldType[getFieldType]) {
            case "textbox":
                createFormElement=createTextBox();
            break;
            case "textarea":
                createFormElement=createTextArea();
            break;
            case "checkbox":
                createFormElement=createCheckBox();
            break;
            case "select":
                createFormElement=createSelectBoxImage();
            break;
            case "radio":
                createFormElement=createRadioGroup();
            break;
        }
        $(this).append(createFormElement);
    }
});


function createTextArea(){
	var getRandomNum = new Date().getTime();
	var createFormElement = "<div class='dynamicEntry'><label class='DescriptiveQuestion'>Question</label><button class='btn btn-danger btn-xsm deleteOption' style='float:right;'>x</button>";
	createFormElement += "<textarea class='form-control text-area' id='txtArea-"+getRandomNum+"'></textarea></div>";
	return createFormElement;
}

function createCheckBox(){

    var getRandomNum = new Date().getTime();
    var createFormElement = "<div class='dynamicEntry'><label class='MCQsQuestion'>Question</label><button class='btn btn-danger btn-xsm deleteOption' style='float:right;'>x</button><input type='text' class='form-control text-input'/><div class='inputOption'><input type='checkbox' name='checkbox-"+getRandomNum+"'/> <input type='text' class='options_for_MCQs'/><button class='btn btn-warning btn-xsm deleteOption'>-</button></div><button class='btn btn-primary btn-sm addOption' >Add Option</button></div>";
    return createFormElement;
}


function createSelectBoxImage(){
	var getRandomNum = new Date().getTime();
	var createFormElement = "<div class='dynamicEntry'>";
	createFormElement +="<label class='ImageMCQsQuestion'>Question</label>";
    createFormElement += "<button class='btn btn-danger btn-xsm deleteOption' style='float:right;'>x</button>";
    createFormElement += "<input type='text' class='form-control text-input'/>";
    createFormElement += "<div class='inputOption'>";
    createFormElement += "<input type='checkbox' name='checkbox-"+getRandomNum+"' />";
    createFormElement += "<label class='btn btn-file' style='background: #e4e5e5 !important; margin-left: 6px;'>";
    createFormElement +=    "    Browse  <input type='file' name='ImagesforMCQs[images-"+getRandomNum+"]' onchange='readURL(this);' style='display: none;'  class='options_for_MCQs'/><img accept='image/gif, image/jpeg, image/png, image/jpg'/>";
    createFormElement += "</label>";
    createFormElement += "<button class='btn btn-warning btn-xsm deleteOption'>-</button>";
    createFormElement += "</div>";
    createFormElement += "<button class='btn btn-primary btn-sm addOption'>Add Option</button>";
    createFormElement += "</div>";

	return createFormElement;
}



$("#TestSubmit").on("click", function(event){

    jsonObj = new Array();

    divs = $('#formdrop > div ');

    const formData = new FormData();
    var imagesData = new Array();

    for(var i =0 ; i < divs.length; i++)
    {
        item = new Object();

        type = divs[i].getElementsByTagName('label')[0];    //get the first <label> inside all the div's , the classname of those labels are actually the type they are

        if(type.className == 'DescriptiveQuestion')
        {
            item['type'] = 'Descriptive';
            item['question'] = divs[i].getElementsByTagName('textarea')[0].value;
        }

        else if(type.className == 'MCQsQuestion')
        {
            mcqQuestion = divs[i].querySelectorAll('input[type=text]')[0];
            console.log(mcqQuestion.value)

            item['type'] = 'MCQ';
            item['question'] = mcqQuestion.value;
            item['values'] = [];

            var innerDiv = divs[i].querySelectorAll('div > .inputOption');

            for(var j = 0 ; j < innerDiv.length; j++)
            {
                choices = innerDiv[j].querySelectorAll('input[type=checkbox]');
                values = innerDiv[j].querySelectorAll('input[type=text]');

                if(choices.length > 0)
                {
                    for(var v = 0 ; v < choices.length; v++)
                    {
                        choices[v].value = values[v].value;
                        console.log("Choice :  " + choices[v].value);
                        a = {}
                        a[choices[v].value] = choices[v].checked;
                        item['values'].push(a);
                    }
                }
            }
        }

        else if(type.className == 'ImageMCQsQuestion')
        {
            mcqQuestion = divs[i].querySelectorAll('input[type=text]')[0];
            console.log(mcqQuestion.value)

            item['type'] = 'ImageMCQ';
            item['question'] = mcqQuestion.value;
            item['values'] = [];

            var innerDiv = divs[i].querySelectorAll('div > .inputOption');

            for(var j = 0 ; j < innerDiv.length; j++)
            {
                choices = innerDiv[j].querySelectorAll('input[type=checkbox]');
                values = innerDiv[j].querySelectorAll('input[type=file]');

                if(choices.length > 0)
                {
                    for(var v = 0 ; v < choices.length; v++)
                    {
                        console.log(values[v].files[0]);

                        var getRandomNumXXXX = new Date().getTime();

                        name = getRandomNumXXXX + '__' + values[v].files[0].name;

                        formData.append('files[]', values[v].files[0]);

                        choices[v].value = name;

                        console.log("Choice :  " + choices[v].value);
                        a = {};
                        a[choices[v].value] = choices[v].checked;
                        item['values'].push(a);

                        imagesData.push(name);
                    }
                }
            }
        }

        jsonObj.push(item);
    }

    var myJsonString = JSON.stringify(jsonObj);
    console.log(myJsonString);

    /*  Sending the Test Form to Server */

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    formData.append('_token', CSRF_TOKEN);
    formData.append('data', myJsonString);
    formData.append('imagesData', imagesData);

    $.ajax({
        method: 'POST', // Type of response and matches what we said in the route
        url: '/teacher/' + {{request()->route('courseId')}} + '/createtest', // This is the url we gave in the route
        data: formData, // a JSON object to send back
        cache: false,
        contentType: false,
        processData: false,

        xhr: function() {
                        var myXhr = $.ajaxSettings.xhr();
                        return myXhr;
                    },

        success: function(response){ // What to do if we succeed
            console.log(response);

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
                    Command: toastr["success"]("Test Saved Successfully");
                    
                    window.location.href = '/teacher/' + {{request()->route('courseId')}};
        },

        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            alert("Couldn't Save Test");
        }
    });

    /* FOR DISPLAY - WILL BE USED */

    //Clear the DISPLAY - TESTING PURPOSE
    /*
    document.getElementById("formdrop").innerHTML = "";

    var res = JSON.parse(myJsonString);

    for(var i = 0; i < res.length; i++)
    {
        if(res[i].type == "Descriptive")
        {
            var createFormElement = "<br><br>";
            createFormElement +="<div><label>"+(i+1)+" :&nbsp;&nbsp;"+res[i].question+"</label>";
            createFormElement += "<textarea placeholder='Write Anser here...' class='form-control text-area' id='txtArea-"+new Date().getTime()+"'></textarea></div>";
            $("#formdrop").append(createFormElement);
        }
        else if(res[i].type == "MCQ")
        {
            var getRandomNum = new Date().getTime();
            var createFormElement = "<br><br>";
            createFormElement +="<div>";
            createFormElement +="<label>"+(i+1)+" :&nbsp;&nbsp;"+res[i].question+"</label>";
            for(var v = 0 ; v < res[i].values.length; v++)
            {
                createFormElement += "<br><input type='checkbox' id='checkbox-"+getRandomNum+"-1' name='"+Object.keys(res[i].values[v])+"' value='"+Object.keys(res[i].values[v])+"'/>";
                createFormElement += "<label for='checkbox-"+getRandomNum+"-1' style='font-weight: 100;' >&nbsp;"+Object.keys(res[i].values[v])+"</label>";
            }
            createFormElement +="</div>";
            $("#formdrop").append(createFormElement);
        }
        else if(res[i].type == "ImageMCQ")
        {
            var getRandomNum = new Date().getTime();
            var createFormElement = "<br><br>";
            createFormElement +="<div>";
            createFormElement +="<label>"+(i+1)+" :&nbsp;&nbsp;"+res[i].question+"</label><div class='grid-container'>";
            for(var v = 0 ; v < res[i].values.length; v++)
            {
                createFormElement += "<div class='grid-item'><input type='checkbox' id='checkbox-"+getRandomNum+"-1' name='"+Object.keys(res[i].values[v])+"' value='"+Object.keys(res[i].values[v])+"'/>";
                createFormElement += "<img for='checkbox-"+getRandomNum+"-1' src='/content/"+Object.keys(res[i].values[v])+"' style='height:320px; width:400px' /></div>";
            //createFormElement += "<label for='checkbox-"+getRandomNum+"-1' style='font-weight: 100;' >&nbsp;"+Object.keys(res[i].values[v])+"</label>";
            }
            createFormElement +="</div></div>";
            $("#formdrop").append(createFormElement);
        }
    }
    */

     /* FOR DISPLAY - WILL BE USED  [END] */
});

function createTextBox(){
	var getRandomNum = new Date().getTime();
	var createFormElement = "";
	createFormElement +="<label>Question</label>";
	createFormElement += "<input type='text' id='txt-"+getRandomNum+"' class='form-control text-input'/>";
	return createFormElement;
}

function createSelectBox(){
	var getRandomNum = new Date().getTime();
	var createFormElement = "<label>Please Select Option</label>";
	createFormElement +="<select class='form-control select' id='select-"+getRandomNum+"'>"
	var createOption="<option value='1'>option 1</option>";
	for(i=2;i<=4;i++){
		createOption +="<option value='"+i+"'>option "+i+"</option>";
	}
	createFormElement += createOption;
	createFormElement += "</select>";
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



















/*
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
    */











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


<!--
<div class='dynamicEntry'>
    <label>Question</label>
    <button class='btn btn-danger btn-xsm deleteOption' style='float:right;'>x</button>
    <input type='text' value='question' class='form-control text-input'/>
    <div class='inputOption'>
        <input type='checkbox' name='checkbox-"+getRandomNum+"' value='"+options[i]+"'/>

        <label class='btn btn-file' style='background: #e4e5e5 !important;'>
            Browse &nbsp;&nbsp;&nbsp;&nbsp;<input type='file' onchange='readURL(this);' style='display: none;'  class='options_for_MCQs'/><img src='#' alt='Image' accept="image/gif, image/jpeg, image/png, image/jpg" />
        </label>

        <button class='btn btn-warning btn-xsm deleteOption'>-</button>
    </div>
    <button class="btn btn-primary btn-sm addOption" >Add Option</button>
</div>
-->

@endsection
