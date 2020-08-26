@extends('layouts.master')

@section('content')
<!-- start card display -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                {{ $title1 }}
            </div>

            <div class="card-body">

            </div>
        </div>
    </div>
</div>
<!-- end display card -->

<!-- start display diagram -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                {{ $title2 }}
            </div>
            
            <div class="card-body">
                
            </div>
        </div>
    </div>
</div>
<!-- end display diagram -->
@endsection
