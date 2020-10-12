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
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table table-bordered hover compact dtTable" id="dtManageItemStock">
                            <thead>
                                <tr>
                                    <th class="text-center bg-primary text-white" colspan="6">
                                        <a href="{!! route('manage.item.detail.editStock', $itemId) !!}" class="btn btn-success float-right">
                                            <i class="fa fa-cog"></i> Atur
                                        </a>
                                    </th>
                                </tr>

                                <tr role="row">
                                    <th class="text-center bg-primary text-white">Sebelum</th>
                                    <th class="text-center bg-primary text-white">+/-</th>
                                    <th class="text-center bg-primary text-white">Sesudah</th>
                                    <th class="text-center bg-primary text-white">Alasan</th>
                                    <th class="text-center bg-primary text-white">Diubah</th>
                                    <th class="text-center bg-primary text-white">Log</th>
                                </tr>

                                <tr role="row" class="filter">
                                    <td class="bg-primary text-white"></td>
                                    <td class="bg-primary text-white"></td>
                                    <td class="bg-primary text-white"></td>
                                    <td class="bg-primary text-white">
                                        {{ Form::text('description', null, array('class' => 'w-100 form-control text-filter', 'data-column' => '3')) }}
                                    </td>
                                    <td class="bg-primary text-white">
                                        {{ Form::text('user_name', null, array('class' => 'w-100 form-control text-filter', 'data-column' => '4')) }}
                                    </td>
                                    <td class="bg-primary text-white">
                                        {{ Form::text('log', null, array('id' => 'log', 'class' => 'w-100 form-control text-filter', 'data-column' => '5', 'readonly' => 'true', 'style' => 'text-align: center;')) }}
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
            initializeManageItemStockDatatable();
            initializeDatePicker();
        });

        function initializeDatePicker() {
            $('#log').datepicker({
                dateFormat: 'yy-mm-dd',
            });
        }

        function initializeManageItemStockDatatable() {
            let dtTable = $('#dtManageItemStock').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: '{!! route('manage.item.detail.listStock', $itemId) !!}',
                columns: [
                    { data: 'before', name: 'before' },
                    { data: 'transaction', name: 'transaction' },
                    { data: 'after', name: 'after' },
                    { data: 'description', name: 'description' },
                    { data: 'editBy', name: 'editBy' },
                    { data: 'log', name: 'log' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'dt-body-right',
                    },
                    {
                        targets: 1,
                        className: 'dt-body-center',
                    },
                    {
                        targets: 2,
                        className: 'dt-body-right',
                    },
                    {
                        targets: 5,
                        className: 'dt-body-center',
                    }
                ],
                responsive: true,
                language: {
                    'url': '/assets/json/datatable-id-lang.json'
                }
            });

            $('input.text-filter').on('keyup change', function(e) {
                var i = $(this).attr('data-column');
                var v = $(this).val();
                if (e.keyCode == 27) {
                    $(this).val('');
                    v = '';
                }
                dtTable.column(i).search(v).draw();
            });
        }
    </script>
@endpush