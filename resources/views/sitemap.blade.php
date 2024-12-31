<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>{{ config('app.name') }} | Masuk Aplikasi</title>
		<meta name="author" content="{{ config('app.name') }}">
		<meta name="keywords" content="{{ config('app.name') }}" />
		<meta name="description" content="{{ config('app.name') }}">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/kejaksaan-logo.jpg') }}" />

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link id="googleFonts" href="{{ asset('assets/css/google_font.css') }}" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/animate/animate.compat.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" />

		<!-- Specific Page Vendor CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.theme.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/media/css/dataTables.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css') }}" />
 
        <!-- Theme CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/skins/default.css') }}" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        
        <!-- Head Libs -->
		<script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign body-locked">

            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="card card-featured card-featured-primary mb-4">
                            <header class="card-header">
                                <div class="card-actions">
                                    <form id="frmSitemapExport" action="{{route('sitemap.excell')}}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <button type="submit" class="mb-1 mt-1 me-1 btn btn-primary pull-right btn-sm">Unduh <i class="fas fa-download"></i></button>
                                    </form>
                                </div>
                                <h2 class="card-title">Daftar Satuan Kerja</h2>
                            </header>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mb-0" id="dtTable" data-plugin-options='{"searchPlaceholder": "Pencarian ..."}' style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">Kode</th>
                                                <th width="7%">Tipe</th>
                                                <th width="25%">Nama Satker</th>
                                                <th width="10%">Aktivitas terkini</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($list) > 0) { ?>
                                            <?php foreach ($list as $row) { ?>
                                            <tr>
                                                <td class="center">{{ $row->satker_code }}</td>
                                                <td class="center">{{ Status::tipeSatker($row->satker_type) }}</td>
                                                <td><a target="_blank" href="{{ $row->satker_url }}">{{ $row->satker_name }}</a></td>
                                                <td class="center">{{ $row->updated_at }}</td>
                                            </tr>
                                            <?php } ?>
                                            <?php } else { ?>
                                            <tr>
                                                <td colspan="4" align="center">
                                                    <p class="description">
                                                        <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                                        <span class="va-middle">Data tidak ditemukan.</span>
                                                    </p>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <p class="text-center text-muted mt-3 mb-3">&copy; Hak Cipta 2023. Kejaksaan Republik Indonesia.</p>
            </div>
            <!-- end: page -->

        </section>
            <!-- end: page -->
        
        <!-- Vendor -->
        <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-cookie/jquery.cookie.js') }}"></script>
        <script src="{{ asset('assets/vendor/popper/umd/popper.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('assets/vendor/common/common.js') }}"></script>
        <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
        <script src="{{ asset('assets/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
        
        <!-- Specific Page Vendor -->
        <script src="{{ asset('assets/vendor/select2/js/select2.js') }}"></script>
        <script src="{{ asset('assets/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>		
        <script src="{{ asset('assets/vendor/datatables/media/js/dataTables.bootstrap5.min.js') }}"></script>
        
		<!-- Theme Base, Components and Settings -->
        <script src="{{ asset('assets/js/theme.js') }}"></script>

        <!-- Theme Initialization Files -->
        <script src="{{ asset('assets/js/theme.init.js') }}"></script>

        <script>
            // DATATABLE
            $('#dtTable').DataTable({
                responsive: true,
                bInfo: false,
                "pageLength": 100,
                "ordering":false,
                "oLanguage": {
                    //"ssearchPlaceholder":"Pencarian",
                    "sZeroRecords": "Data tidak ditemukan",
                    "sLengthMenu": "Tampilkan &nbsp; _MENU_ data",
                    "oPaginate": {
                        "sFirst": "<<",
                        "sPrevious": "<",
                        "sNext": ">",
                        "sLast": ">>"
                    }
                },
            });
        </script>
	</body>
</html>
