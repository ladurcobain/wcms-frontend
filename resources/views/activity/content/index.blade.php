@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="search-content">
                <div class="search-control-wrapper">
                    <form action="{{ route('contents.filter') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group row">
                            <div class="col-lg-4 mb-1">
                                <div class="input-daterange input-group mb-2" data-plugin-datepicker>
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <input type="text" class="form-control" name="start" value="{{ $start }}"
                                        autocomplete="off" />
                                    <span class="input-group-text border-start-0 border-end-0 rounded-0">
                                        s/d
                                    </span>
                                    <input type="text" class="form-control" name="end" value="{{ $end }}"
                                        autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-5 mb-1">
                                <select data-plugin-selectTwo class="form-control populate placeholder"
                                    data-plugin-options='{ "placeholder": "Pilih Satker ...", "allowClear": false }'
                                    name="satker">
                                    <option></option>
                                    <?php foreach($satkers as $r) { ?>
                                    <option value="<?php echo $r->satker_id; ?>" <?php echo (($satker == $r->satker_id)?'selected="selected"':''); ?>><?php echo $r->satker_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3 mb-1">
                                <select data-plugin-selectTwo class="form-control populate placeholder"
                                    data-plugin-options='{ "placeholder": "Pilih Menu ...", "allowClear": false }'
                                    name="menu">
                                    <option></option>
                                    <?php foreach($menus as $r) { ?>
                                    <option value="<?php echo $r->menu_id; ?>" <?php echo (($menu == $r->menu_id)?'selected="selected"':''); ?>><?php echo $r->menu_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-10 mb-1">
                                <input type="search" style="height: 55px;" class="form-control" placeholder="Masukkan kata kunci pencarian berdasarkan isi konten ..."
                                        name="q" value="{{ $q }}" autocomplete="off" />
                            </div>
                            <div class="col-lg-1 mb-1">
                                <button class="btn btn-block btn-default p-3" type="button" OnClick="link_to('contents');">Ulangi</button>
                            </div>
                            <div class="col-lg-1 mb-1">
                                <button class="btn btn-block btn-primary p-3" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled search-results-list">
                        <?php if($results->total() > 0) { ?>
                        <?php foreach ($results as $row) { ?>
                        <li class="mt-3 mb-3">
                            <p class="result-type">
                                <span class="badge badge-primary">{{ $row->satker_name }}</span>
                            </p>
                            <a href="<?php echo url($row->menu_url .'/'. $row->reff_id .'/edit'); ?>">
                                <div class="result-data">
                                    <p class="h5 title text-primary">{{ $row->menu_name }}</p>
                                    <p class="description">
                                        <small>{{ $row->content_date .' '. $row->content_time }}</small>
                                        <br />
                                        <span>{{ Status::str_ellipsis($row->content_text_in, 200) }}</span>
                                    </p>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                        <?php } else { ?>
                        <li>
                            <center>
                                <div class="result-data">
                                    <p class="description">
                                        <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                        <span class="va-middle">Data tidak ditemukan.</span>
                                    </p>
                                </div>
                            </center>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="card-footer">
                    <?php if(!empty($results)) { ?>
                    <p class="text-muted text-uppercase pull-left mt-3">Total Data : {{ $results->total() }}</p>
                    <div class="pull-right mt-3" style="margin-right: 5px;">{{ $results->onEachSide(1)->links() }}</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection