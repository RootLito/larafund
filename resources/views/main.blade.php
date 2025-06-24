<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('images/bfar.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <title>BAR PR Tracking System</title>
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
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full h-screen bg-gray-200 flex flex-col sm:flex-row gap-10 p-10">
        <div class="w-100 h-full bg-white p-10 rounded-lg flex flex-col items-center">
            <img src="{{ asset('images/bfar.png') }}" alt="" width="250" height="250">
            <h2 class="font-black my-7 text-2xl text-gray-700">BAC PR Tracking System</h2>
            <small class="text-gray-500 text-center mb-5">
                The BAC PR Tracking System is a platform for monitoring, managing, and streamlining Purchase Requests
                within the Bids and Awards Committee process.
            </small>
            <a href="/login"
                class="w-72 flex bg-red-400 justify-center items-center gap-2 h-10 text-sm text-white rounded-md hover:bg-red-500   transition-all mt-5">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login
            </a>

            <small class="mt-auto">© 2025 BAC PR Tracking System. All rights reserved.</small>
        </div>

        <div class="flex-1 h-full bg bg-white p-10 rounded-lg">
            <div class="flex-1">
                <div class="w-full h-full bg-white rounded-lg">
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
                        <button onclick="closeModal()"
                            class="px-4 py-2 bg-red-400 text-white rounded cursor-pointer">Close</button>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');
                    var projectEvents = @json($events);

                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        contentHeight: 'auto',
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
        </div>
    </div>
    @vite('resources/js/app.js')
</body>

</html>
