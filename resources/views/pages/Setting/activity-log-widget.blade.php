<!-- Activity Log Widget -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Log Aktifitas
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalActivities ?? 0 }}</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-history fa-2x text-gray-300"></i>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ route('activity-log.index') }}" class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i> View Logs
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities Widget -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Recent Activities
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $recentActivities ?? 0 }}</div>
                    <div class="text-xs text-gray-600">Last 24 hours</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ route('activity-log.index') }}?date_from={{ now()->subDay()->format('Y-m-d') }}"
                    class="btn btn-sm btn-warning">
                    <i class="fas fa-search"></i> View Recent
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Failed Login Attempts Widget -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Failed Logins
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $failedLogins ?? 0 }}</div>
                    <div class="text-xs text-gray-600">Last 24 hours</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ route('activity-log.index') }}?event=failed&date_from={{ now()->subDay()->format('Y-m-d') }}"
                    class="btn btn-sm btn-danger">
                    <i class="fas fa-shield-alt"></i> View Security
                </a>
            </div>
        </div>
    </div>
</div>

<!-- User Activities Widget -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        User Activities
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userActivities ?? 0 }}</div>
                    <div class="text-xs text-gray-600">Today</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ route('activity-log.index') }}?log_name=user&date_from={{ now()->format('Y-m-d') }}"
                    class="btn btn-sm btn-success">
                    <i class="fas fa-user-check"></i> View Users
                </a>
            </div>
        </div>
    </div>
</div>
