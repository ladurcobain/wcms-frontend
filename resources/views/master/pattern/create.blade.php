@extends('layouts.app')

@section('title', $subtitle)

@section('content')

    @include('layouts.partials.breadcrumb')

    <div class="col-md-12">
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
                                    <a href="{{ route('pattern.index') }}" class="btn btn-sm btn-default" role="button"> <i
                                            class="fas fa-chevron-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="card-body">
                        <form id="form" class="form-horizontal form-bordered" action="{{ route('pattern.store') }}"
                            method="post" novalidate enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group row pb-3">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Nama <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nama" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Gambar <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="file" accept="image/jpg, image/png, image/jpeg" class="form-control"
                                        id="userfile" name="userfile" placeholder="Gambar" autocomplete="off" required />
                                    <span class="help-block">Ukuran maksimum 10MB (JPG | PNG | JPEG). Dimensi gambar
                                        50x50</span>
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-3 control-label text-sm-end pt-2">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="desc" name="desc" rows="2" style="resize: none;"
                                        placeholder="Keterangan ..."></textarea>
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
