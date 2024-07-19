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
                    <form class="form-horizontal form-bordered" action="{{ route('fileimage.filter') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-3">
                            <div class="col-lg-8"></div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control mb-2" placeholder="Cari berdasarkan berkas gambar ..." 
                                    name="q" value="{{ $q }}" autocomplete="off" />
                            </div>
                            <div class="col-lg-10"></div>
                            <div class="col-lg-2">
                                <button style="float:right;" class="btn btn-sm btn-primary mb-1 mt-1 me-1">Cari</button>
                                <a style="float:right;" href="{{ route('fileimage.index') }}" class="btn btn-sm btn-default mb-1 mt-1 me-1">Bersihkan</a>
                            </div>
                        </div>
                    </form>
                    <div class="media-gallery mg-main">
                        <div class="row mg-files" data-sort-destination data-sort-id="media-gallery">
                            <?php if($results->total() > 0) { ?>
                                <?php foreach ($results as $row) { ?>
                                    <div class="isotope-item document col-sm-6 col-md-4 col-lg-3">
                                        <div class="thumbnail">
                                            <div class="thumb-preview">
                                                <a class="thumb-image" href="{{ $row->upload_path }}">
                                                    <img loading="lazy" src="{{ $row->upload_path }}" class="img-fluid" alt="{{ $row->upload_name }}" />
                                                </a>
                                                <div class="mg-thumb-options">
                                                    <div class="mg-zoom"><i class="bx bx-search"></i></div>
                                                </div>
                                            </div>
                                            <h5 class="mg-title font-weight-semibold">{{ Status::str_ellipsis($row->upload_name, 20) }}</h5>
                                            <div class="mg-description">
                                                <small class="float-left text-muted">{{ Status::str_ellipsis($row->satker_name, 15) }}</small>
                                                <small class="float-end text-muted">{{ Status::str_ellipsis($row->menu_name, 15) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div>
                                    <center>
                                        <div class="result-data">
                                            <p class="description">
                                                <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                                <span class="va-middle">Data tidak ditemukan.</span>
                                            </p>
                                        </div>
                                    </center>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?php if(!empty($results)) { ?>
                    <p class="text-muted text-uppercase pull-left mt-3">Total Data : {{ $results->total() }}</p>
                    <?php } ?>
                    <div class="pull-right mt-3" style="margin-right: 5px;">{{ $results->onEachSide(1)->links() }}</div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection