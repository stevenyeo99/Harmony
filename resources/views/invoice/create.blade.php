@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a id="previousUrlModule" href="{!! route('manage.invoice') !!}" class="btn-info btn-sm btn float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>

                <div class="card-body">
                    {!! Form::open(array('url' => route('manage.invoice.create'), 'method' => 'POST', 'id' => 'frm')) !!}
                        @csrf
                        <div class="form-group form-inline">
                            {{ Form::label('invoice_no', 'Transaksi no :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('invoice_no', $invoiceNo, array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
                            </div>

                            {{ Form::label('invoice_datetime', 'Tanggal Transaksi :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('invoice_datetime', \Carbon\Carbon::parse(now())->format('Y-m-d'), array('id' => 'invoice_datetime', 'class' => 'form-control w-100', 'readonly' => true)) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            <div class="table-responsive">
                                <table class="table table-bordered hover compact" id="tableInvoiceDetail">
                                    <thead>
                                        <tr role="row">
                                            <th class="text-center bg-primary text-white" colspan="6">
                                                <img src="{{ url('/img/add.png') }}" id="addInvoiceItem" alt="add" style="width: 2rem; height: 2rem; cursor: pointer;">
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

                                    <tbody></tbody>

                                    <tfoot>
                                        <tr role="row">
                                            <th class="text-right" colspan="4">
                                                Sub-Total
                                            </th>

                                            <th>
                                                {{ Form::text('sub_total', null, array('id' => 'invoice_sub_total', 'class' => 'w-100 form-control text-filter amountPercentInput', 'readonly' => true)) }}
                                            </th>

                                            <th></th>
                                        </tr>

                                        <tr role="row">
                                            <th class="text-right" colspan="4">
                                                Bayar
                                            </th>

                                            <th>
                                                {{ Form::text('paid_amt', null, array('id' => 'paid_amt', 'class' => 'w-100 form-control text-filter amountPercentInput harmonyAmountInput', 'maxlength' => '38', 'onkeypress' => 'return isNumberPlusComma(event, $(this))')) }}
                                            </th>

                                            <th></th>
                                        </tr>

                                        <tr role="row">
                                            <th class="text-right" colspan="4">
                                                Kembalian
                                            </th>

                                            <th>
                                                {{ Form::text('return_amt', null, array('id' => 'return_amt', 'class' => 'w-100 form-control text-filter amountPercentInput', 'readonly' => true)) }}
                                            </th>

                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="form-group form-inline text-right">
                            <div class="col-sm-12">
                                {{ Form::button('Kembali', array('class' => 'btn btn-secondary', 'id' => 'btnBack', 'data-toggle' => 'modal', 'data-target' => '#backModal')) }}
                                {{ Form::button('Simpan', array('class' => 'btn btn-primary', 'id' => 'btnInvoiceSave', 'data-target' => '#confirmModal')) }}
                                {{ Form::button('Proses', array('class' => 'btn btn-primary glowing-button', 'id' => 'btnInvoiceProcess', 'data-target' => '#confirmModal')) }}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

