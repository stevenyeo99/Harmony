@extends('layouts.auth')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-10">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-reset-image"></div>
                            
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
                                    </div>

                                    <form action="{{ route('password.request') }}" method="POST" class="user">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="example@gmail.com" max="50" value="{{ $email ?? old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="text-danger text-xs">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="******************" max="50">
                                            @if ($errors->has('password'))
                                                <span class="text-danger text-xs">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password-confirm" name="password_confirmation" placeholder="******************" max="50">
                                        </div>

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Reset">

                                        <hr>

                                        <div class="text-center">
                                            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection