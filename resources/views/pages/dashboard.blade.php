@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex-1 h-full flex gap-6 p-10 bg-gray-200">
        <div class="flex flex-1 flex-col gap-6">
            <div class="flex gap-6">
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-600 text-lg">Purchase Request</h2>
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
                    <div class="flex-1 flex justify-between items-end   ">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-green-400">5</h2>
                        </div>

                        <div class="w-14 h-14 bg-green-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-hand text-2xl text-green-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-500 text-lg">Direct Contracting</h2>
                    <div class="flex-1 flex justify-between items-end   ">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-indigo-400">12</h2>
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
                    <div class="flex-1 flex justify-between items-end   ">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-blue-400">24</h2>
                        </div>

                        <div class="w-14 h-14 bg-blue-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-square-caret-down text-2xl text-blue-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-500 text-lg">Emergency Cases</h2>
                    <div class="flex-1 flex justify-between items-end   ">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-red-400">8</h2>
                        </div>

                        <div class="w-14 h-14 bg-red-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-circle-dot text-2xl text-red-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-600 text-lg">Others</h2>
                    <div class="flex-1 flex justify-between items-end">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-gray-500">5</h2>
                        </div>

                        <button data-micromodal-trigger="modal-2" class="cursor-pointer w-14 h-14 bg-gray-300 rounded-full">
                            <i class="fa-solid fa-bars text-2xl text-gray-500"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col w-full bg-white rounded-xl p-6">
                <h2 class="font-semibold text-gray-600 text-lg mb-6">Project Status Distribution</h2>
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
                        <h2 class="ml-auto text-2xl font-black">32</h2>
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-100 p-5 rounded-md">
                        <div class="w-5 h-5 bg-green-500 rounded-md"></div>
                        <span>PR Below Php 50k</span>
                        <h2 class="ml-auto text-2xl font-black">12</h2>
                    </div>
                </div>
            </div>

            <h2 class="font-semibold text-gray-500 text-lg mt-10 mb-4">Total Awarded Amount</h2>
            <div class="flex-1 flex flex-col items-center justify-center bg-gray-100 p-5 rounded-md">
                <span class="flex-1 grid place-items-center">
                    <h2 class="text-3xl font-black text-gray-600">₱12,230,705,540.00</h2>
                </span>
                <button data-micromodal-trigger="modal-1"
                    class="w-full bg-red-400 py-2 text-white text-sm cursor-pointer rounded">
                    View Offices Amount
                </button>
            </div>


        </div>
    </div>
    <!-- Modal 1: Offices Amount -->
    <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
        <div class="modal__overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            tabindex="-1" data-micromodal-close>
            <div class="modal__container bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative" role="dialog"
                aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-600" id="modal-1-title">Offices Amount</h2>
                </header>
                <main class="modal__content text-sm">
                    <table class="w-full table-auto border-collapse rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="text-left p-3 border-b border-gray-300">Office</th>
                                <th class="text-left p-3 border-b border-gray-300 whitespace-nowrap">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-3 border-b border-gray-300">Office 1</td>
                                <td class="p-3 border-b border-gray-300 whitespace-nowrap">$1,200</td>
                            </tr>
                            <tr>
                                <td class="p-3 border-b border-gray-300">Office 2</td>
                                <td class="p-3 border-b border-gray-300 whitespace-nowrap">$950</td>
                            </tr>
                        </tbody>
                    </table>
                </main>
                <footer class="modal__footer mt-4 text-right">
                    <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-4 py-2 rounded cursor-pointer"
                        data-micromodal-close>Close</button>
                </footer>
            </div>
        </div>
    </div>

    <!-- Modal 2: Menu Options -->
    <div class="modal micromodal-slide" id="modal-2" aria-hidden="true">
        <div class="modal__overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            tabindex="-1" data-micromodal-close>
            <div class="modal__container bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative" role="dialog"
                aria-modal="true" aria-labelledby="modal-2-title">
                <header class="modal__header flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-600" id="modal-2-title">Other Mode of Procurement</h2>
                </header>
                <main class="modal__content text-sm">
                    <table class="w-full table-auto border-collapse rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="text-left p-3 border-b border-gray-300">Mode of Procurement</th>
                                <th class="text-left p-3 border-b border-gray-300 whitespace-nowrap">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-3 border-b border-gray-300">Agency to Agency</td>
                                <td class="p-3 border-b border-gray-300 whitespace-nowrap">6</td>
                            </tr>
                            <tr>
                                <td class="p-3 border-b border-gray-300">Bla bla</td>
                                <td class="p-3 border-b border-gray-300 whitespace-nowrap">2</td>
                            </tr>
                        </tbody>
                    </table>
                </main>
                <footer class="modal__footer mt-4 text-right">
                    <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-4 py-2 rounded  cursor-pointer"
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

            const prChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['PR Above Php 50k', 'PR Below Php 50k'],
                    datasets: [{
                        data: [30, 70],
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
