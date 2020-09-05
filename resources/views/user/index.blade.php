@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                        <a href="{!! route('manage.user.create') !!}" class="btn btn-success float-right"><i class="fa fa-plus"></i> Tambah</a>
                </div>

                <div class="card-body">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-bordered hover compact dtTable" id="dtManageUser">
                                <thead>
                                    <tr role="row">
                                        <!-- <th>No.</th> -->
                                        <th class="text-center bg-primary text-white">User Name</th>
                                        <th class="text-center bg-primary text-white">Email</th>
                                        <th class="text-center bg-primary text-white">Status</th>
                                        <th class="text-center bg-primary text-white">Aksi</th>
                                    </tr>

                                    <tr role="row" class="filter">
                                        <td class="bg-primary text-white">
                                            {{ Form::text('user_name', null, array('class' => 'w-100 form-control text-filter', 'data-column' => '0')) }}
                                        </td>

                                        <td class="bg-primary text-white">
                                            {{ Form::text('email', null, array('class' => 'w-100 form-control text-filter', 'data-column' => '1')) }}
                                        </td>

                                        <td class="bg-primary text-white">
                                            {{ Form::select('status', $ddlStatus, null, array('class' => 'w-100 form-control select-filter', 'data-column' => '2')) }}
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
            initializeManageUserDatatable();
        });

        function initializeManageUserDatatable() {
            let dtTable = $('#dtManageUser').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: '{!! route('manage.user.list') !!}',
                columns: [
                    { data: 'user_name', name: 'user_name' },
                    { data: 'email', name: 'email' },
                    { data: 'status', name: 'status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '20%' }
                ],
                responsive: true,
                // columnDefs : [
                //     {
                //         targets: 0,
                //         className: 'dt-body-right'
                //     }
                // ],
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
            dtTable.column(2).search("ACTIVE").draw();
        }
    </script>
@endpush