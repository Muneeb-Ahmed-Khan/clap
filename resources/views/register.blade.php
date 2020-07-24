@extends('layouts.claplayout')

@section('content')
<section id="main" class="page-register">
    <div class="container">
        <div class="main">
            <div class="area-content">
                <h1 class="h-title">Create an account</h1>
                <div class="row">
                    <div class="col-md-12">
                                @if ($errors->has('success'))
                                    <div class="alert alert-danger error-message" style="display:block;background:#51b74f" id="error-name">{{ $errors->first('success') }}</div>
                                @else
                                    <div class="alert alert-danger error-message" id="error-name"></div>
                                @endif
                        <form class="sp-form" id="register-form-1" method="POST" action="{{ url('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name-input">Full Name</label>
                                <input type="text" class="form-control" id="name-input" placeholder="Full name" name="name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger error-message" style="display:block" id="error-name">{{ $errors->first('name') }}</div>
                                @else
                                    <div class="alert alert-danger error-message" id="error-name"></div>
                                @endif

                            </div>
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
                                <label for="passwird-input">Password</label>
                                <input type="password" class="form-control" id="password-input" placeholder="Password" name="password" required>
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger error-message" style="display:block" id="error-name">{{ $errors->first('password') }}</div>
                                @else
                                    <div class="alert alert-danger error-message" id="error-name"></div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password-input-cf">Confirm password</label>
                                <input type="password" class="form-control" id="password-input-cf" placeholder="Confirm password" name="password_confirmation" required>
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger error-message" style="display:block" id="error-name">{{ $errors->first('password') }}</div>
                                @else
                                    <div class="alert alert-danger error-message" id="error-name"></div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name-input">Role</label>
                                <select id="role-register" required class="form-control" name="role">
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="principal">Principal</option>
                                </select>
                            </div>
                            <div class="checkbox mt20">
                                <label>
                                    <input type="checkbox" name="checkbox" value="1" required> I agree to <a href="/terms" title="CLAP's terms and conditions">CLAP's terms and conditions</a>
                                </label>
                            </div>
                            <button id="register-submit" type="submit" class="btn btn-lg btn-block btn-success mt20">Register</button>
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
