@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <span>{{ $title }}</span>
                    
                <a href="{!! route('manage.item.detail.create') !!}" class="btn btn-success float-right">
                    <i class="fa fa-plus"></i> Tambah
                </a>
            </div>

            <div class="card-body">
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table table-bordered hover compact dtTable" id="dtManageItemDetail">
                            <thead>
                                @if ($count > 0)
                                    <tr>
                                        <th class="text-center bg-primary text-white" colspan="6">
                                            <a href="{!! route('manage.item.detail.exportItemReport') !!}" class="btn btn-light float-right">
                                                <i class="fa fa-file-alt"></i> Cetak
                                            </a>
                                        </th>
                                    </tr>
                                @endif

                                <tr role="row">
                                    <th class="text-center bg-primary text-white">Kode</th>
                                    <th class="text-center bg-primary text-white">Nama</th>
                                    <th class="text-center bg-primary text-white">Supplier</th>
                                    <th class="text-center bg-primary text-white">Kategori</th>
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
                                        {{ Form::select('splr_id', $listOfSupplier, null, array('id' => 'splr_id', 'class' => 'w-100 form-control select-filter', 'data-column' => '2')) }}
                                    </td>

                                    <td class="bg-primary text-white">
                                        {{ Form::select('itcg_id', $listOfItemCategory, null, array('id' => 'itcg_id', 'class' => 'w-100 form-control select-filter', 'data-column' => '3')) }}
                                    </td>

                                    <td class="bg-primary text-white">
                                        {{ Form::select('status', $ddlStatus, null, array('class' => 'w-100 form-control select-filter', 'data-column' => '4')) }}
                                    </td>

                                    <td class="bg-primary text-white"></td> 
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
            initializeManageItemDetailDatatable();
        });

        function initializeManageItemDetailDatatable() {
            let dtTable = $('#dtManageItemDetail').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: '{!! route('manage.item.detail.list') !!}',
                columns: [
                    { data: 'code', name: 'code', width: '10%' },
                    { data: 'name', name: 'name', width: '20%' },
                    { data: 'splr_id', name: 'splr_id', width: '12%' },
                    { data: 'itcg_id', name: 'itcg_id', width: '10%' },
                    { data: 'status', name: 'status', width: '10%' },
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

            $('select.select-filter').on('change', function() {
                var i = $(this).attr('data-column');
                var v = $(this).val();
                dtTable.column(i).search(v).draw();
            });

            // by default search active first when first enter
            dtTable.column(2).search($('#splr_id').children('option:selected').val()).draw();
            dtTable.column(3).search($('#itcg_id').children('option:selected').val()).draw();
            dtTable.column(4).search("ACTIVE").draw();
        }
    </script>
@endpush