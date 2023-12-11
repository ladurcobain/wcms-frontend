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
                                <a href="{{ route('mision.index') }}" class="btn btn-sm btn-default" mision="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('mision.store') }}"
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
            $('#text_in').summernote('code', '<h2 style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;">Tugas dan Wewenang</h2><p style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;"><br></p><p class="card-text" style="margin-bottom: 1rem; color: rgb(104, 114, 129); font-family: Poppins, sans-serif; font-size: 16px;"></p><p style="margin-bottom: 1rem; color: rgb(104, 114, 129); font-family: Poppins, sans-serif; font-size: 16px;">TUGAS &amp; WEWENANG&nbsp;</p><p style="margin-bottom: 1rem;"><span style="color: rgb(104, 114, 129); font-family: Poppins, sans-serif; font-size: 14px;">Berdasarkan Pasal 30 Undang Undang Nomor 16 Tahun 2004 tentang Kejaksaan Republik Indonesia, berikut adalah tugas dan wewenang Kejaksaan.</span><br></p><div style="text-align: justify;"><font color="#687281" face="Poppins, sans-serif"><span style="font-size: 16px;"><br></span></font></div><font color="#687281" face="Poppins, sans-serif"><div style="text-align: justify;"><span style="font-size: 14px;">Di bidang pidana :</span></div></font><p></p><ul style="color: rgb(104, 114, 129); font-family: Poppins, sans-serif; font-size: 16px;"><li style="text-align: justify;"><span style="font-size: 14px;">melakukan penuntutan;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">melaksanakan penetapan hakim dan putusan pengadilan yang telah memperoleh kekuatan hukum tetap;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">melakukan pengawasan terhadap pelaksanaan putusan pidana bersyarat, putusan pidana pengawasan, dan keputusan lepas bersyarat;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">melakukan penyidikan terhadap tindak pidana tertentu berdasarkan undang- undang;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">melengkapi berkas perkara tertentu dan untuk itu dapat melakukan pemeriksaan tambahan sebelum dilimpahkan ke pengadilan yang dalam pelaksanaannya dikoordinasikan dengan penyidik.</span></li></ul><p style="margin-bottom: 1rem;"></p><div style="text-align: justify;"><font color="#687281" face="Poppins, sans-serif"><span style="font-size: 16px;"><br></span></font></div><font color="#687281" face="Poppins, sans-serif"><div style="text-align: justify;"><span style="font-size: 14px;">Di bidang perdata dan tata usaha negara :</span></div></font><font color="#687281" face="Poppins, sans-serif"><div style="text-align: justify;"><span style="font-size: 14px;">Kejaksaan dengan kuasa khusus, dapat bertindak baik di dalam maupun di luar pengadilan untuk dan atas nama negara atau pemerintah.</span></div></font><div style="text-align: justify;"><br></div><font color="#687281" face="Poppins, sans-serif"><div style="text-align: justify;"><span style="font-size: 14px;">Dalam bidang ketertiban dan ketenteraman umum, Kejaksaan turut menyelenggarakan kegiatan:</span></div></font><p></p><ul style="color: rgb(104, 114, 129); font-family: Poppins, sans-serif; font-size: 16px;"><li style="text-align: justify;"><span style="font-size: 14px;">peningkatan kesadaran hukum masyarakat;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">pengamanan kebijakan penegakan hukum;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">pengawasan peredaran barang cetakan;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">pengawasan aliran kepercayaan yang dapat membahayakan masyarakat dan negara;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">pencegahan penyalahgunaan dan/atau penodaan agama;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">penelitian dan pengembangan hukum serta statistik kriminal.</span></li></ul>');
        } else {
            $('#text_in').summernote('code', '');
        }
    }
</script>