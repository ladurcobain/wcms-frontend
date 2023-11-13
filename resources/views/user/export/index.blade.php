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
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" export="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif

                    <form class="form-horizontal form-bordered" action="{{ route('export.filter') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-1">
                            <div class="col-lg-5"></div>
                            <div class="col-lg-3 mb-2">
                                <select data-plugin-selectTwo class="form-control populate placeholder" name="t"
                                    data-plugin-options='{ "placeholder": "Pilih Tipe ...", "allowClear": false }'>
                                    <option><option>
                                    <?php for($i=1; $i<=2; $i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo (($t == $i)?'selected="selected"':''); ?>><?php echo Status::tipeUser($i); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <input type="text" class="form-control" placeholder="Cari berdasarkan nama lengkap ..." 
                                    name="q" value="{{ $q }}" autocomplete="off" />
                            </div>
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <button style="float:right;" class="btn btn-sm btn-primary mb-1 mt-1 me-1">Cari</button>
                                <a style="float:right;" href="{{ route('export.index') }}" class="btn btn-sm btn-default mb-1 mt-1 me-1">Bersihkan</a>
                            </div>
                        </div> 
                    </form>
                    <form id="frmUserExport" action="{{route('export.excell')}}" method="post">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-3">
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <input type="hidden" name="_type" value="{{ $t }}" />
                                <input type="hidden" name="_name" value="{{ $q }}" />
                                <button style="float:right;" type="submit" class="btn btn-sm btn-info btn-block mb-1 mt-1 me-1"><i class="fas fa-download"></i> Unduh</button>
                            </div> 
                        </div>
                    </form>  
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th width="15%">Tipe</th>
                                    <th>Nama Lengkap</th>
                                    <th width="15%">Nama Akun</th>
                                    <th width="25%">Aktivitas Terakhir</th>
                                    <th width="18%">Akses Terakhir</th>
                                    <th class="center" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results->total() > 0) { ?>
                                <?php foreach ($results as $row) { ?>
                                <tr>
                                    <td>{{ Status::tipeUser($row->user_type) }}</td>
                                    <td>{{ $row->user_fullname }}</td>
                                    <td>{{ $row->user_account }}</td>
                                    <td>{{ $row->user_activity }}</td>
                                    <td class="center">{{ $row->user_login }}</td>
                                    <td class="center">    
                                        <button type="button" OnClick="link_to('<?php echo 'user/export/detail/'. $row->user_id;  ?>');" class="btn btn-sm btn-info"><i class="fas fa-list-alt"></i> Detail</button>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                    <tr><td class="center" colspan="6">Data tidak ditemukan</td></tr>
                                <?php } ?>
                            </tbody>
                            <?php if($results->total() > 0) { ?>
                            <tfoot>    
                                <tr>
                                    <td>Total <b>{{ $results->total() }}</b> Data</td>
                                    <td colspan="5"><span style="margin-top: 15px;float:right;">{{ $results->onEachSide(1)->links() }}</span></td>
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

@endsection