@extends('layouts.app')

@section('title', $subtitle)

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-md-12">
    <div class="row">
        <div class="col">
            <section class="card card-featured card-featured-primary">
              <header class="card-header">
                    <h2 class="card-title">Kirim {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                </header>
                <div class="card-body">
                    @if ($alert = Session::get('alrt'))
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" tutorial="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('transmit.store') }}" method="post" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />    
                        <div class="form-group row pb-3">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Pengguna <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Pilih Pengguna ...", "allowClear": true }' id="user_id" name="user_id" required>
                                    <option></option>
                                    <option value="*">Semua Pengguna</option>
                                    <?php foreach($users as $r) { ?>
                                    <option value="<?php echo $r->user_id; ?>"><?php echo $r->user_fullname; ?></option>           
                                    <?php } ?>
                                </select>	
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Judul <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Pesan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="desc" name="desc" rows="2" style="resize: none;" placeholder="Pesan ..."></textarea>
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