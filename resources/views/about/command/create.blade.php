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
                                <a href="{{ route('command.index') }}" class="btn btn-sm btn-default" command="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('command.store') }}"
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
            $('#text_in').summernote({dialogsInBody: true},'code', '<h2 style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;">7 Perintah Harian Jaksa Agung RI</h2><p><span style="color: rgb(50, 50, 50); font-family: -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; font-size: 16px; text-align: center;"><br></span></p><p class="has-medium-font-size" style="text-align: justify; color: var(--wp--preset--color--foreground); line-height: 1.7; font-size: 18px; margin-block: 1.5rem 0px; max-width: var(--wp--style--global--content-size); font-family: -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; margin-left: auto !important; margin-right: auto !important;"><span style="font-size: 14px;">Jaksa Agung RI menyampaikan 7 (tujuh) Perintah Harian untuk diperhatikan dan dilaksanakan dengan baik dan sungguh-sungguh, sebagai pedoman dalam pelaksanaan tugas kepada seluruh jajaran Keluarga Besar Adhyaksa dimanapun berada, sebagai berikut:</span></p><div class="wp-block-columns is-layout-flex wp-container-12" style="color: var(--wp--preset--color--foreground); display: flex; margin-bottom: 1.75em; align-items: center; flex-wrap: nowrap; margin-block: 1.5rem 0px; gap: 1.5rem; max-width: var(--wp--style--global--content-size); font-family: -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; font-size: 18px; margin-left: auto !important; margin-right: auto !important;"><div class="wp-block-column is-layout-flow" style="color: var(--wp--preset--color--foreground); flex-grow: 0; min-width: 0px; overflow-wrap: break-word; word-break: break-word; margin: 0px; flex-basis: 100%;"><ol type="1" style="margin-block: 0px;"><li style="text-align: justify;"><span style="font-size: 14px;">Tingkatkan kapabilitas, kapasitas, dan integritas dalam mengemban kewenangan berdasarkan Undang-Undang.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Kedepankan hati nurani dalam setiap pelaksanaan tugas, fungsi dan kewenangan.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Wujudkan penegakan hukum yang berorientasi pada perlindungan hak dasar manusia.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Tingkatkan penanganan perkara yang menyangkut kepentingan masyarakat.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Akselerasi penegakan hukum yang mendukung Pemulihan Ekonomi Nasional.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Jaga netralitas aparatur Kejaksaan guna menjaga persatuan dan kesatuan bangsa.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Tingkatkan transparansi akuntabilitas kinerja Kejaksaan.</span></li></ol></div></div>');
            
        } else {
            $('#text_in').summernote('code', '');
        }
    }
</script>