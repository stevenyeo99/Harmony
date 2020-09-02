@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a href="{!! route('manage.user') !!}" class="btn-info btn-sm btn float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>

                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection