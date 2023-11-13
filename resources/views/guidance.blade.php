@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php foreach ($list as $row) { ?>
        <div class="col-lg-3 col-xl-3">
            <section class="card mt-3">
                <header class="card-header bg-white">
                    <div class="card-header-icon bg-primary">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                </header>
                <div class="card-body">
                    <h3 class="mt-0 font-weight-semibold mt-0 text-center">{{ $row->tutorial_name }}</h3>
                    <p class="text-center">{{ $row->tutorial_description }}</p>
                </div>
                <div class="card-footer text-center">
                    <?php if($row->tutorial_file != "") { ?>
                    <button OnClick="link_new_tab(' {{ $row->tutorial_path }} ');" type="button" class="mb-1 mt-1 me-1 btn btn-primary"><i class="fas fa-download"></i> Unduh</button>    
                    <?php } else { ?>
                        <button type="button" class="mb-1 mt-1 me-1 btn btn-quaternary">Tidak ada berkas</button> 
                    <?php } ?>
                </div>
            </section>
        </div>
        <?php } ?>
    </div>
</div>

{{-- end dashboard --}}

@endsection

@push('page-scripts')
@endpush