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
                                    <h2 class="card-title">Ubah {{ $subtitle != '' ? $subtitle : $title }}</h2>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('cover.index') }}" class="btn btn-sm btn-default" cover="button">
                                        <i class="fas fa-chevron-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="card-body">
                        <form id="form" class="form-horizontal form-bordered" action="{{ route('cover.update') }}"
                            method="post" novalidate enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="cover_id" value="{{ $info->cover_id }}" />
                            <input type="hidden" name="cover_image" value="{{ $info->cover_image }}" />
                            <input type="hidden" name="cover_size" value="{{ $info->cover_size }}" />
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2"></label>
                                <div class="col-sm-9">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" id="checkboxExample2" name="status" value="1"
                                            {{ $info->cover_status == 1 ? 'checked' : '' }} />
                                        <label for="checkboxExample2"><?php echo Status::tipeStatus(1); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Nama <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nama" value="{{ $info->cover_name }}" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="desc" name="desc" rows="2" style="resize: none;"
                                        placeholder="Keterangan ...">{{ strip_tags($info->cover_description) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Gambar</label>
                                <div class="col-sm-2">
                                    <?php if($info->cover_image != "") { ?>
                                    <img src="{{ $info->cover_path }}" alt="Webphada" class="img-thumbnail" />
                                    <?php } else { ?>
                                    <img src="{{ asset('assets/img/logo-webphada.png') }}" alt="Webphada"
                                        class=" user-image img-thumbnail" />
                                    <?php } ?>
                                </div>
                                <div class="col-sm-7">
                                    <input type="file" accept="image/jpg, image/png, image/jpeg" class="form-control"
                                        id="userfile" name="userfile" placeholder="Gambar" autocomplete="off" />
                                    <span class="help-block">Ukuran maksimum 10MB (JPG | PNG | JPEG). Dimensi gambar
                                        1920x300</span>
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
