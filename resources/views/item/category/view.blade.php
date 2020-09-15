@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a id="previousUrlModule" href="{!! route('manage.item.category') !!}" class="btn-info btn-sm btn float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>

                <div class="card-body">
                    <div class="form-group form-inline">
                        {{ Form::label('code', 'Kode :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                        <div class="col-sm-10 pl-0">
                            {{ Form::text('code', $itemCategoryObj->code, array('class' => 'form-control w-100', 'maxlength' => '10', 'readonly' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('name', 'Nama :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                        <div class="col-sm-10 pl-0">
                            {{ Form::text('name', $itemCategoryObj->name, array('class' => 'form-control w-100', 'maxlength' => '50', 'readonly' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('description', 'Deskripsi :', array('class' => 'col-sm-2 d-inline-block pl-0')) }}

                        <div class="col-sm-10 pl-0">
                            {{ Form::text('description', $itemCategoryObj->code, array('class' => 'form-control w-100', 'maxlength' => '100', 'readonly' => true)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection