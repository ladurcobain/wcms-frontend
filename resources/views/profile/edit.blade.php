@extends('layouts.app')

@section('title')
    {{ $subtitle != '' ? $subtitle : $title }}
@endsection

@section('content')
    @include('layouts.partials.breadcrumb')

    <style>
        .power-container { 
            background-color: #2E424D; 
            width: 100%; 
            height: 15px; 
            border-radius: 5px; 
        } 
        
        .power-container #power-point { 
            background-color: #D73F40; 
            width: 1%; 
            height: 100%; 
            border-radius: 5px; 
            transition: 0.5s; 
        }
    </style>

    <script>
        function check_password(value) {
            var point = 0; 
            var power = document.getElementById("power-point"); 

            var widthPower =  
                ["1%", "25%", "50%", "75%", "100%"]; 
                var colorPower =  
                ["#D73F40", "#DC6551", "#F2B84F", "#BDE952", "#3ba62f"]; 
        
            if (value.length >= 6) { 
                var arrayTest =  
                    [/[0-9]/, /[a-z]/, /[A-Z]/, /[^0-9a-zA-Z]/]; 
                arrayTest.forEach((item) => { 
                    if (item.test(value)) { 
                        point += 1; 
                    } 
                }); 
            } 

            power.style.width = widthPower[point]; 
            power.style.backgroundColor = colorPower[point]; 
            document.getElementById("strength").value = point; 
        }
    </script>
    
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col">
                <section class="card card-featured card-featured-primary">
                    <header class="card-header">
                        <h2 class="card-title">Ubah {{ $subtitle != '' ? $subtitle : $title }}</h2>
                    </header>

                    <div class="card-body">
                        @if ($alert = Session::get('alrt'))
                            <div class="alert <?php echo $alert == 'error' ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" tutorial="alert">
                                <strong><?php echo $alert == 'error' ? 'Error' : 'Success'; ?>!</strong>
                                <?php echo Session::get('msgs'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="tabs tabs-dark">
                            <ul class="nav nav-tabs">
                                <li class="nav-item active">
                                    <a class="nav-link" data-bs-target="#general" href="#general" data-bs-toggle="tab">Info.
                                        Umum</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-target="#password" href="#password"
                                        data-bs-toggle="tab">Ganti Kata Sandi</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="general" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <div class="thumb-info">
                                                <img src="{{ $info->user_path }}" alt="{{ $info->user_fullname }}"
                                                    class="rounded img-fluid" />
                                                <div class="thumb-info-title">
                                                    <span class="thumb-info-inner">{{ $info->user_fullname }}</span>
                                                    <span
                                                        class="thumb-info-type">{{ Status::tipeUser($info->user_type) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-6">
                                            <form id="form" class="form-horizontal form-bordered"
                                                action="{{ route('profile.update') }}" method="post" novalidate
                                                enctype="multipart/form-data">
                                                
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="user_image" value="{{ $info->user_image }}" />
                                                <div class="form-group row pb-2">
                                                    <label class="col-sm-3 control-label text-sm-end pt-2">Nama <span
                                                            class="required">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="fullname"
                                                            name="fullname" value="{{ $info->user_fullname }}"
                                                            placeholder="Nama" autocomplete="off" required />
                                                    </div>
                                                </div>
                                                <div class="form-group row pb-2">
                                                    <label class="col-sm-3 control-label text-sm-end pt-2">Surel</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="email"
                                                            name="email" value="{{ $info->user_email }}"
                                                            placeholder="Surel" autocomplete="off" required />
                                                    </div>
                                                </div>
                                                <div class="form-group row pb-2">
                                                    <label class="col-sm-3 control-label text-sm-end pt-2">Gambar</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control" id="userfile"
                                                            accept="image/jpg, image/png, image/jpeg" name="userfile"
                                                            placeholder="Gambar" autocomplete="off" />
                                                        <span class="help-block">Ukuran maksimum 10MB (JPG | PNG | JPEG).
                                                            Dimensi gambar 200x200</span>
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
                                    </div>
                                </div>
                                <div id="password" class="tab-pane">
                                    <form id="form" class="form-horizontal form-bordered"
                                        action="{{ route('profile.password') }}" method="post" novalidate>
                                        
                                        <input value="0" name="strength" id="strength" type="text" readonly />
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="form-group row pb-3">
                                            <label class="col-sm-3 control-label text-sm-end pt-2">Kata Sandi Lama <span
                                                    class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="oldpassword"
                                                    name="oldpassword" value="" placeholder="Kata Sandi Lama"
                                                    autocomplete="off" required />
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label class="col-sm-3 control-label text-sm-end pt-2">Kata Sandi Baru <span
                                                    class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="newpassword"
                                                    name="newpassword" value="" placeholder="Kata Sandi Baru"
                                                    autocomplete="off" required onkeyup="check_password(this.value);" />
                                                <span class="help-block">
                                                    <div class="power-container"> 
                                                        <div id="power-point"></div> 
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label class="col-sm-3 control-label text-sm-end pt-2">Konfirmasi Kata Sandi
                                                <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="confirmpassword"
                                                    name="confirmpassword" value=""
                                                    placeholder="Konfirmasi Kata Sandi" autocomplete="off" required />
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
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
