@extends('layouts.app')

@section('title') {{ (($subtitle != "")? $subtitle : $title); }} @endsection

@section('content')

@include('layouts.partials.breadcrumb')

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="col-lg-12">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <h2 class="card-title">{{ (($subtitle != "")? $subtitle : $title); }}</h2>
                </header>
                <div class="card-body">
                    <div class="text-center">
                        <a href="{{ asset('assets/img/qr-code.png') }}" data-plugin-lightbox
                            data-plugin-options='{ "type":"image" }'>
                            <img class="img-fluid" src="{{ asset('assets/img/qr-code.png') }}" width="300" />
                        </a>
                        <p class="user-email m-0">{{ URL::to('/') }}/assets/webphada.apk</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

{{-- end dashboard --}}

@endsection

@push('page-scripts')
@endpush