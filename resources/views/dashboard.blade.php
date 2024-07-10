@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php 
            $i=0; $icon = "";
            foreach($visitor as $row) {
                $i=$i+1;  
                switch($i) {
                    case 1 :
                        $icon = "fa-users";
                    break;
                    case 2 :
                        $icon = "fa-list-alt";
                    break;
                    case 3 :
                        $icon = "fa-calendar-alt";
                    break;
                    case 4 :
                        $icon = "fa-history";
                    break;
                }   
        ?>
        <div class="col-lg-3 col-md-6">
            <section class="card card-featured-left card-featured-primary mb-4">
                <div class="card-body">
                    <div class="widget-summary widget-summary-sm">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fas <?php echo $icon; ?>"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">{{ Status::str_ellipsis($row->title, 20) }}</h4>
                                <div class="info">
                                    <strong class="amount">{{ Status::shortNumber($row->count) }}</strong>
                                    <span class="text-primary">
                                        <!--<a href="javascript:void(0);" OnClick="dialogDetail(<?php //echo $i; ?>);">(selengkapnya)</a>-->
                                        <?php if($i == 1) { ?>
                                        <a href="javascript:void(0);" OnClick="link_to('report/summary');">(selengkapnya)</a>
                                        <?php } elseif($i == 2) { ?>
                                        <a href="javascript:void(0);" OnClick="link_to('report/annually');">(selengkapnya)</a>
                                        <?php } elseif($i == 3) { ?>
                                        <a href="javascript:void(0);" OnClick="link_to('report/monthly');">(selengkapnya)</a>
                                        <?php } elseif($i == 4) { ?>
                                        <a href="javascript:void(0);" OnClick="link_to('report/daily');">(selengkapnya)</a>
                                        <?php } ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </section>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="card-title">Grafik Kunjungan bulan <?php echo Status::monthName($month); ?></h2>
                            <!--
                            <div class="pull-left mt-2">
                                <h2 class="card-title">Grafik Kunjungan bulan <?php //echo Status::monthName($month); ?></h2>
                            </div>
                            <div class="pull-right">
                                <div class="form-group" style="width: 200px;">
                                    <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Pilih Bulan ...", "allowClear": true }' name="month" onChange="dashboard_permonth(this.value);" >
                                        <option></option>  
                                        <?php //for($i=1; $i<=12; $i++) { ?>
                                        <option value="<?php //echo ($i < 10)?"0".$i:$i; ?>" <?php //echo (($month == $i)?'selected="selected"':''); ?>><?php //echo Status::monthName($i); ?></option>           
                                        <?php //} ?>         
                                    </select>	
                                </div>
                            </div>
                            -->
                        </div>
                    </div>
                </header>
                <div class="card-body" id="graphline">
                    <div class="chart chart-md" id="flotBasic"></div>
                    <script type="text/javascript">
                    flotBasicData = [{
                        data: [
                        <?php foreach ($plotchart as $row) { ?>
                            [{{ $row->day }}, {{ $row->count }}],
                        <?php } ?>
                        ],
                        label: "<?php echo Status::monthName($month); ?>",
                        color: "#00AC69"
                    }];
                    </script>
                </div>
            </section>
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Halaman Paling Sering Dikunjungi</h2>
                </header>
                <div class="card-body">
                    <div class="chart chart-md" id="flotBars"></div>
                    <script type="text/javascript">
                    var flotBarsData = [
                        <?php foreach ($barchart as $row) { ?>
                            ['{{ $row->title }}', {{ $row->count }}],
                        <?php } ?>
                    ];
                    </script>
                </div>
            </section>
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Konten Berita Terkini</h2>
                </header>
                <div class="card-body">
                    <table class="table table-responsive-lg table-bordered table-striped table-sm mb-0">
                        <thead>
                            <tr>
                                <th class="center" width="15%">Tanggal</th>
                                <th width="10%">Kategori</th>
                                <th>Judul</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($news_latest) > 0) { ?>
                            <?php foreach ($news_latest as $row) { ?>
                            <tr>
                                <td class="center">{{ $row->news_date }}</td>
                                <td>{{ $row->news_category }}</td>
                                <td>{{ $row->news_title }}</td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr><td colspan="3" align="center">
                                <p class="description">
                                    <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                    <span class="va-middle">Data tidak ditemukan.</span>
                                </p>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="col-lg-4">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Status Berita</h2>
                </header>
                <div class="card-body">
                    <ul class="simple-card-list">
                        <?php 
                            $i=0; $icon = "";
                            foreach($article as $row) {
                                $i=$i+1;  
                                switch($i) {
                                    case 1 :
                                        $icon = "bx-clipboard";
                                    break;
                                    case 2 :
                                        $icon = "bx-task";
                                    break;
                                    case 3 :
                                        $icon = "bx-task-x";
                                    break;
                                }    
                        ?>
                        <style>
                            .special:hover{
                                cursor: pointer;
                                opacity: 0.8;
                            }
                            li .primary:hover { background-color: yellow; }
                        </style>
                        <li class="primary">
                            <?php 
                                if($i==1) {
                                    $status = "9";
                                }
                                else if($i==2) {
                                    $status = "1";
                                }
                                else {
                                    $status = "0";
                                }
                            ?>
                            <div class="row align-items-center special" OnClick="link_to('report/article/status/<?php echo $status; ?>');">
                                <div class="col-9 col-md-9">
                                    <h3 class="text-4-1 text-light my-0"><?php echo $row->title; ?></h3>
                                    <strong class="text-5"><?php echo number_format($row->count); ?></strong>
                                </div>
                                <div class="col-3 col-md-3 text-center text-md-center">
                                    <i class="bx <?php echo $icon; ?> icon icon-inline icon-lg bg-primary rounded-circle text-color-light"></i>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>  
            </section>
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Penilaian Indeks Kepuasan</h2>
                </header>
                <div class="card-body">
                    <script type="text/javascript">
                        <?php $validChart = 0; $i = 0; ?>
                        var flotPieData = [
                        <?php foreach ($piechart as $row) { ?>
                            <?php 
                                $i = $i+1; 
                                if($row->count != 0) {
                                    $validChart = 1;    
                                } 
                            ?>
                            {
                            label: "{{ $row->title }}",
                            data: [
                                [1, {{ $row->count }}]
                            ],
                            color: '{{ Status::generateColor($i) }}'
                            },
                        <?php } ?>  
                        ];
                    </script>

                    <?php if($validChart != 0) { ?>
                    <div class="chart chart-md" id="flotPie"></div>
                    <?php } else { ?>
                    <center>
                        <div class="result-data">
                            <p class="description">
                                <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                <span class="va-middle">Data tidak ditemukan.</span>
                            </p>
                        </div>
                    </center>
                    <?php } ?>    
                </div>
            </section>
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Indeks Kepuasan Terkini</h2>
                </header>
                <div class="card-body">
                    <ul class="simple-post-list">
                        <?php if(count($latest_rating) > 0) { ?>
                            <?php foreach ($latest_rating as $row) { ?>
                                <li>
                                    <div class="post-info">
                                        <a>{{ $row->rating_satker }}</a>
                                        <div class="post-meta">
                                            <?php echo Status::generateStar($row->rating_value); ?>
                                        </div>
                                        <p class="mb-0">{{ $row->rating_description }}</p>
                                    </div>
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
            </section>
        </div>
    </div>
</div>
<!-- end: page -->

<script>
function dashboard_permonth(month) {
    var uri = base_url + "ajax/load-chart-line/" + month;
    $.ajax({
        type: "get",
        dataType: "html",
        url: uri,
        //timeout: time_show,
        beforeSend: function() {
            $("#graphline").html(
                '<center><div class="notification-icon"><i class="bx bx-loader"></i></div></center>');
        }
    }).done(function(data) {
            $.ajax({
            type: "get",
            dataType: "html",
            url: uri,
            beforeSend: function() {
                $("#graphline").html(data);
            }
        }).done(function(data) {
            $("#graphline").html(data);
        }).fail(function(jqXHR, textStatus) {
            if (textStatus === 'timeout') {
                $("#graphline").html(
                    '<center><div class="notification-icon"><i class="bx bx-error"></i></div></center>');
            }
        });
    }).fail(function(jqXHR, textStatus) {
        if (textStatus === 'timeout') {
            $("#graphline").html(
                '<center><div class="notification-icon"><i class="bx bx-error"></i></div></center>');
        }
    });
}

function dialogDetail(id) {
    var titleModalHeader = "";
    if(id == 1) {
        titleModalHeader = "Kunjungan Per Satuan Kerja";
    }
    else if(id == 2) {
        titleModalHeader = "Kunjungan Per Bulan";
    }
    else if(id == 3) {
        titleModalHeader = "Kunjungan Per Tanggal";
    }
    else if(id == 4) {
        titleModalHeader = "Kunjungan Per Jam";
    }

    $("#titleModalHeader").html(titleModalHeader);

    var uri = base_url + "ajax/modal-visitor/" + id;
    $.ajax({
        type: "get",
        dataType: "html",
        url: uri,
        timeout: 3000,
        beforeSend: function() {
            $("#modal-content").html(
                '<div class="notification-icon text-center"><i class="bx bx-loader"></i></div>');
        }
    }).done(function(data) {
        $("#modal-content").html(data);
    }).fail(function(jqXHR, textStatus) {
        if (textStatus === 'timeout') {
            $("#modal-content").html(
                '<div class="notification-icon"><i class="bx bx-error"></i></div>');
        }
    });
    
    $('#modalConfirmDetail').modal('show');
}    
</script>

<div class="modal animated bounceIn" id="modalConfirmDetail" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="titleModalHeader" class="card-title"></h2>
            </div>
            <div class="scrollable" data-plugin-scrollable style="height: 350px;">
			    <div class="scrollable-content">
                    <div class="modal-body" id="modal-content"></div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tutup</button> -->
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- end dashboard --}}

@endsection

@push('page-scripts')
@endpush