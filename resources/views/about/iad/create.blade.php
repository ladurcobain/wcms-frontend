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
                                <a href="{{ route('iad.index') }}" class="btn btn-sm btn-default" iad="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('iad.store') }}"
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
            $('#text_in').summernote('code', '<h2 style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;">Ikatan Adhyaksa Dharmakarini</h2><p style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;"><br></p><p style="text-align: justify; color: rgb(50, 50, 51); overflow-wrap: break-word; font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><span style="font-size: 14px;">Bahwa keberadaan Ikatan Adhyaksa Dharmakarini telah dikukkuhkan oleh Jaksa Agung Republik Indonesia berdasarkan Keputusan Jaksa Agung Republik Indonesia, Tanggal 28 November 2007, Nomor: KEP-124/A/JA/11/2007 tentang Pengukuhan Organisasi Adhyaksa Dharmakarini Kejaksaan Republik Indonesia.</span></p><p style="text-align: justify; color: rgb(50, 50, 51); overflow-wrap: break-word; font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><span style="font-size: 14px;">Bahwa Ikatan Adhyaksa Dharmakarini adalah suatu ikatan istri pegawai Kejaksaan, pegawai perempuan Kejaksaan, istri pensiunan pegawai Kejaksaan, pensiunan pegawai perempuan Kejaksaan, dan janda pegawai Kejaksaa, yang mandiri, non politik dan tidak terkait dengan organisasi politik manapun, mempunyai maksud dan tujuan di bidang Kemanusiaan, Sosial Budaya, Ekonomi dan Pendidikan.</span></p><p style="text-align: justify; color: rgb(50, 50, 51); overflow-wrap: break-word; font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><span style="font-size: 14px;">Bahwa Ikatan Adhyaksa Dharmakarini diperlukan keberadaannya untuk membantu pemerintah Indonesia pada umumnya dan keluarga Kejaksaan pada khususnya yang bertaqwa kepada Tuhan Yang Maha Esa, cerdas, terampil, dan menjunjung tinggi harkat dan martabat serta keluhuran bangsa dan budaya Indonesia, dan seiring dengan perkembangan jaman serta semakin banyaknya jumlah anggota , sehingga ikatan Adhyaksa Dharmakarini harus dikelola secara professional.</span></p><p style="text-align: justify; color: rgb(50, 50, 51); overflow-wrap: break-word; font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><span style="font-size: 14px;">Bahwa untuk membantu terwujudnya usaha tersebut diperlukan suatu wadah ikatan berbentuk badan hokum, sehingga menjadi suatu ikatan yang bersatu padu, berwibawa, dan mampu melaksanakan tugas pengabdian dan pelayanannya terhadap masyarakat Indonesia khususnya keluarga Kejaksaan.</span></p><p style="text-align: justify; color: rgb(50, 50, 51); overflow-wrap: break-word; font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><span style="font-size: 14px;">Bahwa pada tanggal 11 sampai dengan tanggal 13 Desember 2007, di Cianjur, Jawa Barat, telah diadakan Rapat Kerja Nasional Luar Biasa Anggota Ikatan, tentang Perubahan Anggaran Dasar, Perubahan Anggaran rumah Tangga dan Peningkatan Status Hukum Adhyaksa Dharmakarini menjadi ikatan berbadan hukum dengan nama ikatan Adhyaksa Dharmakarini.</span></p><p style="text-align: justify; color: rgb(50, 50, 51); overflow-wrap: break-word; font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><span style="font-size: 14px;">Bahwa berdasarkan Berita Acara Rapat Kerja Nasional Luar Biasa tanggal13 Desember 2007, di Cianjur, Jawa Barat, tentang Perubahan Anggaran Dasar, Anggaran rumah Tangga dan Peningkatan Status Hukum Adhyaksa Dharmakarini menjadi ikatan yang berbadan hukum dengan nama Ikatan Adhyaksa Dharmakarini yang disingkat “ I A D”.</span></p><p style="text-align: justify; color: rgb(50, 50, 51); overflow-wrap: break-word; font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><span style="font-size: 14px;">Maksud dan tujuan ikatan</span></p><p style="text-align: justify; color: rgb(50, 50, 51); overflow-wrap: break-word; font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><span style="font-size: 14px;">Ikatan Adhyaksa Dharmakarini mempunyai maksud dan tujuan di bidang sosial dan kemanusian.</span></p><p style="text-align: justify; color: rgb(50, 50, 51); overflow-wrap: break-word; font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><span style="font-size: 14px;">Kegiatan-kegiatan untuk mencapai tujuan tersebut yaitu :</span></p><ol style="margin-bottom: 11.5px; color: rgb(50, 50, 51); font-family: &quot;Open Sans&quot;, arial, sans-serif; font-size: 17px;"><li style="text-align: justify;"><span style="font-size: 14px;">Mempersatukan seluruh istri pegawai Kejaksaan, pegawai perempuan Kejaksaan, istri pensiunan pegawai Kejaksaan, pensiuanan pegawai perempuan Kejaksaan, dan janda pegawai Kejaksaan menjadi anggota ikata;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Menjaga supaya setiap anggota ikatan menjunjung tinggi kehormatan profesi Kejaksaan sesuai dengan, Undang-Undang yang berlaku dan kode etik Kejaksaan</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Membina anggota dalam memperkokoh rasa persatuan dan kesatuan;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Meningkatkan kepedulian sosial;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Melakukan kegiatan untuk menumbuhkan kesadaran rasa turut memiliki ikatan yang bertanggung jawab, guna terciptanya rasa kebersamaan di antara sesame anggota dalam rangka meningkatkan peranan, manfaat, fungsi dan mutu ikatan;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Melakukan kegiatan untuk meningkatkan mutu dan kemampuan anggota di dalam menjalankan pekerjaan dan profesinya secara professional, guna menjaga dan mempertahankan keluhuran martabat Kejaksaan;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Mengadakan, menyelenggarakan, dan mendirikan Lembaga pendidikan, keterampilan dan pelatihan baik formal maupun non formal.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Mengadakan, menyelenggarakan dokumentasi dan penyebaran informasi dalam bidang pendidikan melalui penerbitan buku-buku, yang tidak diperjualbelikan;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Mengadakan, menyelenggarakan, dan mendirikan Panti Asuhan, Panti Jompo, dan Panti Wreda;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Mengadakan Penelitian di bidang ilmu pengetahuan mengenai Kemasyarakatan, Kemanusiaan;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Mengadakan, menyelenggarakan Studi Banding;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Memberi bantuan kepada korban bencana alam;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Memberi bantuan kepada tuna wisma, fakir miskin, dan gelandangan;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Melestarikan lingkungan hidup.</span></li></ol>');
        } else {
            $('#text_in').summernote('code', '');
        }
    }
</script>