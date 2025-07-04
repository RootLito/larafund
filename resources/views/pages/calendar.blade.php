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
        <div class="bg-white p-6 rounded-lg max-w-5xl w-full">
            <h3 class="text-lg font-bold mb-2" id="modalTitle">Event Details</h3>
            <p id="modalDate" class="text-sm text-gray-600 mb-4"></p>
            <div class="flex justify-end">
                <button onclick="closeModal()" class="px-4 py-2 bg-red-400 text-white rounded cursor-pointer">Close</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const projectEvents = @json($events, JSON_UNESCAPED_UNICODE);


            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                showNonCurrentDates: true,
                fixedWeekCount: false,
                dayMaxEvents: false,
                events: projectEvents,

                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    document.getElementById('modalTitle').innerText = info.event.title;

                    const props = info.event.extendedProps;
                    const eventType = props.event_type ?? 'N/A';
                    const eventDate = props.event_date ?? 'N/A';
                    const endUser = props.end_user ?? 'N/A';
                    const totalABC = props.total_abc ?? 'N/A';

                    const lots = props.lots ?? [];
                    console.log("Lots:", lots);

                    let lotsRows = '';

                    if (lots.length === 0) {
                        lotsRows = `<tr>
                        <td colspan="3" class="border border-gray-300 p-2 text-center text-gray-500">
                            No lots available
                        </td>
                    </tr>`;
                    } else {
                        lots.forEach((lot, index) => {
                            lotsRows += `
                            <tr class="border-t border-b border-gray-300">
                                <td class="p-4 text-sm text-gray-600">${lot.lot_name || ('lot' + (index + 1))}</td>

                                <td class="p-4 text-sm text-gray-600">
                                    ${
                                    ['Re-Open', 'Re-Bid', 'Negotiated'].includes(lot.bid_status)
                                    ? `<span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                                ${
                                                    lot.bid_status === 'Re-Open' ? 'bg-yellow-100 text-yellow-700' :
                                                    lot.bid_status === 'Re-Bid' ? 'bg-red-100 text-red-700' :
                                                    lot.bid_status === 'Negotiated' ? 'bg-blue-100 text-blue-700' :
                                                    ''
                                                }
                                                ">
                                                ${lot.bid_status}
                                                </span>`
                                    : lot.bid_status || ''
                                    }
                                </td>

                                <td class="p-4 text-sm text-gray-600">${lot.remarks || ''}</td>
                                </tr>

                            `;
                        });
                    }

                    const details = `
                    <table class="text-sm w-full mb-4">
                        <tr>
                            <td class="font-bold pr-2 py-2">Type:</td>
                            <td>${eventType}</td>
                        </tr>
                        <tr>
                            <td class="font-bold pr-2 py-2">Date:</td>
                            <td>${eventDate}</td>
                        </tr>
                        <tr>
                            <td class="font-bold pr-2 py-2">End User:</td>
                            <td>${endUser}</td>
                        </tr>
                        <tr>
                            <td class="font-bold pr-2 py-2">Total ABC:</td>
                            <td>${totalABC}</td>
                        </tr>
                    </table>

                    <div class="max-h-60 overflow-y-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-100 text-gray-600 border-t border-b border-gray-300">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm">Lot</th>
                                    <th class="px-4 py-2 text-left text-sm">Bid Status</th>
                                    <th class="px-4 py-2 text-left text-sm">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${lotsRows}
                            </tbody>
                        </table>
                    </div>`;

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
