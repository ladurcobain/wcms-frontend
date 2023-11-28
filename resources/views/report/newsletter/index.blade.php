@extends('layouts.app')

@section('title', $subtitle)

@section('content')

    @include('layouts.partials.breadcrumb')

    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col">
                <section class="card card-featured card-featured-primary">
                    <header class="card-header">
                        <h2 class="card-title">Daftar {{ $subtitle != '' ? $subtitle : $title }}</h2>
                    </header>
                    <div class="card-body">
                        @if ($alert = Session::get('alrt'))
                            <div class="alert <?php echo $alert == 'error' ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
                                <strong><?php echo $alert == 'error' ? 'Error' : 'Success'; ?>!</strong>
                                <?php echo Session::get('msgs'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="form-horizontal form-bordered" action="{{ route('newsletter.filter') }}"
                            method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group row pb-1">
                                <div class="col-lg-4 mb-2">
                                    <div class="input-daterange input-group mb-2" data-plugin-datepicker>
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" name="start"
                                            value="{{ $start }}" autocomplete="off" />
                                        <span class="input-group-text border-start-0 border-end-0 rounded-0">
                                            s/d
                                        </span>
                                        <input type="text" class="form-control" name="end"
                                            value="{{ $end }}" autocomplete="off" />
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
                                        placeholder="Cari berdasarkan alamat surel ..." name="q"
                                        value="{{ $q }}" autocomplete="off" />
                                </div>
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2">
                                    <button style="float:right;" class="btn btn-sm btn-primary mb-1 mt-1 me-1">Cari</button>
                                    <a style="float:right;" href="{{ route('newsletter.index') }}"
                                        class="btn btn-sm btn-default mb-1 mt-1 me-1">Bersihkan</a>
                                </div>
                            </div>
                        </form>
                        <form id="frmUserExport" action="{{ route('newsletter.excell') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group row pb-3">
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2">
                                    <input type="hidden" name="_start" value="{{ $start }}" />
                                    <input type="hidden" name="_end" value="{{ $end }}" />
                                    <input type="hidden" name="_satker" value="{{ $satker }}" />
                                    <input type="hidden" name="_q" value="{{ $q }}" />
                                    <button style="float:right;" type="submit"
                                        class="btn btn-sm btn-info btn-block mb-1 mt-1 me-1"><i class="fas fa-download"></i>
                                        Unduh</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="center" width="12%">Tanggal</th>
                                        <th class="center" width="10%">Pukul</th>
                                        <th>Satuan Kerja</th>
                                        <th width="35%">Alamat Surel</th>
                                        <th class="center" width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($results->total() > 0) { ?>
                                    <?php foreach ($results as $row) { ?>
                                    <tr>
                                        <td class="center">{{ $row->newsletter_date }}</td>
                                        <td class="center">{{ $row->newsletter_time }}</td>
                                        <td>{{ $row->newsletter_satker }}</td>
                                        <td>{{ $row->newsletter_email }}</td>
                                        <td class="center">
                                            <button type="button" class="btn btn-sm btn-danger modalConfirmDelete"
                                                data-bs-title="Delete" data-id_delete="{{ $row->newsletter_id }}"><i
                                                    class="fas fa-trash-alt"></i> Hapus</button>
                                            <button type="button" OnClick="link_to('<?php echo 'report/newsletter/detail/' . $row->newsletter_id; ?>');"
                                                class="btn btn-sm btn-info"><i class="fas fa-list-alt"></i> Detail</button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <tr>
                                        <td class="center" colspan="5">Data tidak ditemukan</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <?php if($results->total() > 0) { ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Total <b>{{ $results->total() }}</b> Data</td>
                                        <td colspan="3"><span
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

    @include('report.newsletter.confirm_delete')

@endsection
