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
                                <a href="{{ route('role.index') }}" class="btn btn-sm btn-default" role="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('role.update') }}"
                        method="post" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="role_id" value="{{ $info->role_id }}" />
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2"></label>
                            <div class="col-sm-9">
                                <div class="checkbox-custom checkbox-primary">
                                    <input type="checkbox" id="checkboxExample2" name="status" value="1" {{ ($info->role_status == 1)? 'checked':'' }} />
                                    <label for="checkboxExample2"><?php echo Status::tipeStatus(1); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Nama <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama"
                                    value="{{ $info->role_name }}" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="desc" name="desc" rows="2" style="resize: none;"
                                    placeholder="Keterangan ...">{{ strip_tags($info->role_description) }}</textarea>
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
                <br />
                <div class="card-footer">
                    @if ($alert = Session::get('alrt'))
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" role="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="tabs tabs-dark">
                        <ul class="nav nav-tabs">
                            <?php
                                $tab_setting = ""; $tab_master = ""; $tab_user = ""; $tab_file = ""; $tab_other = "";

                                $tab = Session::get('tab');   
                                switch($tab) {
                                    case 'setting' :
                                        $tab_setting = " active";
                                    break;    
                                    case 'master' :
                                        $tab_master = " active";
                                    break; 
                                    case 'user' :
                                        $tab_user = " active";
                                    break; 
                                    case 'file' :
                                        $tab_file = " active";
                                    break; 
                                    case 'other' :
                                        $tab_other = " active";
                                    break; 
                                    default :
                                        $tab_setting = " active";
                                    break;
                                }
                            ?>
                            <li class="nav-item <?php echo $tab_setting; ?>">
                                <a class="nav-link" data-bs-target="#setting" href="#setting" 
                                data-bs-toggle="tab">Pengaturan</a>
                            </li>
                            <li class="nav-item <?php echo $tab_master; ?>">
                                <a class="nav-link" data-bs-target="#master" href="#master" 
                                data-bs-toggle="tab">Data Induk</a>
                            </li>
                            <li class="nav-item <?php echo $tab_user; ?>">
                                <a class="nav-link" data-bs-target="#user" href="#user" 
                                data-bs-toggle="tab">Pengguna</a>
                            </li>
                            <li class="nav-item <?php echo $tab_file; ?>">
                                <a class="nav-link" data-bs-target="#file" href="#file" 
                                data-bs-toggle="tab">Manajemen Berkas</a>
                            </li>
                            <li class="nav-item <?php echo $tab_other; ?>">
                                <a class="nav-link" data-bs-target="#other" href="#other"
                                    data-bs-toggle="tab">Lainnya</a>
                            </li>
                        </ul>
                    </div> 
                    <div class="tab-content">
                        <div id="setting" class="tab-pane <?php echo $tab_setting; ?>">
                            <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('role.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="role_id" value="{{ $info->role_id }}" />
                                <input type="hidden" name="tab_name" value="setting" />
                                <input type="hidden" name="parent" value="2" />
                                
                                <div class="row">
                                    @foreach($menu as $key => $val)
                                    @if($val->module_parent == 2)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="modules[]" value="{{ $val->module_id }}" <?php if (in_array($val->module_id, $authoritys)) { echo "checked"; } ?> />
                                                <label>{{ $val->module_name }}</label>
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
                        <div id="master" class="tab-pane <?php echo $tab_master; ?>">  
                            <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('role.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="role_id" value="{{ $info->role_id }}" />
                                <input type="hidden" name="tab_name" value="master" />
                                <input type="hidden" name="parent" value="3" />
                                
                                <div class="row">
                                    @foreach($menu as $key => $val)
                                    @if($val->module_parent == 3)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="modules[]" value="{{ $val->module_id }}" <?php if (in_array($val->module_id, $authoritys)) { echo "checked"; } ?> />
                                                <label>{{ $val->module_name }}</label>
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
                        <div id="user" class="tab-pane <?php echo $tab_user; ?>">  
                            <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('role.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="role_id" value="{{ $info->role_id }}" />
                                <input type="hidden" name="tab_name" value="user" />
                                <input type="hidden" name="parent" value="4" />
                                
                                <div class="row">
                                    @foreach($menu as $key => $val)
                                    @if($val->module_parent == 4)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="modules[]" value="{{ $val->module_id }}" <?php if (in_array($val->module_id, $authoritys)) { echo "checked"; } ?> />
                                                <label>{{ $val->module_name }}</label>
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
                        <div id="file" class="tab-pane <?php echo $tab_file; ?>">  
                            <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('role.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="role_id" value="{{ $info->role_id }}" />
                                <input type="hidden" name="tab_name" value="file" />
                                <input type="hidden" name="parent" value="5" />
                                
                                <div class="row">
                                    @foreach($menu as $key => $val)
                                    @if($val->module_parent == 5)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="modules[]" value="{{ $val->module_id }}" <?php if (in_array($val->module_id, $authoritys)) { echo "checked"; } ?> />
                                                <label>{{ $val->module_name }}</label>
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
                        <div id="other" class="tab-pane <?php echo $tab_other; ?>">  
                            <form id="form" class="form-horizontal form-bordered"
                                action="{{ route('role.process') }}" method="post" novalidate>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="role_id" value="{{ $info->role_id }}" />
                                <input type="hidden" name="tab_name" value="other" />
                                <input type="hidden" name="parent" value="0" />
                                
                                <div class="row">
                                    @foreach($link as $key => $val)
                                    @if($val->module_id != 1)
                                    <div class="form-group row pb-2">
                                        <label class="col-sm-1  text-sm-end pt-2"></label>
                                        <div class="col-sm-11">
                                            <div class="checkbox-custom checkbox-primary">
                                                <input type="checkbox" name="modules[]" value="{{ $val->module_id }}" <?php if (in_array($val->module_id, $authoritys)) { echo "checked"; } ?> />
                                                <label>{{ $val->module_name }}</label>
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
                    </div>     
                </div>
            </section>
        </div>
    </div>
</div>

@endsection