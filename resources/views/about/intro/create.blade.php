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
                                <a href="{{ route('intro.index') }}" class="btn btn-sm btn-default" intro="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('intro.store') }}"
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
            $('#text_in').summernote('code', '<h2 style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;">Sambutan Kepala Kejaksaan&nbsp;</h2><p style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;"><br></p><p style="text-align: justify; margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2;"><font color="#000000" face="Playfair Display, serif"><span style="font-size: 14px;">Puji syukur kita panjatkan Kehadirat Tuhan Yang Maha Esa sehubungan dengan telah berfungsinya Website Kejaksaan Tinggi Lampung yang merupakan salah satu langkah upaya penerapan teknologi informasi menuju reformasi birokrasi kejaksaan untuk Indonesia lebih maju. </span></font></p><p style="text-align: justify; margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2;"><font color="#000000" face="Playfair Display, serif"><span style="font-size: 14px;"><br></span></font></p><p style="text-align: justify; margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2;"><font color="#000000" face="Playfair Display, serif"><span style="font-size: 14px;">KEJAKSAAN UNTUK INDONESIA</span></font><br></p>');
        } else {
            $('#text_in').summernote('code', '');
        }
    }
</script>