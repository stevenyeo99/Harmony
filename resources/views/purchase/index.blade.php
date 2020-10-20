@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <span>{{ $title }}</span>

                <a href="{!! route('manage.purchase.create') !!}" class="btn btn-success float-right">
                    <i class="fa fa-plus"></i> Tambah
                </a>
            </div>

            <div class="card-body">
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table table-bordered hover compact dtTable" id="dtManagePurchase">
                            <thead>
                                <tr role="row">
                                    <th class="text-center bg-primary text-white">Kode</th>
                                    <th class="text-center bg-primary text-white">Supplier</th>
                                    <th class="text-center bg-primary text-white">Total</th>
                                    <th class="text-center bg-primary text-white">Waktu Pembelian</th>
                                    <th class="text-center bg-primary text-white">Status</th>
                                    <th class="text-center bg-primary text-white">Aksi</th>
                                </tr>

                                <tr role="row" class="filter">
                                    <td class="bg-primary text-white">
                                        {{ Form::text('po_no', null, array('class' => 'w-100 form-control text-filter', 'data-column' => '0')) }}
                                    </td>

                                    <td class="bg-primary text-white">
                                        {{ Form::select('splr_id', $listOfSupplier, null, array('class' => 'w-100 form-control select-filter', 'data-column' => '1')) }}
                                    </td>

                                    <td class="bg-primary text-white">

                                    </td>

                                    <td class="bg-primary text-white">
                                        {{ Form::text('purchase_datetime', null, array('id' => 'purchase_datetime', 'class' => 'w-100 form-control date-filter', 'data-column' => '2', 'readonly' => true, 'style' => 'text-align: center;')) }}
                                    </td>

                                    <td class="bg-primary text-white">
                                        {{ Form::select('status', $ddlStatus, null, array('class' => 'w-100 form-control select-filter', 'data-column' => '3')) }}
                                    </td>

                                    <td class="bg-primary text-white">

                                    </td>
                                </tr>
                            </thead>

                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initializeManagePurchaseDatatable();
            initializeDatePicker();
        });

        function initializeDatePicker() {
            $('#purchase_datetime').datepicker({
                dateFormat: 'yy-mm-dd',
            });
        }

        function initializeManagePurchaseDatatable() {
            let dtTable = $('#dtManagePurchase').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: '{!! route('manage.purchase.list') !!}',
                columns: [
                    { data: 'po_no', name: 'po_no' },
                    { data: 'splr_id', name: 'splr_id' },
                    { data: 'sub_total', name: 'sub_total' },
                    { data: 'purchase_datetime', name: 'purchase_datetime' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '20%' },
                ],
                responsive: true,
                language: {
                    'url': '/assets/json/datatable-id-lang.json'
                }
            });

            $('input.text-filter').on('keyup', function() {
                var i = $(this).attr('data-column');
                var v = $(this).val();               
                dtTable.column(i).search(v).draw();
            });

            $('input.date-filter').on('keyup change', function(e) {
                var i = $(this).attr('data-column');
                var v = $(this).val();
                if (e.keyCode == 27) {
                    $(this).val('');
                    v = '';
                }
                dtTable.column(i).search(v).draw();
            });

            $('select.select-filter').on('change', function() {
                var i = $(this).attr('data-column');
                var v = $(this).val();
                dtTable.column(i).search(v).draw();
            });

            dtTable.column(3).search("ACTIVE").draw();
        }
    </script>
@endpush