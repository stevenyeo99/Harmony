@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                {{ $title }}

                <a href="{!! route('manage.user') !!}" class="btn-info btn-sm btn float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>

            <div class="card-body">
                <div class="form-group form-inline">
                    {{ Form::label('user_name', 'User Name :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                    <div class="col-sm-10 pl-0">
                        {{ Form::text('user_name', $userObj->user_name, array('class' => 'form-control w-100', 'maxlength' => '50', 'readonly' => 'true')) }}
                    </div>
                </div>

                <div class="form-group form-inline">
                    {{ Form::label('email', 'Email :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                    <div class="col-sm-10 pl-0">
                        {{ Form::text('email', $userObj->email, array('class' => 'form-control w-100', 'maxlength' => '50', 'readonly' => 'true')) }}
                    </div>
                </div>

                <div class="form-group form-inline">
                    {{ Form::label('phone', 'Phone :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                    <div class="col-sm-10 pl-0">
                        {{ Form::text('phone', $userObj->phone, array('class' => 'form-control w-100', 'maxlength' => '50', 'readonly' => 'true')) }}
                    </div>
                </div>
                
                <div class="form-group form-inline">
                    {{ Form::label('status', 'Status :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                    <div class="col-sm-10 pl-0">
                        {{ Form::text('status', $userObj->status,  array('class' => 'form-control w-100', 'maxlength' => '15', 'readonly' => 'true')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection