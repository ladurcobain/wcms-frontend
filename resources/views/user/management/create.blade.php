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
                                    <a href="{{ route('management.index') }}" class="btn btn-sm btn-default"
                                        management="button"> <i class="fas fa-chevron-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="card-body">
                        <form id="form" class="form-horizontal form-bordered" action="{{ route('management.store') }}"
                            method="post" novalidate enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Nama Akun <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="account" name="account"
                                        placeholder="Nama Akun" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Kata Sandi <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Kata Sandi" autocomplete="off" required />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end">Tipe <span
                                        class="required">*</span></label>
                                <div class="col-lg-3">
                                    <div class="radio-custom radio-primary">
                                        <input type="radio" name="type" value="1" checked=""
                                            onChange="showTypeUser(1);" />
                                        <label><?php echo Status::tipeUser(1); ?></label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="radio-custom radio-primary">
                                        <input type="radio" name="type" value="2" onChange="showTypeUser(2);" />
                                        <label><?php echo Status::tipeUser(2); ?></label>
                                    </div>
                                </div>
                                <div class="col-lg-4"></div>
                            </div>
                            <div id="cmb-user-role" style="display:block;">
                                <div class="form-group row pt-2 pb-2">
                                    <label class="col-sm-3 control-label text-sm-end pt-2">Otoritas <span
                                            class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <select data-plugin-selectTwo class="form-control populate placeholder"
                                            data-plugin-options='{ "placeholder": "Pilih Otoritas ...", "allowClear": true }'
                                            id="role" name="role">
                                            <option></option>
                                            <?php foreach($roles as $r) { ?>
                                            <option value="<?php echo $r->role_id; ?>"><?php echo $r->role_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="cmb-user-satker" style="display:none;">
                                <div class="form-group row pt-2 pb-2">
                                    <label class="col-sm-3 control-label text-sm-end pt-2">Satuan Kerja <span
                                            class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <select data-plugin-selectTwo class="form-control populate placeholder"
                                            data-plugin-options='{ "placeholder": "Pilih Satuan Kerja ...", "allowClear": true }'
                                            id="satker" name="satker">
                                            <option></option>
                                            <?php foreach($satkers as $r) { ?>
                                            <option value="<?php echo $r->satker_id; ?>"><?php echo $r->satker_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pt-3 pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Nama Lengkap <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="fullname" name="fullname"
                                        placeholder="Nama Lengkap" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Surel</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Surel" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Gambar</label>
                                <div class="col-sm-9">
                                    <input type="file" accept="image/jpg, image/png, image/jpeg" class="form-control"
                                        id="userfile" name="userfile" placeholder="File Gambar" autocomplete="off" />
                                    <span class="help-block">Ukuran maksimum 10MB (JPG | PNG | JPEG). Dimensi gambar
                                        200x200</span>
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
