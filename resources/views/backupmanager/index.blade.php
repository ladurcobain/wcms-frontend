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
                                <h2 class="card-title">Daftar {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                            </div>
                            <div class="pull-right">
                                <form id="frmCreateBackup" action="{{route('backupmanager_create')}}" method="post">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-spinner"></i> Proses</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>
                <form id="frmBackup" action="{{route('backupmanager_restore_delete')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="card-body">
                        @if ($alert = Session::get('alrt'))
                        <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" tutorial="alert">
                            <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                            <?php echo Session::get('msgs'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0" id="dtTable" data-plugin-options='{"searchPlaceholder": "Pencarian ..."}' style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="13%">Tanggal</th>
                                        <th>Nama</th>
                                        <th width="12%">Ukuran</th>
                                        <th width="5%">Status</th>
                                        <th width="5%">Tipe</th>
                                        <th width="5%">Unduh</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($backups as $index => $backup)
                                    <tr>
                                        <td class="center">{{$backup['date']}}</td>
                                        <td>{{$backup['name']}}</td>
                                        <td>{{$backup['size']}}</td>
                                        <td class="center">
                                            <?php
                                            $okSizeBytes = 1024;
                                            $isOk = $backup['size_raw'] >= $okSizeBytes;
                                            $text = $isOk ? 'Bagus' : 'Buruk';
                                            $icon = $isOk ? 'success' : 'danger';

                                            echo "<span class='badge badge-label bg-$icon'><i class='mdi mdi-circle-medium'></i>$text</span>";
                                            ?>
                                        </td>
                                        <td class="center">
                                            <span class="badge badge-label bg-{{$backup['type'] === 'Files' ? 'primary' : 'success'}}"><i class='mdi mdi-circle-medium'></i>{{$backup['type']}}</span>
                                        </td>
                                        <td class="center">
                                            <a href="{{ route('backupmanager_download', [$backup['name']])  }}" type="button" class="btn btn-sm btn-info">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td class="center">
                                            <input type="checkbox" name="backups[]" class="chkBackup" value="{{$backup['name']}}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if (count($backups))
                            <input type="hidden" name="type" value="restore" id="typeBackup">
                            <div class="pull-right" style="margin-right: 15px;">
                                <button type="submit" id="btnSubmitBackup" class="btn btn-success" disabled="disabled">
                                    <i class="fa fas-refresh"></i>
                                    <small><strong>Pulihkan</strong></small>
                                </button>
                                <button type="submit" id="btnDeleteBackup" class="btn btn-danger" disabled="disabled">
                                    <i class="fa fas-remove"></i>
                                    <small><strong>Hapus</strong></small>
                                </button>
                            </div>
                            <div class="clearfix"></div>
                        @endif
                    </div>
                 </form>       
            </section>
        </div>
    </div>    
</div>

@endsection

