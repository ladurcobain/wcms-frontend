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
                                <h2 class="card-title">Ubah {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('management.index') }}" class="btn btn-sm btn-default" user="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    @if ($alert = Session::get('alrt'))
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" management="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="tabs tabs-dark">
                        <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link" data-bs-target="#general" href="#general" data-bs-toggle="tab">Info.
                                    Umum</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#password" href="#password"
                                    data-bs-toggle="tab">Ganti Kata Sandi</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="general" class="tab-pane active">
                                <form id="form" class="form-horizontal form-bordered"
                                    action="{{ route('management.update') }}" method="post" novalidate enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="user_id" value="{{ $info->user_id }}" />
                                    <input type="hidden" name="user_image" value="{{ $info->user_image }}" />
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Nama Akun</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $info->user_account }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Tipe</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                value="{{ App\Helpers\Status::tipeUser($info->user_type) }}" readonly />
                                        </div>
                                    </div>
                                    <?php if($info->user_type == 1) { ?>
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Otoritas</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $info->role_name }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Satuan Kerja</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $info->satker_name }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <hr />
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2"></label>
                                        <div class="col-sm-9">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" id="checkboxExample2" name="status" value="1"
                                                    {{ ($info->user_status == 1)? 'checked':'' }} />
                                                <label for="checkboxExample2"><?php echo Status::tipeStatus(1); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row pt-3 pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Nama Lengkap <span
                                                class="required">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="fullname" name="fullname"
                                                value="{{ $info->user_fullname }}" placeholder="Nama Lengkap"
                                                autocomplete="off" required />
                                        </div>
                                    </div>
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Surel</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $info->user_email }}" placeholder="Surel"
                                                autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="form-group row pb-3">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Gambar</label>
                                        <div class="col-sm-2">
                                            <?php if($info->user_image != "") { ?>
                                                <img src="{{ $info->user_path }}" alt="Webphada" class="img-thumbnail" />
                                            <?php } else { ?>
                                                <img src="{{ asset('assets/img/logo-webphada.png') }}" alt="Webphada" class=" user-image img-thumbnail" />
                                            <?php } ?>        
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="file" class="form-control" id="userfile" name="userfile" placeholder="File Gambar" autocomplete="off" />
                                            <span class="help-block">Ukuran maksimum 10MB (JPG | PNG | JPEG). Dimensi gambar 200x200</span>
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
                            <div id="password" class="tab-pane">
                                <form id="form" class="form-horizontal form-bordered"
                                    action="{{ route('management.password') }}" method="post" novalidate>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="user_id" value="{{ $info->user_id }}" />
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Nama Akun</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $info->user_account }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Tipe</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                value="{{ Status::tipeUser($info->user_type) }}" readonly />
                                        </div>
                                    </div>
                                    <?php if($info->user_type == 1) { ?>
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Otoritas</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $info->role_name }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Satuan Kerja</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $info->satker_name }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <hr />
                                    <div class="form-group row pt-3 pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Kata Sandi Baru <span
                                                class="required">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="password" name="password"
                                                value="" placeholder="Kata Sandi Baru" autocomplete="off" required />
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
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection