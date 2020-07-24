@extends('layouts.claplayout')

@section('content')
<section id="main" class="page-register">
    <div class="container">
        <div class="main">
            <div class="area-content">
                <h1 class="h-title">Reset Password</h1>
                <div class="row">
                    <div class="col-md-12">
                                @if ($errors->has('success'))
                                    <div class="alert alert-danger error-message" style="display:block;background:#51b74f" id="error-name">{{ $errors->first('success') }}</div>
                                @else
                                    <div class="alert alert-danger error-message" id="error-name"></div>
                                @endif
                        <form class="sp-form" id="register-form-1" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            @if (session()->has('status'))
                            <div class="alert alert-danger error-message" style="display:block;background:#51b74f" id="error-name">Email Sent</div>
                            @else
                                <div class="alert alert-danger error-message" id="error-name"></div>
                            @endif

                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" class="form-control" placeholder="Email address" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger error-message" style="display:block" id="error-name">{{ $errors->first('email') }}</div>
                                @else
                                    <div class="alert alert-danger error-message" id="error-name"></div>
                                @endif
                            </div>
                            <div class="form-group">
                                <select required class="form-control" name="role">
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="principal">Principal</option>
                                </select>
                            </div>
                            <button id="register-submit" type="submit" class="btn btn-lg btn-block btn-success mt20">{{ __('Send Password Reset Link') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="area-note">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
@endsection
