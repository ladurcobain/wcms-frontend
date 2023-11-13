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
                                <h2 class="card-title">Detail {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('export.index') }}" class="btn btn-sm btn-default" user="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <div class="tabs tabs-dark">
                        <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link" data-bs-target="#general" href="#general" data-bs-toggle="tab">Info.
                                    Umum</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#log" href="#log" data-bs-toggle="tab">Akses
                                    Aplikasi</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="general" class="tab-pane active">
                                <form id="form" class="form-horizontal form-bordered">
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Username</label>
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
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Otoritas User</label>
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
                                                <input type="checkbox" id="checkboxExample2" disabled
                                                    {{ ($info->user_status == 1)? 'checked':'' }} />
                                                <label for="checkboxExample2"><?php echo Status::tipeStatus(1); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row pt-3 pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Nama Lengkap</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $info->user_fullname }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-3 control-label text-sm-end pt-2">Surel</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $info->user_email }}"
                                                readonly />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="log" class="tab-pane">
                                <div>
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th width="20%">Tanggal</th>
                                                <th width="15%">Pukul</th>
                                                <th width="15%">Alamat IP</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($list)) { ?>
                                            <?php foreach ($list as $row) { ?>
                                            <tr>
                                                <td class="center">{{ $row->activity_date }}</td>
                                                <td class="center">{{ $row->activity_time }}</td>
                                                <td class="center">{{ $row->activity_ip }}</td>
                                                <td>{{ $row->activity_description }}</td>
                                            </tr>
                                            <?php } ?>
                                            <?php } else { ?>
                                            <tr><td colspan="4" align="center">
                                                <p class="description">
                                                    <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                                    <span class="va-middle">Data tidak ditemukan.</span>
                                                </p>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection