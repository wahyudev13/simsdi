<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        {{-- <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li> --}}

        <!-- Nav Item - Alerts -->
        {{-- <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 12, 2019</div>
                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        $290.29 has been deposited into your account!
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: We've noticed unusually high spending for your account.
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
        </li> --}}
        {{-- @hasanyrole('user|sdi|diklat|k3')
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#qr_code">
                    <i class='fas fa-qrcode'></i>
                </a>
            </li>
            <x-modalqr :nik="$pegawai->nik"/>
        @endhasanyrole --}}
        <!-- Nav Item - Messages -->
        {{-- <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{asset('/img/undraw_profile_1.svg')}}" alt="...">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                            problem I've been having.</div>
                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{asset('/img/undraw_profile_2.svg')}}" alt="...">
                        <div class="status-indicator"></div>
                    </div>
                    <div>
                        <div class="text-truncate">I have the photos that you ordered last month, how
                            would you like them sent to you?</div>
                        <div class="small text-gray-500">Jae Chun · 1d</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{asset('/img/undraw_profile_3.svg')}}" alt="...">
                        <div class="status-indicator bg-warning"></div>
                    </div>
                    <div>
                        <div class="text-truncate">Last month's report looks great, I am very happy with
                            the progress so far, keep up the good work!</div>
                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                            alt="...">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div>
                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                            told me that people say this to all dogs, even if they aren't good...</div>
                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
            </div>
        </li> --}}

        <!-- Nav Item - Activity Log (Admin Only) -->
        @if ((auth()->check() && auth()->user()->can('admin-all-access')) || auth()->guard('admin')->check())
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="activityLogDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Activity Log">
                    <i class="fas fa-history fa-fw"></i>
                    <span class="badge badge-info badge-counter" id="activityLogCounter">0</span>
                </a>
                <!-- Dropdown - Activity Log -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="activityLogDropdown">
                    <h6 class="dropdown-header">
                        <i class="fas fa-history"></i> Activity Log
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('activity-log.index') }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-info">
                                <i class="fas fa-list text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="font-weight-bold">View All Activities</div>
                            <div class="small text-gray-500">Complete activity log</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center"
                        href="{{ route('activity-log.index') }}?date_from={{ now()->subDay()->format('Y-m-d') }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="font-weight-bold">Recent Activities</div>
                            <div class="small text-gray-500">Last 24 hours</div>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center"
                        href="{{ route('activity-log.index') }}?event=failed&date_from={{ now()->subDay()->format('Y-m-d') }}">
                        <div class="mr-3">
                            <div class="icon-circle bg-danger">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="font-weight-bold">Failed Logins</div>
                            <div class="small text-gray-500">Security alerts</div>
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500"
                        href="{{ route('activity-log.index') }}">View All Activities</a>
                </div>
            </li>
        @endif

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    @if (auth()->check())
                        {{ auth()->user()->pegawai ? auth()->user()->pegawai->nama : auth()->user()->username }}
                    @elseif(auth()->guard('admin')->check())
                        {{ auth()->guard('admin')->user()->username }}
                    @else
                        Guest
                    @endif
                </span>
                <img class="img-profile rounded-circle" src="{{ asset('/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @if (auth()->user()->can('user-menu-access'))
                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('profile.ubah_password') }}">
                        <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                        Ubah Password
                    </a>

                    {{-- <a class="dropdown-item" href="{{route("profile.email")}}">
                    <i class="fas fa-envelope fa-sm fa-fw mr-2 text-gray-400"></i>
                    
                    Ubah Email
                </a> --}}
                    <div class="dropdown-divider"></div>
                @endif
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>



</nav>

@if ((auth()->check() && auth()->user()->can('admin-all-access')) || auth()->guard('admin')->check())
    <script>
        // Update activity log counter
        function updateActivityLogCounter() {
            fetch('{{ route('activity-log.index') }}?ajax=stats')
                .then(response => response.json())
                .then(data => {
                    const counter = document.getElementById('activityLogCounter');
                    if (counter) {
                        const total = data.today_activities || 0;
                        counter.textContent = total > 99 ? '99+' : total;

                        // Add pulse animation if there are activities
                        if (total > 0) {
                            counter.classList.add('pulse');
                        } else {
                            counter.classList.remove('pulse');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error updating activity log counter:', error);
                });
        }

        // Update counter every 30 seconds
        document.addEventListener('DOMContentLoaded', function() {
            updateActivityLogCounter();
            setInterval(updateActivityLogCounter, 30000);
        });
    </script>

    <style>
        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endif
