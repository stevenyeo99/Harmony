@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a id="previousUrlModule" href="{!! route('manage.item.detail') !!}" class="btn-info btn-sm btn float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>

                <div class="card-body">
                    <div class="form-group form-inline">
                        {{ Form::label('name', 'Nama<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}
                        
                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('name', $itemDetailObj->name, array('class' => 'form-control w-100', 'maxlength' => '50', 'readonly' => true)) }}
                        </div>

                        {{ Form::label('code', 'Kode :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('code', $itemDetailObj->code, array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('description', 'Deskripsi<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}
                        
                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('description', $itemDetailObj->description, array('class' => 'form-control w-100', 'maxlength' => '50', 'readonly' => true)) }}
                        </div>

                        {{ Form::label('splr_id', 'Supplier<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::select('splr_id', $listOfSupplier, $itemDetailObj->splr_id, array('class' => 'form-control w-100', 'disabled' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('itcg_id', 'Kategori<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::select('itcg_id', $listOfItemCategory, $itemDetailObj->itcg_id, array('class' => 'form-control w-100', 'maxlength' => '20', 'disabled' => true)) }}
                        </div>

                        {{ Form::label('ituo_id', 'Jenis<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::select('ituo_id', $listOfItemUom, $itemDetailObj->itcg_id, array('class' => 'form-control w-100', 'maxlength' => '20', 'disabled' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('quantity', 'Kuantiti<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}
                        
                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('quantity', number_format($itemDetailObj->quantity, 0), array('id' => 'quantity', 'class' => 'form-control w-100 amountPercentInput harmonyAmountInput', 'maxlength' => '21', 'readonly' => true)) }}
                        </div>

                        {{ Form::label('price', 'Harga Beli<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('price', number_format($itemDetailObj->price, 2), array('id' => 'price', 'class' => 'form-control w-100 amountPercentInput harmonyAmountInput', 'maxlength' => '38', 'readonly' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('net_pct', 'Untung%<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}
                        
                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('net_pct', $itemDetailObj->net_pct, array('id' => 'net_pct', 'class' => 'form-control w-100 amountPercentInput harmonyAmountInput', 'maxlength' => '21', 'readonly' => true)) }}
                        </div>

                        {{ Form::label('net_price', 'Harga Jual<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('net_price', number_format($itemDetailObj->net_price, 2), array('id' => 'net_price', 'class' => 'form-control w-100 amountPercentInput harmonyAmountInput', 'maxlength' => '38', 'onkeypress' => 'return isNumberPlusComma(event, $(this))', 'placeholder' => '0.00', 'readonly' => true)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection