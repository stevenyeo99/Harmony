@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a href="{!! route('manage.invoice.create') !!}" class="btn btn-success float-right">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-bordered hover compact dtTable" id="dtManageInvoice">
                                <thead>
                                    <tr role="row">
                                        <th class="text-center bg-primary text-white">Kode</th>
                                        <th class="text-center bg-primary text-white">Biaya</th>
                                        <th class="text-center bg-primary text-white">Tanggal Penjualan</th>
                                        <th class="text-center bg-primary text-white">Status</th>
                                        <th class="text-center bg-primary text-white">Aksi</th>
                                    </tr>

                                    <tr role="row" class="filter">
                                        <td class="bg-primary text-white">
                                            {{ Form::text('invoice_no', null, array('class' => 'w-100 form-control text-filter', 'data-column' => '0')) }}
                                        </td>

                                        <td class="bg-primary text-white"></td>

                                        <td class="bg-primary text-white">
                                            {{ Form::text('invoice_datetime', null, array('id' => 'invoice_datetime', 'class' => 'w-100 form-control date-filter', 'readonly' => true, 'data-column' => '2')) }}
                                        </td>

                                        <td class="bg-primary text-white">
                                            {{ Form::select('status', $ddlStatus, null, array('class' => 'w-100 form-control select-filter', 'data-column' => '3')) }}
                                        </td>

                                        <td class="bg-primary text-white">

                                        </td>
                                    </tr>
                                </thead>
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
            initializeDatePicker();
            initializeManageInvoiceDatatable();
        });

        function initializeDatePicker() {
            $('#invoice_datetime').datepicker({
                dateFormat: 'yy-mm-dd',
            });
        }

        function initializeManageInvoiceDatatable() {
            let dtTable = $('#dtManageInvoice').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: '{!! route('manage.invoice.list')  !!}',
                columns: [
                    { data : 'invoice_no', name: 'invoice_no' },
                    { data : 'sub_total', name: 'sub_total' },
                    { data : 'invoice_datetime', name: 'invoice_datetime' },
                    { data : 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '25%' },
                ],
                columnDefs: [
                    {
                        target: 1,
                        className: 'dt-body-right',
                    },
                    {
                        targets: 2,
                        className: 'dt-body-center',
                    }
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