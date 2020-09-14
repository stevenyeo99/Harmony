@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a href="{!! route('manage.item.unit.create') !!}" class="btn btn-success float-right">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection