@extends('layout.app')

@section('title', 'Post-Qualification Report')

@section('content')



    <div class="container mx-auto p-10">
        <div class="flex w-full justify-between mb-5">
            <h1 class="text-xl font-bold mb-4 text-gray-700">
                Upcoming Post-Qualification Reminders
            </h1>

            <div class="flex gap-5">
                <select name="" id="">
                    <option value="">days</option>
                    <option value="">week</option>
                    <option value="">month</option>
                </select>
                <select name="" id="">
                    <option value="">days</option>
                    <option value="">week</option>
                    <option value="">month</option>
                </select>
                <button class="bg-gray-600 w-32 rounded cursor-pointer text-white text-xs">Filter</button>
            </div>
        </div>

        @if ($upcomingReminders->isEmpty())
            <p class="text-gray-500">No upcoming reminders found.</p>
        @else
            <ul class="space-y-6">
                @foreach ($upcomingReminders as $reminder)
                    <li class=" p-4 bg-white rounded-lg flex justify-between gap-10 items-center relative ripple-border">
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
                            <a href="{{ route('project.action.edit', ['edit_id' => $reminder['id']]) }}"
                                class="w-52 mt-5 px-4 py-2 text-white bg-green-400 rounded-md flex items-center justify-center hover:bg-green-600 transition-colors duration-300"
                                title="Edit Project">
                                <i class="fa-solid fa-pen-to-square mr-2"></i>Take Action
                            </a>
                        </div>

                        <div class="flex items-center gap-4">
                            <span
                                class="relative inline-block w-4 h-4 bg-red-600 rounded-full ripple-dot flex-shrink-0"></span>
                        </div>
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
