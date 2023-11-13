@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

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
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" module="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif

                    <form class="form-horizontal form-bordered" action="{{ route('module.filter') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-3">
                            <div class="col-lg-8"></div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control mb-2" placeholder="Cari berdasarkan nama modul ..." 
                                    name="q" value="{{ $q }}" autocomplete="off" />
                            </div>
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <button style="float:right;" class="btn btn-sm btn-primary mb-1 mt-1 me-1">Cari</button>
                                <a style="float:right;" href="{{ route('module.index') }}" class="btn btn-sm btn-default mb-1 mt-1 me-1">Bersihkan</a>
                            </div>
                        </div>
                    </form>  
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th width="35%">Nama Modul</th>
                                    <th>Keterangan</th>
                                    <th class="center" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results->total() > 0) { ?>
                                <?php foreach ($results as $row) { ?>
                                <tr>
                                    <td>{{ $row->module_name }}</td>
                                    <td>{{ $row->module_description }}</td>
                                    <td class="center">
                                        <button type="button" class="btn btn-sm btn-warning modalConfirmEdit"
                                            data-bs-toggle="modal" data-bs-title="Edit" data-id_edit="{{ $row->module_id }}"><i
                                                class="fas fa-pencil-alt"></i> Ubah</button>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                    <tr><td class="center" colspan="3">Data tidak ditemukan</td></tr>
                                <?php } ?>
                            </tbody>
                            <?php if($results->total() > 0) { ?>
                            <tfoot>    
                                <tr>
                                    <td>Total <b>{{ $results->total() }}</b> Data</td>
                                    <td colspan="2"><span style="margin-top: 15px;float:right;">{{ $results->onEachSide(1)->links() }}</span></td>
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

@include('master.module.confirm_edit')

@endsection