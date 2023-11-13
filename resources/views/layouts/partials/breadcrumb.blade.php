<header class="page-header">
    <h2>{{ (($subtitle != "")? $subtitle : $title) }}</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs" style="padding-right:20px;">
            <li>
                <a href="{{ route('dashboard.index') }}">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            @if ($title != "")
                <li><span>{{ $title }}</span></li>
            @endif
            @if ($subtitle != "")
                <li><span>{{ $subtitle }}</span></li>
            @endif
        </ol>
    </div>
</header>