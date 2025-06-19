@extends('layout.app')

@section('title', 'Calendar')

@section('content')
    <div class="flex-1 p-10">
        <div class="w-full h-full bg-white p-10 rounded-lg">
            <div id='calendar'></div>
        </div>
    </div>
    <div id="eventModal" class="fixed inset-0  hidden items-center justify-center z-50"
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
                // showNonCurrentDates: false,
                fixedWeekCount: false,      
                events: projectEvents,
                dayMaxEvents: true,
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    document.getElementById('modalTitle').innerText = info.event.title;
                    let details = `
                        <table class="text-sm w-full">
                            <tr>
                                <td class="font-bold pr-2 py-2">Bid Opening:</td>
                                <td>${info.event.extendedProps.bid_opening}</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-2 py-2">End User:</td>
                                <td>${info.event.extendedProps.end_user}</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-2 py-2">ABC:</td>
                                <td>${info.event.extendedProps.total_abc}</td>
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
