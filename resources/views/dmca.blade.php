@extends('layouts.claplayout')

@section('content')
<section id="main" class="page-info page-dmca">
    <div class="container">
        <form action="/dmca" method="POST">
            <input type="hidden" name="_token" value="f2S4YCdqzeqNrjTvqIUqHhQYLKxqxhK3On2CM9qa">
            <div class="main">
                <h1 class="h-title">DMCA</h1>
                <h3 class="other-title">Copyright infringement - Who is the copyright holder?</h3>
                <div class="pd-top mb20">
                    <div class="radio">
                        <label>
                            <input type="radio" name="user_type" value="the owner" checked> I am the owner of the infringing content
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="user_type" value="agent"> I am an agent, commissioned and allowed to file this takedown notice on behalf of the rightholder
                        </label>
                    </div>
                </div>
                <div class="pd-middle mt30">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Your full Legal Name</label>
                                <input class="form-control" name="name" type="text" value="" required="required" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input class="form-control" name="email" type="email" value="" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                <input class="form-control" name="address" type="text" value="" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Zip/Postal Code</label>
                                <input class="form-control" name="zip" value="" type="text" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Country</label>
                                <input class="form-control" name="country" value="" type="text" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">City</label>
                                <input class="form-control" name="city" value="" type="text" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Right holders Name or Company Name (if you are an agent)</label>
                                <input class="form-control" name="rightsholdername" value="" type="text" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Right holders Country (if you are an agent)</label>
                                <input class="form-control" name="rightsholdercountry" value="" type="text" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Your Company/Organisation</label>
                                <input class="form-control" name="company" value="" type="text" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Phone</label>
                                <input class="form-control" name="phone" value="" type="text" required="required">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Your Job Title / Position</label>
                                <input class="form-control" name="job" value="" type="text" required="required">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pd-bottom">
                    <div class="form-group">
                        <label class="control-label">URL/s where the allegedly infringing content was found</label>
                        <textarea class="form-control" name="urlfound" rows="6" required="required"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">URL/s of allegedly infringing content</label>
                        <textarea class="form-control" name="urlcontent" rows="6" required="required"></textarea>
                    </div>
                </div>
                <h3 class="other-title highlight">By checking the following box, I state that:</h3>
                <p class="pd-desc mb20">I am the owner, or an agent authorized to act on behalf of the owner of an exclusive right that is allegedly infringed. I have good faith belief that the use of the content in the manner complained of, is not authorized by the compyright owner, its agent, or the law. The information in this notification is accurate. This also means that each content type field contains corresponding information related to a single copyright infringement only. Otherwise it is possible that the notification is not going to be processed. I acknowledge that there may be adverse legal consequences for making false or bad faith allegations of copyright infringement by using this process. I understand that each affected user will be informed about this take down action. This also includes contact details you provide, upon the user's request.</p>
                <div class="form-group field-dmca-ownerconfirm">
                    <input name="ownerconfirm" value="0" type="hidden">
                    <input id="dmca-ownerconfirm" name="ownerconfirm" value="1" type="checkbox">
                    <label for="dmca-ownerconfirm"> I've read the above and confirm that the information provided are accurate.</label>
                </div>
                <div class="pd-button">
                    <button type="submit" class="btn btn-lg btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection
