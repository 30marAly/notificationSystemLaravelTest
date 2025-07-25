@extends('layouts.app')

@section('content')
    <h2 class="mb-4">🔔 Notifications</h2>

    <div class="mb-4 d-flex justify-content-end">
        <form action="{{ route('notifications.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".csv,.xlsx" class="form-control-file d-inline-block" required>
            <button type="submit" class="btn btn-primary">📤 Upload Notifications</button>
        </form>
    </div>
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <a href="{{ route('notifications.create') }}" class="btn btn-primary float-end mb-3">➕ Add Notification</a>
    @if($notifications->isEmpty())
        <div class="alert alert-info">No notifications found.</div>
    @else
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Recipient</th>
                    <th>Read</th>
                    <th>Scheduled At</th> 
                    <th>Is Sent</th> 
                    <th>Cancelled</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as $notification)
                    <tr>
                        <td>{{ $notification->title }}</td>               
                        <td>{{ $notification->description }}</td>
                        <td>{{ $notification->notification_type }}</td>
                        <td>{{ $notification->recipient }}</td>
                        <td>{{ $notification->is_cancelled}}</td>
                        <td>
                            {{ $notification->scheduled_at
                                ? \Carbon\Carbon::parse($notification->scheduled_at)->timezone('Africa/Cairo')->format('Y-m-d H:i')
                                : '-' }}
                        </td>

                        <td>
                            @if($notification->is_sent)
                                ✅ Sent
                            @else
                                ❌ UnSend
                            @endif
                        </td>

                        <td>

                            <form action="{{ route('notifications.updateCancelledStatus', $notification->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $notification->is_cancelled ? 'btn-success' : 'btn-danger' }}">
                                    {{ $notification->is_cancelled ? ' Cancelled' : ' Not Cancelled' }}
                                </button>
                            </form>
                        </td>                   


                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
