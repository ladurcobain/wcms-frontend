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
                                    <h2 class="card-title">Daftar {{ $subtitle != '' ? $subtitle : $title }}</h2>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('news.create') }}"> <i
                                            class="fas fa-plus"></i> Tambah</a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="card-body">
                        @if ($alert = Session::get('alrt'))
                            <div class="alert <?php echo $alert == 'error' ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" tutorial="alert">
                                <strong><?php echo $alert == 'error' ? 'Error' : 'Success'; ?>!</strong>
                                <?php echo Session::get('msgs'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="form-horizontal form-bordered" action="{{ route('news.filter') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group row pb-3">
                                <div class="col-lg-4 mb-2">
                                    <div class="input-daterange input-group mb-2" data-plugin-datepicker>
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" name="start" value="{{ $start }}"
                                            autocomplete="off" />
                                        <span class="input-group-text border-start-0 border-end-0 rounded-0">
                                            s/d
                                        </span>
                                        <input type="text" class="form-control" name="end" value="{{ $end }}"
                                            autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <select data-plugin-selectTwo class="form-control populate placeholder"
                                        data-plugin-options='{ "placeholder": "Pilih Satuan Kerja ...", "allowClear": false }'
                                        name="satker">
                                        <option></option>
                                        <?php foreach($satkers as $r) { ?>
                                        <option value="<?php echo $r->satker_id; ?>" <?php echo $satker == $r->satker_id ? 'selected="selected"' : ''; ?>><?php echo $r->satker_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <input type="text" class="form-control"
                                        placeholder="Cari berdasarkan judul berita ..." name="q"
                                        value="{{ $q }}" autocomplete="off" />
                                </div>
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2">
                                    <button style="float:right;" class="btn btn-sm btn-primary mb-1 mt-1 me-1">Cari</button>
                                    <a style="float:right;" href="{{ route('news.index') }}"
                                        class="btn btn-sm btn-default mb-1 mt-1 me-1">Bersihkan</a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th width="15%">Satuan Kerja</th>
                                        <th width="12%">Tanggal</th>
                                        <th width="10%">Kategori</th>
                                        <th>Judul Berita</th>
                                        <th class="center" width="10%">Gambar</th>
                                        <th class="center" width="10%">Status</th>
                                        <th class="center" width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($results->total() > 0) { ?>
                                    <?php foreach ($results as $row) { ?>
                                    <tr>
                                        <td>{{ $row->news_satker }}</td>
                                        <td class="center">{{ $row->news_date }}</td>
                                        <td class="center">{{ $row->news_category }}</td>
                                        <td>{{ $row->news_title }}</td>
                                        <td class="center">
                                            <?php if($row->news_image != "") { ?>
                                                <img loading="lazy" src="{{ $row->news_path }}" alt="Webphada" class="img-thumbnail" />
                                            <?php } else { ?>
                                                <img loading="lazy" src="{{ asset('assets/img/logo-webphada.png') }}" alt="Webphada" class=" user-image img-thumbnail" />
                                            <?php } ?>   
                                        </td>
                                        <td class="center"><span
                                                class="badge badge-<?php echo $row->news_status == 1 ? 'success' : 'danger'; ?>"><?php echo $row->news_status == 1 ? Status::tipeNews(1) : Status::tipeNews(2); ?></span></td>
                                        <td class="center">
                                            <button type="button" class="btn btn-sm btn-warning modalConfirmEdit"
                                                data-bs-toggle="modal" data-bs-title="Edit"
                                                data-id_edit="{{ $row->news_id }}"><i class="fas fa-pencil-alt"></i>
                                                Ubah</button>
                                            <button type="button" class="btn btn-sm btn-danger modalConfirmDelete"
                                                data-bs-toggle="modal" data-bs-title="Delete"
                                                data-id_delete="{{ $row->news_id }}"><i class="fas fa-trash-alt"></i>
                                                Hapus</button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <tr>
                                        <td class="center" colspan="7">Data tidak ditemukan</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <?php if($results->total() > 0) { ?>
                                <tfoot>
                                    <tr>
                                        <td>Total <b>{{ $results->total() }}</b> Data</td>
                                        <td colspan="6"><span
                                                style="margin-top: 15px;float:right;">{{ $results->onEachSide(1)->links() }}</span>
                                        </td>
                                    </tr>
                                </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @include('conference.news.confirm_edit')
    @include('conference.news.confirm_delete')

@endsection
