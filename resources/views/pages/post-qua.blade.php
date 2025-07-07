@extends('layout.app')

@section('title', 'Post-Qualification Report')

@section('content')



    <div class="container mx-auto p-10">
    <h1 class="text-xl font-bold mb-4 text-gray-700">
        Upcoming Post-Qualification Reminders
    </h1>

    @if ($upcomingReminders->isEmpty())
        <p class="text-gray-500">No upcoming reminders found.</p>
    @else
        <ul class="space-y-6">
            @foreach ($upcomingReminders as $reminder)
                <li class="p-4 bg-white rounded-lg ">
                    <div class="font-semibold text-gray-700 mb-1">
                        {{ $reminder['project'] ?? 'Untitled Project' }}
                    </div>
                    <div class="text-sm text-gray-600 mb-1">
                        LOT Description: {{ $reminder['lot_description'] ?? 'N/A' }}
                    </div>
                    <div class="text-sm text-gray-600">
                        Date: {{ $reminder['date'] }}
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>



@endsection
