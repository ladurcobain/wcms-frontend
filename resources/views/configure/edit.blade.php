@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col">
            <section class="card card-featured card-featured-primary card-big-info">
                <header class="card-header">
                    <h2 class="card-title">Ubah {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                </header>
                <div class="card-body">
                    @if ($alert = Session::get('alrt'))
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" tutorial="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="tabs-modern row" style="min-height: 490px;">
                        <div class="col-lg-2-5 col-xl-1-5">
                            <div class="nav flex-column" id="tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="info-tab" data-bs-toggle="pill" data-bs-target="#info" href="#info" role="tab" aria-controls="info" aria-selected="true"><i class="bx bx-id-card me-2"></i> Informasi Umum</a>
                                <a class="nav-link" id="medsos-tab" data-bs-toggle="pill" data-bs-target="#medsos" href="#medsos" role="tab" aria-controls="medsos" aria-selected="false"><i class="bx bx-link me-2"></i> Widget & SEO</a>
                                <a class="nav-link" id="support-tab" data-bs-toggle="pill" data-bs-target="#support" href="#support" role="tab" aria-controls="support" aria-selected="false"><i class="bx bx-support me-2"></i> Bantuan Layanan</a>
                                <a class="nav-link" id="videos-tab" data-bs-toggle="pill" data-bs-target="#videos" href="#videos" role="tab" aria-controls="videos" aria-selected="false"><i class="bx bx-movie-play me-2"></i> Video Sambutan</a>
                                <a class="nav-link" id="patterns-tab" data-bs-toggle="pill" data-bs-target="#patterns" href="#patterns" role="tab" aria-controls="patterns" aria-selected="false"><i class="bx bx-image me-2"></i> Gambar Sampul</a>
                                <a class="nav-link" id="backgrounds-tab" data-bs-toggle="pill" data-bs-target="#backgrounds" href="#backgrounds" role="tab" aria-controls="backgrounds" aria-selected="false"><i class="bx bx-photo-album me-2"></i> Latar Belakang</a>
                            </div>
                        </div>
                        <div class="col-lg-3-5 col-xl-4-5">
                            <div class="tab-content" id="tabContent">
                                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                                    <div class="card-body">
                                        <form id="form" class="form-horizontal form-bordered" action="{{ route('configure.updateinfo') }}" method="post" novalidate>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                            <input type="hidden" name="status" value="1" readonly />
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Tipe</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control"
                                                        value="{{ App\Helpers\Status::tipeSatker($info->satker_type) }}" readonly />
                                                </div>
                                            </div>
                                            <div class="form-group row pt-3 pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Slug</label>
                                                <div class="col-sm-9">
                                                    <input type="text" value="{{ $info->satker_slug }}" class="form-control"readonly />
                                                </div>
                                            </div>
                                            <div class="form-group row pt-3 pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Kode</label>
                                                <div class="col-sm-9">
                                                    <input type="text" value="{{ $info->satker_code }}" class="form-control"readonly />
                                                </div>
                                            </div>
                                            <div class="form-group row pt-3 pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Nama</label>
                                                <div class="col-sm-9">
                                                    <input type="text" value="{{ $info->satker_name }}" class="form-control"readonly />
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Url Website</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="url" name="url"
                                                        value="{{ $info->satker_url }}" placeholder="Url Website"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">No. Telepon</label>
                                                <div class="col-sm-9">
                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');"  class="form-control" id="phone" name="phone"
                                                        value="{{ $info->satker_phone }}" placeholder="No. Telepon"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Surel</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        value="{{ $info->satker_email }}" placeholder="Surel"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Alamat</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="address" name="address" rows="2"
                                                        style="resize: none;"
                                                        placeholder="Alamat ...">{{ strip_tags($info->satker_address) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Tampilan Memuat Halaman</label>
                                                <div class="col-sm-9">
                                                    <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Pilih Tampilan Memuat Halaman ...", "allowClear": true }' id="overlay" name="overlay">
                                                        <option></option>
                                                        <?php for($i=0; $i<=10; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" {{ ($info->satker_overlay == $i)? 'selected':'' }} ><?php echo Status::loadingOverlay($i); ?></option>           
                                                        <?php } ?>
                                                    </select>	
                                                </div>
                                            </div>
                                            <div class="row justify-content-end pb-3">
                                                <div class="col-sm-9">
                                                    <button type="reset" class="btn btn-default">Batal</button>
                                                    <button class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="medsos" role="tabpanel" aria-labelledby="medsos-tab">
                                    <div class="card-body">
                                        <form id="form" class="form-horizontal form-bordered" action="{{ route('configure.updatemedsos') }}" method="post" novalidate>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Url Map Embed</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="embed_map" name="embed_map" rows="1" style="resize: none;" placeholder="https://maps.google.com/maps?q=kejaksaan agung republik indonesia&t=&z=10&ie=UTF8&iwloc=&output=embed">{{ $info->satker_map }}</textarea>
                                                    <span class="help-block">Cara menambahkan <a href="javascript:void(0);" OnClick="modal_google();">Url Google Maps</a></span>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Url Profil Facebook</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="url_facebook" name="url_facebook" rows="1" style="resize: none;" placeholder="https://www.facebook.com/people/Kejaksaan-RI/100064391933878/">{{ $info->satker_facebook }}</textarea>
                                                    <span class="help-block">Cara menambahkan <a href="javascript:void(0);" OnClick="modal_facebook();">Url Profil Facebook</a></span>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Url Profil Twitter</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="url_twitter" name="url_twitter" rows="1" style="resize: none;" placeholder="https://twitter.com/KejaksaanRI">{{ $info->satker_twitter }}</textarea>
                                                    <span class="help-block">Cara menambahkan <a href="javascript:void(0);" OnClick="modal_twitter();">Url Profil Twitter</a></span>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Url Profil Instagram</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="url_instagram" name="url_instagram" rows="1" style="resize: none;" placeholder="https://www.instagram.com/kejaksaan.ri/">{{ $info->satker_instagram }}</textarea>
                                                    <span class="help-block">Cara menambahkan <a href="javascript:void(0);" OnClick="modal_instagram();">Url Profil Instagram</a></span>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Konten SEO</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="description" name="description" rows="3"
                                                        style="resize: none;"
                                                        placeholder="Konten SEO ...">{{ strip_tags($info->satker_description) }}</textarea>
                                                    <span class="help-block">Direkomendasikan untuk menuliskan teks dalam jumlah antara 150 hingga 160 karakter</span>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end pb-3">
                                                <div class="col-sm-9">
                                                    <button type="reset" class="btn btn-default">Batal</button>
                                                    <button class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="support" role="tabpanel" aria-labelledby="support-tab">
                                    <div class="card-body">
                                        <form id="form" class="form-horizontal form-bordered" action="{{ route('configure.updatesupport') }}" method="post" novalidate>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">No. WhatsApp</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                                        value="{{ $info->satker_whatsapp }}" placeholder="No. WhatsApp"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Teks Pembuka</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" id="opening" name="opening"
                                                        value="{{ $info->satker_opening }}" placeholder="Teks Pembuka"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="row justify-content-end pb-3">
                                                <div class="col-sm-9">
                                                    <button type="reset" class="btn btn-default">Batal</button>
                                                    <button class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                                    <div class="card-body">
                                        <form id="form" class="form-horizontal form-bordered" action="{{ route('configure.updatevideos') }}" method="post" novalidate>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Judul Video</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="videotitle" name="videotitle"
                                                        value="{{ $info->satker_videotitle }}" placeholder="Judul Video"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end pt-2">Keterangan Video</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="videosubtitle" name="videosubtitle"
                                                        value="{{ $info->satker_videosubtitle }}" placeholder="Keterangan Video"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group row pb-2">
                                                <label class="col-sm-3 control-label text-sm-end">Tipe Video</label>
                                                <div class="col-lg-3">
                                                    <div class="radio-custom radio-primary">
                                                        <input type="radio" name="typeVideo" value="1" onChange="showTypeVideo(1);" <?php echo (($info->satker_videotype == 1)?"checked":""); ?> />
                                                        <label><?php echo Status::tipeVideo(1); ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="radio-custom radio-primary">
                                                        <input type="radio" name="typeVideo" value="2" onChange="showTypeVideo(2);" <?php echo (($info->satker_videotype == 2)?"checked":""); ?> />
                                                        <label><?php echo Status::tipeVideo(2); ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3"></div>
                                            </div>
                                            <div id="form-embed" style="<?php echo (($info->satker_videotype == 1)?"display:block;":"display:none;"); ?>">
                                                <div class="form-group row pb-2">
                                                    <label class="col-sm-3 control-label text-sm-end pt-2">Url Link Video</label>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" id="videolink" name="videolink"
                                                            value="{{ $info->satker_videolink }}" placeholder="Url Link Video"
                                                            autocomplete="off" />
                                                        <span class="help-block">Cara menambahkan <a href="javascript:void(0);" OnClick="modal_youtube();">Url Youtube</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="form-upload" style="<?php echo (($info->satker_videotype == 2)?"display:block;":"display:none;"); ?>">
                                                <div class="form-group row pb-2">
                                                    <label class="col-sm-3 control-label text-sm-end pt-2">Unggah Berkas Video</label>
                                                    <?php if($info->satker_videopath != "") { ?>
                                                    <div class="col-sm-3">
                                                        <video width="180" controls>
                                                            <source src="<?php echo $info->satker_videopath; ?>" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <?php } else { ?>
                                                    <div class="col-sm-9">
                                                    <?php } ?>
                                                        <input type="file" class="form-control" id="userfile" name="userfile" placeholder="Video" autocomplete="off" />
                                                        <span class="help-block">Ukuran maksimum 10MB (MP4 | AVI).</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end pb-3">
                                                <div class="col-sm-9">
                                                    <button type="reset" class="btn btn-default">Batal</button>
                                                    <button class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="patterns" role="tabpanel" aria-labelledby="patterns-tab">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs tabs-primary justify-content-end">
                                            <li class="nav-item <?php echo ($info->is_cover != 1)? 'active':'' ?>">
                                                <a class="nav-link" data-bs-target="#patternz" href="#patternz" data-bs-toggle="tab">Gambar Sebagian</a>
                                            </li>
                                            <li class="nav-item <?php echo ($info->is_cover == 1)? 'active':'' ?>">
                                                <a class="nav-link" data-bs-target="#coverz" href="#coverz" data-bs-toggle="tab">Gambar Penuh</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="patternz" class="tab-pane <?php echo ($info->is_cover != 1)? 'active':'' ?>">
                                                <form id="form" class="form-horizontal form-bordered" action="{{ route('configure.updatepatterns') }}" method="post" novalidate enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                                    <input type="hidden" name="is_cover" value="0" />
                                                    <div class="form-group row pb-2">
                                                        <div class="row mg-files" data-sort-destination data-sort-id="media-gallery">
                                                            <div class="isotope-item document col-sm-6 col-md-4 col-lg-3">
                                                                <div class="thumbnail">
                                                                    <div class="thumb-preview">
                                                                        <div class="mg-thumb-options">
                                                                            <div style="border: 1px solid grey;height:100px;margin:2px;"></div>
                                                                            <div class="mg-toolbar">
                                                                                <div class="mg-option radio-custom radio-inline">
                                                                                    <input type="radio" name="pattern" value=""  <?php echo ($info->satker_pattern == '')? 'checked':'' ?> />
                                                                                    <label>Transparan</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php foreach($pattern as $r) { ?>
                                                            <div class="isotope-item document col-sm-6 col-md-4 col-lg-3">
                                                                <div class="thumbnail">
                                                                    <div class="thumb-preview">
                                                                        <a class="thumb-image" href="<?php echo $r->pattern_path; ?>">
                                                                            <img style="width:100%;" src="<?php echo $r->pattern_path; ?>" class="img-fluid" alt="<?php echo $r->pattern_name; ?>" />
                                                                        </a>
                                                                        <div class="mg-thumb-options">
                                                                            <div class="mg-toolbar">
                                                                                <div class="mg-option radio-custom radio-inline">
                                                                                    <input type="radio" id="file_1" name="pattern" value="<?php echo $r->pattern_path; ?>" <?php echo ($info->satker_pattern == $r->pattern_path)? 'checked':'' ?> />
                                                                                    <label for="file_1"><?php echo $r->pattern_name; ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end pb-3">
                                                        <div class="col-sm-9">
                                                            <button type="reset" class="btn btn-default">Batal</button>
                                                            <button class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div id="coverz" class="tab-pane <?php echo ($info->is_cover == 1)? 'active':'' ?>">
                                                <form id="form" class="form-horizontal form-bordered" action="{{ route('configure.updatepatterns') }}" method="post" novalidate enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                                    <input type="hidden" name="is_cover" value="1" />
                                                    <div class="form-group row pb-2">
                                                        <div class="row mg-files" data-sort-destination data-sort-id="media-gallery">
                                                            <div class="isotope-item document col-sm-6 col-md-4 col-lg-3">
                                                                <div class="thumbnail">
                                                                    <div class="thumb-preview">
                                                                        <div class="mg-thumb-options">
                                                                            <div style="border: 1px solid grey;height:100px;margin:2px;"></div>
                                                                            <div class="mg-toolbar">
                                                                                <div class="mg-option radio-custom radio-inline">
                                                                                    <input type="radio" name="pattern" value=""  <?php echo ($info->satker_pattern == '')? 'checked':'' ?> />
                                                                                    <label>Transparan</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php foreach($cover as $r) { ?>
                                                            <div class="isotope-item document col-sm-6 col-md-4 col-lg-3">
                                                                <div class="thumbnail">
                                                                    <div class="thumb-preview">
                                                                        <a class="thumb-image" href="<?php echo $r->cover_path; ?>">
                                                                            <img style="width:100%;" src="<?php echo $r->cover_path; ?>" class="img-fluid" alt="<?php echo $r->cover_name; ?>" />
                                                                        </a>
                                                                        <div class="mg-thumb-options">
                                                                            <div class="mg-toolbar">
                                                                                <div class="mg-option radio-custom radio-inline">
                                                                                    <input type="radio" id="file_1" name="pattern" value="<?php echo $r->cover_path; ?>" <?php echo ($info->satker_pattern == $r->cover_path)? 'checked':'' ?> />
                                                                                    <label for="file_1"><?php echo $r->cover_name; ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end pb-3">
                                                        <div class="col-sm-9">
                                                            <button type="reset" class="btn btn-default">Batal</button>
                                                            <button class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="backgrounds" role="tabpanel" aria-labelledby="backgrounds-tab">
                                    <div class="card-body">
                                        <form id="form" class="form-horizontal form-bordered" action="{{ route('configure.updatebackgrounds') }}" method="post" novalidate enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                            <div class="form-group row pb-2">
                                                <div class="row mg-files" data-sort-destination data-sort-id="media-gallery">
                                                    <div class="isotope-item document col-sm-6 col-md-4 col-lg-3">
                                                        <div class="thumbnail">
                                                            <div class="thumb-preview">
                                                                <div class="mg-thumb-options">
                                                                    <div style="border: 1px solid grey;height:100px;margin:2px;"></div>
                                                                    <div class="mg-toolbar">
                                                                        <div class="mg-option radio-custom radio-inline">
                                                                            <input type="radio" name="background" value=""  <?php echo ($info->satker_background == '')? 'checked':'' ?> />
                                                                            <label>Transparan</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php foreach($pattern as $r) { ?>
                                                    <div class="isotope-item document col-sm-6 col-md-4 col-lg-3">
                                                        <div class="thumbnail">
                                                            <div class="thumb-preview">
                                                                <a class="thumb-image" href="<?php echo $r->pattern_path; ?>">
                                                                    <img style="width:100%;" src="<?php echo $r->pattern_path; ?>" class="img-fluid" alt="<?php echo $r->pattern_name; ?>" />
                                                                </a>
                                                                <div class="mg-thumb-options">
                                                                    <div class="mg-toolbar">
                                                                        <div class="mg-option radio-custom radio-inline">
                                                                            <input type="radio" name="background" value="<?php echo $r->pattern_path; ?>" <?php echo ($info->satker_background == $r->pattern_path)? 'checked':'' ?> />
                                                                            <label><?php echo $r->pattern_name; ?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end pb-3">
                                                <div class="col-sm-9">
                                                    <button type="reset" class="btn btn-default">Batal</button>
                                                    <button class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="card card-modern card-big-info">
                <header class="card-header">
                    <h2 class="card-title">Pengaturan Menu Navigasi</h2>
                </header>
                <div class="card-body">
                    <div class="tabs tabs-dark">
                        <ul class="nav nav-tabs">
                            <?php
                                $tab_about = ""; $tab_information = ""; $tab_conference = ""; $tab_archive = ""; $tab_integrity = ""; $tab_contact = "";

                                $tab = Session::get('tab');   
                                switch($tab) {
                                    case 'about' :
                                        $tab_about = " active";
                                    break;    
                                    case 'information' :
                                        $tab_information = " active";
                                    break; 
                                    case 'conference' :
                                        $tab_conference = " active";
                                    break; 
                                    case 'archive' :
                                        $tab_archive = " active";
                                    break; 
                                    case 'integrity' :
                                        $tab_integrity = " active";
                                    break;
                                    case 'contact' :
                                        $tab_contact = " active";
                                    break; 
                                    default :
                                        $tab_about = " active";
                                    break;
                                }
                            ?>
                            <li class="nav-item <?php echo $tab_about; ?>">
                                <a class="nav-link" data-bs-target="#about" href="#about" 
                                data-bs-toggle="tab">Tentang Kami</a>
                            </li>
                            <li class="nav-item <?php echo $tab_information; ?>">
                                <a class="nav-link" data-bs-target="#information" href="#information" 
                                data-bs-toggle="tab">Informasi Umum</a>
                            </li>
                            <li class="nav-item <?php echo $tab_conference; ?>">
                                <a class="nav-link" data-bs-target="#conference" href="#conference" 
                                data-bs-toggle="tab">Konten Berita</a>
                            </li>
                            <li class="nav-item <?php echo $tab_archive; ?>">
                                <a class="nav-link" data-bs-target="#archive" href="#archive" 
                                data-bs-toggle="tab">Arsip Pemberkasan</a>
                            </li>
                            <li class="nav-item <?php echo $tab_integrity; ?>">
                                <a class="nav-link" data-bs-target="#integrity" href="#integrity"
                                    data-bs-toggle="tab">Zona Integritas</a>
                            </li>
                            <li class="nav-item <?php echo $tab_contact; ?>">
                                <a class="nav-link" data-bs-target="#contact" href="#contact"
                                    data-bs-toggle="tab">Kontak Kami</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="about" class="tab-pane <?php echo $tab_about; ?>">
                            <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('configure.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                <input type="hidden" name="tab_name" value="about" />
                                <input type="hidden" name="parent" value="2" />
                                
                                <div class="row">
                                    @foreach($menu as $key => $val)
                                    @if($val->menu_parent == 2)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="menus[]" value="{{ $val->menu_id }}" <?php if (in_array($val->menu_id, $navigations)) { echo "checked"; } ?> />
                                                <label>{{ $val->menu_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    <div class="row justify-content-end pt-3">
                                        <div class="col-sm-11">
                                            <button type="reset" id="btn_reset" class="btn btn-default">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>      
                            </form>
                        </div> 
                        <div id="information" class="tab-pane <?php echo $tab_information; ?>">
                            <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('configure.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                <input type="hidden" name="tab_name" value="information" />
                                <input type="hidden" name="parent" value="3" />
                                
                                <div class="row">
                                    @foreach($menu as $key => $val)
                                    @if($val->menu_parent == 3)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="menus[]" value="{{ $val->menu_id }}" <?php if (in_array($val->menu_id, $navigations)) { echo "checked"; } ?> />
                                                <label>{{ $val->menu_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    <div class="row justify-content-end pt-3">
                                        <div class="col-sm-11">
                                            <button type="reset" id="btn_reset" class="btn btn-default">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>      
                            </form>
                        </div> 
                        <div id="conference" class="tab-pane <?php echo $tab_conference; ?>">
                        <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('configure.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                <input type="hidden" name="tab_name" value="conference" />
                                <input type="hidden" name="parent" value="4" />
                                
                                <div class="row">
                                    @foreach($menu as $key => $val)
                                    @if($val->menu_parent == 4)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="menus[]" value="{{ $val->menu_id }}" <?php if (in_array($val->menu_id, $navigations)) { echo "checked"; } ?> />
                                                <label>{{ $val->menu_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    <div class="row justify-content-end pt-3">
                                        <div class="col-sm-11">
                                            <button type="reset" id="btn_reset" class="btn btn-default">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>      
                            </form>
                        </div> 
                        <div id="archive" class="tab-pane <?php echo $tab_archive; ?>">
                        <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('configure.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                <input type="hidden" name="tab_name" value="archive" />
                                <input type="hidden" name="parent" value="5" />
                                
                                <div class="row">
                                    @foreach($menu as $key => $val)
                                    @if($val->menu_parent == 5)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="menus[]" value="{{ $val->menu_id }}" <?php if (in_array($val->menu_id, $navigations)) { echo "checked"; } ?> />
                                                <label>{{ $val->menu_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    <div class="row justify-content-end pt-3">
                                        <div class="col-sm-11">
                                            <button type="reset" id="btn_reset" class="btn btn-default">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>      
                            </form>
                        </div> 
                        <div id="integrity" class="tab-pane <?php echo $tab_integrity; ?>">
                            <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('configure.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                <input type="hidden" name="tab_name" value="integrity" />
                                <input type="hidden" name="parent" value="6" />
                                
                                <div class="row">
                                    @foreach($menu as $key => $val)
                                    @if($val->menu_parent == 6)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="menus[]" value="{{ $val->menu_id }}" <?php if (in_array($val->menu_id, $navigations)) { echo "checked"; } ?> />
                                                <label>{{ $val->menu_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    <div class="row justify-content-end pt-3">
                                        <div class="col-sm-11">
                                            <button type="reset" id="btn_reset" class="btn btn-default">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>      
                            </form>
                        </div>
                        <div id="contact" class="tab-pane <?php echo $tab_contact; ?>">
                            <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('configure.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="satker_id" value="{{ $info->satker_id }}" />
                                <input type="hidden" name="tab_name" value="contact" />
                                
                                <div class="row">
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="menus[]" value="7" <?php if (in_array(7, $navigations)) { echo "checked"; } ?> />
                                                <label>Kontak Kami</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end pt-3">
                                        <div class="col-sm-11">
                                            <button type="reset" id="btn_reset" class="btn btn-default">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>      
                            </form>
                        </div> 
                    </div>     
                </div> 
            </section>
        </div>
    </div>
</div>

<div id="modalFacebook" class="modal animated bounceIn" tabindex="-1" role="dialog" aria-labelledby="modalFacebook" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="modal-content">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="ecommerce-timeline mb-3">
                            <div class="tm-title">
                                <h5 class="m-0 pt-2 pb-2 text-dark font-weight-semibold text-uppercase">Cara menambahkan Url Profil Facebook</h5>
                            </div>
                            <div class="ecommerce-timeline-items-wrapper">
                                <div class="ecommerce-timeline-item">
                                    <small>Buka website <a target="_blank" href="https://www.facebook.com/" class="text-color-primary">Facebook</a></small>
                                    <p>Kemudian salin <i>url facebook</i> profil tersebut</p>
                                </div>
                                <div class="ecommerce-timeline-item">
                                    <p>Mencari profil berdasarkan nama</p>
                                    <div>
                                        <ol>
                                            <li>Klik <i class="bx bx-search"></i> Cari di Facebook di kiri atas</li>
                                            <li>Masukkan nama di bilah pencarian, lalu ketuk atau di kanan bawah</li>
                                            <li>Ketuk <i class="bx bx-user"></i> ORANG di bagian atas</li>
                                            <li>Anda bisa memilih untuk memfilter berdasarkan kota, pendidikan, pekerjaan dan lainnnya</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="ecommerce-timeline-item">
                                    <div class="thumbnail-gallery">
                                        <img class="img-fluid" width="100%" src="{{ asset('assets/img/guide_facebook.png') }}" alt="Pencarian Facebook" />
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
    function modal_facebook() {
        $('#modalFacebook').modal('show');
    }
</script>

<div id="modalTwitter" class="modal animated bounceIn" tabindex="-1" role="dialog" aria-labelledby="modalTwitter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="modal-content">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="ecommerce-timeline mb-3">
                            <div class="tm-title">
                                <h5 class="m-0 pt-2 pb-2 text-dark font-weight-semibold text-uppercase">Cara menambahkan Url Profil Twitter</h5>
                            </div>
                            <div class="ecommerce-timeline-items-wrapper">
                                <div class="ecommerce-timeline-item">
                                    <small>Buka website <a target="_blank" href="https://twitter.com/" class="text-color-primary">Twitter</a></small>
                                    <p>Kemudian salin <i>url twitter</i> profil tersebut</p>
                                </div>
                                <div class="ecommerce-timeline-item">
                                    <p>Mencari profil berdasarkan nama</p>
                                    <div>
                                        <ol>
                                            <li>Ketik nama atau nama pengguna orang yang ingin dicari di kotak pencarian pada bagian atas beranda</li>
                                            <li>Atau sentuh tab Jelajah <i class="bx bx-search"></i> untuk mengakses kotak pencarian</li>
                                            <li>Anda akan melihat 6 opsi yang berbeda untuk memperinci hasil pencarian</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="ecommerce-timeline-item">
                                    <div class="thumbnail-gallery">
                                        <img class="img-fluid" width="100%" src="{{ asset('assets/img/guide_twitter.png') }}" alt="Pencarian twitter" />
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
    function modal_twitter() {
        $('#modalTwitter').modal('show');
    }
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

<div id="modalGoogle" class="modal animated bounceIn" tabindex="-1" role="dialog" aria-labelledby="modalGoogle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="modal-content">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="ecommerce-timeline mb-3">
                            <div class="tm-title">
                                <h5 class="m-0 pt-2 pb-2 text-dark font-weight-semibold text-uppercase">Cara menambahkan Url Google Maps</h5>
                            </div>    
                            <div class="ecommerce-timeline-items-wrapper">
                                <div class="ecommerce-timeline-item">
                                    <small>Buka website <a target="_blank" href="https://www.google.com/maps" class="text-color-primary">Google Maps</a></small>
                                    <p>Kemudian salin <i>url google maps</i> tersebut</p>
                                </div>
                                <div class="ecommerce-timeline-item">
                                    <p>Mencari profil berdasarkan nama</p>
                                    <div>
                                        <ol>
                                            <li>Klik <i class="bx bx-search"></i> Cari di google di kiri atas google.</li>
                                            <li>Pada kotak pencarian, ketikkan nama lokasi yang dinginkan dan kemudian tekan Enter</li>
                                            <li>Kemudian klik <i class="bx bx-share-alt"></i> Bagikan dan pilih Embed map</li>
                                            <li>Klik pada kolom Medium kemudian salin url tersebut</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="ecommerce-timeline-item">
                                    <div class="thumbnail-gallery">
                                        <img class="img-fluid" width="100%" src="{{ asset('assets/img/guide_map.png') }}" alt="Pencarian google" />
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
    function modal_google() {
        $('#modalGoogle').modal('show');
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