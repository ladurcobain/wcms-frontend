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
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show"
                        role="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"
                            aria-label="Close"></button>
                    </div>
                    @endif

                    <form class="form-horizontal form-bordered" action="{{ route('survey.filter') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-3">
                            <div class="col-lg-4"></div>
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
                                <input type="text" class="form-control" placeholder="Cari berdasarkan nama pengguna ..." 
                                    name="q" value="{{ $q }}" autocomplete="off" />
                            </div>
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <button style="float:right;" class="btn btn-sm btn-primary mb-1 mt-1 me-1">Cari</button>
                                <a style="float:right;" href="{{ route('survey.index') }}" class="btn btn-sm btn-default mb-1 mt-1 me-1">Bersihkan</a>
                            </div>
                        </div> 
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th class="center" width="12%">Tanggal</th>
                                    <th class="center" width="10%">Pukul</th>
                                    <th>Pengguna</th>
                                    <th width="10%">Penilaian</th>
                                    <th class="center" width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($results->total() > 0) { ?>
                                <?php foreach ($results as $row) { ?>
                                <tr>
                                    <td class="center">{{ $row->survey_date }}</td>
                                    <td class="center">{{ $row->survey_time }}</td>
                                    <td>{{ $row->survey_user }}</td>
                                    <td class="center">{{ $row->survey_value }}</td>
                                    <td class="center">
                                        <button type="button" class="btn btn-sm btn-danger modalConfirmDelete"
                                             data-bs-title="Delete" data-id_delete="{{ $row->survey_id }}"><i
                                                class="fas fa-trash-alt"></i> Hapus</button>
                                        <button type="button" OnClick="link_to('<?php echo 'survey/detail/'. $row->survey_id;  ?>');" class="btn btn-sm btn-info"><i class="fas fa-list-alt"></i> Detail</button>
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
                                    <td colspan="2">Total <b>{{ $results->total() }}</b> Data</td>
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

@include('survey.confirm_delete')

@endsection