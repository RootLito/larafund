@extends('layout.app')

@section('title', 'Calendar')

@section('content')
    <style>
        .fc-event.philgeps-advertisement {
            @apply bg-blue-500 border-blue-500 text-white !important;
        }

        .fc-event.pre-bid {
            @apply bg-green-500 border-green-500 text-white !important;
        }

        .fc-event.bid-opening {
            @apply bg-yellow-500 border-yellow-500 text-black !important;
        }

        .fc-event.post-qualification {
            @apply bg-red-500 border-red-500 text-white !important;
        }
    </style>

    <div class="flex-1 p-10">
        <div class="w-full h-full bg-white p-10 rounded-lg">
            <div class="flex space-x-4 mb-4 justify-center">
                <div class="flex items-center space-x-2">
                    <span class="w-4 h-4 bg-blue-500 rounded"></span>
                    <span>PhilGeps Advertisement</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-4 h-4 bg-green-500 rounded"></span>
                    <span>Pre-bid Conference</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-4 h-4 bg-yellow-500 rounded"></span>
                    <span>Bid Opening</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-4 h-4 bg-red-500 rounded"></span>
                    <span>Post-Qua Report Presentation</span>
                </div>
            </div>

            <div id='calendar'></div>
        </div>
    </div>

    <div id="eventModal" class="fixed inset-0 hidden items-center justify-center z-50"
        style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="bg-white p-6 rounded-lg max-w-2xl w-full">
            <h3 class="text-lg font-bold mb-2" id="modalTitle">Event Details</h3>
            <p id="modalDate" class="text-sm text-gray-600 mb-4"></p>
            <div class="flex justify-end">
                <button onclick="closeModal()" class="px-4 py-2 bg-red-400 text-white rounded cursor-pointer">Close</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var projectEvents = @json($events);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                showNonCurrentDates: true,
                fixedWeekCount: false,
                dayMaxEvents: false,
                events: projectEvents,
                eventRender: function(info) {
                    info.el.style.backgroundColor = info.event.extendedProps.color || info.event
                        .backgroundColor;
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    document.getElementById('modalTitle').innerText = info.event.title;

                    const eventType = info.event.extendedProps.event_type ?? 'N/A';
                    const eventDate = info.event.extendedProps.event_date ?? 'N/A';
                    const endUser = info.event.extendedProps.end_user ?? 'N/A';
                    const totalABC = info.event.extendedProps.total_abc ?? 'N/A';

                    let details = `
                <table class="text-sm w-full">
                    <tr>
                        <td class="font-bold pr-2 py-2">${eventType}:</td>
                        <td>${eventDate}</td>
                    </tr>
                    <tr>
                        <td class="font-bold pr-2 py-2">End User:</td>
                        <td>${endUser}</td>
                    </tr>
                    <tr>
                        <td class="font-bold pr-2 py-2">ABC:</td>
                        <td>${totalABC}</td>
                    </tr>
                </table>
            `;

                    document.getElementById('modalDate').innerHTML = details;
                    document.getElementById('eventModal').classList.remove('hidden');
                    document.getElementById('eventModal').classList.add('flex');
                }
            });

            calendar.render();
        });

        function closeModal() {
            document.getElementById('eventModal').classList.remove('flex');
            document.getElementById('eventModal').classList.add('hidden');
        }
    </script>

@endsection
