@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex-1 h-full flex gap-6 p-10 bg-gray-200 relative">
        <div class="flex flex-1 flex-col gap-6">
            <div class="flex gap-6">
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-600 text-lg">Purchase Request</h2>
                    <p class="text-sm text-gray-500 font-medium">Total PR</p>

                    <div class="flex-1 flex justify-between items-end">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-amber-400">{{ $totalCount }}</h2>
                        </div>

                        <div class="w-14 h-14 bg-amber-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-file-lines text-2xl text-amber-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-600 text-lg">Public Bidding</h2>
                    <p class="text-sm text-gray-500 font-medium">Total Lot</p>
                    <div class="flex-1 flex justify-between items-end   ">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-green-400">{{ $publicBiddingCount }}</h2>
                        </div>

                        <div class="w-14 h-14 bg-green-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-hand text-2xl text-green-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-500 text-lg">Direct Contracting</h2>
                    <p class="text-sm text-gray-500 font-medium">Total Lot</p>

                    <div class="flex-1 flex justify-between items-end   ">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-indigo-400">{{ $directContractingCount }}</h2>
                        </div>

                        <div class="w-14 h-14 bg-indigo-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-handshake text-2xl text-indigo-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-6">

                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-500 text-lg">Small Value Procurement</h2>
                    <p class="text-sm text-gray-500 font-medium">Total Lot</p>
                    <div class="flex-1 flex justify-between items-end   ">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-blue-400">{{ $smallValueProcurementCount }}</h2>
                        </div>

                        <div class="w-14 h-14 bg-blue-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-square-caret-down text-2xl text-blue-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-500 text-lg">Emergency Cases</h2>
                    <p class="text-sm text-gray-500 font-medium">Total Lot</p>
                    <div class="flex-1 flex justify-between items-end   ">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-red-400">{{ $emergencyCasesCount }}</h2>
                        </div>

                        <div class="w-14 h-14 bg-red-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-circle-dot text-2xl text-red-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-600 text-lg">Others</h2>
                    <p class="text-sm text-gray-500 font-medium">Total Lot</p>

                    <div class="flex-1 flex justify-between items-end">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-gray-500">{{ $othersCount }}</h2>
                        </div>

                        <button data-micromodal-trigger="modal-2" class="cursor-pointer w-14 h-14 bg-gray-300 rounded-full">
                            <i class="fa-solid fa-bars text-2xl text-gray-500"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col w-full bg-white rounded-xl p-6">
                <div class="w-full flex justify-between items-center">
                    <h2 class="font-semibold text-gray-600 text-lg mb-6">Project Status Distribution</h2>
                    <button
                        class="h-8 bg-amber-100 text-amber-500 text-sm px-2 cursor-pointer rounded border border-amber-500"
                        data-micromodal-trigger="modal-pending">
                        View Pendings
                    </button>

                </div>
                <div class="w-full p-5">
                    <canvas id="projectStatusChart"></canvas>
                </div>
            </div>
        </div>


        <div class="flex flex-col w-96 bg-white p-5 rounded-xl">
            <h2 class="font-semibold text-gray-500 text-lg">PR Breakdown</h2>

            <div class="flex flex-col flex-1 items-center justify-center gap-10 mt-10">
                <div class="w-60 h-full grid place-items-center">
                    <canvas id="prChart"></canvas>
                </div>

                <div class="w-full flex flex-col gap-2 text-gray-600">
                    <div class="flex items-center space-x-2 bg-gray-100 p-5 rounded-md">
                        <div class="w-5 h-5 bg-blue-500 rounded-md"></div>
                        <span>PR Above Php 50k</span>
                        <h2 class="ml-auto text-2xl font-black">{{ $prAbove50kCount }}</h2>
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-100 p-5 rounded-md">
                        <div class="w-5 h-5 bg-green-500 rounded-md"></div>
                        <span>PR Below Php 50k</span>
                        <h2 class="ml-auto text-2xl font-black">{{ $prBelow50kCount }}</h2>
                    </div>
                </div>
            </div>

            <h2 class="font-semibold text-gray-500 text-lg mt-10 mb-4">Total Awarded Amount</h2>
            <div class="flex-1 flex flex-col items-center justify-center bg-gray-100 p-5 rounded-md">
                <span class="flex-1 grid place-items-center">
                    <h2 class="text-3xl font-black text-gray-600">₱{{ number_format($totalAmount, 2) }}</h2>
                </span>
                <button data-micromodal-trigger="modal-1"
                    class="w-full bg-red-400 py-2 text-white text-sm cursor-pointer rounded">
                    View Amount
                </button>
            </div>
        </div>






        @if ($upcomingCount > 0)
            <div x-data="{ open: false }" x-show="open" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="fixed bottom-12 right-12 w-80 bg-red-400 shadow-lg rounded-lg border border-red-300 z-50"
                style="display: none;" x-init="setTimeout(() => open = true, 1000)">
                <div class="flex justify-between items-center p-4 border-b border-red-300">
                    <h3 class="text-lg text-white">
                        <i class="fa-solid fa-clipboard text-lg mr-1"></i> Reminder
                    </h3>
                    <button @click="open = false"
                        class="text-white hover:text-gray-200 focus:outline-none text-xl cursor-pointer"
                        aria-label="Close modal">
                        &times;
                    </button>
                </div>
                <div class="p-4 text-white text-sm">
                    You have {{ $upcomingCount }} upcoming Post Qualification Presentation(s).
                </div>
            </div>
        @endif
    </div>

    <div class="modal micromodal-slide" id="modal-pending" aria-hidden="true">
        <div class="modal__overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            tabindex="-1" data-micromodal-close>
            <div class="modal__container bg-white rounded-lg shadow-lg p-6 w-full max-w-7xl relative" role="dialog"
                aria-modal="true" aria-labelledby="modal-pending-title">
                <header class="modal__header mb-6">
                    <h2 class="text-lg font-semibold text-gray-600" id="modal-pending-title">
                        Pending Projects
                    </h2>
                    <small class="text-gray-600">Track all the pending project status</small>
                </header>
                <main class="modal__content text-sm">
                    <div class="w-full max-h-96 overflow-y-auto">
                        <table class="w-full table-auto border-collapse">
                            <thead class="sticky top-0 bg-gray-100 z-10 border-b border-gray-300">
                                <tr class="text-gray-700">
                                    <th class="w-32 text-left p-3">PR Number</th>
                                    <th class="text-left p-3">Project Title</th>
                                    <th class="w-72 text-left p-3 ">Tracking Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingProjectsDetails as $project)
                                    <tr class="border-b border-gray-300">
                                        <td class="p-3 ">{{ $project['pr_number'] }}</td>
                                        <td class="p-3">{{ $project['procurement_project'] }}</td>
                                        <td class="p-3 w-80">
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="px-3 py-2 rounded-full text-xs font-semibold flex items-center gap-1
                    {{ $project['date_received_from_planning'] ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-500' }}">
                                                    @if ($project['date_received_from_planning'])
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="3">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @endif
                                                    Planning
                                                </span>

                                                <span
                                                    class="px-3 py-2 rounded-full text-xs font-semibold flex items-center gap-1
                    {{ $project['date_received_by_twg'] ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-500' }}">
                                                    @if ($project['date_received_by_twg'])
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="3">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @endif
                                                    TWG
                                                </span>

                                                <span
                                                    class="px-3 py-2 rounded-full text-xs font-semibold flex items-center gap-1
                    {{ $project['approved_pr_received'] ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-500' }}">
                                                    @if ($project['approved_pr_received'])
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="3">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @endif
                                                    Approved PR
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-3 text-center text-gray-500">No pending records found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>
                </main>
                <footer class="modal__footer mt-4 text-right">
                    <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-4 py-2 rounded cursor-pointer"
                        data-micromodal-close>
                        Close
                    </button>
                </footer>
            </div>
        </div>
    </div>


    <!-- Other mode -->
    <div class="modal micromodal-slide" id="modal-2" aria-hidden="true">
        <div class="modal__overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            tabindex="-1" data-micromodal-close>
            <div class="modal__container bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl relative" role="dialog"
                aria-modal="true" aria-labelledby="modal-2-title">
                <header class="modal__header flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-600" id="modal-2-title">Other Mode of Procurement</h2>
                </header>
                <main class="modal__content text-sm">
                    <div class="w-full h-96 overflow-y-auto">
                        <table class="w-full table-auto border-collapse overflow-hidden">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700">
                                    <th class="text-left p-3 border-b border-gray-300">Mode of Procurement</th>
                                    <th class="text-left p-3 border-b border-gray-300 whitespace-nowrap">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($othersGrouped as $other)
                                    <tr>
                                        <td class="p-3 border-b border-gray-300">
                                            @php
                                                $modes = json_decode($other->mode_of_procurement, true);
                                            @endphp

                                            @if (is_array($modes))
                                                @foreach ($modes as $mode)
                                                    <span
                                                        class="inline-block bg-gray-300 text-gray-800 text-xs font-semibold mr-1 px-2.5 py-0.5 rounded-full">
                                                        {{ $mode }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span
                                                    class="inline-block bg-gray-300 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                                    {{ $other->mode_of_procurement ?: 'N/A' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-3 border-b border-gray-300 whitespace-nowrap">{{ $other->total }}
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </main>
                <footer class="modal__footer mt-4 text-right">
                    <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-4 py-2 rounded  cursor-pointer"
                        data-micromodal-close>Close</button>
                </footer>
            </div>
        </div>
    </div>

    <!--  Amount -->
    <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
        <div class="modal__overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            tabindex="-1" data-micromodal-close>
            <div class="modal__container bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl relative" role="dialog"
                aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-600" id="modal-1-title">Awarded Amount Distribution</h2>
                </header>
                <main class="modal__content text-sm ">
                    <div class="w-full h-96 overflow-y-auto">
                        <table class="w-full table-auto border-collapse">
                            <thead class="sticky top-0 bg-gray-100 z-10">
                                <tr class="text-gray-700">
                                    <th class="text-left p-3 border-b border-gray-300">Office</th>
                                    <th class="text-left p-3 border-b border-gray-300 whitespace-nowrap">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($endUserGrouped as $group)
                                    <tr>
                                        <td class="p-3 border-b border-gray-300">{{ $group->end_user }}</td>
                                        <td class="p-3 border-b border-gray-300 whitespace-nowrap">
                                            ₱{{ number_format($group->total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </main>
                <footer class="modal__footer mt-4 text-right">
                    <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-4 py-2 rounded cursor-pointer"
                        data-micromodal-close>Close</button>
                </footer>
            </div>
        </div>
    </div>






    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('projectStatusChart').getContext('2d');

            const statusLabels = @json($statusLabels);
            const statusData = @json($statusData);

            const projectStatusChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        label: 'Number of Projects',
                        data: statusData,
                        backgroundColor: [
                            '#F59E0B',
                            '#10B981',
                            '#3B82F6',
                            '#9333EA',
                            '#EF4444',
                        ],

                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: false,
                            },

                            border: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 14
                                }
                            },
                            ticks: {
                                stepSize: 1,
                                maxTicksLimit: 5,
                                font: {
                                    size: 14
                                }
                            },
                            grid: {
                                drawBorder: false
                            }

                        },
                        x: {
                            title: {
                                display: false,
                            },
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false,
                        }
                    }
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('prChart').getContext('2d');

            const prAbove = {{ $prAbove50kCount }};
            const prBelow = {{ $prBelow50kCount }};

            const prChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['PR Above Php 50k', 'PR Below Php 50k'],
                    datasets: [{
                        data: [prAbove, prBelow],
                        backgroundColor: ['#3B82F6', '#10B981'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
