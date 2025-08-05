@if ((auth()->check() && auth()->user()->can('Pegawai Admin')) || auth()->guard('admin')->check())
    <!-- Floating Action Button for Activity Log -->
    <div class="position-fixed" style="bottom: 20px; right: 20px; z-index: 1000;">
        <div class="dropdown">
            <button class="btn btn-primary btn-lg rounded-circle shadow-lg" type="button" id="activityLogFab"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Activity Log">
                <i class="fas fa-history"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right shadow-lg" aria-labelledby="activityLogFab"
                style="min-width: 250px;">
                <div class="dropdown-header bg-primary text-white">
                    <i class="fas fa-history"></i> Activity Log
                </div>
                <a class="dropdown-item" href="{{ route('activity-log.index') }}">
                    <i class="fas fa-list text-info"></i> View All Logs
                </a>
                <a class="dropdown-item"
                    href="{{ route('activity-log.index') }}?date_from={{ now()->subDay()->format('Y-m-d') }}">
                    <i class="fas fa-clock text-warning"></i> Recent Activities
                </a>
                <a class="dropdown-item"
                    href="{{ route('activity-log.index') }}?event=failed&date_from={{ now()->subDay()->format('Y-m-d') }}">
                    <i class="fas fa-exclamation-triangle text-danger"></i> Failed Logins
                </a>
                <a class="dropdown-item"
                    href="{{ route('activity-log.index') }}?log_name=user&date_from={{ now()->format('Y-m-d') }}">
                    <i class="fas fa-users text-success"></i> User Activities
                </a>
                <a class="dropdown-item"
                    href="{{ route('activity-log.index') }}?log_name=verifikasi_ijazah&date_from={{ now()->format('Y-m-d') }}">
                    <i class="fas fa-file-check text-info"></i> Verifikasi Ijazah Activities
                </a>
                <a class="dropdown-item"
                    href="{{ route('activity-log.index') }}?log_name=file_ijazah&date_from={{ now()->subDay()->format('Y-m-d') }}">
                    <i class="fas fa-file-alt text-info"></i> File Ijazah Activities
                </a>
                <a class="dropdown-item"
                    href="{{ route('activity-log.index') }}?log_name=file_ijazah&event=created&date_from={{ now()->subWeek()->format('Y-m-d') }}">
                    <i class="fas fa-plus-circle text-success"></i> New Ijazah Uploads
                </a>
                <a class="dropdown-item"
                    href="{{ route('activity-log.index') }}?log_name=admin&date_from={{ now()->format('Y-m-d') }}">
                    <i class="fas fa-user-shield text-primary"></i> Admin Activities
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('activity-log.export') }}">
                    <i class="fas fa-download text-secondary"></i> Export CSV
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Modal -->
    <div class="modal fade" id="activityLogStatsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-chart-bar"></i> Activity Log Statistics
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-left-info">
                                <div class="card-body">
                                    <h6 class="card-title text-info">Today's Activities</h6>
                                    <h3 class="text-gray-800" id="todayActivities">Loading...</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-left-warning">
                                <div class="card-body">
                                    <h6 class="card-title text-warning">Failed Logins (24h)</h6>
                                    <h3 class="text-gray-800" id="failedLogins">Loading...</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card border-left-success">
                                <div class="card-body">
                                    <h6 class="card-title text-success">User Activities</h6>
                                    <h3 class="text-gray-800" id="userActivities">Loading...</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-left-primary">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">Admin Activities</h6>
                                    <h3 class="text-gray-800" id="adminActivities">Loading...</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{ route('activity-log.index') }}" class="btn btn-primary">View Full Logs</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .position-fixed {
            transition: all 0.3s ease;
        }

        .position-fixed:hover {
            transform: scale(1.1);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .dropdown-header {
            font-weight: bold;
            padding: 0.75rem 1rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
        }
    </style>

    <script>
        // Load activity log statistics
        function loadActivityLogStats() {
            fetch('{{ route('activity-log.index') }}?ajax=stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('todayActivities').textContent = data.today_activities || 0;
                    document.getElementById('failedLogins').textContent = data.failed_logins || 0;
                    document.getElementById('userActivities').textContent = data.user_activities || 0;
                    document.getElementById('adminActivities').textContent = data.admin_activities || 0;
                })
                .catch(error => {
                    console.error('Error loading activity log stats:', error);
                });
        }

        // Show stats modal
        document.addEventListener('DOMContentLoaded', function() {
            // Add double click event to FAB for stats
            const fab = document.getElementById('activityLogFab');
            if (fab) {
                fab.addEventListener('dblclick', function(e) {
                    e.preventDefault();
                    $('#activityLogStatsModal').modal('show');
                    loadActivityLogStats();
                });
            }
        });
    </script>
@endif
