@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col-lg-12">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left mt-2">
                                <h2 class="card-title">{{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('integration.download') }}" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Unduh</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <?php foreach ($list as $row) { ?>
                    <div style="padding-bottom: 20px;">
                        <h4 class="font-weight-bold text-dark">{{ $row->request_name }}</h4>
                        <div class="toggle toggle-primary" data-plugin-toggle>
                            <section class="toggle active">
                                <label>Spesifikasi</label>
                                <div class="toggle-content">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0" style="width:100%">
                                            <tbody>
                                                <tr>
                                                    <td width="15%">API Url</th>
                                                    <td>{{ $row->request_url }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Metode</th>
                                                    <td>{{ $row->request_method }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Keterangan</th>
                                                    <td>{{ $row->request_description }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                            <section class="toggle">
                                <label>Parameter</label>
                                <div class="toggle-content">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="15%">Tipe Data</th>
                                                    <th width="25%">Nilai Awal</th>
                                                    <th>Catatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $listing = $row->parameter; ?>
                                                <?php if(!empty($listing)) { ?>
                                                <?php foreach ($listing as $rows) { ?>
                                                <tr>
                                                    <td>{{ $rows->param_type }}</td>
                                                    <td>{{ $rows->param_initial }}</td>
                                                    <td>{{ $rows->param_description }}</td>
                                                </tr>
                                                <?php } ?>
                                                <?php } else { ?>
                                                    <tr><td class="center" colspan="3">
                                                        <p>
                                                            <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                                            <span class="va-middle">Data tidak ditemukan.</span>
                                                        </p>
                                                    </td></tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
</div>

{{-- end dashboard --}}

@endsection

@push('page-scripts')
@endpush