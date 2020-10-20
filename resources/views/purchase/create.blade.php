@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }} </span>

                    <a id="previousUrlModule" href="{!! route('manage.purchase') !!}" class="btn-info btn-sm btn float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>

                <div class="card-body">
                    {!! Form::open(array('url' => route('manage.purchase.store'), 'method' => 'POST', 'id' => 'frm')) !!}
                        @csrf
                        <div class="form-group form-inline">
                            {{ Form::label('po_no', 'PO :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('po_no', $poNo, array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
                            </div>

                            {{ Form::label('splr_id', 'Supplier :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::select('splr_id', $listOfSupplier, old('splr_id'), array('class' => 'form-control w-100')) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('purchase_datetime', 'Tanggal PO :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('purchase_datetime', old('purchase_datetime'), array('id' => 'purchase_datetime', 'class' => 'form-control w-100', 'readonly' => true)) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            <div class="table-responsive">
                                <table class="table table-bordered hover compact" id="tablePurchaseDetail">
                                    <thead>
                                        <tr role="row">
                                            <th class="text-center bg-primary text-white" colspan="6">
                                                <img src="{{ url('/img/add.png') }}" id="addItem" alt="add" style="width: 2rem; height: 2rem; cursor: pointer;">
                                            </th>
                                        </tr>

                                        <tr role="row">
                                            <th class="text-center bg-primary text-white" style="width: 5%;">No.</th>
                                            <th class="text-center bg-primary text-white">Item</th>
                                            <th class="text-center bg-primary text-white">Kuantiti</th>
                                            <th class="text-center bg-primary text-white">Harga</th>
                                            <th class="text-center bg-primary text-white" style="width: 20%;">Total</th>
                                            <th class="text-center bg-primary text-white"></th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>

                                    <tfoot>
                                        <tr role="row">
                                            <th class="text-right" colspan="4">
                                                Sub-Total
                                            </th>

                                            <th>
                                                {{ Form::text('sub_total', null, array('id' => 'sub_total', 'class' => 'w-100 form-control text-filter amountPercentInput', 'readonly' => true)) }}
                                            </th>

                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table> 
                            </div>
                        </div>

                        <div class="form-group form-inline text-right">
                            <div class="col-sm-12">
                                {{ Form::button('Back', array('class' => 'btn btn-secondary', 'id' => 'btnBack', 'data-toggle' => 'modal', 'data-target' => '#backModal')) }}
                                {{ Form::button('Save', array('class' => 'btn btn-primary', 'id' => 'btnSave', 'data-target' => '#confirmModal')) }}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection