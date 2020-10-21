@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a id="previousUrlModule" href="{!! route('manage.purchase') !!}" class="btn-info btn-sm btn float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>

                <div class="card-body">
                    <div class="form-group form-inline">
                        {{ Form::label('po_no', 'PO :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('po_no', $purchaseObj->po_no ? $purchaseObj->po_no : $poNo, array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
                        </div>

                        {{ Form::label('splr_id', 'Supplier :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('supplier', $purchaseObj->hsSupplier->name, array('class' => 'form-control w-100', 'readonly' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('purchase_datetime', 'Tanggal PO :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('purchase_datetime', \Carbon\Carbon::parse($purchaseObj->purchase_datetime)->format('Y-m-d'), array('id' => 'view_date', 'class' => 'form-control w-100', 'readonly' => true)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection