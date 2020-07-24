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

abc = '{!! $test !!}';
var res = JSON.parse(abc);
console.log(res);
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
</script>
@endsection
