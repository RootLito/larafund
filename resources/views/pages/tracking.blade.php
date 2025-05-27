@extends('layout.app')

@section('title', 'Tracking')

@section('content')
    <div class="w-full h-full flex flex-col gap-10 p-10">

        <div class="md:w-full h-full bg-white p-6 rounded-lg shadow-md" x-data="{ lots: [] }">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Add new PR</h2>
                <button x-on:click="lots.push({});"
                    class="bg-blue-800 text-white p-2 text-xs cursor-pointer rounded w-28">Add Lot</button>
            </div>

            <form action="" method="post">
                @csrf

                <small>Procurement Project <span class="text-red-500">*</span></small>
                <textarea type="text" name="name"
                    class="w-full h-20 p-2 border bg-gray-50 border-gray-300 rounded resize-none text-sm"></textarea>

                <div class="flex gap-2 items-end mt-3">
                    <div class="flex flex-col flex-1">
                        <small>Lot and Description <span class="text-red-500">*</span></small>
                        <input type="text" name=""
                            class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded">
                    </div>

                    <div class="flex flex-col w-72">
                        <small>ABC per LOT <span class="text-red-500">*</span></small>
                        <input type="text" name=""
                            class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded">
                    </div>

                </div>
                <template x-for="(lot, index) in lots" :key="index">
                    <div class="flex gap-2 items-end mt-1">
                        <div class="flex flex-col flex-1">
                            <input type="text" name="lot_description[]"
                                class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                :id="'lot_description_' + index"> <!-- Use template literals here -->
                        </div>

                        <div class="flex flex-col w-72">
                            <input type="text" name="abc_per_lot[]"
                                class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded"
                                :id="'abc_per_lot_' + index"> <!-- Use template literals here -->
                        </div>

                    </div>
                </template>

                <div class="flex gap-2 items-end mt-3">
                    <div class="flex flex-col flex-1">
                        <small>End User <span class="text-red-500">*</span></small>
                        <input type="text" name="email"
                            class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded">
                    </div>
                    <div class="flex flex-col w-72">
                        <small>Total ABC <span class="text-red-500">*</span></small>
                        <input type="text" name="total_abc"
                            class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded">
                    </div>
                </div>

                <button class="w-full bg-red-400 py-2 mt-5 text-white cursor-pointer rounded">Save</button>
            </form>
        </div>



        <div class="md:w-full h-full bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold text-gray-700 mb-4">PR Lists</h2>


            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead class="border-b border-gray-300">
                    <tr class="bg-gray-100 text-gray-600">
                        <th class="px-4 py-2 text-left text-sm">Status</th>
                        <th class="px-4 py-2 text-left text-sm">PR Number</th>
                        <th class="px-4 py-2 text-left text-sm">Procurement Project</th>
                        <th class="px-4 py-2 text-left text-sm">Total ABC</th>
                        <th class="px-4 py-2 text-left text-sm">End User</th>
                        <th class="px-4 py-2 text-left text-sm">View</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-600">Pending</td>
                        <td class="px-4 py-2 text-sm text-gray-600">PR12345</td>
                        <td class="px-4 py-2 text-sm text-gray-600">Office Supplies</td>
                        <td class="px-4 py-2 text-sm text-gray-600">₱1,500,000.00</td>
                        <td class="px-4 py-2 text-sm text-gray-600">Admin Department</td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            <button class="px-4 py-2 text-white bg-blue-500 rounded-md">View</button>
                        </td>
                    </tr>

                    <!-- Second Row of Dummy Data -->
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-600">Completed</td>
                        <td class="px-4 py-2 text-sm text-gray-600">PR98765</td>
                        <td class="px-4 py-2 text-sm text-gray-600">IT Equipment</td>
                        <td class="px-4 py-2 text-sm text-gray-600">₱750,000.00</td>
                        <td class="px-4 py-2 text-sm text-gray-600">IT Department</td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            <button class="px-4 py-2 text-white bg-green-500 rounded-md">View</button>
                        </td>
                    </tr>

                    <!-- Third Row of Dummy Data -->
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-600">Approved</td>
                        <td class="px-4 py-2 text-sm text-gray-600">PR11223</td>
                        <td class="px-4 py-2 text-sm text-gray-600">Furniture</td>
                        <td class="px-4 py-2 text-sm text-gray-600">₱350,000.00</td>
                        <td class="px-4 py-2 text-sm text-gray-600">HR Department</td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            <button class="px-4 py-2 text-white bg-yellow-500 rounded-md">View</button>
                        </td>
                    </tr>

                    <!-- Fourth Row of Dummy Data -->
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 text-sm text-gray-600">In Progress</td>
                        <td class="px-4 py-2 text-sm text-gray-600">PR54321</td>
                        <td class="px-4 py-2 text-sm text-gray-600">Security Systems</td>
                        <td class="px-4 py-2 text-sm text-gray-600">₱2,000,000.00</td>
                        <td class="px-4 py-2 text-sm text-gray-600">Security Department</td>
                        <td class="px-4 py-2 text-sm text-gray-600">
                            <button class="px-4 py-2 text-white bg-red-500 rounded-md">View</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
