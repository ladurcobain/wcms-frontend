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
                                <a href="{{ route('logo.index') }}" class="btn btn-sm btn-default" logo="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('logo.store') }}"
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
            $('#text_in').summernote('code', '<h2 style="text-align: center; margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; font-family: &quot;Playfair Display&quot;, serif; color: black;">Logo &amp; Maknanya</h2><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; text-align: center; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; text-align: center; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><br></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-weight: bolder; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Bintang bersudut tiga</span><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"></span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;">Bintang adalah salah satu benda alam ciptaan Tuhan Yang Maha Esa yang tinggi letaknya dan memancarkan cahaya abadi. Sedangkan jumlah tiga buah merupakan pantulan dari Trapsila Adhyaksa sebagai landasan kejiwaan warga Adhyaksa yang harus dihayati dan diamalkan.</span></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><br></span></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-weight: bolder; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Pedang</span><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"></span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;">Senjata pedang melambangkan kebenaran, senjata untuk membasmi kemungkaran/kebathilan dan kejahatan.</span></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><br></span></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-weight: bolder; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Timbangan</span><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"></span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;">Timbangan adalah lambang keadilan, keadilan yang diperoleh melalui keseimbangan antara suratan dan siratan rasa.</span></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><br></span></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-weight: bolder; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Padi dan Kapas</span><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"></span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Padi dan kapas melambangkan kesejahteraan dan kemakmuran yang menjadi dambaan masyarakat.</span></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-size: 14px;">﻿</span><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><br></span></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-weight: bolder; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Seloka ”Satya Adhi Wicaksana”</span><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"></span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;">Merupakan Trapsila Adhyaksa yang menjadi landasan jiwa dan raihan cita-cita setiap warga Adhyaksa dan mempunyai arti serta makna:</span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Satya : Kesetiaan yang bersumber pada rasa jujur, baik terhadap Tuhan Yang Maha Esa, terhadap diri pribadi dan keluarga maupun kepada sesama manusia.</span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Adhi : kesempurnaan dalam bertugas dan yang berunsur utama, bertanggungjawab baik terhadap Tuhan Yang Maha Esa, terhadap keluarga dan terhadap sesama manusia.</span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Wicaksana : Bijaksana dalam tutur-kata dan tingkah laku, khususnya dalam penerapan kekuasaan dan kewenangannya.</span></p><p style="margin-bottom: 0.5rem; color: black; line-height: 1.2; font-size: 2rem; font-family: &quot;Playfair Display&quot;, serif;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><br></span><span style="font-weight: bolder; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Makna tata warna</span><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"></span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;">Warna kuning diartikan luhur, keluhuran makna yang dikandung dalam gambar/lukisan, keluhuran yang dijadikan cita-cita.</span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><span style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Warna hijau diberi arti tekun, ketekunan yang menjadi landasan pengejaran/pengraihan cita-cita.</span><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><br style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;"><i style="font-family: &quot;Open Sans&quot;, sans-serif; font-size: 16px; text-align: justify;">Sumber: Kepja No. 074/1978 dan Perja No. 018/A/J.A/08/2008</i></p>');
        } else {
            $('#text_in').summernote('code', '');
        }
    }
</script>