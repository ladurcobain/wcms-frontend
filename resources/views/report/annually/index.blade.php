@extends('layouts.app')

@section('title', $subtitle)

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col">
            <section class="card card-featured card-featured-primary">
                <header class="card-header">
                    <h2 class="card-title">Daftar {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                </header>
                <div class="card-body">
                    @if ($alert = Session::get('alrt'))
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show"
                        role="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"
                            aria-label="Close"></button>
                    </div>
                    @endif

                    <form class="form-horizontal form-bordered" action="{{ route('annually.filter') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-1">
                            <div class="col-lg-6"></div>
                            <div class="col-lg-2 mb-2">
                                <select data-plugin-selectTwo class="form-control populate placeholder" name="year"
                                    data-plugin-options='{ "placeholder": "Pilih Tahun ...", "allowClear": false }'>
                                    <option><option>
                                    <?php for($i=0; $i<count($years); $i++) { ?>
                                    <option value="<?php echo $years[$i]; ?>" <?php echo (($year == $years[$i])?'selected="selected"':''); ?>><?php echo $years[$i]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <select data-plugin-selectTwo class="form-control populate placeholder"
                                    data-plugin-options='{ "placeholder": "Pilih Satuan Kerja ...", "allowClear": false }'
                                    name="satker">
                                    <option></option>
                                    <?php foreach($satkers as $r) { ?>
                                    <option value="<?php echo $r->satker_id; ?>" <?php echo (($satker == $r->satker_id)?'selected="selected"':''); ?>><?php echo $r->satker_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <button style="float:right;" class="btn btn-sm btn-primary mb-1 mt-1 me-1">Cari</button>
                                <a style="float:right;" href="{{ route('annually.index') }}" class="btn btn-sm btn-default mb-1 mt-1 me-1">Bersihkan</a>
                            </div>
                        </div> 
                    </form>
                    <form id="frmUserExport" action="{{route('annually.excell')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-3">
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <input type="hidden" name="_satker" value="{{ $satker }}" />
                                <input type="hidden" name="_year" value="{{ $year }}" />
                                <button style="float:right;" type="submit" class="btn btn-sm btn-info btn-block mb-1 mt-1 me-1"><i class="fas fa-download"></i> Unduh</button>
                            </div> 
                        </div>
                    </form>
                    <div class="table-responsive">
                        <style>
                            div.dataTables_filter, div.dataTables_length {
                            padding: 5px;
                            }
                        </style>
                        <table id="tableDt" class="table table-responsive-lg table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th style="display:none;" width="1%">
                                        sort
                                    </th>
                                    <th>
                                        Nama Bulan
                                    </th>
                                    <th class="center" width="20%">
                                        Jumlah
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($list) > 0) { ?>
                                    <?php 
                                        $i=0;
                                        foreach ($list as $row) { 
                                            $i = $i+1;
                                    ?>
                                    <tr>
                                        <td style="display:none;">
                                            <?php echo $row->sort; ?>
                                        </td>
                                        <td valign="middle">
                                            <?php echo $row->title; ?>
                                        </td>
                                        <td class="text-center" valign="middle">
                                            <?php echo number_format($row->count); ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="3" class="text-center" valign="middle">
                                            <p class="description">
                                                <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                                <span class="va-middle">Data tidak ditemukan.</span>
                                            </p>
                                        </td>
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


@endsection