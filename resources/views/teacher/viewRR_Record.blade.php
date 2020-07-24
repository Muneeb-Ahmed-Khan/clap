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

.msg_date{
    font-size: 10px;
    float: right;
    color: grey;
}
</style>

<script src="/js/jspdf.min.js"></script>
<script>
    function generatePDF() {
        var doc = new jsPDF();
        
        qs = $(".card-body")[0].querySelectorAll("div");
        line_margin = 20;
        for(var i = 0 ; i < qs.length; i++)
        {

            doc.setFont("helvetica");
            doc.setFontType("bold");
            doc.setFontSize(18);
            doc.text(20, line_margin, qs[i].querySelectorAll("label")[0].innerText);
            

            doc.setFont("courier");
            doc.setFontType("normal");
            doc.setFontSize(16);
            doc.text(20, line_margin + 10, qs[i].querySelectorAll("p")[0].innerText);

            doc.setFont("times");
            doc.setFontType("italic");
            doc.setFontSize(10);
            doc.text(20, line_margin + 20, qs[i].querySelectorAll("msg")[0].innerText);

            line_margin += 40;

            if(line_margin >= 250)
            {
                doc.addPage();
                line_margin = 20
            }
        }


        doc.addPage();
        
        // doc.setFont("helvetica");
        // doc.setFontType("bold");
        // doc.setFontSize(18);
        // doc.text(20, 'CHATS');

        qs = $(".chat-popup")[0].querySelectorAll("div");
        line_margin = 20;
        for(var i = 0 ; i < qs.length; i++)
        {

            doc.setFont("helvetica");
            doc.setFontType("normal");
            doc.setFontSize(16);
            doc.text(20, line_margin + 10, qs[i].querySelectorAll("p")[0].innerText);

            doc.setFont("times");
            doc.setFontType("italic");
            doc.setFontSize(10);
            doc.text(20, line_margin + 20, qs[i].querySelectorAll("msg")[0].innerText);
            
            line_margin += 30;

            if(line_margin >= 250)
            {
                doc.addPage();
                line_margin = 20
            }
        }
        
        // Save the PDF
        var sites = '{!! $chapters[0]->chapterName !!}';
        

        //Get the names
        @foreach(json_decode($chapters[0]->participants,true) as $item)
            sites += '-{{__($item[0])}}'
        @endforeach


        //Save the .pdf by name => Chaptername-User1-...UserN.pdf
        doc.save(sites + '.pdf');
    }

</script>

<div id="main" class="main-padding main-dashboard extend">



    <div class="col-lg-custom">
        <div class="main-card mb-3 card" style="flex-direction: row;">
            <div class="card-body"  style=" width: 65%;">
                @foreach($chapters as $chapter)
                    @foreach(json_decode($chapter->data,true) as $item)
                            <div style=" margin: 20px; border-bottom: 1px solid; ">
                                <label>{{__($item['question'])}}</label>
                                <msg class="msg_date">{{__($item['answer-owner-name'])}}</msg>
                                <p>{{__($item['answer'])}}</p>
                            </div>
                        @endforeach
                @endforeach

            </div>

            <div class="chat-popup" id="chatBox" style="width: 30%; margin-top:20px; margin-right:10px; margin-bottom:10px; display: flex; flex-flow: column;">
                @foreach($chapters as $chapter)
                    @foreach(json_decode($chapter->messages,true) as $item)
                        <div style=" margin: 20px; border-bottom: 1px solid; ">
                            <msg class="msg_date">{{__($item['msg-timestamp'])}}</msg>
                            <p>{{__($item['message'])}}</p>
                        </div>
                    @endforeach
                @endforeach

            </div>
            
        </div>
        <div id="elementH"></div>
        <button id="next_RR" class="btn btn-success" onclick="generatePDF();" style="margin:10px; float:right">Download</button>
    </div>


</div>

@endsection
