@extends('layouts.app')

@section('title', $subtitle)

@section('content')

    @include('layouts.partials.breadcrumb')

    <script src="{{ asset('assets/ckeditor_custom/ckeditor.js') }}"></script>

    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col">
                <section class="card card-featured card-featured-primary">
                    <header class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left mt-2">
                                    <h2 class="card-title">Tambah {{ $subtitle != '' ? $subtitle : $title }}</h2>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('news.index') }}" class="btn btn-sm btn-default" info="button">
                                        <i class="fas fa-chevron-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="card-body">
                        <form id="form" class="form-horizontal form-bordered" action="{{ route('news.store') }}"
                            method="post" novalidate enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2"></label>
                                <div class="col-sm-9">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" id="checkboxExample2" name="broadcast" value="1" />
                                        <label for="checkboxExample2">Berita Utama</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Satuan Kerja <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control populate placeholder"
                                        data-plugin-options='{ "placeholder": "Pilih Satuan Kerja ...", "allowClear": false }'
                                        id="satker" name="satker" required>
                                        <option></option>
                                        <?php foreach($satkers as $r) { ?>
                                        <option value="<?php echo $r->satker_id; ?>" <?php echo $satker == $r->satker_id ? 'selected="selected"' : ''; ?>><?php echo $r->satker_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row pt-3 pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Kategori <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select data-plugin-selectTwo class="form-control populate placeholder"
                                        data-plugin-options='{ "placeholder": "Pilih Kategori ...", "allowClear": false }'
                                        id="category" name="category" required onChange="showCategoryNews(this.value);">
                                        <option></option>
                                        <?php for($i=1; $i<=5; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo Status::categoryNews($i); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row pt-3 pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Judul <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Judul" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group row pt-3 pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Tanggal <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <input type="text" data-plugin-datepicker data-provide="datepicker"
                                            data-date-end-date="0d" class="form-control" id="date" name="date"
                                            placeholder="Tanggal" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Teks Bhs. Indonesia </label>
                                <div class="col-sm-9">
                                    <textarea id="editor_in" class="form-control" id="text_in" name="text_in" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Teks Bhs. Inggris</label>
                                <div class="col-sm-9">
                                    <textarea id="editor_en" class="form-control" id="text_en" name="text_en"></textarea>
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Tautan Youtube</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="link_youtube" name="link_youtube"
                                        placeholder="Tautan Youtube" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Tautan Instagram</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="link_instagram" name="link_instagram"
                                        placeholder="Tautan Instagram" autocomplete="off" />
                                </div>
                            </div>
                            <div id="upload-img-news" style="display:none;">
                                <div class="form-group row pt-2 pb-3">
                                    <label class="col-sm-3 control-label text-sm-end pt-2">Gambar </label>
                                    <div class="col-sm-9">
                                        <input type="file" accept="image/jpg, image/png, image/jpeg"
                                            class="form-control" id="userfile" name="userfile" placeholder="Gambar"
                                            autocomplete="off" required />
                                        <span class="help-block">Ukuran maksimum 10MB (JPG | PNG | JPEG). Dimensi gambar
                                            1200x500</span>
                                    </div>
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

    <script>
        CKEDITOR.replace('editor_in');
        CKEDITOR.replace('editor_en');
    </script>

@endsection
