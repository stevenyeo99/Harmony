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
                    <div class="form-group form-inline">
                        {{ Form::label('invoice_no', 'Transaksi no :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('invoice_no', $invoiceObj->invoice_no ? $invoiceObj->invoice_no : $invoiceNo, array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
                        </div>

                        {{ Form::label('invoice_datetime', 'Tanggal Transaksi :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('invoice_datetime', \Carbon\Carbon::parse($invoiceObj->invoice_datetime)->format('Y-m-d'), array('id' => 'invoice_datetime', 'class' => 'form-control w-100', 'readonly' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        <div class="table-responsive">
                            <table class="table table-bordered hover compact" id="tableInvoiceDetail">
                                <thead>
                                    <tr role="row">
                                        <th class="text-center bg-primary text-white" style="width: 5%;">No.</th>
                                        <th class="text-center bg-primary text-white">Item</th>
                                        <th class="text-center bg-primary text-white">Kuantiti</th>
                                        <th class="text-center bg-primary text-white">Harga</th>
                                        <th class="text-center bg-primary text-white" style="width: 20%;">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($invoiceObj->hsInvoiceDetail as $itemDetail)
                                        <tr>
                                            <td style="text-align: right;"></td>
                                            <td class='text-center'><input type='text' class='form-control' value='{{ $itemDetail->hsItemDetail->name }}' readonly></td>
                                            <td class='text-center'><input type='text' class='form-control amountPercentInput harmonyAmountInput txtItemQuantity' value='{{ number_format($itemDetail->quantity, 2) }}' readonly></td>
                                            <td class='text-center'><input type='text' class='form-control amountPercentInput' value='{{ number_format($itemDetail->price, 2) }}' readonly></td>
                                            <td class='text-center'><input type='text' class='form-control amountPercentInput' value='{{ number_format($itemDetail->sub_total, 2) }}' readonly></td>
                                        </tr>
                                   @endforeach
                                </tbody>

                                <tfoot>
                                    <tr role="row">
                                        <th class="text-right" colspan="4">
                                            Sub-Total
                                        </th>

                                        <th>
                                            {{ Form::text('sub_total', $invoiceObj->sub_total, array('id' => 'invoice_sub_total', 'class' => 'w-100 form-control text-filter amountPercentInput', 'readonly' => true)) }}
                                        </th>
                                    </tr>

                                    <tr role="row">
                                        <th class="text-right" colspan="4">
                                            Bayar
                                        </th>

                                        <th>
                                            {{ Form::text('paid_amt', $invoiceObj->paid_amt, array('id' => 'paid_amt', 'class' => 'w-100 form-control text-filter amountPercentInput harmonyAmountInput', 'maxlength' => '38', 'onkeypress' => 'return isNumberPlusComma(event, $(this))', 'readonly' => true)) }}
                                        </th>
                                    </tr>

                                    <tr role="row">
                                        <th class="text-right" colspan="4">
                                            Kembalian
                                        </th>

                                        <th>
                                            <input type="hidden" id="triggerPrint" value="{{ $triggerPrint }}" readonly>
                                            {{ Form::text('return_amt', $invoiceObj->return_amt, array('id' => 'return_amt', 'class' => 'w-100 form-control text-filter amountPercentInput', 'readonly' => true)) }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @if (isset($invoiceObj->invoice_no))
                        <div class="form-group form-inline text-right">
                            <div class="col-sm-12">
                                <button onclick="fnOpenPopUpWindow('View Receipt', '{{ route('manage.invoice.generateReceipt', $invoiceObj->invc_id) }}')" class='btn btn-success'>Lihat Struk</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection