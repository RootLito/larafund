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
                    <li class="border border-red-500  p-4 bg-white rounded-lg flex justify-between gap-10 items-center relative ripple-border">
                        <div>
                            <div class="font-semibold text-gray-700 mb-1">
                                {{ $reminder['project'] ?? 'Untitled Project' }}
                            </div>
                            <div class="text-sm text-gray-600 mb-1">
                                LOT Description: {{ $reminder['lot_description'] ?? 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-600">
                                Date: {{ $reminder['date'] }}
                            </div>
                        </div>

                        <span class="relative inline-block w-4 h-4 bg-red-600 rounded-full ripple-dot flex-shrink-0"></span>
                    </li>
                @endforeach
            </ul>

        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.ripple-dot').forEach(dot => {
                dot.classList.add('ripple-effect');
            });
        });
    </script>

    <style>
        @keyframes ripple {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(220, 38, 38, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
            }
        }

        .ripple-effect {
            animation: ripple 1.5s infinite;
        }
    </style>

@endsection
