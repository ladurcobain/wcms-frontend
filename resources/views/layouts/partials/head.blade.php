<header class="header">
    <div class="logo-container">
        <a href="{{ route('dashboard.index') }}" class="logo">
            <img src="{{ asset('assets/img/webphada.png') }}" style="width: 45px; height: 45px; margin-top: -5px;" alt="WEBPHADA" />
        </a>
        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
            data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <!-- start: search & user box -->
    <div class="header-right">
        <form action="{{ route('contents.filter') }}" method="post" class="search nav-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="input-group">
                <input type="text" class="form-control" name="q" id="q" value="" placeholder="Pencarian Mutakhir ..."
                    autocomplete="off" />
                <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
            </div>
        </form>
        
        <span class="separator"></span>
        <ul class="notifications">
            <li id="notif-chat">
                <a href="javascript:void(0);" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
                    <i class="bx bx-comment"></i>
                </a>
                <div class="dropdown-menu notification-menu">
                    <div class="notification-title">
                        Percakapan
                    </div>

                    <div class="content">
                        <center><span class="va-middle">Data tidak ditemukan.</span><center>
                    </div>
                </div>
            </li>
            <li id="notif-alert">
                <a href="javascript:void(0);" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
                    <i class="bx bx-bell"></i>
                </a>
                <div class="dropdown-menu notification-menu">
                    <div class="notification-title">
                        Notifikasi
                    </div>

                    <div class="content">
                        <center><span class="va-middle">Data tidak ditemukan.</span><center>
                    </div>
                </div>
            </li>
        </ul>
        
        <span class="separator"></span>

        <div id="userbox" class="userbox">
            <a href="javascript:void(0);" data-bs-toggle="dropdown">
                <figure class="profile-picture">    
                    <img src="{{ Session::get('user_path') }}" alt="{{ Session::get('user_fullname') }}" class="rounded-circle"
                        data-lock-picture="Session::get('user_path')" style="height: 32px;" /> 
                </figure>
                <div class="profile-info" data-lock-name="{{ Session::get('user_fullname') }}" data-lock-email="{{ Session::get('user_account') }}">
                    <span class="name">{{ Session::get('user_fullname') }}</span>
                    <span class="role">{{ Status::tipeUser(Session::get('user_type')) }}</span>
                </div>
                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled mb-2">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('profile.edit') }}">
                            <i class="bx bx-user-circle"></i> Profil
                        </a>
                    </li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('logout') }}"><i class="bx bx-power-off"></i>
                            Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>