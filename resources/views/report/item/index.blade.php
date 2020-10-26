@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>
                </div>

                <div class="card-body">
                    {{ Form::open(array('url' => route('manage.report.exportItemReport'), 'method' => 'POST', 'id' => 'frm')) }}

                    <div class="form-group form-inline">
                        {{ Form::label('date_from', 'Tanggal dari: ', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('date_from', old('date_from'), array('class' => 'form-control w-100', 'maxlength' => '50', 'readonly' => true)) }}
                        </div>

                        {{ Form::label('date_to', 'Tanggal ke: ', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('date_to', old('date_to'), array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
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