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
                                <h2 class="card-title">Tambah {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('movie.index') }}" class="btn btn-sm btn-default" info="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('movie.store') }}"
                        method="post" novalidate enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Satuan Kerja <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select data-plugin-selectTwo class="form-control populate placeholder"
                                    data-plugin-options='{ "placeholder": "Pilih Satuan Kerja ...", "allowClear": false }'
                                    id="satker" name="satker" required>
                                    <option></option>
                                    <?php foreach($satkers as $r) { ?>
                                    <option value="<?php echo $r->satker_id; ?>" <?php echo (($satker == $r->satker_id)?'selected="selected"':''); ?>><?php echo $r->satker_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Judul <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul" autocomplete="off" required />
                                <span class="help-block">Cara menambahkan <a href="javascript:void(0);" OnClick="modal_youtube();">Url Youtube</a></span>
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Tautan Youtube <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="link" name="link" placeholder="Tautan Youtube" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="desc" name="desc" rows="2" style="resize: none;" placeholder="Keterangan ..."></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="reset" class="btn btn-default">Batal</button>
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<div id="modalYoutube" class="modal animated bounceIn" tabindex="-1" role="dialog" aria-labelledby="modalYoutube" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="modal-content">
                <div class="card card-modern">
                    <div class="card-header">
                        <h2 class="card-title"></h2>
                    </div>
                    <div class="card-body">
                        <div class="ecommerce-timeline mb-3">
                            <div class="tm-title">
                                <h5 class="m-0 pt-2 pb-2 text-dark font-weight-semibold text-uppercase">Cara menambahkan Url Youtube</h5>
                            </div>
                            <div class="ecommerce-timeline-items-wrapper">
                                <div class="ecommerce-timeline-item">
                                    <small>Buka website <a target="_blank" href="https://www.youtube.com/" class="text-color-primary">Youtube</a></small>
                                    <p>Kemudian salin <i>url youtube</i> video tersebut</p>
                                </div>
                                <div class="ecommerce-timeline-item">
                                    <p>Mencari video yang ingin bagikan</p>
                                    <div>
                                        <ol>
                                            <li>Buka video yang ingin Anda bagikan</li>
                                            <li>Di bawah pemutar video, ketuk <i class="bx bx-share"></i> Bagikan</li>
                                            <li>Akan muncul panel yang menampilkan beberapa opsi berbagi</li>
                                            <li>Pilih Salin tautan, untuk menyalin dan menempelkan URL video tersebut</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="ecommerce-timeline-item">
                                    <div class="thumbnail-gallery">
                                        <img class="img-fluid" width="100%" src="{{ asset('assets/img/guide_youtube.png') }}" alt="Pencarian youtube" />
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function modal_youtube() {
        $('#modalYoutube').modal('show');
    }
</script>

@endsection