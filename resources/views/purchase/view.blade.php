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

                    <div class="form-group form-inline">
                        <div class="table-responsive">
                            <table class="table table-bordered hover compact" id="tablePurchaseDetail">
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
                                   @foreach ($purchaseObj->hsPurchaseDetail as $itemDetail)
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
                                            {{ Form::text('sub_total', $purchaseObj->sub_total, array('id' => 'sub_total', 'class' => 'w-100 form-control text-filter amountPercentInput', 'readonly' => true)) }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection