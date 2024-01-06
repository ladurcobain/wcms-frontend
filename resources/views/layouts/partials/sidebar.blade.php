<div class="sidebar-header">
    <div class="sidebar-title">
        Menu Navigasi
    </div>
    <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html"
        data-fire-event="sidebar-left-toggle">
        <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
    </div>
</div>

<div class="nano">
    <div class="nano-content">
        <nav id="menu" class="nav-main" role="navigation">
            <ul class="nav nav-main">
                <li class="{{ Request::is('dashboard*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.index') }}">
                        <i class="bx bx-home" aria-hidden="true"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <?php if(Session::get('user_type') == 1) { ?>
                <li class="{{ Request::is('sitemap*') ? 'nav-active' : '' }}">
                    <a target="_blank" class="nav-link" href="{{ route('sitemap.index') }}">
                        <i class="bx bx-desktop" aria-hidden="true"></i>
                        <span>Pratinjau</span>
                    </a>
                </li>
                <?php } else { ?>
                    <li>
                    <a class="nav-link" target="_blank" href="{{ Session::get('satker_url') }}">
                        <i class="bx bx-desktop" aria-hidden="true"></i>
                        <span>Pratinjau</span>
                    </a>
                </li>
                <?php } ?>

                @php
                $menu = Module::getModule();
                $tempModule = Session::get('access');
                if(!empty($tempModule)) {
                    $arrModule = $tempModule;
                }
                else {
                    $arrModule = array();
                }
                @endphp

                @foreach($menu as $val)
                    @foreach($val as $data)
                        @if($data->module_nav == 1)
                        <?php if (in_array($data->module_id, $arrModule)) { ?>
                        <li class="{{ Request::is("".$data->module_active."*") ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ $data->module_url != "#" ? route("".$data->module_url."") : "javascript:void(0);" }}">
                                <i class="{{ $data->module_icon }}" aria-hidden="true"></i>
                                <span>{{ $data->module_name }}</span>
                            </a>
                        </li>
                        <?php } ?>
                        @elseif($data->module_nav == 2)
                        <?php if (in_array($data->module_id, $arrModule)) { ?>
                        <li
                            class="{{ Request::is("".$data->module_active."*") ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                            <a class="nav-link" href="javascript:void(0);">
                                <i class="{{ $data->module_icon }}" aria-hidden="true"></i>
                                <span>{{ $data->module_name }}</span>
                            </a>

                            @if(!empty($data->menu))
                            @include('layouts.partials.sidebar_child', ['menus' => $data])
                            @endif
                        </li>
                        <?php } ?>
                        @endif
                    @endforeach
                @endforeach
                
                <?php if(Session::get('user_type') == 1) { ?>
                <li style="background-color:#343a40;margin:0px;">
                    <a href="javascript:void(0);">CMS</a>
                </li> 
                <?php } ?>
                
                <?php if(Session::get('user_type') == 2) { ?>
                <li class="{{ Request::is('configure*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('configure.edit') }}">
                        <i class="bx bx-wrench" aria-hidden="true"></i>
                        <span>Konfigurasi</span>
                    </a>
                </li>
                <li class="{{ Request::is('setting*') ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                    <a class="nav-link" href="javascript:void(0);">
                        <i class="bx bx-sitemap" aria-hidden="true"></i>
                        <span>Data Induk</span>
                    </a>
                    <ul class="nav nav-children">
                        <li class="{{ Request::is('setting/patterns*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('patterns.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Gambar Pola
                            </a>
                        </li>
                        <li class="{{ Request::is('setting/covers*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('covers.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Gambar Sampul
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('chat*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('chat.index') }}">
                        <i class="bx bx-message-dots" aria-hidden="true"></i>
                        <span>Percakapan</span>
                    </a>
                </li>
                <li class="{{ Request::is('notification*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('notification.index') }}">
                        <i class="bx bx-bell" aria-hidden="true"></i>
                        <span>Notifikasi</span>
                    </a>
                </li>
                <li class="{{ Request::is('log-activity*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('log-activity.index') }}">
                        <i class="bx bx-receipt" aria-hidden="true"></i>
                        <span>Catatan Aktivitas</span>
                    </a>
                </li>
                <?php } ?>

                <li class="{{ Request::is('home*') ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                    <a class="nav-link" href="javascript:void(0);">
                        <i class="bx bx-desktop" aria-hidden="true"></i>
                        <span>Tampilan Awal</span>
                    </a>
                    <ul class="nav nav-children">
                        <li class="{{ Request::is('home/banner*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('banner.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Gambar Besar
                            </a>
                        </li>
                        <li class="{{ Request::is('home/infografis*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('infografis.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Infografis
                            </a>
                        </li>
                        <li class="{{ Request::is('home/related*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('related.index') }}">
                            <i class="bx bx-caret-right" aria-hidden="true"></i> Situs Terkait
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('about*') ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                    <a class="nav-link" href="javascript:void(0);">
                        <i class="bx bx-news" aria-hidden="true"></i>
                        <span>Tentang Kami</span>
                    </a>
                    <ul class="nav nav-children">
                        <li>
                            <a>Sekilas</a>
                        </li>
                        <li class="{{ Request::is('about/info*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('info.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Tentang Kejaksaan
                            </a>
                        </li>
                        <li class="{{ Request::is('about/story*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('story.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Sejarah Kejaksaan
                            </a>
                        </li>
                        <li class="{{ Request::is('about/doctrin*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('doctrin.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Doktrin Adhyaksa
                            </a>
                        </li>
                        <li class="{{ Request::is('about/logo*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('logo.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Logo & Makna
                            </a>
                        </li>
                        <li class="{{ Request::is('about/iad*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('iad.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Ikatan Adhyaksa Darmakarini
                            </a>
                        </li>
                        <li>
                            <a>Profil</a>
                        </li>
                        <li class="{{ Request::is('about/intro*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('intro.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Kata Sambutan
                            </a>
                        </li>
                        <li class="{{ Request::is('about/vision*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('vision.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Visi & Misi
                            </a>
                        </li>
                        <li class="{{ Request::is('about/mision*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('mision.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Tugas & Wewenang
                            </a>
                        </li>
                        <li class="{{ Request::is('about/program*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('program.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Program Kerja JA
                            </a>
                        </li>
                        <li class="{{ Request::is('about/command*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('command.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Perintah Harian JA
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('information*') ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                    <a class="nav-link" href="javascript:void(0);">
                        <i class="bx bx-info-square" aria-hidden="true"></i>
                        <span>Informasi Umum</span>
                    </a>
                    <ul class="nav nav-children">
                        <li class="{{ Request::is('information/unit*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('unit.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Bidang Organisasi
                            </a>
                        </li>
                        <li class="{{ Request::is('information/structural*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('structural.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Pejabat Struktural
                            </a>
                        </li>
                        <li class="{{ Request::is('information/infrastructure*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('infrastructure.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Sarana & Prasarana
                            </a>
                        </li>
                        <li class="{{ Request::is('information/service*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('service.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Layanan Publik
                            </a>
                        </li>
                        <li class="{{ Request::is('information/dpo*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('dpo.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Daftar Pencarian Orang
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('conference*') ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                    <a class="nav-link" href="javascript:void(0);">
                        <i class="bx bx-news" aria-hidden="true"></i>
                        <span>Konten</span>
                    </a>
                    <ul class="nav nav-children">
                        <li class="{{ Request::is('conference/news*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('news.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Berita
                            </a>
                        </li>
                    </ul>
                </li>    
                <li class="{{ Request::is('archive*') ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                    <a class="nav-link" href="javascript:void(0);">
                        <i class="bx bx-archive" aria-hidden="true"></i>
                        <span>Arsip Pemberkasan</span>
                    </a>
                    <ul class="nav nav-children">
                        <li class="{{ Request::is('archive/regulation*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('regulation.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Peraturan
                            </a>
                        </li>
                        <li class="{{ Request::is('archive/photo*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('photo.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Galeri Foto
                            </a>
                        </li>
                        <li class="{{ Request::is('archive/movie*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('movie.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Koleksi Video
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('integrity*') ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                    <a class="nav-link" href="javascript:void(0);">
                        <i class="bx bx-directions" aria-hidden="true"></i>
                        <span>Zona Integritas</span>
                    </a>
                    <ul class="nav nav-children">
                        <li class="{{ Request::is('integrity/legal*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('legal.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Dasar Hukum
                            </a>
                        </li>
                        <li class="{{ Request::is('integrity/mechanism*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('mechanism.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Manajemen Perubahan
                            </a>
                        </li>
                        <li class="{{ Request::is('integrity/arrangement*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('arrangement.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Penataan Tatalaksana
                            </a>
                        </li>
                        <li class="{{ Request::is('integrity/accountability*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('accountability.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Penguatan Akuntabilitas
                            </a>
                        </li>
                        <li class="{{ Request::is('integrity/professionalism*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('professionalism.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Penataan Manajemen SDM
                            </a>
                        </li>
                        <li class="{{ Request::is('integrity/innovation*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('innovation.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Pelayanan Publik
                            </a>
                        </li>
                        <li class="{{ Request::is('integrity/supervision*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('supervision.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Penguatan Pengawasan
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('contact*') ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                    <a class="nav-link" href="javascript:void(0);">
                        <i class="bx bx-support" aria-hidden="true"></i>
                        <span>Kontak Kami</span>
                    </a>
                    <ul class="nav nav-children">
                        <li class="{{ Request::is('contact/medsos*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('medsos.index') }}">
                            <i class="bx bx-caret-right" aria-hidden="true"></i> Media Sosial
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::is('report*') ? 'nav-parent nav-active nav-expanded' : 'nav-parent' }}">
                    <a class="nav-link" href="javascript:void(0);">
                        <i class="bx bx-calendar" aria-hidden="true"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="nav nav-children">
                        <li class="{{ Request::is('report/viewer*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('viewer.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> <span>Statistik Pengunjung</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('report/polling*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('polling.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Indeks Kepuasan</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('report/contact-us*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('contact-us.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Kritik & Saran
                            </a>
                        </li>
                        <li class="{{ Request::is('report/newsletter*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('newsletter.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Kontak Berlangganan
                            </a>
                        </li>
                        <li class="{{ Request::is('report/article*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('article.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> Konten Berita
                            </a>
                        </li>
                        <li class="{{ Request::is('report/summary*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('summary.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> <span>Kunjungan Persatker</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('report/annually*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('annually.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> <span>Kunjungan Pertahun</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('report/monthly*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('monthly.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> <span>Kunjungan Perbulan</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('report/daily*') ? 'nav-active' : '' }}">
                            <a class="nav-link" href="{{ route('daily.index') }}">
                                <i class="bx bx-caret-right" aria-hidden="true"></i> <span>Kunjungan Perhari</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php if(Session::get('user_type') == 1) { ?>
                <li class="{{ Request::is('survey*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('survey.index') }}">
                        <i class="bx bx-mobile" aria-hidden="true"></i>
                        <span>Survei Aplikasi</span>
                    </a>
                </li>
                <li class="{{ Request::is('backupmanager*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('backupmanager.index') }}">
                        <i class="bx bx-data" aria-hidden="true"></i>
                        <span>Pencadangan & Pemulihan</span>
                    </a>
                </li>
                <li class="{{ Request::is('integration*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('integration.index') }}">
                        <i class="bx bx-link" aria-hidden="true"></i>
                        <span>Integrasi API</span>
                    </a>
                </li>
                <?php } ?>
                <li class="{{ Request::is('guidance*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('guidance.index') }}">
                        <i class="bx bx-book-reader" aria-hidden="true"></i>
                        <span>Dokumen Panduan</span>
                    </a>
                </li>
                <li class="{{ Request::is('apk*') ? 'nav-active' : '' }}">
                    <a class="nav-link" href="{{ route('apk.index') }}">
                        <i class="bx bx-qr" aria-hidden="true"></i>
                        <span>Scan APK Android</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <script>
    // Maintain Scroll Position
    if (typeof localStorage !== 'undefined') {
        if (localStorage.getItem('sidebar-left-position') !== null) {
            var initialPosition = localStorage.getItem('sidebar-left-position'),
                sidebarLeft = document.querySelector('#sidebar-left .nano-content');

            sidebarLeft.scrollTop = initialPosition;
        }
    }
    </script>

</div>