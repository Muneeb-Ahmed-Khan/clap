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

            line_margin += 40;

            if(line_margin >= 250)
            {
                doc.addPage();
                line_margin = 20
            }
        }
        
        doc.save('Document.pdf');
    }

</script>

<div id="main" class="main-padding main-dashboard extend">



    <div class="col-lg-custom">
        <div class="main-card mb-3 card" style="flex-direction: row;">
            <div class="card-body">
                <h6 class="card-title" style="text-align:right; color:#008623">Score : {{ json_decode($data[0]->data,true)['score'][0] }}</h6>

                @foreach($data as $d)
                    @foreach(json_decode($d->data,true)['response'] as $item)
                        
                        @foreach($item as $key => $value)
                            <div style=" margin: 20px; border-bottom: 1px solid; ">
                                <label>{{__($key)}}</label>
                                <p>{{__($value)}}</p>
                            </div>
                        @endforeach

                    @endforeach
                @endforeach

            </div>
        </div>
    </div>


</div>

@endsection
