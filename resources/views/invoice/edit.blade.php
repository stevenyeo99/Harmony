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
                    {!! Form::open(array('url' => route('manage.invoice.update', $invoiceObj->invc_id), 'method' => 'POST', 'id' => 'frm'))  !!}
                        <div class="form-group form-inline">
                            {{ Form::label('invoice_no', 'Transaksi no :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('invoice_no', $invoiceNo, array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
                            </div>

                            {{ Form::label('invoice_datetime', 'Tanggal Transaksi :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('invoice_datetime', \Carbon\Carbon::parse($invoiceObj->invoice_datetime)->format('Y-m-d'), array('id' => 'txtInvoiceDateTime', 'class' => 'form-control w-100', 'readonly' => true)) }}
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

                                    <tbody>
                                        @foreach ($invoiceObj->hsInvoiceDetail as $itemDetail)
                                            <tr>
                                                <td style="text-align: right;"></td>
                                                <td class="text-center">
                                                    <select class='ddlChosen'>
                                                        <option value = ''>-- Pilih Item --</option>
                                                        @foreach ($hsItemDetailData as $itdt)
                                                            <option value = '{{ $itdt->itdt_id }}'
                                                                @if(isset($itemDetail->itdt_id))
                                                                    @if ($itemDetail->itdt_id == $itdt->itdt_id)
                                                                        selected
                                                                    @endif
                                                                @endif
                                                            >
                                                                {{ $itdt->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class='text-center'><input type='text' class='form-control amountPercentInput harmonyAmountInput txtItemQuantity' value='{{ number_format($itemDetail->quantity, 2) }}' onkeypress='return isNumberPercentage(event, $(this))'></td>
                                                <td class='text-center'><input type='text' class='form-control amountPercentInput' value='{{ number_format($itemDetail->price, 2) }}' readonly></td>
                                                <td class='text-center'><input type='text' class='form-control amountPercentInput' value='{{ number_format($itemDetail->sub_total, 2) }}' readonly></td>
                                                <td class='text-center' style='width: 5%;'><img class='deleteItemRow' src='/img/delete.png' style='cursor: pointer; width: 2rem; height: 2rem;' onclick='deleteRowInvoiceItemDetail($(this))'></td>
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

                                            <th>
                                                
                                            </th>
                                        </tr>

                                        <tr role="row">
                                            <th class="text-right" colspan="4">
                                                Bayar
                                            </th>

                                            <th>
                                                {{ Form::text('paid_amt', $invoiceObj->paid_amt, array('id' => 'paid_amt', 'class' => 'w-100 form-control text-filter amountPercentInput harmonyAmountInput', 'maxlength' => '38', 'onkeypress' => 'return isNumberPlusComma(event, $(this))')) }}
                                            </th>

                                            <th></th>
                                        </tr>

                                        <tr role="row">
                                            <th class="text-right" colspan="4">
                                                Kembalian
                                            </th>

                                            <th>
                                                {{ Form::text('return_amt', $invoiceObj->return_amt, array('id' => 'return_amt', 'class' => 'w-100 form-control text-filter amountPercentInput', 'readonly' => true)) }}
                                            </th>

                                            <th>
                                                <input type="hidden" id="txtIsProcess" name="txtIsProcess" value="false" readonly>
                                            </th>   
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="form-group form-inline text-right">
                            <div class="col-sm-12">
                                <!-- <a href="{{ route('manage.invoice.receiptPage', $invoiceObj->invc_id) }}" class='btn btn-danger'>Demo Receipt</a> -->
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