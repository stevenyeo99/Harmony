@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <span>{{ $title }}</span>

                    <a id="previousUrlModule" href="{!! route('manage.supplier') !!}" class="btn btn-info btn-sm float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>

                <div class="card-body">
                    {!! Form::open(array('url' => route('manage.supplier.update', $supplierObj->splr_id), 'method' => 'POST', 'id' => 'frm')) !!}
                        <div class="form-group form-inline">
                            {{ Form::label('name', 'Nama<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('name', $supplierObj->name ? $supplierObj->name : old('name'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>

                            {{ Form::label('code', 'Kode :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('code', $supplierObj->code, array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('email', 'Email :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('email', $supplierObj->email ? $supplierObj->email : old('email'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>

                            {{ Form::label('telp_no', 'Telpon<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('telp_no', $supplierObj->telp_no ? $supplierObj->telp_no : old('telp_no'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-sm-12 pl-0">Detail Kontak #1</span>
                            <hr class="bg-primary">
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('contact_name_1', 'Nama<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('contact_name_1', $supplierObj->contact_name_1 ? $supplierObj->contact_name_1 : old('contact_name_1'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>

                            {{ Form::label('contact_person_1', 'Kontak<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('contact_person_1', $supplierObj->contact_person_1 ? $supplierObj->contact_person_1 : old('contact_person_1'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-sm-12 pl-0">Detail Kontak #2</span>
                            <hr class="bg-primary">
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('contact_name_2', 'Nama :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('contact_name_2', $supplierObj->contact_name_2 ? $supplierObj->contact_name_2 : old('contact_name_2'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>

                            {{ Form::label('contact_person_2', 'Kontak :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('contact_person_2', $supplierObj->contact_person_2 ? $supplierObj->contact_person_2 : old('contact_person_2'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-sm-12 pl-0">Detail Kontak #3</span>
                            <hr class="bg-primary">
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('contact_name_3', 'Nama :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('contact_name_3', $supplierObj->contact_name_3 ? $supplierObj->contact_name_3 : old('contact_name_3'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>

                            {{ Form::label('contact_person_3', 'Kontak :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-4 col-md-4 col-lg-4 pl-0">
                                {{ Form::text('contact_person_3', $supplierObj->contact_person_3 ? $supplierObj->contact_person_3 : old('contact_person_3'), array('class' => 'form-control w-100', 'maxlength' => '50')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-sm-12 pl-0">Detail Alamat</span>
                            <hr class="bg-primary">
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('address_line_1', 'Baris 1<span class="text-danger">*</span> :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0'), false) }}

                            <div class="col-sm-10 col-md-10 col-lg-10 pl-0">
                                {{ Form::text('address_line_1', $supplierObj->address_line_1 ? $supplierObj->address_line_1 : old('address_line_1'), array('class' => 'form-control w-100', 'maxlength' => '100')) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('address_line_2', 'Baris 2 :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-10 col-md-10 col-lg-10 pl-0">
                                {{ Form::text('address_line_2', $supplierObj->address_line_2 ? $supplierObj->address_line_2 : old('address_line_2'), array('class' => 'form-control w-100', 'maxlength' => '100')) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('address_line_3', 'Baris 3 :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-10 col-md-10 col-lg-10 pl-0">
                                {{ Form::text('address_line_3', $supplierObj->address_line_3 ? $supplierObj->address_line_3 : old('address_line_3'), array('class' => 'form-control w-100', 'maxlength' => '100')) }}
                            </div>
                        </div>

                        <div class="form-group form-inline">
                            {{ Form::label('address_line_4', 'Baris 4 :', array('class' => 'col-sm-2 col-md-2 col-lg-2 d-inline-block pl-0')) }}

                            <div class="col-sm-10 col-md-10 col-lg-10 pl-0">
                                {{ Form::text('address_line_4', $supplierObj->address_line_4 ? $supplierObj->address_line_4 : old('address_line_4'), array('class' => 'form-control w-100', 'maxlength' => '100')) }}
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