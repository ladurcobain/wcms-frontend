@extends('layouts.app')

@section('title', $subtitle)

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col">
            <section class="card card-featured card-featured-primary">
                <header class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left mt-2">
                                <h2 class="card-title">Tambah {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('unit.index') }}" class="btn btn-sm btn-default" unit="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('unit.store') }}"
                        method="post" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Satuan Kerja <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select data-plugin-selectTwo class="form-control populate placeholder"
                                    data-plugin-options='{ "placeholder": "Pilih Satuan Kerja ...", "allowClear": false }'
                                    id="satker" name="satker" required>
                                    <option></option>
                                    <?php foreach($satkers as $r) { ?>
                                    <option value="<?php echo $r->satker_id; ?>" <?php echo (($satker == $r->satker_id)?'selected="selected"':''); ?>><?php echo $r->satker_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Nama <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Nama" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Teks Bhs. Indonesia</label>
                            <div class="col-sm-9">
                                <textarea class="summernote form-control" id="text_in" name="text_in"></textarea>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Teks Bhs. Inggris</label>
                            <div class="col-sm-9">
                                <textarea class="summernote form-control" id="text_en" name="text_en"></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="reset" class="btn btn-default">Batal</button>
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection