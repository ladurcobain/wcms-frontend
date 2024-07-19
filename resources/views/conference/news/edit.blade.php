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
                                    <h2 class="card-title">Ubah {{ $subtitle != '' ? $subtitle : $title }}</h2>
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
                                        <input type="checkbox" id="checkboxExample2" name="status" value="1"
                                            {{ $info->news_status == 1 ? 'checked' : '' }} />
                                        <label for="checkboxExample2"><?php echo Status::tipeNews(1); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pt-3 pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Kategori</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $info->news_category }}"
                                        readonly />
                                </div>
                            </div>
                            <div class="form-group row pt-3 pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Judul <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Judul" value="{{ $info->news_title }}" autocomplete="off" required />
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
                                            placeholder="Tanggal" value="{{ $info->news_date }}" autocomplete="off"
                                            required />
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
                                    <input type="text" class="form-control" id="link_youtube" name="link_youtube"
                                        placeholder="Tautan Youtube" value="{{ $info->news_link_youtube }}"
                                        autocomplete="off" />
                                    <span class="help-block">Cara menambahkan <a href="javascript:void(0);" OnClick="modal_youtube();">Url Youtube</a></span>
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Tautan Instagram</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="link_instagram" name="link_instagram"
                                        placeholder="Tautan Instagram" value="{{ $info->news_link_instagram }}"
                                        autocomplete="off" />
                                    <span class="help-block">Cara menambahkan <a href="javascript:void(0);" OnClick="modal_instagram();">Url Profil Instagram</a></span>
                                </div>
                            </div>
                            <?php
                            if ($info->news_category == 'Berita' || $info->news_category == 'Pengumuman' || $info->news_category == 'Kegiatan') {
                                $display = 'style="display:block;"';
                            } else {
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
                                        <img src="{{ asset('assets/img/logo-webphada.png') }}" alt="Webphada"
                                            class=" user-image img-thumbnail" />
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="file" accept="image/jpg, image/png, image/jpeg"
                                            class="form-control" id="userfile" name="userfile" placeholder="Gambar"
                                            autocomplete="off" />
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

    <div id="modalInstagram" class="modal animated bounceIn" tabindex="-1" role="dialog" aria-labelledby="modalInstagram" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body" id="modal-content">
                    <div class="card card-modern">
                        <div class="card-header">
                            <h2 class="card-title"></h2>
                        </div>
                        <div class="card-body">
                            <div class="ecommerce-timeline mb-3">
                                <div class="tm-title">
                                    <h5 class="m-0 pt-2 pb-2 text-dark font-weight-semibold text-uppercase">Cara menambahkan Url Profil Instagram</h5>
                                </div>
                                <div class="ecommerce-timeline-items-wrapper">
                                    <div class="ecommerce-timeline-item">
                                        <small>Buka website <a target="_blank" href="https://www.instagram.com/" class="text-color-primary">Instagram</a></small>
                                        <p>Kemudian salin <i>url instagram</i> profil tersebut</p>
                                    </div>
                                    <div class="ecommerce-timeline-item">
                                        <p>Mencari profil berdasarkan nama</p>
                                        <div>
                                            <ol>
                                                <li>Ketuk <i class="bx bx-search"></i> ikon kaca pembesar</li>
                                                <li>Ketik nama pengguna orang di Bilah Pencarian</li>
                                                <li>Lihatlah hasilnya dan cobalah untuk cari seseorang yang tepat</li>
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="ecommerce-timeline-item">
                                        <div class="thumbnail-gallery">
                                            <img class="img-fluid" width="100%" src="{{ asset('assets/img/guide_instagram.png') }}" alt="Pencarian instagram" />
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function modal_instagram() {
            $('#modalInstagram').modal('show');
        }
    </script>

    <div id="modalYoutube" class="modal animated bounceIn" tabindex="-1" role="dialog" aria-labelledby="modalYoutube" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body" id="modal-content">
                    <div class="card card-modern">
                        <div class="card-header">
                            <h2 class="card-title"></h2>
                        </div>
                        <div class="card-body">
                            <div class="ecommerce-timeline mb-3">
                                <div class="tm-title">
                                    <h5 class="m-0 pt-2 pb-2 text-dark font-weight-semibold text-uppercase">Cara menambahkan Url Youtube</h5>
                                </div>
                                <div class="ecommerce-timeline-items-wrapper">
                                    <div class="ecommerce-timeline-item">
                                        <small>Buka website <a target="_blank" href="https://www.youtube.com/" class="text-color-primary">Youtube</a></small>
                                        <p>Kemudian salin <i>url youtube</i> video tersebut</p>
                                    </div>
                                    <div class="ecommerce-timeline-item">
                                        <p>Mencari video yang ingin bagikan</p>
                                        <div>
                                            <ol>
                                                <li>Buka video yang ingin Anda bagikan</li>
                                                <li>Di bawah pemutar video, ketuk <i class="bx bx-share"></i> Bagikan</li>
                                                <li>Akan muncul panel yang menampilkan beberapa opsi berbagi</li>
                                                <li>Pilih Salin tautan, untuk menyalin dan menempelkan URL video tersebut</li>
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="ecommerce-timeline-item">
                                        <div class="thumbnail-gallery">
                                            <img class="img-fluid" width="100%" src="{{ asset('assets/img/guide_youtube.png') }}" alt="Pencarian youtube" />
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function modal_youtube() {
            $('#modalYoutube').modal('show');
        }
    </script>
@endsection
