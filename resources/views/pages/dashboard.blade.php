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
                            <h2 class="text-5xl font-bold text-amber-400">32</h2>
                            {{-- <p class="text-sm font-bold text-gray-600">Total as of </p> --}}
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
                            {{-- <p class="text-sm font-bold text-gray-600">Total as of</p> --}}
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
                            {{-- <p class="text-sm font-bold text-gray-600">Total as of</p> --}}
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
                            {{-- <p class="text-sm font-bold text-gray-600">Total as of</p> --}}
                        </div>

                        <div class="w-14 h-14 bg-blue-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-handshake text-2xl text-blue-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-1 bg-white p-4 rounded-xl h-36">
                    <h2 class="font-semibold text-gray-500 text-lg">Emergency Cases</h2>
                    <div class="flex-1 flex justify-between items-end   ">
                        <div class="flex flex-col">
                            <h2 class="text-5xl font-bold text-red-400">8</h2>
                            {{-- <p class="text-sm font-bold text-gray-600">Total as of</p> --}}
                        </div>

                        <div class="w-14 h-14 bg-red-100 rounded-full grid place-items-center">
                            <i class="fa-regular fa-handshake text-2xl text-red-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1 bg-white p-4 rounded-xl h-36"></div>
            </div>

            <div class="flex flex-col h-100 w-full bg-white rounded-xl p-6">
                <h2 class="font-semibold text-gray-600 text-lg">PR Breakdown</h2>
                {{-- <hr class="mt-4 border-1 border-gray-100" /> --}}


                <div class="flex flex-1 items-center justify-center gap-10">
                    <div class="w-60 h-full grid place-items-center">
                        <canvas id="prChart"></canvas>
                    </div>

                    <div class="flex flex-col gap-6 font-semibold text-gray-500">
                        <div class="flex items-center space-x-2 bg-gray-100 p-5 rounded-md">
                            <div class="w-6 h-6 bg-blue-500 rounded-md"></div>
                            <span>PR Above Php 50k</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-gray-100 p-5 rounded-md">
                            <div class="w-6 h-6 bg-green-500 rounded-md"></div>
                            <span>PR Below Php 50k</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="w-96 -full bg-white p-5 rounded-xl">
            <h2 class="font-semibold text-gray-500 text-lg">Note</h2>

        </div>
    </div>

    <script>
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
