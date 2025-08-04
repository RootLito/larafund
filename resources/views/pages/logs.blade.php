@extends('layout.app')

@section('title', 'Activity Logs')

@section('content')
<div class="flex-1 p-10 overflow-auto">
    <div class="h-full w-full p-6 bg-white rounded-lg">
        <div class="flex w-full justify-between mb-5">
            <h1 class="text-xl font-bold mb-4 text-gray-700">
                Activity Logs
            </h1>
            <form method="GET" action="{{ route('logs.filtered') }}" class="flex gap-2 mb-4">
                <select name="filter_date" class="bg-gray-50 border border-gray-300 p-2 text-sm rounded">
                    <option value="today" {{ request('filter_date') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('filter_date') == 'yesterday' ? 'selected' : '' }}>Yesterday
                    </option>
                    <option value="last_week" {{ request('filter_date') == 'last_week' ? 'selected' : '' }}>Last Week
                    </option>
                    <option value="all" {{ request('filter_date') == 'all' ? 'selected' : '' }}>All</option>
                </select>
                <button type="submit"
                    class="text-white border border-gray-300 p-2 text-sm rounded w-32 cursor-pointer bg-blue-500">Filter</button>
            </form>
        </div>
        @if ($logs->count())
        @foreach ($logs as $log)
        <div class="card mb-3 p-3">
            <p><strong>User:</strong> {{ $log->user_name }}</p>
            <p><strong>Procurement Project:</strong> {{ $log->procurement_project ?? 'N/A' }}</p>

            <p><strong>Lot and Description:</strong></p>
            @if ($log->lot_description)
            <ul>
                @foreach (explode(',', $log->lot_description) as $lot)
                <li>- {{ trim($lot) }}</li>
                @endforeach
            </ul>
            @else
            <p>N/A</p>
            @endif

            <p><strong>Changes:</strong></p>
            <ul>
                @php
                $changeLines = array_filter(
                explode("\n", trim($log->changed_fields)),
                fn($line) => trim($line) !== '' && str_starts_with(trim($line), '-'),
                );
                @endphp

                @foreach ($changeLines as $line)
                @php
                if (preg_match("/^- (\w+): '(.+)' → '(.+)'/", trim($line), $matches)) {
                $field = $matches[1];
                $oldValues = explode(',', $matches[2]);
                $newValues = explode(',', $matches[3]);
                } else {
                $field = null;
                $oldValues = null;
                $newValues = null;
                }
                @endphp

                @if ($field && $oldValues && $newValues && count($oldValues) === count($newValues))
                <li>
                    <span class="text-gray-500">{{ ucfirst(str_replace('_', ' ', $field)) }}
                        changes:</span class="text-gray-500">
                    <ul>
                        @for ($i = 0; $i < count($oldValues); $i++)
                            <li>{{ trim($oldValues[$i]) }} → {{ trim($newValues[$i]) }}
                </li>
                @endfor
            </ul>
            </li>
            @else
            <li>{{ $line }}</li>
            @endif
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