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
                                    <h2 class="card-title">Tambah {{ $subtitle != '' ? $subtitle : $title }}</h2>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('infografis.index') }}" class="btn btn-sm btn-default" info="button">
                                        <i class="fas fa-chevron-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="card-body">
                        <form id="form" class="form-horizontal form-bordered" action="{{ route('infografis.store') }}"
                            method="post" novalidate enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Satuan Kerja <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control populate placeholder"
                                        data-plugin-options='{ "placeholder": "Pilih Satuan Kerja ...", "allowClear": false }'
                                        id="satker" name="satker" required>
                                        <option></option>
                                        <?php foreach($satkers as $r) { ?>
                                        <option value="<?php echo $r->satker_id; ?>" <?php echo $satker == $r->satker_id ? 'selected="selected"' : ''; ?>><?php echo $r->satker_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row pt-3 pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Nama <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nama" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group row pt-3 pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Tautan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="link" name="link"
                                        placeholder="Tautan" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Gambar <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="file" accept="image/jpg, image/png, image/jpeg" class="form-control"
                                        id="userfile" name="userfile" placeholder="Gambar" autocomplete="off" required />
                                    <span class="help-block">Ukuran maksimum 10MB (JPG | PNG | JPEG). Dimensi gambar
                                        400x600</span>
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
