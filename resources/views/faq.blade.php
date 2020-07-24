@extends('layouts.claplayout')

@section('content')
<section id="main" class="page-info page-faq">
    <div class="container">
        <div class="main">
            <h1 class="h-title">FAQ</h1>
            <p>This is a short list of our most frequently asked questions. For more information about VidCloud, or if you need support, please visit our <a class="highlight" href="contact.html" title="">contact page</a></p>
            <div class="content-faq mt10 mb10">
                <div class="faq-div">
                    <ul aria-multiselectable="true" role="tablist" id="accordion" class="panel-group faq-ul">
                        <li class="panel">
                            <a href="#faq1" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>1</span><h3>What is VidCloud?</h3></a>
                            <div role="tabpanel" class="panel-collapse faq-li-content collapse" id="faq1" aria-expanded="false" style="height: 0px;">
                                <p>VidCloud is a free Video Storage/Sharing/Streaming service.</p>
                            </div>
                        </li>
                        <li class="panel">
                            <a href="#faq2" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>2</span><h3>What types of files are supported?</h3></a>
                            <div role="tabpanel" class="panel-collapse collapse faq-li-content" id="faq2" aria-expanded="false">
                                <p>We support most media files types (avi, mkv, mpg, mpeg, vob, wmv, flv, mp4, mov, m2v, divx, xvid, webm, ogv, ogg, rmvb)</p>
                            </div>
                        </li>
                        <li class="panel">
                            <a href="#faq3" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>3</span><h3>What is streamable?</h3></a>
                            <div role="tabpanel" class="panel-collapse collapse faq-li-content" id="faq3" aria-expanded="false">
                                <p>Any video file that can be converted into a high quality streamable video
                                </p>
                                <ul>
                                    <li>avi, mp4, mkv, 3gp, mov, mpeg, mpg, xvid, flv, divx</li>
                                </ul>
                                <p></p>
                            </div>
                        </li>
                        <li class="panel">
                            <a href="#faq4" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>4</span><h3>Streamable file size</h3></a>
                            <div role="tabpanel" class="panel-collapse collapse faq-li-content" id="faq4" aria-expanded="false">
                                <p>Maximum streamable file size is 1GB, you can upload files up to 10GB and make them streamable if you let us convert them</p>
                            </div>
                        </li>
                        <li class="panel">
                            <a href="#faq5" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>5</span><h3>Download and stream speed limits</h3></a>
                            <div role="tabpanel" class="panel-collapse collapse faq-li-content" id="faq5" aria-expanded="false">
                                <p>There are no download and stream speed limits at the moment</p>
                            </div>
                        </li>
                        <li class="panel">
                            <a href="#faq6" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>6</span><h3>How long do you host my files</h3></a>
                            <div role="tabpanel" class="panel-collapse collapse faq-li-content" id="faq6" aria-expanded="false">
                                <p>Files are hosted forever unless they are inactive. Inactive files are removed after 60 days.</p>
                            </div>
                        </li>
                        <li class="panel">
                            <a href="#faq7" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>7</span><h3>What kind of files aren't allowed? </h3></a>
                            <div role="tabpanel" class="panel-collapse collapse faq-li-content" id="faq7" aria-expanded="false">
                                <p>We do not allow the upload of copyrighted content. Please read our terms and conditions and copyright policy, if you are looking to report abusive content, please use the report abuse form. </p>
                            </div>
                        </li>
                        <li class="panel">
                            <a href="#faq8" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>8</span><h3>Do you have a privacy policy? </h3></a>
                            <div role="tabpanel" class="panel-collapse collapse faq-li-content" id="faq8" aria-expanded="false">
                                <p>We highly respect your privacy and will never forward your data to 3rd party services, for more information please visit our <a href="terms.html">terms and conditions</a>.</p>
                            </div>
                        </li>
                        <li class="panel">
                            <a href="#faq9" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>9</span><h3>Do you accept Adult content? </h3></a>
                            <div role="tabpanel" class="panel-collapse collapse faq-li-content" id="faq9" aria-expanded="false">
                                <p>No, we do not accept adult content.</p>
                            </div>
                        </li>
                        <li class="panel">
                            <a href="#faq10" data-parent="#accordion" data-toggle="collapse" class="faq-li collapsed" aria-expanded="false"><span>10</span><h3>Any information I should know about making money by sharing my videos? </h3></a>
                            <div role="tabpanel" class="panel-collapse collapse faq-li-content" id="faq10" aria-expanded="false">
                                <p>- All Tier rates are listed for 10 000 views and downloads (embeds views are counted too)</p>
                                <p>- Views and downloads are counted 1 time every 24 hours per 1 IP</p>
                                <p>- When advertisment is blocked, views are not counted</p>
                                <p>- The minimum payout amount is $5 USD</p>
                                <p>- Payment methods : Webmoney, ETH, Bitcoin, Skrill, Perfect Money</p>
                                <p>- Requested payouts are processed within 24 hours</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
