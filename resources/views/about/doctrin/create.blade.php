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
                                <a href="{{ route('doctrin.index') }}" class="btn btn-sm btn-default" doctrin="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('doctrin.store') }}"
                        method="post" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2"></label>
                            <div class="col-sm-9">
                                <div class="checkbox-custom checkbox-primary">
                                    <input type="checkbox" id="chkTemp" onclick="templete_about_info();" />
                                    <label>Template Konten</label>
                                </div>
                            </div>
                        </div>
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
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Teks Bhs. Indonesia <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <textarea class="summernote form-control" id="text_in" name="text_in" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Teks Bhs. Inggris</label>
                            <div class="col-sm-9">
                                <textarea class="summernote form-control" id="text_en" name="text_en"></textarea>
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

@endsection

<script>
    function templete_about_info() {
        var checkBox = document.getElementById("chkTemp");
        if (checkBox.checked == true) {
            $('#text_in').summernote('code', '<h2 style="text-align: center; margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; font-family: &quot;Playfair Display&quot;, serif; color: black;">Dokrin Kejaksaan</h2><h2 style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; font-family: &quot;Playfair Display&quot;, serif; color: black;"><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem;"><br></p><div style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; margin-right: 40px; margin-top: 10px; padding: 1px;"><p style="margin-bottom: 1rem;"><span style="font-weight: 700 !important;">Trikrama Adhyaksa :<br>Satya Adhi Wicaksana</span></p><p style="margin-bottom: 1rem;"><span style="font-weight: bolder;">SATYA :</span><br></p><div style="text-align: justify;"><span style="font-size: 14px;">Kesetiaan yang bersumber pada rasa jujur, baik terhadap Tuhan Yang Maha Esa, terhadap diri pribadi dan keluarga maupun kepada sesama manusia.</span></div><div style="text-align: justify;"><span style="font-size: 14px;"><br></span></div><p style="margin-bottom: 1rem;"><span style="font-weight: bolder;">ADHI :</span><br></p><div style="text-align: justify;"><span style="font-size: 14px;">Kesempurnaan dalam bertugas dan berunsur utama pada rasa tanggung jawab terhadap Tuhan Yang Maha Esa, keluarga dan sesama manusia.</span></div><div style="text-align: justify;"><span style="font-size: 14px;"><br></span></div><p style="margin-bottom: 1rem;"><span style="font-weight: bolder;">WICAKSANA :</span><br></p><div style="text-align: justify;"><span style="font-size: 14px;">Bijaksana dalam tutur kata dan tingkah laku, khususnya dalam penerapan kekuasaan dan kewenangannya.</span></div></div></h2><div style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; margin-right: 40px; margin-top: 10px; padding: 1px; color: black;"><p></p></div>');
        } else {
            $('#text_in').summernote('code', '');
        }
    }
</script>