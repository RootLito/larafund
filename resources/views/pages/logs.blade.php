@extends('layout.app')

@section('title', 'Activity Logs')

@section('content')
    <div class="flex-1 p-10 overflow-auto">
        <div class="h-full w-full p-6 bg-white rounded-lg">
            <h2 class="text-xl font-bold text-gray-700 mb-6">Activity Logs</h2>


            @if ($logs->count())
                 @foreach($logs as $log)
            <div class="card mb-3 p-3 ">
                <p><strong>User:</strong> {{ $log->user_name }}</p>
                <p><strong>Model:</strong> {{ \Illuminate\Support\Str::headline($log->model_name) }}</p>
                <p><strong>Changes:</strong></p>
                <ul>
                    @foreach(explode(',', $log->changed_fields) as $field)
                        <li>{{ trim($field) }}</li>
                    @endforeach
                </ul>
                <p><strong>Date:</strong> {{ $log->created_at->format('F j, Y, g:i A') }}</p>
            </div>
        @endforeach
            @else
                <p class="text-muted">No activity logs found.</p>
            @endif
        </div>
    </div>
@endsection
