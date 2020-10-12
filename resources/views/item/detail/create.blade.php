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
                    {!! Form::open(array('url' => route('manage.item.detail.store'), 'method' => 'POST', 'id' => 'frm')) !!}
                    @csrf
                    <div class="form-group form-inline">
                        {{ Form::label('name', 'Nama<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}
                        
                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('name', old('name'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                        </div>

                        {{ Form::label('code', 'Kode :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('code', $code, array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('description', 'Deskripsi<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}
                        
                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('description', old('description'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                        </div>

                        {{ Form::label('splr_id', 'Supplier<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::select('splr_id', $listOfSupplier, old('splr_id'), array('class' => 'form-control w-100')) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('itcg_id', 'Kategori<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::select('itcg_id', $listOfItemCategory, old('itcg_id'), array('class' => 'form-control w-100', 'maxlength' => '20')) }}
                        </div>

                        {{ Form::label('ituo_id', 'Jenis<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::select('ituo_id', $listOfItemUom, old('ituo_id'), array('class' => 'form-control w-100', 'maxlength' => '20')) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('quantity', 'Kuantiti<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}
                        
                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('quantity', old('quantity') ?  old('quantity') : '1.00', array('id' => 'quantity', 'class' => 'form-control w-100 amountPercentInput harmonyAmountInput', 'maxlength' => '21', 'onkeypress' => 'return isNumberPlusComma(event, $(this))')) }}
                        </div>

                        {{ Form::label('price', 'Harga Beli<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('price', old('price') ?  old('price') : '0.00', array('id' => 'price', 'class' => 'form-control w-100 amountPercentInput harmonyAmountInput', 'maxlength' => '38', 'onkeypress' => 'return isNumberPlusComma(event, $(this))')) }}
                        </div>
                    </div>

                    <div class="form-group form-inline">
                        {{ Form::label('net_pct', 'Untung%<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}
                        
                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('net_pct', old('net_pct') ?  old('net_pct') : '0.00', array('id' => 'net_pct', 'class' => 'form-control w-100 amountPercentInput harmonyAmountInput', 'maxlength' => '21', 'onkeypress' => 'return isNumberPercentage(event, $(this))')) }}
                        </div>

                        {{ Form::label('net_price', 'Harga Jual<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                        <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                            {{ Form::text('net_price', old('net_price'), array('id' => 'net_price', 'class' => 'form-control w-100 amountPercentInput harmonyAmountInput', 'maxlength' => '38', 'onkeypress' => 'return isNumberPlusComma(event, $(this))', 'placeholder' => '0.00', 'readonly' => true)) }}
                        </div>
                    </div>

                    <div class="form-group form-inline text-right">
                        <div class="col-sm-12">
                            {{ Form::button('Back', array('class' => 'btn btn-secondary', 'id' => 'btnBack', 'data-toggle' => 'modal', 'data-target' => '#backModal')) }}
                            {{ Form::button('Save', array('class' => 'btn btn-primary', 'id' => 'btnSave', 'data-toggle' => 'modal', 'data-target' => '#confirmModal')) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            triggerChangeEvent();
        });

        function triggerChangeEvent() {
            $('#quantity').change(function() {
                calculateSellingPrice();
            });

            $('#price').change(function() {
                calculateSellingPrice();
            });

            $('#net_pct').change(function() {
                calculateSellingPrice();
            });
        }

        function calculateSellingPrice() {
            var quantity = $('#quantity').val();
            var price = $('#price').val();
            var net_pct = $('#net_pct').val();
            var net_price = $('#net_price');

            if (quantity === '') {
                quantity = '0.00';
            }
            quantity = parseFloat(removeNumberFormat(quantity));
            
            if (price === '') {
                price = '0.00';
            }
            price = parseFloat(removeNumberFormat(price));

            if (net_pct === '') {
                net_pct = '0.00';
            }
            net_pct = parseFloat(removeNumberFormat(net_pct));

            var total_price =  price;
            var total_net_price = total_price + ((net_pct / 100) * total_price);
            net_price.val(getPriceFormattedNumber(total_net_price, 2));
        }
    </script>
@endpush