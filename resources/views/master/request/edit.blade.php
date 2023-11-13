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
                                <a href="{{ route('request.index') }}" class="btn btn-sm btn-default" request="button">
                                    <i class="fas fa-chevron-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <form id="form" class="form-horizontal form-bordered" action="{{ route('request.update') }}"
                        method="post" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="request_id" value="{{ $info->request_id }}" />
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2"></label>
                            <div class="col-sm-9">
                                <div class="checkbox-custom checkbox-primary">
                                    <input type="checkbox" id="checkboxExample2" name="status" value="1" {{ ($info->request_status == 1)? 'checked':'' }} />
                                    <label for="checkboxExample2"><?php echo Status::tipeStatus(1); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Nama <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama"
                                    value="{{ $info->request_name }}" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Metode <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <select data-plugin-selectTwo class="form-control populate placeholder" id="method" name="method"
                                    data-plugin-options='{ "placeholder": "Pilih Metode ...", "allowClear": false }'>
                                    <option><option>
                                    <option value="GET" <?php echo (($info->request_method == "GET")?'selected="selected"':''); ?>>GET</option>
                                    <option value="POST" <?php echo (($info->request_method == "POST")?'selected="selected"':''); ?>>POST</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Url <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="url" name="url" placeholder="Url"
                                    value="{{ $info->request_url }}" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <label class="col-sm-3 control-label text-sm-end pt-2">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="desc" name="desc" rows="2" style="resize: none;"
                                    placeholder="Keterangan ...">{{ strip_tags($info->request_description) }}</textarea>
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
                    <div class="table-responsive">
                        <header class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <a class="btn btn-sm btn-primary" href="javascript:void(0);" OnClick="dialogParam({{ $info->request_id }});"> <i class="fas fa-plus"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <table class="table table-bordered table-striped mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="10%">Tipe</th>
                                    <th width="25%">Nilai</th>
                                    <th>Catatan</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($list)) { ?>
                                <?php foreach ($list as $row) { ?>
                                <tr>
                                    <td class="center">{{ $row->param_type }}</td>
                                    <td>{{ $row->param_initial }}</td>
                                    <td>{{ $row->param_description }}</td>
                                    <td class="center">
                                        <a href="{{ URL('master/request/remove') }}" onclick="location.href=this.href +'/'+ {{ $row->param_id }} + '/'+ {{ $info->request_id }}; return false;" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                    <tr><td class="center" colspan="4">
                                        <p>
                                            <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                            <span class="va-middle">Data tidak ditemukan.</span>
                                        </p>
                                    </td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>    
            </section>
        </div>
    </div>
</div>

<script>
    function dialogParam(id) {
        document.getElementById('parentId').value = id;
        $('#modalConfirmDetail').modal('show');
    }    
</script>

@include('master.request.confirm_param')
@endsection