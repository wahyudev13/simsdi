<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIMSDI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @yield('dashboard')">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    @if (
        (auth()->check() && (auth()->user()->can('View Karyawan') || auth()->user()->can('Pegawai Admin'))) ||
            (auth()->guard('admin')->check() &&
                (auth()->guard('admin')->user()->can('View Karyawan') ||
                    auth()->guard('admin')->user()->can('Pegawai Admin'))))
        <!-- Heading -->
        <div class="sidebar-heading">
            Kelola Karyawan
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item @yield('main1')">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-users"></i>
                <span>Karyawan</span>
            </a>
            <div id="collapseTwo" class="collapse @yield('main2')" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item @yield('karyawan')" href="{{ route('karyawan.index') }}">Data Karyawan</a>
                </div>
            </div>
        </li>
    @endif
    @if (
        (auth()->check() && (auth()->user()->can('Peringatan') || auth()->user()->can('Pegawai Admin'))) ||
            (auth()->guard('admin')->check() &&
                (auth()->guard('admin')->user()->can('Peringatan') ||
                    auth()->guard('admin')->user()->can('Pegawai Admin'))))
        <li class="nav-item @yield('pengingat1')">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAlert"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-bell"></i>
                <span>Peringatan</span>
            </a>
            <div id="collapseAlert" class="collapse @yield('pengingat2')" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    <a class="collapse-item @yield('pengingat-str')" href="{{ route('pengingat.str.index') }}">STR </a>
                    <a class="collapse-item @yield('pengingat-sip')" href="{{ route('pengingat.sip.pengingatSip') }}">SIP </a>
                    {{-- @if ($countstr > 0)
                    <span class="badge badge-danger">{{$countstr}}</span></a>  
                    @endif  --}}
                    <a class="collapse-item @yield('pengingat-kontrak')"
                        href="{{ route('pengingat.kontrak.pengingatKontrak') }}">Kontrak Kerja</a>
                    {{-- <a class="collapse-item" href="cards.html">Jadwal Shift</a> --}}
                </div>
            </div>
        </li>
        <!-- Nav Item - Utilities Collapse Menu -->
    @endif
    @if (
        (auth()->check() && (auth()->user()->can('Dokumen Diklat') || auth()->user()->can('Pegawai Admin'))) ||
            (auth()->guard('admin')->check() &&
                (auth()->guard('admin')->user()->can('Dokumen Diklat') ||
                    auth()->guard('admin')->user()->can('Pegawai Admin'))))
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Heading -->
        <div class="sidebar-heading">
            Kelola Diklat Karyawan
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item @yield('diklat-main1')">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDiklat"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-calendar-day"></i>
                <span>Diklat</span>
            </a>
            <div id="collapseDiklat" class="collapse @yield('diklat-main2')" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    <a class="collapse-item @yield('diklat-kegiatan')" href="{{ route('kegiatan.index') }}">Kegiatan</a>
                    <a class="collapse-item @yield('diklat-jeniskegiatan')" href="{{ route('diklat.kegiatan.jenis') }}">Master
                        Jenis
                        Kegiatan</a>
                </div>
            </div>
        </li>
    @endif
    @if (
        (auth()->check() && auth()->user()->can('Pengguna')) ||
            (auth()->guard('admin')->check() && auth()->guard('admin')->user()->can('Pengguna')))
        <!-- Heading -->
        <div class="sidebar-heading">
            Dokumen Karyawan
        </div>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item @yield('user-main1')">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true"
                aria-controls="collapseTwo">
                <i class="fas fa-users"></i>
                <span>Dokumen Kepegawaian</span>
            </a>
            <div id="collapseUser" class="collapse @yield('user-main2')" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item @yield('user-pendidikan')" href="{{ route('pengguna.pendidikan') }}">Data
                        Pendidikan</a>
                    <a class="collapse-item @yield('user-izin')" href="{{ route('pengguna.izin') }}">Data Perizinan</a>
                    <a class="collapse-item @yield('user-riwayat')" href="{{ route('pengguna.riwayat') }}">Data Riwayat
                        Pekerjaan</a>
                    <a class="collapse-item @yield('user-orientasi')" href="{{ route('pengguna.orientasi') }}">Data
                        Orientasi</a>
                </div>
            </div>
        </li>
        <li class="nav-item @yield('user-main3')">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsekes" aria-expanded="true"
                aria-controls="collapseTwo">
                <i class="fas fa-notes-medical"></i>
                <span>Dokumen K3</span>
            </a>
            <div id="collapsekes" class="collapse @yield('user-main4')" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item @yield('user-kes')" href="{{ route('pengguna.kesehatan') }}">Data Tes
                        Kesehatan</a>
                    <a class="collapse-item @yield('user-vaksin')" href="{{ route('pengguna.vaksin') }}">Data
                        Vaksinasi</a>
                    <a class="collapse-item @yield('user-mcu')" href="{{ route('pengguna.mcu') }}">Data Kesehatan
                        Berkala</a>
                </div>
            </div>
        </li>
        <li class="nav-item @yield('user-main5')">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsediklat"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-school"></i>
                <span>Dokumen Diklat</span>
            </a>
            <div id="collapsediklat" class="collapse @yield('user-main6')" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item @yield('user-sertif')" href="{{ route('pengguna.sertifikat') }}">Sertifikat
                        Pelatihan</a>
                    <a class="collapse-item @yield('user-pelatihan')" href="{{ route('pengguna.pelatihan') }}">Riwayat
                        Pelatihan IHT</a>
                </div>
            </div>
        </li>
    @endif
    @if ((auth()->check() && auth()->user()->can('Pegawai Admin')) || auth()->guard('admin')->check())
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Administrator
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item  @yield('master1')">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Master</span>
            </a>
            <div id="collapsePages" class="collapse @yield('master2')" aria-labelledby="headingPages"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Login Screens:</h6> --}}
                    <a class="collapse-item @yield('master-berkas')" href="{{ route('master.berkas') }}">Berkas
                        Pegawai</a>
                    <a class="collapse-item @yield('master-role')" href="{{ route('master.role.index') }}">Role</a>
                    <a class="collapse-item @yield('master-pengguna')" href="{{ route('master.pengguna') }}">Pengguna</a>
                    <a class="collapse-item @yield('master-mapingrm')" href="{{ route('master.maping') }}">Maping Rekam
                        Medis</a>
                </div>
            </div>
        </li>
        {{-- <li class="nav-item @yield('dashboard')">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Maping No RM</span></a>
        </li> --}}

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item  @yield('setting')">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting"
                aria-expanded="true" aria-controls="collapseSetting">
                <i class="fas fa-fw fa-cog"></i>
                <span>Setting</span>
            </a>
            <div id="collapseSetting" class="collapse @yield('setting2')" aria-labelledby="headingPages"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Login Screens:</h6> --}}
                    <a class="collapse-item @yield('admin')" href="{{ route('setting.admin.index') }}">Set
                        Administrator</a>
                    <a class="collapse-item @yield('aplikasi')" href="{{ route('setting.aplikasi.index') }}">Set
                        Aplikasi</a>
                    <a class="collapse-item @yield('activity-log')" href="{{ route('activity-log.index') }}">
                        Log Aktifitas
                    </a>
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
