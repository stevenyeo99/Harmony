@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-10">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Harmony System</h1>
                                    </div>

                                    <form action="{{ route('login') }}" method="POST" class="user">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="user_name" name="user_name" value="{{ old('user_name') }}" placeholder="Isi User Name..." max="50">
                                            @if ($errors->has('user_name'))
                                                <span class="text-danger text-xs">
                                                    <strong>{{ $errors->first('user_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="*********************" max="20">
                                            @if ($errors->has('user_name'))
                                                <span class="text-danger text-xs">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" {{ old('remember') ? 'checked' : '' }} class="custom-control-input" id="remember" name="remember">
                                                <label class="custom-control-label" for="remember">Ingat Saya</label>
                                            </div>
                                        </div>

                                        

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Login">
                                    </form>

                                    <hr>
                                    
                                    <div class="text-center">
                                        <a class="small" href="{{ route('password.request') }}">Lupa Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection