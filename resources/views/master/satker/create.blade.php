@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

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
                                <a href="{{ route('satker.index') }}" class="btn btn-sm btn-default" management="button"> <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('satker.store') }}" method="post" novalidate enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Tipe <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Pilih Tipe ...", "allowClear": true }' id="type" name="type" required>
                                    <option></option>
                                    <?php for($i=0; $i<=4; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo Status::tipeSatker($i); ?></option>           
                                    <?php } ?>
                                </select>				
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Kode <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="code" name="code" placeholder="Kode" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Akronim <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="akronim" name="akronim" placeholder="Akronim" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pt-3 pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Nama <span class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">No. Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" id="phone" name="phone" placeholder="No. Telepon" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Surel</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Surel" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Alamat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="address" name="address" rows="2" style="resize: none;" placeholder="Alamat ..."></textarea>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Url Google Map</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="embed_map" name="embed_map" rows="1" style="resize: none;" placeholder="https://maps.google.com/maps?q=kejaksaan agung republik indonesia&t=&z=10&ie=UTF8&iwloc=&output=embed"></textarea>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Url Profil Facebook</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="url_facebook" name="url_facebook" rows="1" style="resize: none;" placeholder="https://www.facebook.com/people/Kejaksaan-RI/100064391933878/"></textarea>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Url Profil Twitter</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="url_twitter" name="url_twitter" rows="1" style="resize: none;" placeholder="https://www.instagram.com/kejaksaan.ri/"></textarea>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Url Profil Instagram</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="url_instagram" name="url_instagram" rows="1" style="resize: none;" placeholder="https://www.instagram.com/kejaksaan.ri/"></textarea>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Konten SEO</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="description" name="description" rows="3" style="resize: none;" placeholder="Konten SEO ..."></textarea>
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