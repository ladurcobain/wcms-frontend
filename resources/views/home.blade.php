@extends('layouts.app')

@section('title', $subtitle)

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <section class="card card-featured-left card-featured-primary mb-4">
                <div class="card-body">
                    <div class="widget-summary widget-summary-sm">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fas fa-life-ring"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Seluruh Satker</h4>
                                <div class="info">
                                    <strong class="amount">{{ $total_satkerAll }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-md-6">
            <section class="card card-featured-left card-featured-primary mb-4">
                <div class="card-body">
                    <div class="widget-summary widget-summary-sm">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fas fa-life-ring"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Kejati</h4>
                                <div class="info">
                                    <strong class="amount">{{ $total_satker1 }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-md-6">
            <section class="card card-featured-left card-featured-primary mb-4">
                <div class="card-body">
                    <div class="widget-summary widget-summary-sm">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fas fa-life-ring"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Kejari</h4>
                                <div class="info">
                                    <strong class="amount">{{ $total_satker2 }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-md-6">
            <section class="card card-featured-left card-featured-primary mb-4">
                <div class="card-body">
                    <div class="widget-summary widget-summary-sm">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fas fa-life-ring"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Cabang Kejari</h4>
                                <div class="info">
                                    <strong class="amount">{{ $total_satker3 }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Aktivitas Terkini</h2>
                </header>
                <div class="card-body">
                    <table class="table table-responsive-lg table-bordered table-striped table-sm mb-0">
                        <thead>
                            <tr>
                                <th width="15%">Tanggal</th>
                                <th class="center" width="10%">Pukul</th>
                                <th width="20%">Pengguna</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latest_activity as $row) { ?>
                            <tr>
                                <td class="center">{{ $row->activity_date }}</td>
                                <td class="center">{{ $row->activity_time }}</td>
                                <td>{{ $row->activity_user }}</td>
                                <td>{{ $row->activity_description }}</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Kunjungan Minggu Ini</h2>
                </header>
                <div class="card-body">
                    <div class="chart chart-md" id="flotBasic"></div>
                    <script type="text/javascript">
                    var flotBasicData = [{
                        data: [
                        <?php foreach ($plotchart as $row) { ?>
                            [{{ $row->day }}, {{ $row->count }}],
                        <?php } ?>
                        ],
                        label: "Pertanggal",
                        color: "#0088cc"
                    }];
                    </script>
                </div>
            </section>
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Kunjungan Berdasarkan Menu</h2>
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
        </div>
        <div class="col-lg-4">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Notifikasi Pesan Terkini</h2>
                </header>
                <div class="card-body">
                    <div class="content">
                        <ul class="simple-user-list">
                            <?php if(count($latest_notification) > 0) { ?>
                                <?php foreach ($latest_notification as $row) { ?>
                                    <li>
                                        <figure class="image rounded">
                                            <img src="img/!sample-user.jpg" alt="Joseph Doe Junior" class="rounded-circle">
                                        </figure>
                                        <span class="title">{{ $row->notification_user }}</span>
                                        <span class="message truncate pt-1">{{ $row->notification_description }}</span>
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
                                        <?php echo Status::generateStar($row->rating_value); ?>
                                        <div class="post-meta">
                                            {{ $row->rating_date .' '. $row->rating_time }}
                                        </div>
                                        <p>{{ $row->rating_description }}</p>
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
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Survei Aplikasi Terkini</h2>
                </header>
                <div class="card-body">
                    <ul class="simple-post-list">
                        <?php if(count($latest_survey) > 0) { ?>
                            <?php foreach ($latest_survey as $row) { ?>
                                <li>
                                    <div class="post-image">
                                        <div class="img-thumbnail">
                                            <a>
                                                <img src="img/post-thumb-1.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="post-info">
                                        <a>{{ $row->survey_user }}</a>
                                        <div class="post-meta">{{ $row->survey_description }}</div>
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
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="javascript:void(0);" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>
                    <h2 class="card-title">Grafik Rating</h2>
                </header>
                <div class="card-body">
                    <div class="chart chart-md" id="flotPie"></div>
                    <script type="text/javascript">
                    <?php $i = 0; ?>
                    var flotPieData = [
                    <?php foreach ($piechart as $row) { ?>
                        <?php $i = $i+1; ?>
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
                </div>
            </section>
        </div>
    </div>
</div>
<!-- end: page -->


{{-- end dashboard --}}

@endsection

@push('page-scripts')
@endpush