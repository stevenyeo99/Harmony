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
                            <table class="table table-bordered hover compact" id="dtManageUser">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
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
            $('#dtManageUser').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('manage.user.list') !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '5%'},
                    { data: 'user_name', name: 'user_name' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '20%' }
                ],
                responsive: true,
                columnDefs : [
                    {
                        targets: 0,
                        className: 'dt-body-right'
                    }
                ]
            });
        }
    </script>
@endpush