@extends('layouts.claplayout')
@section('content')
<section id="main" class="page-register">
    <div class="container">
        <div class="main">
            <div class="area-content">
                <h1 class="h-title">Reset Password</h1>
                <div class="row">
                    <div class="col-md-12">
                        <form class="sp-form" id="register-form-1" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label>Email address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @if ($errors->has('email'))
                                    <div class="alert alert-danger error-message" style="display:block" id="error-name">{{ $errors->first('email') }}</div>
                                @else
                                    <div class="alert alert-danger error-message" id="error-name"></div>
                                @endif
                            </div>


                            <div class="form-group">
                                <label>Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @if ($errors->has('password'))
                                    <div class="alert alert-danger error-message" style="display:block" id="error-name">{{ $errors->first('password') }}</div>
                                @else
                                    <div class="alert alert-danger error-message" id="error-name"></div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <select required class="form-control" name="role">
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="principal">Principal</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-lg btn-block btn-success mt20">{{ __('Reset Password') }}</button>
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
