@extends('layouts.claplayout')

@section('content')

<section id="main" class="page-info page-contact">
    <div class="container">
        <div class="main">
            <h1 class="h-title">Contact</h1>
            <div class="row">
                <div class="col-md-6 contact-form">
                    <p class="mb20">If you have business inquiries or other questions, please fill out the following form to contact us. Thank you. </p>
                    <div class="alert alert-grey">Please use this page (<a href="dmca.html" title="DMCA">link</a>) for DMCA report. Submitting DMCA report using this contact form will not be solved.</div>
                    <form class="sp-form" method="POST" action="https://CLAP.co/store_ticket">
                        <input type="hidden" name="_token" value="f2S4YCdqzeqNrjTvqIUqHhQYLKxqxhK3On2CM9qa">
                        <div class="form-group">
                            <label for="name-input">Name</label>
                            <input type="name" class="form-control" id="name-input" placeholder="Your name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email-input">Email</label>
                            <input type="email" class="form-control" id="email-input" placeholder="Your email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject-input">Subject</label>
                            <input type="text" class="form-control" id="subject-input" placeholder="Subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="body-input">Body</label>
                            <textarea rows="5" class="form-control" style="height: auto;" name="content" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="captcha-input">Captcha</label>
                            <div class="g-recaptcha" data-sitekey="6LfTa1UUAAAAAOHBYN1DumaZ07ouHyrtcySPxV_7"></div>
                        </div>
                        <button type="submit" class="btn btn-lg btn-success mt20">Send</button>
                    </form>
                </div>
                <div class="col-md-6 contact-info">
                    <div class="ci-content" style="display: inline-block; background: #FFCA00; padding: 20px; margin-left: 100px;">
                        <div class="block ci-block mb10"><i class="icon-mail mr10"></i>g.p.m.leenders@gmail.com</div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>

@endsection
