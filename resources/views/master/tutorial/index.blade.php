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
                                <h2 class="card-title">Daftar {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-primary" href="{{ route('tutorial.create') }}" > <i class="fas fa-plus"></i> Tambah</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    @if ($alert = Session::get('alrt'))
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" tutorial="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif

                    <form class="form-horizontal form-bordered" action="{{ route('tutorial.filter') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-3">
                            <div class="col-lg-8"></div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control mb-2" placeholder="Cari berdasarkan nama dokumen panduan ..." 
                                    name="q" value="{{ $q }}" autocomplete="off" />
                            </div>
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <button style="float:right;" class="btn btn-sm btn-primary mb-1 mt-1 me-1">Cari</button>
                                <a style="float:right;" href="{{ route('tutorial.index') }}" class="btn btn-sm btn-default mb-1 mt-1 me-1">Bersihkan</a>
                            </div>
                        </div>
                    </form> 
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th width="25%">Nama Dokumen</th>
                                    <th>Keterangan</th>
                                    <th class="center" width="5%">PDF</th>
                                    <th class="center" width="10%">Status</th>
                                    <th class="center" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results->total() > 0) { ?>
                                <?php foreach ($results as $row) { ?>
                                <tr>
                                    <td>{{ $row->tutorial_name }}</td>
                                    <td>{{ $row->tutorial_description }}</td>
                                    <td class="center">
                                        <?php if($row->tutorial_file != "") { ?>
                                        <button OnClick="link_new_tab(' {{ $row->tutorial_path }} ');" type="button" class="btn btn-sm btn-info"><i class="fas fa-file-pdf"></i></button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-sm btn-default"><i class="fas fa-file-pdf"></i></button>
                                        <?php } ?>      
                                    </td>
                                    <td class="center"><span class="badge badge-<?php echo (($row->tutorial_status == 1 ? "info" : "dark")); ?>"><?php echo (($row->tutorial_status == 1 ? Status::tipeStatus(1) : Status::tipeStatus(2))); ?></span></td>
                                    <td class="center">
                                        <button type="button" class="btn btn-sm btn-warning modalConfirmEdit"
                                            data-bs-toggle="modal" data-bs-title="Edit" data-id_edit="{{ $row->tutorial_id }}"><i
                                                class="fas fa-pencil-alt"></i> Ubah</button>
                                        <button type="button" class="btn btn-sm btn-danger modalConfirmDelete"
                                            data-bs-toggle="modal" data-bs-title="Delete" data-id_delete="{{ $row->tutorial_id }}"><i
                                                class="fas fa-trash-alt"></i> Hapus</button>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                    <tr><td class="center" colspan="5">Data tidak ditemukan</td></tr>
                                <?php } ?>
                            </tbody>
                            <?php if($results->total() > 0) { ?>
                            <tfoot>    
                                <tr>
                                    <td>Total <b>{{ $results->total() }}</b> Data</td>
                                    <td colspan="4"><span style="margin-top: 15px;float:right;">{{ $results->onEachSide(1)->links() }}</span></td>
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

@include('master.tutorial.confirm_edit')
@include('master.tutorial.confirm_delete')

@endsection