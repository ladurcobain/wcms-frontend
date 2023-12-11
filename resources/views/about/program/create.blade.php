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
                                <a href="{{ route('program.index') }}" class="btn btn-sm btn-default" program="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('program.store') }}"
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
            $('#text_in').summernote('code', '<h2 style="margin-top: 0px; margin-bottom: 0.5rem; line-height: 1.2; font-size: 2rem; letter-spacing: normal; text-align: center; font-family: &quot;Playfair Display&quot;, serif; color: black;">7 Program Kerja Kejaksaan</h2><p class="has-text-align-center" style="color: var(--wp--preset--color--foreground); line-height: 1.7; font-size: var(--wp--preset--font-size--small); text-align: center; margin-block: 0px; max-width: var(--wp--style--global--content-size); font-family: -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; margin-left: auto !important; margin-right: auto !important;"><br></p><p class="has-medium-font-size" style="text-align: justify; color: var(--wp--preset--color--foreground); line-height: 1.7; font-size: 18px; margin-block: 1.5rem 0px; max-width: var(--wp--style--global--content-size); font-family: -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; margin-left: auto !important; margin-right: auto !important;"><span style="font-size: 14px;">Pada Kamis 03 Februari 2022, Jaksa Agung RI Burhanuddin menetapkan 7 (tujuh) Program Kerja Prioritas Kejaksaan Republik Indonesia Tahun 2022 kepada seluruh jajaran di seluruh Indonesia baik di lingkungan Kejaksaan Agung, Kejaksaan Tinggi, Kejaksaan Negeri, dan Cabang Kejaksaan Negeri.</span></p><p class="has-medium-font-size" style="text-align: justify; color: var(--wp--preset--color--foreground); line-height: 1.7; font-size: 18px; margin-block: 1.5rem 0px; max-width: var(--wp--style--global--content-size); font-family: -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; margin-left: auto !important; margin-right: auto !important;"><span style="font-size: 14px;">Adapun 7 (tujuh) Program Kerja Prioritas Kejaksaan Republik Indonesia Tahun 2022, yang telah ditetapkan oleh Jaksa Agung, yaitu :</span></p><div class="wp-block-columns is-layout-flex wp-container-12" style="color: var(--wp--preset--color--foreground); display: flex; margin-bottom: 1.75em; align-items: center; flex-wrap: nowrap; margin-block: 1.5rem 0px; gap: 1.5rem; max-width: var(--wp--style--global--content-size); font-family: -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; font-size: 18px; margin-left: auto !important; margin-right: auto !important;"><div class="wp-block-column is-layout-flow" style="color: var(--wp--preset--color--foreground); flex-grow: 0; min-width: 0px; overflow-wrap: break-word; word-break: break-word; margin: 0px; flex-basis: 100%;"><div class="wp-block-columns is-layout-flex wp-container-10" style="display: flex; margin-bottom: 1.75em; align-items: center; flex-wrap: nowrap; color: var(--wp--preset--color--foreground); margin-block: 0px; gap: 1.5rem;"><div class="wp-block-column is-layout-flow" style="color: var(--wp--preset--color--foreground); flex-grow: 0; min-width: 0px; overflow-wrap: break-word; word-break: break-word; margin: 0px; flex-basis: 100%;"><ol type="1" class="has-medium-font-size" style="margin-block: 0px; font-size: var(--wp--preset--font-size--medium)  !important;"><li style="text-align: justify;"><span style="font-size: 14px;">Laksanakan penegakan hukum integral yang menempatkan kebijakan penegakan hukum dan kebijakan kriminal sebagai satu kesatuan dalam Kebijakan Pembangunan Nasional;</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Hadirkan penegakan hukum yang berlandaskan Hati Nurani untuk terwujudnya keadilan substantif.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Tingkatkan kualitas penanganan perkara tindak pidana korupsi dan tindak Pidana Pencucian Uang dalam rangka meningkatkan indeks persepsi Korupsi.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Percepat penyelesaian perkara dugaan pelanggaran Hak Asasi Manusia yang Berat secara tuntas dan adil sesuai dengan ketentuan yang berlaku.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Tingkatkan sistem pengawasan internal menuju SDM Kejaksaan yang Profesional dan Berintegritas.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Tingkatkan kepercayaan publik melalui peningkatan kinerja dan strategi komunikasi hukum yang adaptif, inovatif dan kolaboratif.</span></li><li style="text-align: justify;"><span style="font-size: 14px;">Tingkatkan kredibilitas akuntabilitas kinerja, akuntabilitas keuangan dan maturitas sistem pengendalian internal pemerintah.</span></li></ol></div></div></div></div>');
        } else {
            $('#text_in').summernote('code', '');
        }
    }
</script>