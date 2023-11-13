@if(!empty($menus->menu))
<ul class="nav nav-children">
    @foreach($menus->menu as $keys => $sub_menu)
        <?php if (in_array($sub_menu->module_id, $arrModule)) { ?>
        <li class="{{ request()->routeIs("".$sub_menu->module_active."*") ? 'nav-active' : '' }}">
            <a class="nav-link" href="{{ $sub_menu->module_url != "#" ? route("".$sub_menu->module_url."") : "#" }}">
                <i class="bx bx-caret-right" aria-hidden="true"></i>  {{ $sub_menu->module_name }}
            </a>
        </li>
        <?php } ?>
        @if(!empty($sub_menu->menu))
            @include('layouts.partials.sidebar_child', ['menus' => $sub_menu])
        @endif
    @endforeach
</ul>
@endif