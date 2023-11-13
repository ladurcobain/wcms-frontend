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
                                <h2 class="card-title">Ubah {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('news.index') }}" class="btn btn-sm btn-default" info="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('news.update') }}"
                        method="post" novalidate enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="news_id" value="{{ $info->news_id }}" />
                        <input type="hidden" name="news_image" value="{{ $info->news_image }}" />
                        <input type="hidden" name="news_size" value="{{ $info->news_size }}" />
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2"></label>
                            <div class="col-sm-9">
                                <div class="checkbox-custom checkbox-primary">
                                    <input type="checkbox" id="checkboxExample2" name="status" value="1" {{ ($info->news_status == 1)? 'checked':'' }} />
                                    <label for="checkboxExample2"><?php echo Status::tipeNews(1); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Kategori</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $info->news_category }}" readonly />
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Judul <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul" value="{{ $info->news_title }}" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Tanggal <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <input type="text" data-plugin-datepicker data-provide="datepicker" data-date-end-date="0d" class="form-control" id="date" name="date" placeholder="Tanggal" value="{{ $info->news_date }}" autocomplete="off" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Teks Bhs. Indonesia </label>
                            <div class="col-sm-9">
                                <textarea id="editor_in" class="form-control" id="text_in" name="text_in" required>{{ $info->news_text_in }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Teks Bhs. Inggris</label>
                            <div class="col-sm-9">
                                <textarea id="editor_en" class="form-control" id="text_en" name="text_en">{{ $info->news_text_en }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Tautan Youtube</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="link_youtube" name="link_youtube" placeholder="Tautan Youtube" value="{{ $info->news_link_youtube }}" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Tautan Instagram</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="link_instagram" name="link_instagram" placeholder="Tautan Instagram" value="{{ $info->news_link_instagram }}" autocomplete="off" />
                            </div>
                        </div>
                        <?php
                            if(($info->news_category == "Berita") || ($info->news_category == "Pengumuman") || ($info->news_category == "Kegiatan")) { 
                                $display = 'style="display:block;"';
                            }
                            else {
                                $display = 'style="display:none;"';
                            }
                        ?>
                        <div id="upload-img-news" <?php echo $display; ?>>
                            <div class="form-group row pb-3">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Gambar</label>
                                <div class="col-sm-2">
                                    <?php if($info->news_image != "") { ?>
                                        <img src="{{ $info->news_path }}" alt="Webphada" class="img-thumbnail" />
                                    <?php } else { ?>
                                        <img src="{{ asset('assets/img/logo-webphada.png') }}" alt="Webphada" class=" user-image img-thumbnail" />
                                    <?php } ?>        
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" class="form-control" id="userfile" name="userfile" placeholder="Gambar" autocomplete="off" />
                                    <span class="help-block">Ukuran maksimum 10MB (JPG | PNG | JPEG). Dimensi gambar 1200x500</span>
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
    CKEDITOR.replace( 'editor_in' );
    CKEDITOR.replace( 'editor_en' );
</script>

@endsection