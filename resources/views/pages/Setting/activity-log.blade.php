@extends('layouts.app')
@section('title', 'Log Aktifitas')
@section('setting', 'active')
@section('setting2', 'show')
@section('activity-log', 'active')

@section('body')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Activity Log</h1>
        <div>
            <button class="btn btn-success btn-sm" onclick="exportLogs()">
                <i class="fas fa-download fa-sm"></i> Export CSV
            </button>
            <button class="btn btn-danger btn-sm" onclick="clearLogs()">
                <i class="fas fa-trash fa-sm"></i> Clear Old Logs
            </button>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Logs</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('activity-log.index') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-2">
                        <label>Log Name</label>
                        <select name="log_name" class="form-control form-control-sm">
                            <option value="">All</option>
                            @foreach ($logNames as $logName)
                                <option value="{{ $logName }}" {{ request('log_name') == $logName ? 'selected' : '' }}>
                                    {{ ucfirst($logName) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Event</label>
                        <select name="event" class="form-control form-control-sm">
                            <option value="">All</option>
                            <option value="failed" {{ request('event') == 'failed' ? 'selected' : '' }}>Failed Login
                            </option>
                            @foreach ($events as $event)
                                @if ($event != 'failed')
                                    <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
                                        {{ ucfirst($event) }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Date From</label>
                        <input type="date" name="date_from" class="form-control form-control-sm"
                            value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Date To</label>
                        <input type="date" name="date_to" class="form-control form-control-sm"
                            value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search fa-sm"></i> Filter
                            </button>
                            <a href="{{ route('activity-log.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times fa-sm"></i> Clear
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activity Log Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Activity Logs</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Event</th>
                            <th>IP Address</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($activities->count() > 0)
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</td>
                                    <td>
                                        @if ($activity->causer)
                                            <span class="badge badge-primary">{{ $activity->causer->username }}</span>
                                        @else
                                            <span class="badge badge-secondary">System</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($activity->properties && isset($activity->properties['user_name']))
                                            <span class="text-primary">{{ $activity->properties['user_name'] }}</span>
                                            @if ($activity->properties && isset($activity->properties['employee_nik']))
                                                <br><small class="text-muted">NIK:
                                                    {{ $activity->properties['employee_nik'] }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $activity->description }}
                                        @if ($activity->properties && isset($activity->properties['attempted_username']))
                                            <br><small class="text-danger">
                                                <strong>Username:</strong>
                                                {{ $activity->properties['attempted_username'] }}
                                                @if ($activity->properties && isset($activity->properties['attempted_password']))
                                                    <br><strong>Password:</strong>
                                                    {{ $activity->properties['attempted_password'] }}
                                                @endif
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($activity->event == 'created')
                                            <span class="badge badge-success">Created</span>
                                        @elseif($activity->event == 'updated')
                                            <span class="badge badge-warning">Updated</span>
                                        @elseif($activity->event == 'deleted')
                                            <span class="badge badge-danger">Deleted</span>
                                        @else
                                            <span class="badge badge-info">{{ ucfirst($activity->event) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($activity->properties && isset($activity->properties['ip_address']))
                                            <small>{{ $activity->properties['ip_address'] }}</small>
                                        @else
                                            <small>-</small>
                                        @endif
                                    </td>
                                    <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('activity-log.show', $activity->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">No activity logs found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $activities->appends(request()->query())->links() }}
            </div>
        </div>
    </div>


    <!-- Clear Logs Modal -->
    <div class="modal fade" id="clearLogsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Clear Old Logs</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Masukkan jumlah hari untuk menghapus log yang lebih lama dari hari tersebut:</p>
                    <input type="number" id="clearDays" class="form-control" value="30" min="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmClearLogs()">Clear Logs</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function exportLogs() {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);

            window.location.href = '{{ route('activity-log.export') }}?' + params.toString();
        }

        function clearLogs() {
            $('#clearLogsModal').modal('show');
        }

        function confirmClearLogs() {
            const days = document.getElementById('clearDays').value;

            $.ajax({
                url: '{{ route('activity-log.clear') }}',
                method: 'POST',
                data: {
                    days: days,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 200) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus log');
                }
            });

            $('#clearLogsModal').modal('hide');
        }
    </script>
@endpush
