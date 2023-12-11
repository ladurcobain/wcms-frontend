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
                                <a href="{{ route('info.index') }}" class="btn btn-sm btn-default" info="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('info.store') }}"
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
            $('#text_in').summernote('code', '<h1 style="text-align: center;">Pengertian Kejaksaan</h1><h1 style="text-align:center"><p style="text-align: justify; font-size: 13px; letter-spacing: normal;"><span style="font-size: 14px;">Kejaksaan R.I. adalah lembaga negara yang melaksanakan kekuasaan negara, khususnya di bidang penuntutan. Sebagai badan yang berwenang dalam penegakan hukum dan keadilan, Kejaksaan dipimpin oleh Jaksa Agung yang dipilih oleh dan bertanggung jawab kepada Presiden. Kejaksaan Agung, Kejaksaan Tinggi, dan Kejaksaan Negeri merupakan kekuasaan negara khususnya dibidang penuntutan, dimana semuanya merupakan satu kesatuan yang utuh yang tidak dapat dipisahkan.</span></p><p style="text-align: justify; font-size: 13px; letter-spacing: normal;"><span style="font-size: 14px;">Mengacu pada Undang-Undang Republik Indonesia Nomor 11 Tahun 2021 perubahan atas Undang-Undang Nomor 16 Tahun 2004 tentang Kejaksaan Republik Indonesia, Kejaksaan sebagai salah satu lembaga penegak hukum dituntut untuk lebih berperan dalam menegakkan supremasi hukum, perlindungan kepentingan umum, penegakan hak asasi manusia, serta pemberantasan Korupsi, Kolusi, dan Nepotisme (KKN). Didalam UU Kejaksaan yang baru ini, Kejaksaan ri sebagai lembaga pemerintahan yang fungsinya berkaitan dengan kekuaasaan kehakiman yang melaksanakan kekuasaan Negara dibidang penuntutan serta kewenangan lain berdasarkan UU secara merdeka, terlepas dari pengaruh kekuasaan pemerintah dan &nbsp;pengaruh kekuasaan lainnya. (Pasal 2 ayat 1 Undang-Undang Nomor 11 Tahun 2021)</span></p><p style="text-align: justify; font-size: 13px; letter-spacing: normal;"><span style="font-size: 14px;">Dalam menjalankan tugas dan wewenangnya, Kejaksaan dipimpin oleh Jaksa Agung yang membawahi 7 (tujuh) Jaksa Agung Muda, 1 (satu) Kepala Badan Diklat Kejaksaan RI serta 33 Kepala Kejaksaan Tinggi pada tiap provinsi. Undang-Undang Republik Indonesia Nomor 11 Tahun 2021 perubahan atas Undang-Undang Nomor 16 Tahun 2004 tentang Kejaksaan Republik Indonesia berada pada posisi sentral dengan peran strategis dalam pemantapan ketahanan bangsa. Karena Kejaksaan berada di poros dan menjadi filter antara proses penyidikan dan proses pemeriksaan di persidangan serta juga sebagai pelaksana penetapan dan keputusan pengadilan. Sehingga, Lembaga&nbsp;Kejaksaan sebagai pengendali proses perkara (Dominus Litis), karena hanya institusi Kejaksaan yang dapat menentukan apakah suatu kasus dapat diajukan ke Pengadilan atau tidak berdasarkan alat bukti yang sah menurut Hukum Acara Pidana.</span></p><p style="text-align: justify; font-size: 13px; letter-spacing: normal;"><span style="font-size: 14px;">Perlu ditambahkan, Kejaksaan juga merupakan satu-satunya instansi pelaksana putusan pidana (executive ambtenaar). Selain berperan dalam perkara pidana, Kejaksaan juga memiliki peran lain dalam Hukum Perdata dan Tata Usaha Negara, yaitu dapat mewakili Pemerintah dalam Perkara Perdata dan Tata Usaha Negara sebagai Jaksa Pengacara Negara. Jaksa sebagai pelaksana kewenangan tersebut diberi wewenang sebagai Penuntut Umum serta melaksanakan putusan pengadilan, dan wewenang lain berdasarkan Undang-Undang.</span></p></h1>');
        } else {
            $('#text_in').summernote('code', '');
        }
    }
</script>