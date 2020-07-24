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
                {{-- <h6 class="card-title">Student's Table</h6> --}}
                    <div class="stepwizard">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button" class="btn btn-primary btn-circle activePage">1</a>
                                <p>Chapter</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                                <p>Animation</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                                <p>Quiz</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                                <p>Round Robin</p>
                            </div>
                        </div>
                    </div>
                    <form role="form"   method="post" action="{{ route('ManageNewChapter',$courseId ?? '') }}" enctype="multipart/form-data" >
                            @csrf
                            <div class="row setup-content" id="step-1">
                                <div class="col-xs-12">
                                    <div class="col-md-12" >
                                        <h3> Chapter Information</h3>
                                        <div class="form-group">
                                            <label class="control-label">Chapter Name</label>
                                            <input  maxlength="100" name="chapterName" type="text" required="required" class="form-control" placeholder="Enter Name"  />
                                        </div>
                                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content" id="step-2">
                                <div class="col-xs-12">
                                    <div class="col-md-12" >
                                        <h3> Animation</h3>
                                        <div class="form-group">
                                            <label class="control-label">Animation Title</label>
                                            <input  maxlength="100" name="animationTitle" type="text" required="required" class="form-control" placeholder="Enter Title"  />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Andimation File</label>
                                            <input name="upload[animation]" type="file" required="required" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Keynotes</label>
                                            <input name="animationKeyNotes" type="textarea" required="required" class="form-control" placeholder="Enter Keynotes" />
                                        </div>
                                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content" id="step-3">
                                <div class="col-xs-12">
                                    <div class="col-md-12" name="Quiz">
                                        <h3> Quiz</h3>
                                        <div class="form-group">
                                            <label class="control-label">Quiz File</label>
                                            <input name="upload[quiz]" type="file" required="required" class="form-control" />
                                        </div>
                                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content" id="step-4">
                                <div class="col-xs-12">
                                    <div class="col-md-12">
                                        <h3> Round Robin</h3>
                                        <div class="form-group">
                                            <label class="control-label">Round Robin</label>
                                            <input  name="upload[roundrobin]" type="file" required="required" class="form-control"/>
                                        </div>
                                        <button class="btn btn-success btn-lg pull-right" type="submit">Publish!</button>
                                    </div>
                                </div>
                            </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
