@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a id="previousUrlModule" href="{!! route('manage.user') !!}" class="btn-info btn-sm btn float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>

                <div class="card-body">
                    {!! Form::open(array('url' => route('manage.user.create'), 'method' => 'POST', 'id' => 'frm')) !!}
                        @csrf
                        <div class="form-group form-inline">
                            {{ Form::label('user_name', 'User Name :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                            <div class="col-sm-10 pl-0">
                                {{ Form::text('user_name', old('user_name'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>                            
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('email', 'Email :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                            <div class="col-sm-10 pl-0">
                                {{ Form::text('email', old('email'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('phone', 'Phone :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                            <div class="col-sm-10 pl-0">
                                {{ Form::text('phone', old('phone'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('is_admin', 'Jabatan :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                            <div class="col-sm-10 pl-0">
                                {{ Form::select('is_admin', $ddlUserType, old('is_admin'), array('class' => 'form-control w-100', 'maxlength' => 15)) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('password', 'Password :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                            <div class="col-sm-10 pl-0">
                                {{ Form::password('password', array('class' => 'form-control w-100', 'maxlength' => 15)) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('password_confirmation', 'Konfirmasi Password :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                            <div class="col-sm-10 pl-0">
                                {{ Form::password('password_confirmation', array('class' => 'form-control w-100', 'maxlength' => 15)) }}
                            </div>
                        </div>

                        <div class="form-group form-inline text-right">
                            <div class="col-sm-12">
                                {{ Form::button('Back', array('class' => 'btn btn-secondary', 'id' => 'btnBack', 'data-toggle' => 'modal', 'data-target' => '#backModal')) }}
                                {{ Form::button('Save', array('class' => 'btn btn-primary', 'id' => 'btnSave', 'data-toggle' => 'modal', 'data-target' => '#confirmModal')) }}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection