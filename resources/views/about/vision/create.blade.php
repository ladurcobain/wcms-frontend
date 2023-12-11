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
                                <a href="{{ route('vision.index') }}" class="btn btn-sm btn-default" vision="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('vision.store') }}"
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
            $('#text_in').summernote('code', '<p style="margin-bottom: 15px; color: rgb(102, 102, 102); line-height: 26px; padding: 0px; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><span style="padding: 0px; margin: 0px; font-weight: 900;"></span></p><h2 style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;">Visi dan Misi Kejaksaan R.I</h2><p style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;"><br></p><p style="margin-bottom: 15px; color: rgb(102, 102, 102); line-height: 26px; padding: 0px; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><span style="padding: 0px; margin: 0px; font-weight: 900;">Visi Kejaksaan R.I :</span></p><p style="margin-bottom: 15px; color: rgb(102, 102, 102); line-height: 26px; padding: 0px; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><span style="font-size: 14px;">"Menjadi Lembaga Penegak Hukum yang Professional, Proporsional dan Akuntabel"</span></p><ol style="padding: 0px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><li style="padding: 0px; margin: 0px;"><span style="font-size: 14px;">Lembaga Penegak Hukum: Kejaksaan RI sebagai salah satu lembaga penegak hukum di Indonesia yang mempunyai tugas dan fungsi sebagai penyidik pada tindak pidana tertentu, penuntut umum, pelaksana penetapan hakim, pelaksana putusan pengadilan yang telah memperoleh kekuatan hukum tetap, melakukan pengawasan terhadap pelaksanaan putusan pidana bersyarat, pidana pengawasan dan lepas bersyarat, bertindak sebagai Pengacara Negara serta turut membina ketertiban dan ketentraman umum melalui upaya antara lain : meningkatkan kesadaran hukum masyarakat, Pengamanan kebijakan penegakan hukum dan Pengawasan Aliran Kepercayaan dan penyalahgunaan penodaan agama.</span><br style="padding: 0px; margin: 0px;"><br style="padding: 0px; margin: 0px;"></li><li style="padding: 0px; margin: 0px;">Profesional: Segenap aparatur Kejaksaan RI dalam melaksanakan tugas didasrkan atas nilai luhur TRI KRAMA ADHYAKSA serta kompetensi dan kapabilitas yang ditunjang dengan pengetahuan dan wawasan yang luas serta pengalaman kerja yang memadai dan berpegang teguh pada aturan serta kode etik profesi yang berlaku.<br style="padding: 0px; margin: 0px;"><br style="padding: 0px; margin: 0px;"></li><li style="padding: 0px; margin: 0px;">Proporsional: Dalam melaksanakan tugas dan fungsinya Kejaksaan selalu memakai semboyan yakni menyeimbangkan yang tersurat dan tersirat dengan penuh tanggungjawab, taat azas, efektif dan efisien serta penghargaan terhadap hak-hak publik.<br style="padding: 0px; margin: 0px;"><br style="padding: 0px; margin: 0px;"></li><li style="padding: 0px; margin: 0px;">Akuntabel: Bahwa kinerja Kejaksaan Republik Indonesia dapat dipertanggungjawabkan sesuai dengan ketentuan yang berlaku.</li></ol><p style="margin-bottom: 15px; color: rgb(102, 102, 102); line-height: 26px; padding: 0px; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;">&nbsp;</p><p style="margin-bottom: 15px; color: rgb(102, 102, 102); line-height: 26px; padding: 0px; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><span style="padding: 0px; margin: 0px; font-weight: 900;">Misi Kejaksaan R.I :</span></p><ol style="padding: 0px; margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><li style="padding: 0px; margin: 0px;">Meningkatkan Peran Kejaksaan Republik Indonesia Dalam Program Pencegahan Tindak Pidana.<br style="padding: 0px; margin: 0px;"><br style="padding: 0px; margin: 0px;"></li><li style="padding: 0px; margin: 0px;">Meningkatkan Professionalisme Jaksa Dalam Penanganan Perkara Tindak Pidana.<br style="padding: 0px; margin: 0px;"><br style="padding: 0px; margin: 0px;"></li><li style="padding: 0px; margin: 0px;">Meningkatkan Peran Jaksa Pengacara Negara Dalam Penyelesaian Masalah Perdata dan Tata Usaha Negara.<br style="padding: 0px; margin: 0px;"><br style="padding: 0px; margin: 0px;"></li><li style="padding: 0px; margin: 0px;">Mewujudkan Upaya Penegakan Hukum Memenuhi Rasa Keadilan Masyarakat.<br style="padding: 0px; margin: 0px;"><br style="padding: 0px; margin: 0px;"></li><li style="padding: 0px; margin: 0px;">Mempercepat Pelaksanaan Reformasi Birokrasi dan Tata Kelola Kejaksaan Republik Indonesia yang Bersih dan Bebas Korupsi, Kolusi dan Nepotisme.</li></ol><p style="margin-bottom: 15px; color: rgb(102, 102, 102); line-height: 26px; padding: 0px; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;">&nbsp;</p><p style="margin-bottom: 15px; color: rgb(102, 102, 102); line-height: 26px; padding: 0px; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; text-align: justify;"><em style="padding: 0px; margin: 0px;">(Sumber: Peraturan Jaksa Agung Nomor: 007/A/JA/08/2016 tentang Perubahan Atas Peraturan Jaksa Agung Republik Indonesia Nomor PER-010/A/JA/06/2015 Tentang Rencana Strategis Kejaksaan Republik Indonesia Tahun 2015-2019 tanggal 4 Agustus 2016)</em></p>');
        } else {
            $('#text_in').summernote('code', '');
        }
    }
</script>