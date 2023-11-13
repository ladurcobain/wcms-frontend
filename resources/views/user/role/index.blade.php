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
                                <a class="btn btn-sm btn-primary" href="{{ route('role.create') }}" > <i class="fas fa-plus"></i> Tambah</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    @if ($alert = Session::get('alrt'))
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" role="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif

                    <form class="form-horizontal form-bordered" action="{{ route('role.filter') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-3">
                            <div class="col-lg-8"></div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control mb-2" placeholder="Cari berdasarkan nama otoritas ..." 
                                    name="q" value="{{ $q }}" autocomplete="off" />
                            </div>
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <button style="float:right;" class="btn btn-sm btn-primary mb-1 mt-1 me-1">Cari</button>
                                <a style="float:right;" href="{{ route('role.index') }}" class="btn btn-sm btn-default mb-1 mt-1 me-1">Bersihkan</a>
                            </div>
                        </div>
                    </form> 
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th width="15%">Nama Otoritas</th>
                                    <th>Daftar Modul</th>
                                    <th class="center" width="10%">Status</th>
                                    <th class="center" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results->total() > 0) { ?>
                                <?php foreach ($results as $row) { ?>
                                <tr>
                                    <td>{{ $row->role_name }}</td>
                                    <td>
                                        <?php
                                            $lists = $row->child;
                                            for($i=0; $i<count($lists); $i++) { ?>
                                                <span class="badge badge-primary"><?php echo $lists[$i]; ?></span>
                                            <?php }
                                        ?>
                                    </td>
                                    <td class="center"><span class="badge badge-<?php echo (($row->role_status == 1 ? "info" : "dark")); ?>"><?php echo (($row->role_status == 1 ? Status::tipeStatus(1) : Status::tipeStatus(2))); ?></span></td>
                                    <td class="center">
                                        <button type="button" class="btn btn-sm btn-warning modalConfirmEdit"
                                            data-bs-toggle="modal" data-bs-title="Edit" data-id_edit="{{ $row->role_id }}"><i
                                                class="fas fa-pencil-alt"></i> Ubah</button>
                                        <button type="button" class="btn btn-sm btn-danger modalConfirmDelete"
                                            data-bs-toggle="modal" data-bs-title="Delete" data-id_delete="{{ $row->role_id }}"><i
                                                class="fas fa-trash-alt"></i> Hapus</button>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                    <tr><td class="center" colspan="4">Data tidak ditemukan</td></tr>
                                <?php } ?>
                            </tbody>
                            <?php if($results->total() > 0) { ?>
                            <tfoot>    
                                <tr>
                                    <td>Total <b>{{ $results->total() }}</b> Data</td>
                                    <td colspan="3"><span style="margin-top: 15px;float:right;">{{ $results->onEachSide(1)->links() }}</span></td>
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

<script>
    function dialogDetail(id) {
        var uri = base_url + "ajax/modal-userrole/" + id;
        $.ajax({
            type: "get",
            dataType: "html",
            url: uri,
            timeout: 3000,
            beforeSend: function() {
                $("#modal-content").html(
                    '<div class="notification-icon text-center"><i class="bx bx-loader"></i></div>');
            }
        }).done(function(data) {
            $("#modal-content").html(data);
        }).fail(function(jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#modal-content").html(
                    '<div class="notification-icon"><i class="bx bx-error"></i></div>');
            }
        });
        
        $('#modalConfirmDetail').modal('show');
    }    
</script>

@include('user.role.confirm_edit')
@include('user.role.confirm_delete')
@include('user.role.confirm_detail')

@endsection