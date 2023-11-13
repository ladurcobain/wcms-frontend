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
                                <h2 class="card-title">Detail {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('survey.index') }}" class="btn btn-sm btn-default" user="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered">
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Tanggal</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $info->survey_date }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Pukul</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control"
                                value="{{ $info->survey_time }}" readonly />
                            </div>
                        </div>
                        <hr />
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $info->survey_user }}" readonly />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Penilaian</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $info->survey_value }}" readonly />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="2" style="resize: none;" readonly>{{ strip_tags($info->survey_description) }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection