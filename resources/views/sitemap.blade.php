@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col-lg-12">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Daftar Satuan Kerja</h2>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0" id="dtTable" data-plugin-options='{"searchPlaceholder": "Pencarian ..."}' style="width:100%">
                            <thead>
                                <tr>
                                    <th width="5%">Kode</th>
                                    <th width="7%">Tipe</th>
                                    <th width="25%">Nama Satker</th>
                                    <th width="10%">Aktivitas terkini</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($list) > 0) { ?>
                                <?php foreach ($list as $row) { ?>
                                <tr>
                                    <td class="center">{{ $row->satker_code }}</td>
                                    <td class="center">{{ Status::tipeSatker($row->satker_type) }}</td>
                                    <td><a target="_blank" href="{{ $row->satker_url }}">{{ $row->satker_name }}</a></td>
                                    <td class="center">{{ $row->updated_at }}</td>
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
            </section>
        </div>
    </div>
</div>
<!-- end: page -->

{{-- end dashboard --}}

@endsection

@push('page-scripts')
@endpush