@extends('layouts.app')
@section('title', 'Detail Log Aktifitas')
@section('setting', 'active')
@section('setting2', 'show')
@section('activity-log', 'active')

@section('body')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Log Aktifitas</h1>
        <a href="{{ route('activity-log.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Back to List
        </a>
    </div>

    <!-- Activity Detail Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Activity Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>ID:</strong></td>
                            <td>{{ $activity->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Log Name:</strong></td>
                            <td><span class="badge badge-info">{{ ucfirst($activity->log_name) }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Description:</strong></td>
                            <td>
                                {{ $activity->description }}
                                @if ($activity->properties && isset($activity->properties['attempted_username']))
                                    <div class="mt-2 p-2 bg-danger text-white rounded">
                                        <strong>Failed Login Details:</strong><br>
                                        <strong>Username:</strong> {{ $activity->properties['attempted_username'] }}<br>
                                        @if ($activity->properties && isset($activity->properties['attempted_password']))
                                            <strong>Password:</strong>
                                            {{ $activity->properties['attempted_password'] }}<br>
                                        @endif
                                        <strong>Time:</strong> {{ $activity->properties['attempt_time'] ?? 'N/A' }}<br>
                                        <strong>IP:</strong> {{ $activity->properties['ip_address'] ?? 'N/A' }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Event:</strong></td>
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
                        </tr>
                        <tr>
                            <td><strong>Created At:</strong></td>
                            <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>User:</strong></td>
                            <td>
                                @if ($activity->causer)
                                    <span class="badge badge-primary">{{ $activity->causer->username }}</span>
                                    <br><small>ID: {{ $activity->causer->id }}</small>
                                    @if ($activity->properties && isset($activity->properties['user_name']))
                                        <br><strong class="text-primary">{{ $activity->properties['user_name'] }}</strong>
                                        @if ($activity->properties && isset($activity->properties['employee_nik']))
                                            <br><small class="text-muted">NIK:
                                                {{ $activity->properties['employee_nik'] }}</small>
                                        @endif
                                    @endif
                                @else
                                    <span class="badge badge-secondary">System</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Subject Type:</strong></td>
                            <td>{{ $activity->subject_type ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Subject ID:</strong></td>
                            <td>{{ $activity->subject_id ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Causer Type:</strong></td>
                            <td>{{ $activity->causer_type ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Causer ID:</strong></td>
                            <td>{{ $activity->causer_id ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Properties Card -->
    @if ($activity->properties && count($activity->properties) > 0)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Additional Properties</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity->properties as $key => $value)
                                <tr>
                                    <td><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}</strong></td>
                                    <td>
                                        @if (is_array($value))
                                            <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                        @elseif(is_bool($value))
                                            <span class="badge badge-{{ $value ? 'success' : 'danger' }}">
                                                {{ $value ? 'True' : 'False' }}
                                            </span>
                                        @elseif($key == 'ip_address')
                                            <code>{{ $value }}</code>
                                        @elseif($key == 'user_agent')
                                            <small>{{ $value }}</small>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Changes Card (for updated events) -->
    @if ($activity->event == 'updated' && isset($activity->properties['attributes']) && isset($activity->properties['old']))
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Changes Made</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity->properties['attributes'] as $key => $newValue)
                                @if (isset($activity->properties['old'][$key]) && $activity->properties['old'][$key] !== $newValue)
                                    <tr>
                                        <td><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}</strong></td>
                                        <td>
                                            @if (is_bool($activity->properties['old'][$key]))
                                                <span
                                                    class="badge badge-{{ $activity->properties['old'][$key] ? 'success' : 'danger' }}">
                                                    {{ $activity->properties['old'][$key] ? 'True' : 'False' }}
                                                </span>
                                            @else
                                                {{ $activity->properties['old'][$key] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (is_bool($newValue))
                                                <span class="badge badge-{{ $newValue ? 'success' : 'danger' }}">
                                                    {{ $newValue ? 'True' : 'False' }}
                                                </span>
                                            @else
                                                {{ $newValue }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

@endsection
