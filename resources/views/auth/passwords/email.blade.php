@extends('layouts.auth')

@section('content')
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-10">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>

                            <div class="col-lg-6">
                                <div class="p-5">
                                    @if (session('status'))
                                        <div id="alert-message" class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Lupa Password Anda?</h1>
                                        <p class="mb-4">Tidak masalah, isi email pengguna anda dan kami akan mengirimkan reset password anda melalui email!</p>
                                    </div>

                                    <form class="user" method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" id="email" name="email" class="form-control form-control-user" placeholder="Isi Email Address..." required>
                                        </div>
                                        @if ($errors->has('email'))
                                            <span class="text-danger text-xs">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif

                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Reset Password">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">Sudah punya akun? Login!</a>
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