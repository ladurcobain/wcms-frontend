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
                                <h2 class="card-title">Ubah {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('regulation.index') }}" class="btn btn-sm btn-default" info="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('regulation.update') }}"
                        method="post" novalidate enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="regulation_id" value="{{ $info->regulation_id }}" />
                        <input type="hidden" name="regulation_file" value="{{ $info->regulation_file }}" />
                        <input type="hidden" name="regulation_size" value="{{ $info->regulation_size }}" />
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2"></label>
                            <div class="col-sm-9">
                                <div class="checkbox-custom checkbox-primary">
                                    <input type="checkbox" id="checkboxExample2" name="status" value="1" {{ ($info->regulation_status == 1)? 'checked':'' }} />
                                    <label for="checkboxExample2"><?php echo Status::tipeStatus(1); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Judul <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul" value="{{ $info->regulation_title }}" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Berkas PDF</label>
                            <div class="col-sm-1">
                                <?php if($info->regulation_file != "") { ?>
                                    <button OnClick="link_new_tab(' {{  $info->regulation_path }} ');" type="button" class="btn btn-sm btn-info"><i class="fas fa-file-pdf"></i></button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-sm btn-default"><i class="fas fa-file-pdf"></i></button>
                                <?php } ?>        
                            </div>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" id="userfile" name="userfile" placeholder="Berkas PDF" autocomplete="off" />
                                <span class="help-block">Ukuran maksimum 20MB (PDF)</span>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="desc" name="desc" rows="2" style="resize: none;"
                                    placeholder="Keterangan ...">{{ strip_tags($info->regulation_description) }}</textarea>
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