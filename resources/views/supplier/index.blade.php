@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a href="{!! route('manage.supplier.create') !!}" class="btn btn-success float-right">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-bordered hover compact dtTable" id="dtManageSupplier">
                                <thead>
                                    @if ($count > 0)
                                        <tr>
                                            <th class="text-center bg-primary text-white" colspan="5">
                                                <a href="{!! route('manage.supplier.exportSupplierReport') !!}" class="btn btn-light float-right">
                                                    <i class="fa fa-file-alt"></i> Cetak
                                                </a>
                                            </th>
                                        </tr>
                                    @endif

                                    <tr role="row">
                                        <th class="text-center bg-primary text-white">Kode</th>
                                        <th class="text-center bg-primary text-white">Nama</th>
                                        <th class="text-center bg-primary text-white">Email</th>
                                        <th class="text-center bg-primary text-white">Status</th>
                                        <th class="text-center bg-primary text-white">Aksi</th>
                                    </tr>

                                    <tr role="row" class="filter">
                                        <td class="bg-primary text-white">
                                            {{ Form::text('code', null, array('class' => 'w-100 form-control text-filter', 'data-column' => '0')) }}
                                        </td>

                                        <td class="bg-primary text-white">
                                            {{ Form::text('name', null, array('class' => 'w-100 form-control text-filter', 'data-column' => '1')) }}
                                        </td>

                                        <td class="bg-primary text-white">
                                            {{ Form::text('email', null, array('class' => 'w-100 form-control text-white', 'data-column' => '2')) }}
                                        </td>

                                        <td class="bg-primary text-white">
                                            {{ Form::select('status', $ddlStatus, null, array('class' => 'w-100 form-control select-filter', 'data-column' => '3')) }}
                                        </td>

                                        <td class="bg-primary text-white"></td>
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
            initializeManageSupplierDatatable();
        });

        function initializeManageSupplierDatatable() {
            let dtTable = $('#dtManageSupplier').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: '{!! route('manage.supplier.list') !!}',
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'status', name: 'status '},
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '20%'}
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

            $('select.select-filter').on('change', function() {
                var i = $(this).attr('data-column');
                var v = $(this).val();
                dtTable.column(i).search(v).draw();
            });

            // by default search active first when first enter
            dtTable.column(3).search("ACTIVE").draw();
        }
    </script>
@endpush