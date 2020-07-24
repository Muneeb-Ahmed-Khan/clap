@extends('layouts.dashboardEssentials')
@section('content')

<style>
body{
    margin-top:40px;
}

.stepwizard-step p {
    margin-top: 10px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
    margin-top: 30px;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}

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

.activePage
{
    background : #03a9f4 !important;
    color: white !important;
}
video {
  width: 100%;
  height : 480px;
}

input {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;

  border-radius: 50%;
  width: 16px;
  height: 16px;

  border: 2px solid #999;
  transition: 0.2s all linear;
  margin-right: 5px;

  position: relative;
  top: 4px;
}

input:checked {
  border: 8px solid #0973eb;
}


</style>
<script>
$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            allWells.hide();
            $target.show();
            $item.addClass('activePage');
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-primary').trigger('click');
});
</script>
<div id="main" class="main-padding main-dashboard extend">
    <div class="col-lg-custom">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h6 class="card-title">Animation</h6>
                <div class="stepwizard">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step" style="width: 50%;">
                                <a href="#step-1" type="button" class="btn btn-primary btn-circle activePage">1</a>
                                <p>Animation</p>
                            </div>
                            <div class="stepwizard-step" style="width: 50%;">
                                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                                <p>Quiz</p>
                            </div>
                        </div>
                    </div>

                    <div>
                            <div class="row setup-content" id="step-1">
                                <div class="col-xs-12">
                                    <div class="col-md-12" >
                                        <h3>{{$chapters[0][key($chapters[0])]["animation"]["anim_title"]}}</h3>
                                        <div class="form-group">
                                            
                                            <video controls style="width: 50%;height: 400px;">
                                            <source src="{{ "/".$chapters[0][key($chapters[0])]['animation']['anim_file'] }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                            </video>
                                            
                                            <div class="form-group" style=" float: right; width: 47%; height: 100%;">
                                                <!-- <label class="control-label">Write down your notes here.</label> -->
                                                <textarea id="notes" class="form-control" style="height: 400px;" placeholder="Write your notes here..."></textarea>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Key Notes</label>
                                            <textarea readonly class="form-control">{{$chapters[0][key($chapters[0])]["animation"]["anim_keynotes"]}}</textarea>
                                        </div>
                                        
                                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content" id="step-2">
                                <div class="col-xs-12">
                                    <div class="col-md-12" >
                                        <h3> Quiz</h3>
                                        <div class="form-group"  style="width: 50%; float : left">
                                        @foreach($chapters as $chapter)
                                            <?php $i = 0 ?>
                                            <form class="QUESTIONS">
                                                <input id="form_keynotes" name="form_keynotes" type="text" value="" hidden/>
                                                @foreach($chapter[key($chapters[0])]["quiz"] as $question)
                                                            <label id='<?php echo $i ?>' class="control-label">{{$question["Q"]}}</label><br>
                                                            <input type="radio" name="<?php echo $i ?>" value="{{$question['A']}}" required> {{$question['A']}}<br>
                                                            <input type="radio" name="<?php echo $i ?>" value="{{$question['B']}}" required> {{$question['B']}}<br>
                                                            <input type="radio" name="<?php echo $i ?>" value="{{$question['C']}}" required> {{$question['C']}}<br>
                                                            <input type="radio" name="<?php echo $i ?>" value="{{$question['D']}}" required> {{$question['D']}}<br><br><br>
                                                    <?php $i = $i + 1 ?>
                                                @endforeach
                                                <button id="publish" type="submit" class="btn btn-success btn-lg pull-right">Submit!</button>
                                            </form>
                                        @endforeach
                                        </div>

                                        <div class="form-group" style=" float: right; width: 47%; height: 100%;">
                                            <textarea id="notessa" class="form-control" style="height: 400px;" readonly placeholder="Notes..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
var form = document.querySelector(".QUESTIONS");
var nextBtn = document.querySelector(".nextBtn");

nextBtn.addEventListener("click", function(event) {
    textarea = document.getElementById("notes").value;
    document.getElementById("form_keynotes").value = textarea;
    document.getElementById("notessa").value = textarea
    console.log(textarea);
}, false);

form.addEventListener("submit", function(event) {
    
    event.preventDefault();
    var  data = new FormData(form);
    var object = {};
    data.forEach((value, key) => {object[key] = value});
    var json = JSON.stringify(object);
    console.log(object);

    document.getElementById("publish").disabled = true;
    document.getElementById("publish").innerHTML = "Please wait ...";

    $.ajax({
        method: 'POST', // Type of response and matches what we said in the route
        url: "/student/checkQuiz/{{Request::route('courseId')}}/{{Request::route('chapterId')}}", // This is the url we gave in the route
        data: object, // a JSON object to send back

        success: function(response){ // What to do if we succeed
            console.log(response);

            var res = JSON.parse(response);
            document.getElementById("responseToogler").click();

            var responseBody = document.querySelector("#responseBody");
            for (const [key, value] of Object.entries(res['score']))
            {
                var div = document.createElement("div");
                div.className = "alert alert-success";
                div.role = "alert";
                var strong = document.createElement("h4");
                strong.textContent = "Score : " + value;
                div.appendChild(strong);
                responseBody.appendChild(div);
                responseBody.appendChild(document.createElement("br"));
            }

            for (const [key1, value1] of Object.entries(res['response']))
            {
                for (const [key, value] of Object.entries(value1))
                {
                    //console.log(key,value);

                    var label = document.createElement("label");
                    label.className = "control-label";
                    label.textContent = key;
                    responseBody.appendChild(label);
                    if(value.includes("Correct is : "))
                    {
                        var div = document.createElement("div");
                        div.className = "alert alert-danger";
                        div.role = "alert";
                        div.textContent = value;
                        responseBody.appendChild(div);
                    }
                    else
                    {
                        var div = document.createElement("div");
                        div.className = "alert alert-success";
                        div.role = "alert";
                        div.textContent = value;
                        responseBody.appendChild(div);
                    }
                    responseBody.appendChild(document.createElement("br"));
                }
            }
        },

        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });

}, false);
</script>


<button style="display:none" id="responseToogler" type="button" data-target="#response" data-toggle="modal"></button>
<!--  Response Popup      -->
<div class="modal fade modal-cuz" id="response" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group" id="responseBody">

                        </div>
                        <a href='/student/{{request()->route('courseId')}}' class="btn btn-primary  btn-lg" type="button" >Next</a>
                </div>
            </div>
        </div>
</div>

@endsection
