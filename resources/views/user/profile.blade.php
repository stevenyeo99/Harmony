@extends('layouts.master')

@section('content')
{!! Html::script('js/profile/profile.js') !!}
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                {{ $title }}
            </div>

            <div class="card-body">
                {{ Form::open(array('url' => route('manage.user.save_profile'), 'method' => 'POST', 'id' => 'frm')) }}
                    @csrf
                    <div class="form-group form-inline">
                        {{ Form::label('user_name', 'User Name :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                        <div class="col-sm-10 pl-0">
                            {{ Form::text('user_name', Auth::guard()->user()->user_name, array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('email', 'Email :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                        <div class="col-sm-10 pl-0">
                            {{ Form::text('email', Auth::guard()->user()->email, array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('phone', 'Phone :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                        <div class="col-sm-10 pl-0">
                            {{ Form::text('phone', Auth::guard()->user()->phone, array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                        </div>
                    </div>
                    
                    <div class="form-group form-inline">
                        {{ Form::label('password', 'Password :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                        <div class="col-sm-10 pl-0">
                            {{ Form::password('password', array('class' => 'form-control w-100', 'maxlength' => '15')) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('password_confirmation', 'Konfirmasi Password :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                        <div class="col-sm-10 pl-0">
                            {{ Form::password('password_confirmation', array('class' => 'form-control w-100', 'maxlength' => '15')) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        <div>
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                    </div>

                    <hr>

                    <div class="form-group form-inline text-right">
                        <div class="col-sm-12">
                            {{ Form::button('Back', array('class' => 'btn btn-secondary', 'id' => 'btnBack', 'data-toggle' => 'modal', 'data-target' => '#backModal')) }}
                            {{ Form::button('Save', array('class' => 'btn btn-primary', 'id' => 'btnSave', 'data-toggle' => 'modal', 'data-target' => '#confirmModal')) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection