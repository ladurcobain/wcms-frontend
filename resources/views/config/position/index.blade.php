@extends('layouts.app')

@section('title', $subtitle)

@section('content')

@include('layouts.partials.breadcrumb')
<script>
    is_nestable = 1;
</script> 

<div class="col-md-12">
    <div class="row">
        <div class="col">
            <section class="card card-featured card-featured-primary">
                <header class="card-header">
                    <h2 class="card-title">Ubah {{ (($subtitle != "")? $subtitle : $title); }}</h2>
                </header>
                <div class="card-body">
                    @if ($alert = Session::get('alrt'))
                    <div class="alert <?php echo (($alert == "error")?'alert-danger':'alert-success'); ?> alert-dismissible fade show" management="alert">
                        <strong><?php echo (($alert == "error")?'Error':'Success'); ?>!</strong>
                        <?php echo Session::get('msgs'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="dd" id="nestable">
                                <ol class="dd-list" style="cursor: all-scroll;">
                                    @foreach($menu as $key => $val)
                                        <li class="dd-item" data-id="{{ $val->module_id }}">
                                            <div class="dd-handle">{{ $val->module_name }}</div>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('position.sorting') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <textarea id="nestable-output" name="nested_menu_array" rows="3" class="form-control" hidden></textarea>
                        <button type="reset" id="btn_reset" class="btn btn-default">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </section>
        </div>
    </div>    
</div>

@endsection
   