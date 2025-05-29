@extends('layout.app')

@section('title', 'Users')

@section('content')
    <div class="w-full h-full grid grid-cols-[1fr_2fr] gap-10 p-10">
        <div class="flex flex-col h-full bg-white p-6 rounded-lg ">
            <h2 class="text-xl font-bold text-gray-700 mb-6">New User</h2>
            <form action="" method="post">
                @csrf

                <small>Select Profile <span class="text-red-500">*</span></small>
                <input type="file" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md cursor-pointer mb-2">

                <small>Name <span class="text-red-500">*</span></small>
                <input type="text" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2">

                <small>Role <span class="text-red-500">*</span></small>
                <input type="text" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2">

                <small>Username <span class="text-red-500">*</span></small>
                <input type="text" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2">

                <small>Password <span class="text-red-500">*</span></small>
                <input type="text" name=""
                    class="w-full bg-gray-50 border border-gray-300 p-2 text-sm rounded-md mb-2">




                <button class="w-full bg-red-400 py-2 mt-5 text-white cursor-pointer rounded-md text-sm">Save</button>
            </form>

        </div>

        <div class="flex flex-col h-full bg-white p-6 rounded-lg ">
            <h2 class="text-xl font-bold text-gray-700 mb-6">User Lists</h2>
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
